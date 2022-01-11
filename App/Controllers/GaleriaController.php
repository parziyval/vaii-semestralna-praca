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
                "album_id" => $this->request()->getValue("album_id"),
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
                $chyba = $this->checkSubor("albumSubor", -1);

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

    /*
     * index je -1 ak je súbor len jeden, alebo nezáporný ak je súborov viacero
     */
    private function checkSubor(string $nazovSuboru, int $index) {
        $chyba = "";

        if($index < 0) {
            $name = $_FILES[$nazovSuboru]["name"];
        } else {
            $name = $_FILES[$nazovSuboru]["name"][$index];
        }
        $path = Configuration::UPLOAD_DIR . $name;
        $pripona = strtolower(pathinfo($path,PATHINFO_EXTENSION));

        if(strlen($name) > 255) {
            $chyba .= $name . ": Meno súboru nesmie byť dlhšie ako 255 znakov <br>";
        }

        if($index < 0) {
            if(getimagesize($_FILES[$nazovSuboru]["tmp_name"]) == false) {
                $chyba .= $name . ": Súbor nie je obrázok <br>";
            }
        } else {
            if(getimagesize($_FILES[$nazovSuboru]["tmp_name"][$index]) == false) {
                $chyba .= $name . ": Súbor nie je obrázok <br>";
            }
        }

        if($index < 0) {
            if (($_FILES[$nazovSuboru]["size"] > Configuration::MAX_UPLOAD_SIZE) == true) {
                $chyba .= $name . ": Súbor je príliš veľký, maximálna veľkosť je" . ini_get("upload_max_filesize") . " <br>";
            }
        } else {
            if (($_FILES[$nazovSuboru]["size"][$index] > Configuration::MAX_UPLOAD_SIZE) == true) {
                $chyba .= $name . ": Súbor je príliš veľký, maximálna veľkosť je" . ini_get("upload_max_filesize") . " <br>";
            }
        }

        if (file_exists($path) == true) {
            $chyba .= $name . ": Súbor so zadaným menom už existuje<br>";
        }

        if($pripona != "jpg" && $pripona != "png" && $pripona != "jpeg") {
            $chyba .= $name . ": Povolené sú iba súbory typu JPG, JPEG a PNG<br>";
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
                    //najprv sa musia vymazat vsetky obrazky z albumu az potom sa moze vymazat album
                    for ($i = 0; $i < sizeof($obrazky); $i++) {
                        $obrazokCesta = Configuration::UPLOAD_DIR . $obrazky[$i]->getSubor();
                        unlink($obrazokCesta);
                        $obrazky[$i]->delete();
                    }

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
                $chyba = $this->checkSubor("albumSubor", -1);

                if ($chyba !== "") {
                    $this->redirect("galeria", "upravAlbumForm", ["form_sprava" => "Chyba pri nahrávaní súboru<br>" . $chyba, "form_sprava_typ" => "danger", "album_id" => $album_id]);
                    return;
                } else {
                    $name = $_FILES['albumSubor']['name'];
                    $path = Configuration::UPLOAD_DIR . $name;
                    $staryThumbnailCesta = Configuration::UPLOAD_DIR . Album::getOne($album_id)->getThumbnail();
                    unlink($staryThumbnailCesta);
                    move_uploaded_file($_FILES['albumSubor']['tmp_name'], $path);
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

            } else {
                $this->redirect("galeria","pridajAlbumForm",["form_sprava" => "Nahrávanie súboru zlyhalo. Počkajte chvíľu a skúste to znova.", "form_sprava_typ" => "danger"]);
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
                    "sprava_typ" => $this->request()->getValue("sprava_typ"),
                    "album_id" => $this->request()->getValue("album_id")
                ]);
        } else {
            $this->redirect("home");
        }
    }

    public function pridajObrazky()
    {
        if(Auth::jePrihlaseny() && Auth::getRola() == "admin") {
            $pocet = count($_FILES["obrazkySubory"]["name"]);
            $album_id = $this->request()->getValue("album_id");

            $chyba = "";
            for( $i=0 ; $i < $pocet ; $i++ ) {
                $chyba .= $this->checkSubor("obrazkySubory",$i);
            }

            if($chyba == "") {
                for( $i=0 ; $i < $pocet ; $i++ ) {
                    $tmpCesta = $_FILES['obrazkySubory']['tmp_name'][$i];

                    if ($tmpCesta !== ""){
                        $name = $_FILES['obrazkySubory']['name'][$i];
                        $novaCesta = Configuration::UPLOAD_DIR . $name;
                        //$album_id = $this->request()->getValue("album_id");
                        if(move_uploaded_file($tmpCesta, $novaCesta)) {
                            try {
                                $obrazok = new Obrazok(subor: $name, album_id: intval($album_id));
                                $obrazok->save();
                            } catch (PDOException $e) {
                                $this->redirect("galeria", "zobrazAlbum", ["album_id" => $album_id, "sprava" => "Chyba databázy", "sprava_typ" => "danger"]);
                                return;
                            }
                        }
                    }
                }
            } else {
                $this->redirect("galeria", "pridajObrazkyForm", ["album_id" => $album_id, "sprava" => "Chyba pri nahrávaní súboru<br>" . $chyba, "sprava_typ" => "danger"]);
                return;
            }

            $this->redirect("galeria","zobrazAlbum",["album_id" => $album_id, "sprava" => "Obrázky úspešne pridané!", "sprava_typ" => "success"]);
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
                unlink($obrazokCesta);
                $this->redirect("galeria", "zobrazAlbum", ["album_id" => $album_id, "sprava" => "Obrázok bol úspešne vymazaný!", "sprava_typ" => "success"]);
            } catch (PDOException $e) {
                $this->redirect("galeria", "zobrazAlbum", ["album_id" => $album_id, "sprava" => "Chyba databázy", "sprava_typ" => "danger"]);
            }

        } else {
            $this->redirect("home");
        }
    }

}