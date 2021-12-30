<?php

namespace App;

use App\Models\Uzivatel;

class Auth
{
    public static function prihlas($email, $password)
    {
        if(!self::jeEmailPlatny($email) || $email == "" || $password == "") {
            return false;
        }

        $uzivatel = Uzivatel::getAll("email=?", [$email]);
        if(sizeof($uzivatel) == 0) {
            return false;
        } else if(sizeof($uzivatel) == 1){
            if(password_verify($password, $uzivatel[0]->getHeslo())) {
                $_SESSION["email"] = $email;
                $_SESSION["rola"] = $uzivatel[0]->getRola();
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

    public static function registruj($email,$meno,$priezvisko,$heslo,$rola)
    {
        $novyUzivatel = new Uzivatel($email,$meno,$priezvisko,password_hash($heslo,PASSWORD_DEFAULT),$rola);
        $novyUzivatel->save();
    }

    public static function jeEmailPlatny($email)
    {
        return (bool)preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email);
    }
}