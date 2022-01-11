<?php

namespace App\Models;

class KnihaNavstevPrispevok extends \App\Core\Model
{

    public function __construct(
        public int $id = 0,
        public string $text = "",
        public string $datum_pridania = "",
        public string $uzivatel_email = ""

    )
    {

    }

    static public function setDbColumns()
    {
        return ["id", "text", "datum_pridania", "uzivatel_email"];
    }

    static public function setTableName()
    {
        return "kniha_navstev_prispevok";
    }
}