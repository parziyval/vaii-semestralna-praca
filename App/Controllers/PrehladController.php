<?php

namespace App\Controllers;

use App\Core\Responses\Response;
use App\Models\Uzivatel;

class PrehladController extends AControllerRedirect
{

    /**
     * @inheritDoc
     */
    public function index()
    {
        return $this->html(
            [
                "stlpec" => $this->request()->getValue("stlpec"),
                "vzostupne" => $this->request()->getValue("vzostupne")
            ]);
    }

    public function dajZoradene()
    {
        $stlpec = $this->request()->getValue("stlpec");
        $vzostupne = $this->request()->getValue("vzostupne");
        $uzivatelia = Uzivatel::getAll();
        if($vzostupne == "true") {
            switch($stlpec) {
                case "id":
                    usort($uzivatelia, function($a, $b) {return $a->getId() - $b->getId();});
                    break;
                case "email":
                    usort($uzivatelia, function($a, $b) {return strcmp(strtolower($a->getEmail()), strtolower($b->getEmail()));});
                    break;
                case "meno":
                    usort($uzivatelia, function($a, $b) {return strcmp(strtolower($a->getMeno()), strtolower($b->getMeno()));});
                    break;
                case "priezvisko":
                    usort($uzivatelia, function($a, $b) {return strcmp(strtolower($a->getPriezvisko()), strtolower($b->getPriezvisko()));});
                    break;
                default:
                    usort($uzivatelia, function($a, $b) {return $a->getId() - $b->getId();});
                    break;
            }
        } else if($vzostupne == "false") {
            switch($stlpec) {
                case "id":
                    usort($uzivatelia, function($a, $b) {return $b->getId() - $a->getId();});
                    break;
                case "email":
                    usort($uzivatelia, function($a, $b) {return strcmp(strtolower($b->getEmail()), strtolower($a->getEmail()));});
                    break;
                case "meno":
                    usort($uzivatelia, function($a, $b) {return strcmp(strtolower($b->getMeno()), strtolower($a->getMeno()));});
                    break;
                case "priezvisko":
                    usort($uzivatelia, function($a, $b) {return strcmp(strtolower($b->getPriezvisko()), strtolower($a->getPriezvisko()));});
                    break;
                default:
                    usort($uzivatelia, function($a, $b) {return $b->getId() - $a->getId();});
                    break;
            }

        } else { //na zaciatku ak sa nic nezoradzuje chceme len udaje tak ako su v databaze
            return $this->json($uzivatelia);
        }

        return $this->json($uzivatelia);

    }
}