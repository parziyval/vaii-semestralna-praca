<?php

namespace App\Controllers;

use App\Auth;
use App\Core\DB\Connection;
use App\Core\Responses\Response;
use App\Models\Uzivatel;

class AdminEditController extends AControllerRedirect
{

    /**
     * @inheritDoc
     */
    public function index()
    {
        if(Auth::jePrihlaseny() && Auth::getRola() == "admin") {
            $uzivatelia = Uzivatel::getAll();
            return $this->html(
                [
                    "uzivatelia" => $uzivatelia
                ]);
        } else {
            $this->redirect("home");
        }

    }

    public function upravUzivatela()
    {
        if(Auth::jePrihlaseny() && Auth::getRola() == "admin") {
            if(isset($_POST["stlpec"]) && isset($_POST["hodnota"]) && isset($_POST["id"])) {
                $stlpec = $_POST["stlpec"];
                $hodnota = $_POST["hodnota"];
                $edit_id = $_POST["id"];

                $stmt = Connection::connect()->prepare("UPDATE uzivatel SET $stlpec = ? WHERE id = ?");
                $stmt->execute([$hodnota, $edit_id]);
            }
        } else {
            $this->redirect("home");
        }
    }
}