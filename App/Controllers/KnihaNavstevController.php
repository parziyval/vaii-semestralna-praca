<?php

namespace App\Controllers;

use App\Auth;
use App\Core\DB\Connection;
use App\Core\Responses\Response;
use App\Models\KnihaNavstevPrispevok;
use App\Models\Uzivatel;

class KnihaNavstevController extends AControllerRedirect
{

    /**
     * @inheritDoc
     */
    public function index()
    {
        return $this->html();
    }

    public function getVsetkyPrispevky()
    {
        $prispevky = KnihaNavstevPrispevok::getAll();
        foreach($prispevky as $prispevok) {
            $uzivatel = Uzivatel::getOne($prispevok->getUzivatelId());
            $prispevok->setMeno($uzivatel->getMeno());
            $prispevok->setPriezvisko($uzivatel->getPriezvisko());
        }
        return $this->json($prispevky);
    }

    public function pridajPrispevok()
    {
        if(Auth::jePrihlaseny()) {
            $text = $this->request()->getValue("kn_text");
            $uzivatel_id = $_SESSION["id"];

            $prihlaseny = Uzivatel::getOne($uzivatel_id);
            $meno = $prihlaseny->getMeno();
            $priezvisko = $prihlaseny->getPriezvisko();

            if (strlen($text) == 0) {
                return $this->json("error_prazdny_text");
            }

            if (strlen($text) > 2000) {
                return $this->json("error_dlhy_text");
            }

            $prispevok = new KnihaNavstevPrispevok(text: $text,
                datum_pridania: date('Y-m-d H:i:s'),
                uzivatel_id: $uzivatel_id,
                meno: $meno,
                priezvisko: $priezvisko);
            $prispevok->save();
            return $this->json("ok");
        } else {
            $this->redirect("knihanavstev");
        }
    }

}
