<?php

namespace App\Models;

class Oznam extends \App\Core\Model
{

    public function __construct(
        public int $id = 0,
        public string $nadpis = "",
        public string $text = "",
        public string $datumPridania = ""
    )
    {
    }

    static public function setDbColumns()
    {
        return ["id", "nadpis", "text", "datumPridania"];
    }

    static public function setTableName()
    {
        return "oznam";
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
    public function getNadpis(): string
    {
        return $this->nadpis;
    }

    /**
     * @param string $nadpis
     */
    public function setNadpis(string $nadpis): void
    {
        $this->nadpis = $nadpis;
    }

    /**
     * @return string
     */
    public function getDatumPridania(): string
    {
        return $this->datumPridania;
    }

    /**
     * @param string $datumPridania
     */
    public function setDatumPridania(string $datumPridania): void
    {
        $this->datumPridania = $datumPridania;
    }
}