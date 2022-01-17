<?php

namespace App\Controllers;

use App\Core\Responses\Response;

class RestauraciaController extends AControllerRedirect
{

    /**
     * @inheritDoc
     */
    public function index()
    {
        return $this->html(
            [

            ]);
    }
}