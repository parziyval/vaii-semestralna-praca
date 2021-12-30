<?php

namespace App\Controllers;

use App\Core\Responses\Response;
use App\Models\Oznam;

class OznamController extends \App\Core\AControllerBase
{
    public function index()
    {
        $oznamy = Oznam::getAll();
        return $this->html(
            [
                "oznamy" => $oznamy
            ]);
    }

    public function oznam()
    {
        $oznamId = $this->request()->getValue("oznamid");
        $oznam = Oznam::getOne($oznamId);

        $nadpis = $oznam->getNadpis();
        $text = $oznam->getText();
        return $this->html(
            [
                "nadpis" => $nadpis,
                "text" => $text
            ]);
    }
}