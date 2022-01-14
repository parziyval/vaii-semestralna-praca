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

            ]);
    }

    public function dajZoradene()
    {
        $pole = $this->request()->getValue("pole");
        $vzostupne = $this->request()->getValue("vzostupne");
        $uzivatelia = Uzivatel::getAll();
        if($vzostupne == "true") {
            switch($pole) {
                case "id":
                    usort($uzivatelia, function($a, $b) {return $a->getId() - $b->getId();});
                    break;
                case "email":
                    usort($uzivatelia, function($a, $b) {return strcmp($a->getEmail(), $b->getEmail());});
                    break;
                case "meno":
                    usort($uzivatelia, function($a, $b) {return strcmp($a->getMeno(), $b->getMeno());});
                    break;
                case "priezvisko":
                    usort($uzivatelia, function($a, $b) {return strcmp($a->getPriezvisko(), $b->getPriezvisko());});
                    break;
                default:
                    usort($uzivatelia, function($a, $b) {return $a->getId() - $b->getId();});
                    break;
            }
        } else if($vzostupne == "false") {
            switch($pole) {
                case "id":
                    usort($uzivatelia, function($a, $b) {return $b->getId() - $a->getId();});
                    break;
                case "email":
                    usort($uzivatelia, function($a, $b) {return strcmp($b->getEmail(), $a->getEmail());});
                    break;
                case "meno":
                    usort($uzivatelia, function($a, $b) {return strcmp($b->getMeno(), $a->getMeno());});
                    break;
                case "priezvisko":
                    usort($uzivatelia, function($a, $b) {return strcmp($b->getPriezvisko(), $a->getPriezvisko());});
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