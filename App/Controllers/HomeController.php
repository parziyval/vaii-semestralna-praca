<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Models\Oznam;

/**
 * Class HomeController
 * Example of simple controller
 * @package App\Controllers
 */
class HomeController extends AControllerBase
{

    public function index()
    {
        $oznamy = Oznam::getAll();
        return $this->html(
            [
                "oznamy" => $oznamy
            ]);
    }

}