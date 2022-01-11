<?php

namespace App\Controllers;

use App\Auth;
use App\Core\Responses\Response;
use App\Models\KnihaNavstevPrispevok;

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
        return $this->json($prispevky);
    }

    public function pridajPrispevok()
    {
        if(Auth::jePrihlaseny()) {
            $text = $this->request()->getValue("kn_text");
            //$email = $this->request()->getValue("uzivatel_email");
            $email = $_SESSION["email"];
            //$email = "a@a.a";
            if (strlen($text) == 0) {
                return $this->json("error");
            }

            if (strlen($text) > 2000) {
                return $this->json("error");
            }

            $prispevok = new KnihaNavstevPrispevok(text: $text,
                datum_pridania: date('Y-m-d H:i:s'),
                uzivatel_email: $email);
            $prispevok->save();
            return $this->json("ok");
        } else {
            $this->redirect("knihanavstev");
        }
    }

}
