<?php

namespace App\Models;

class KnihaNavstevPrispevok extends \App\Core\Model
{

    public function __construct(
        public int $id = 0,
        public string $text = "",
        public string $datum_pridania = "",
        public int $uzivatel_id = 0,
        public string $meno = "",
        public string $priezvisko = ""

    )
    {

    }

    static public function setDbColumns()
    {
        return ["id", "text", "datum_pridania", "uzivatel_id"];
    }

    static public function setTableName()
    {
        return "kniha_navstev_prispevok";
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getDatumPridania(): string
    {
        return $this->datum_pridania;
    }

    /**
     * @param string $datum_pridania
     */
    public function setDatumPridania(string $datum_pridania): void
    {
        $this->datum_pridania = $datum_pridania;
    }

    /**
     * @return int
     */
    public function getUzivatelId(): int
    {
        return $this->uzivatel_id;
    }

    /**
     * @param int $uzivatel_id
     */
    public function setUzivatelId(int $uzivatel_id): void
    {
        $this->uzivatel_id = $uzivatel_id;
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
}