<?php

namespace App\Controllers;

use App\Auth;
use App\Core\DB\Connection;
use App\Models\Oznam;
use PDOException;

class OznamController extends AControllerRedirect
{
    public function index()
    {
        $oznamy = Oznam::getAll();
        usort($oznamy, function($a, $b) {
            return strtotime($b->getDatumPridania()) - strtotime($a->getDatumPridania());
        });
        return $this->html(
            [
                "oznamy" => $oznamy,
                "sprava" => $this->request()->getValue("sprava"),
                "sprava_typ" => $this->request()->getValue("sprava_typ")
            ]);
    }

    private function checkNadpisAText($nadpis, $text)
    {
        $chyba = "";

        if($nadpis == "") {
            $chyba .= "Pole nadpis nesmie byť prázdne<br>";
        }

        if(strlen($nadpis) > 50) {
            $chyba .= "Nadpis nesmie byť dlhší ako 50 znakov<br>";
        }

        if($text == "") {
            $chyba .= "Pole text nesmie byť prázdne<br>";
        }

        if(strlen($text) > 2000) {
            $chyba .= "Text nesmie byť dlhší ako 2000 znakov<br>";
        }

        return $chyba;
    }

    public function pridajOznamForm()
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

    public function pridajOznam()
    {
        if(Auth::jePrihlaseny() && Auth::getRola() == "admin") {
            $nadpis = $this->request()->getValue("oznamNadpis");
            $text = $this->request()->getValue("oznamText");

            $chyba = $this->checkNadpisAText($nadpis, $text);

            if($chyba != "") {
                $this->redirect("oznam", "pridajOznamForm", ["sprava" => $chyba, "sprava_typ" => "danger"]);
                return;
            }

            try {
                $oznam = new Oznam(nadpis: $nadpis, text: $text, datumPridania: date('Y-m-d H:i:s'));
                $oznam->save();
                $this->redirect("oznam", "index", ["sprava" => "Oznam úspešne pridaný", "sprava_typ" => "success"]);
                return;
            } catch(PDOException $e) {
                $this->redirect("oznam", "pridajOznamForm", ["sprava" => "Chyba databázy", "sprava_typ" => "danger"]);
                return;
            }

        } else {
            $this->redirect("home");
        }
    }

    public function vymazOznam()
    {
        if(Auth::jePrihlaseny() && Auth::getRola() == "admin") {
            try{
                $oznam_id = $this->request()->getValue("oznam_id");
                $mazanyOznam = Oznam::getAll("id = ?", [$oznam_id]);
                if(sizeof($mazanyOznam) == 1) {
                    $mazanyOznam[0]->delete();
                    $this->redirect("oznam","index",["sprava" => "Oznam bol úspešne vymazaný!", "sprava_typ" => "success"]);
                    return;
                }
            } catch(PDOException $e) {
                $this->redirect("oznam", "index", ["sprava" => "Chyba databázy", "sprava_typ" => "danger"]);
            }
        } else {
            $this->redirect("home");
        }
    }

    public function upravOznamForm()
    {
        if(Auth::jePrihlaseny() && Auth::getRola() == "admin") {
            $oznam_id = $this->request()->getValue("oznam_id");
            $oznam = Oznam::getOne($oznam_id);
            $nadpis = $oznam->getNadpis();
            $text = $oznam->getText();
            return $this->html(
                [
                    "sprava" => $this->request()->getValue("sprava"),
                    "sprava_typ" => $this->request()->getValue("sprava_typ"),
                    "oznam_id" => $this->request()->getValue("oznam_id"),
                    "nadpis" => $nadpis,
                    "text" => $text
                ]);
        } else {
            $this->redirect("home");
        }
    }

    public function upravOznam()
    {
        if(Auth::jePrihlaseny() && Auth::getRola() == "admin") {
            $oznam_id = $this->request()->getValue("oznam_id");
            $novyNadpis = $this->request()->getValue("oznamNadpis");
            $novyText = $this->request()->getValue("oznamText");
            $chyba = $this->checkNadpisAText($novyNadpis,$novyText);

            if($chyba != "") {
                $this->redirect("oznam", "upravOznamForm", ["sprava" => $chyba, "sprava_typ" => "danger", "oznam_id" => $oznam_id]);
                return;
            }

            try {
                $stmt = Connection::connect()->prepare("UPDATE oznam SET nadpis = ?, text = ? WHERE id = ?");
                $stmt->execute([$novyNadpis, $novyText, $oznam_id]);
                $this->redirect("oznam", "index", ["sprava" => "Oznam bol úspešne upravený!", "sprava_typ" => "success"]);
                return;
            } catch(PDOException $e) {
                $this->redirect("oznam", "upravOznamForm", ["sprava" => "Chyba databázy", "sprava_typ" => "danger", "oznam_id" => $oznam_id]);
            }
        } else {
            $this->redirect("home");
        }
    }
}
