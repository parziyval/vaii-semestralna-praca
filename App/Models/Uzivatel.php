<?php

namespace App\Models;

class Uzivatel extends \App\Core\Model
{
    public string $email;
    public string $meno;
    public string $priezvisko;
    public string $heslo;
    public string $rola;

    public function __construct($email = "", $meno = "", $priezvisko="", $heslo="", $rola="")
    {
        $this->email = $email;
        $this->meno = $meno;
        $this->priezvisko = $priezvisko;
        $this->heslo = $heslo;
        $this->rola = $rola;
    }

    static public function setDbColumns()
    {
        return ["email","meno","priezvisko","heslo","rola"];
    }

    static public function setTableName()
    {
        return "uzivatel";
    }

    /**
     * @return string
     */
    public function getUzivatelskeMeno(): string
    {
        return $this->uzivatelske_meno;
    }

    /**
     * @param string $uzivatelske_meno
     */
    public function setUzivatelskeMeno(string $uzivatelske_meno): void
    {
        $this->uzivatelske_meno = $uzivatelske_meno;
    }

    /**
     * @return string
     */
    public function getMeno(): string
    {
        return $this->meno;
    }

    /**
     * @param string $meno
     */
    public function setMeno(string $meno): void
    {
        $this->meno = $meno;
    }

    /**
     * @return string
     */
    public function getPriezvisko(): string
    {
        return $this->priezvisko;
    }

    /**
     * @param string $priezvisko
     */
    public function setPriezvisko(string $priezvisko): void
    {
        $this->priezvisko = $priezvisko;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getHeslo(): string
    {
        return $this->heslo;
    }

    /**
     * @param string $heslo
     */
    public function setHeslo(string $heslo): void
    {
        $this->heslo = $heslo;
    }

    /**
     * @return string
     */
    public function getRola(): string
    {
        return $this->rola;
    }

    /**
     * @param string $rola
     */
    public function setRola(string $rola): void
    {
        $this->rola = $rola;
    }
}