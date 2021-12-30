<?php

namespace App\Controllers;

use App\Auth;
use App\Core\Responses\Response;
use App\Models\Album;

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
                    "registration_error" => $this->request()->getValue("registration_error")
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

        if($email == "" || $meno == "" || $priezvisko == "" || $heslo == "" || $heslo2 == "") {
            $this->redirect("auth","registraciaForm",["registration_error" => "Vyplňte všetky polia!"]);
        } else {
            Auth::registruj($email,$meno,$priezvisko,$heslo,"user");
            $this->redirect("auth","loginForm",["login_message" => "Registrácia úspešná! Teraz sa môžete prihlásiť."]);
        }
    }


}