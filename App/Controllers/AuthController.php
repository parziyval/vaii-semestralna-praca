<?php

namespace App\Controllers;

use App\Auth;
use App\Core\Responses\Response;
use App\Models\Album;
use App\Models\Uzivatel;

class AuthController extends AControllerRedirect
{

    public function index()
    {
        return $this->html(
            [

            ]);
    }

    public function loginForm()
    {
        if(Auth::jePrihlaseny()) {
            $this->redirect("home");
        } else {
            return $this->html(
                [
                    "login_error" => $this->request()->getValue("login_error"),
                    "login_message" => $this->request()->getValue("login_message")
                ]);
        }

    }

    public function registraciaForm() {
        if(Auth::jePrihlaseny()) {
            $this->redirect("home");
        } else {
            return $this->html(
                [
                    "sprava" => $this->request()->getValue("sprava"),
                    "sprava_typ" => $this->request()->getValue("sprava_typ")
                ]);
        }
    }

    public function prihlas()
    {
        $email = $this->request()->getValue("email");
        $heslo = $this->request()->getValue("heslo");

        $prihlaseny = Auth::prihlas($email, $heslo);
        if($prihlaseny) {
            $this->redirect("home");
        } else {
            $this->redirect("auth", "loginForm", ["login_error" => "Nesprávne meno alebo heslo!"]);
        }
    }

    public function odhlas()
    {
        Auth::odhlas();
        $this->redirect("home");
    }

    public function registruj()
    {
        $email = $this->request()->getValue("email");
        $meno = $this->request()->getValue("meno");
        $priezvisko = $this->request()->getValue("priezvisko");
        $heslo = $this->request()->getValue("heslo");
        $heslo2 = $this->request()->getValue("heslo2");

        $registraciaOK  = true;
        $chyba = "";

        //validacia emailu
        $uzivatelSMailom = Uzivatel::getAll("email = ?", [$email]);
        if(sizeof($uzivatelSMailom) > 0) {
            $chyba .= "Užívateľ s daným emailom už existuje. Zadajte prosím iný email. <br>";
            $registraciaOK = false;
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $chyba .= "Zadaný email je neplatný. <br>";
            $registraciaOK = false;
        }

        if(strlen($email) > 70) {
            $chyba .= "Email nesmie byť dlhší ako 70 znakov <br>";
            $registraciaOK = false;
        }


        //validacia mena
        if(!preg_match("/^[a-zA-Z ]*$/",$meno)) {
            $chyba .= "Meno môže obsahovať iba písmená a medzery. <br>";
            $registraciaOK = false;
        }

        if(strlen($meno) > 50) {
            $chyba .= "Meno nesmie byť dlhšie ako 50 znakov <br>";
            $registraciaOK = false;
        }


        //validacia priezviska
        if(!preg_match("/^[a-zA-Z ]*$/",$priezvisko)) {
            $chyba .= "Priezvisko môže obsahovať iba písmená a medzery. <br>";
            $registraciaOK = false;
        }

        if(strlen($priezvisko) > 50) {
            $chyba .= "Priezvisko nesmie byť dlhšie ako 50 znakov <br>";
            $registraciaOK = false;
        }


        //validacia hesla
        if($heslo != $heslo2) {
            $chyba .= "Heslá sa nezhodujú. <br>";
            $registraciaOK = false;
        }

        //musi obsahovat aspon osem znakov, velke a male pismeno a cislicu
        if(!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/",$heslo)) {
            $chyba .= "Heslo musí mať 8-30 znakov, musí obsahovať aspoň jedno veľké písmeno, aspoň jedno malé písmeno a aspoň jednu číslicu. <br>";
            $registraciaOK = false;
        }

        if(strlen($heslo) > 30) {
            $chyba .= "Heslo nesmie byť dlhšie ako 30 znakov. <br>";
            $registraciaOK = false;
        }

        //validacia vsetkych poli ci nie su prazdne
        if($email == "" || $meno == "" || $priezvisko == "" || $heslo == "" || $heslo2 == "") {
            $chyba .= "Všetky polia musia byť vyplnené <br>";
            $registraciaOK = false;
        }


        //ak je vsetko spravne, registruj
        if($registraciaOK) {
            Auth::registruj($email,$meno,$priezvisko,$heslo,"user");
            $this->redirect("auth","loginForm",["login_message" => "Registrácia úspešná! Teraz sa môžete prihlásiť."]);
        } else {
            $this->redirect("auth","registraciaForm",["sprava" => $chyba,"sprava_typ" => "danger"]);
        }
    }


}