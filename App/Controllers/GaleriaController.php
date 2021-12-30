<?php

namespace App\Controllers;

use App\Auth;
use App\Config\Configuration;
use App\Core\DB\Connection;
use App\Core\Responses\Response;
use App\Models\Album;
use App\Models\Obrazok;
use PDOException;

class GaleriaController extends AControllerRedirect
{

    /**
     * @inheritDoc
     */
    public function index()
    {
        $albumy = Album::getAll();
        return $this->html(
            [
                "albumy" => $albumy,
                "index_sprava" => $this->request()->getValue("index_sprava"),
                "index_sprava_typ" => $this->request()->getValue("index_sprava_typ")
            ]);
    }

    public function zobrazAlbum()
    {
        $album_id = $this->request()->getValue("album_id");
        $album = Album::getOne($album_id);
        $obrazky = $album->getObrazky();
        return $this->html(
            [
                "obrazky" => $obrazky,
                "sprava" => $this->request()->getValue("sprava"),
                "sprava_typ" => $this->request()->getValue("sprava_typ")
            ]);
    }

    public function pridajAlbumForm()
    {
        if(Auth::jePrihlaseny() && Auth::getRola() == "admin") {
            return $this->html(
                [
                    "form_sprava" => $this->request()->getValue("form_sprava"),
                    "form_sprava_typ" => $this->request()->getValue("form_sprava_typ")
                ]);
        } else {
            $this->redirect("home");
        }
    }

    public function pridajAlbum()
    {
        if(Auth::jePrihlaseny() && Auth::getRola() == "admin") {
            $popisok = $this->request()->getValue("albumPopisok");
            if($popisok == "") {
                $this->redirect("galeria","pridajAlbumForm",["form_sprava" => "Popisok nesmie byť prázdny", "form_sprava_typ" => "danger"]);
                return;
            }

            if(strlen($popisok) > 50) {
                $this->redirect("galeria","pridajAlbumForm",["form_sprava" => "Dĺžka popisku nesmie bzť väčšia ako 50 znakov", "form_sprava_typ" => "danger"]);
                return;
            }

            if($_FILES['albumSubor']['name'] !== "" && $_FILES['albumSubor']['error'] == UPLOAD_ERR_OK) {
                $chyba = $this->checkSubor("albumSubor");

                if($chyba !== "") {
                    $this->redirect("galeria","pridajAlbumForm",["form_sprava" => "Chyba pri nahrávaní súboru<br>" . $chyba, "form_sprava_typ" => "danger"]);
                    return;
                } else {
                    $name = $_FILES["albumSubor"]["name"];
                    $path = Configuration::UPLOAD_DIR . $name;
                    move_uploaded_file($_FILES['albumSubor']['tmp_name'], $path);

                    $novyAlbum = new Album(thumbnail:$name,popisok: $popisok);
                    $novyAlbum->save();
                }

            } else {
                $this->redirect("galeria","pridajAlbumForm",["form_sprava" => "Nahrávanie súboru zlyhalo. Počkajte chvíľu a skúste to znova.", "form_sprava_typ" => "danger"]);
                return;
            }

            $this->redirect("galeria","index",["index_sprava" => "Album bol úspešne pridaný!", "index_sprava_typ" => "success"]);
        } else {
            $this->redirect("home");
        }
    }

    private function checkSubor($nazovSuboru) {
        $chyba = "";

        $name = $_FILES[$nazovSuboru]["name"];
        $path = Configuration::UPLOAD_DIR . $name;
        $pripona = strtolower(pathinfo($path,PATHINFO_EXTENSION));

        if(strlen($name) > 255) {
            $chyba .= "Meno súboru nesmie byť dlhšie ako 255 znakov <br>";
        }

        if(getimagesize($_FILES[$nazovSuboru]["tmp_name"]) == false) {
            $chyba .= "Súbor nie je obrázok <br>";
        }

        if (($_FILES[$nazovSuboru]["size"] > Configuration::MAX_UPLOAD_SIZE) == true) {
            $chyba .= "Súbor je príliš veľký, maximálna veľkosť je" . ini_get("upload_max_filesize") . " <br>";
        }

        if (file_exists($path) == true) {
            $chyba .= "Súbor so zadaným menom už existuje<br>";
        }

        if($pripona != "jpg" && $pripona != "png" && $pripona != "jpeg") {
            $chyba .= "Povolené sú iba súbory typu JPG, JPEG a PNG<br>";
        }

        return $chyba;
    }

    private function jeSuborObrazok($nazovSuboru) {
        return getimagesize($_FILES[$nazovSuboru]["tmp_name"]);
    }

    private function jeSuborPrilisVelky ($nazovSuboru, $maxVelkost) {
        return $_FILES[$nazovSuboru]["size"] > $maxVelkost;
    }

    private function existujeSubor($cesta) {
        return file_exists($cesta);
    }

    private function maSuborPlatnyFormat($pripona) {
        return ($pripona == "jpg" || $pripona == "png" || $pripona == "jpeg");
    }

    public function vymazAlbum()
    {
        if(Auth::jePrihlaseny() && Auth::getRola() == "admin") {
            try{
                $album_id = $this->request()->getValue("album_id");
                $mazanyAlbum = Album::getAll("id = ?", [$album_id]);
                if(sizeof($mazanyAlbum) == 1) {
                    $obrazky = Obrazok::getAll("album_id = ?", [$album_id]);
                    for ($i = 0; $i < sizeof($obrazky); $i++) {
                        $obrazokCesta = Configuration::UPLOAD_DIR . $obrazky[$i]->getSubor();
                        unlink($obrazokCesta);
                        $obrazky[$i]->delete();
                    }
                    //$query = Connection::connect()->prepare("DELETE FROM obrazok WHERE album_id = ?");
                    //$query->execute([$album_id]);

                    $thumbnailCesta = Configuration::UPLOAD_DIR . $mazanyAlbum[0]->getThumbnail();
                    unlink($thumbnailCesta);
                    $mazanyAlbum[0]->delete();
                    $this->redirect("galeria","index",["index_sprava" => "Album bol úspešne vymazaný!", "index_sprava_typ" => "success"]);
                }
            } catch(PDOException $e) {
                $this->redirect("galeria", "index", ["album_id" => $album_id, "sprava" => "Chyba databázy", "sprava_typ" => "danger"]);
            }


        } else {
            $this->redirect("home");
        }

    }

    public function upravAlbumForm()
    {
        if(Auth::jePrihlaseny() && Auth::getRola() == "admin") {
            $album_id = $this->request()->getValue("album_id");
            $popisok = Album::getOne($album_id)->getPopisok();
            return $this->html(
                [
                    "form_sprava" => $this->request()->getValue("form_sprava"),
                    "form_sprava_typ" => $this->request()->getValue("form_sprava_typ"),
                    "album_id" => $this->request()->getValue("album_id"),
                    "popisok" => $popisok
                ]);
        } else {
            $this->redirect("home");
        }
    }

    public function upravAlbum()
    {
        $album_id = $this->request()->getValue("album_id");
        $novyThumbnailSubor = $_FILES["albumSubor"]["name"];
        $novyPopisok = $this->request()->getValue("albumPopisok");

        if ($novyPopisok == "") {
            $this->redirect("galeria", "upravAlbumForm", ["form_sprava" => "Popisok nesmie byť prázdny", "form_sprava_typ" => "danger","album_id" => $album_id]);
            return;
        }

        if(strlen($novyPopisok) > 50) {
            $this->redirect("galeria","pridajAlbumForm",["form_sprava" => "Dĺžka popisku nesmie bzť väčšia ako 50 znakov", "form_sprava_typ" => "danger"]);
            return;
        }

        if ($_FILES['albumSubor']['name'] !== "") {
            if ($_FILES['albumSubor']['error'] == UPLOAD_ERR_OK) {
                $chyba = $this->checkSubor("albumSubor");

                if ($chyba !== "") {
                    $this->redirect("galeria", "upravAlbumForm", ["form_sprava" => "Chyba pri nahrávaní súboru<br>" . $chyba, "form_sprava_typ" => "danger", "album_id" => $album_id]);
                    return;
                } else {
                    $name = $_FILES['albumSubor']['name'];
                    $path = Configuration::UPLOAD_DIR . $name;
                    $staryThumbnailCesta = Configuration::UPLOAD_DIR . Album::getOne($album_id)->getThumbnail();
                    //TODO: unlink($staryThumbnailCesta);
                    move_uploaded_file($_FILES['albumSubor']['tmp_name'], $path);
                }
            } else {
                $this->redirect("galeria","pridajAlbumForm",["form_sprava" => "Nahrávanie súboru zlyhalo. Počkajte chvíľu a skúste to znova.", "form_sprava_typ" => "danger"]);
                return;
            }

            try {
                $stmt = Connection::connect()->prepare("UPDATE album SET popisok=?, thumbnail=? WHERE id=?");
                $stmt->execute([$novyPopisok,$novyThumbnailSubor,$album_id]);
                $this->redirect("galeria","index",["index_sprava" => "Album bol úspešne upravený!", "index_sprava_typ" => "success"]);
                return;
            } catch (PDOException $e) {
                $this->redirect("galeria", "upravAlbumForm", ["form_sprava" => "Chyba v databáze. Počkajte chvíľu a skúste to znova, prosím", "form_sprava_typ" => "danger", "album_id" => $album_id]);
                return;
            }
        } else { //ak sa neupravuje thumbnail
            try {
                $stmt = Connection::connect()->prepare("UPDATE album SET popisok=? WHERE id=?");
                $stmt->execute([$novyPopisok,$album_id]);
                $this->redirect("galeria","index",["index_sprava" => "Album bol úspešne upravený!", "index_sprava_typ" => "success"]);
                return;
            } catch (PDOException $e) {
                $this->redirect("galeria", "upravAlbumForm", ["form_sprava" => "Chyba v databáze. Počkajte chvíľu a skúste to znova, prosím", "form_sprava_typ" => "danger", "album_id" => $album_id]);
                return;
            }
        }

    }

    public function pridajObrazkyForm()
    {
        if(Auth::jePrihlaseny() && Auth::getRola() == "admin") {
            return $this->html(
                [
                    "sprava" => $this->request()->getValue("sprava"),
                    "sprava_typ" => $this->request()->getValue("sprava_typ")
                ]);
        } else {
            $this->redirect("home");
        }
    }



    public function vymazObrazok()
    {
        if(Auth::jePrihlaseny() && Auth::getRola() == "admin") {
            try {
                $obrazok_id = $this->request()->getValue("obrazok_id");
                $obrazok = Obrazok::getOne($obrazok_id);
                $obrazokCesta = Configuration::UPLOAD_DIR . $obrazok->getSubor();
                $album_id = $obrazok->getAlbumId();
                $obrazok->delete();
                //TODO: unlink($obrazokCesta);
                $this->redirect("galeria", "zobrazAlbum", ["album_id" => $album_id, "sprava" => "Obrázok bol úspešne vymazaný!", "sprava_typ" => "success"]);
            } catch (PDOException $e) {
                $this->redirect("galeria", "zobrazAlbum", ["album_id" => $album_id, "sprava" => "Chyba databázy", "sprava_typ" => "danger"]);
            }

        } else {
            $this->redirect("home");
        }
    }



}