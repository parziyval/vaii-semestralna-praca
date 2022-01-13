<?php

namespace App;

use App\Models\Uzivatel;

class Auth
{
    public static function prihlas($email, $password)
    {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL) && $email != "" && $password != "") {
            return false;
        }

        $uzivatel = Uzivatel::getAll("email=?", [$email]);
        if(sizeof($uzivatel) == 0) {
            return false;
        } else if(sizeof($uzivatel) == 1){
            if(password_verify($password, $uzivatel[0]->getHeslo())) {
                $_SESSION["email"] = $email;
                $_SESSION["rola"] = $uzivatel[0]->getRola();
                $_SESSION["id"] = $uzivatel[0]->getId();
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function odhlas()
    {
        unset($_SESSION["email"]);
        unset($_SESSION["rola"]);
        unset($_SESSION["id"]);
        session_destroy();
    }

    public static function jePrihlaseny()
    {
        return isset($_SESSION["email"]);
    }

    public static function getEmail()
    {
        return (Auth::jePrihlaseny() ? $_SESSION["email"] : " ");
    }

    public static function getRola()
    {
        return (Auth::jePrihlaseny() ? $_SESSION["rola"] : " ");
    }

    public static function getId()
    {
        return (Auth::jePrihlaseny() ? $_SESSION["id"] : " ");
    }

    public static function registruj($email,$meno,$priezvisko,$heslo,$rola)
    {
        $novyUzivatel = new Uzivatel(0, $email,$meno,$priezvisko,password_hash($heslo,PASSWORD_DEFAULT),$rola);
        $novyUzivatel->save();
    }
}