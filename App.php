<?php
require_once "DBStorage.php";

require_once "Prispevok.php";

class App
{
    private DBStorage $storage;

    public function  __construct()
    {
        $this->storage = new DBStorage();

    }

    public function getAllPosts()
    {
        return $this->storage->getAllPosts();
    }

    public function runQuery($sql)
    {
        $stmt = $this->storage->getConnection()->prepare($sql);
        return $stmt;
    }

    public function insert($meno, $text)
    {
        try {
            $datum = date('Y-m-d H:i:s');
            $stmt = $this->storage->getConnection()->prepare("INSERT INTO kn_prispevok(meno, text, datum) VALUES(:meno, :text, :datum) ");
            $stmt->bindParam(':meno' , $meno);
            $stmt->bindParam(':text' , $text);
            $stmt->bindParam(':datum' , $datum);
            $stmt->execute();
            return $stmt;
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function update($id, $meno, $text) {
        try {
            $stmt = $this->storage->getConnection()->prepare("UPDATE kn_prispevok SET meno=:meno, text=:text WHERE id=:id");
            $stmt->bindParam(':meno', $meno);
            $stmt->bindParam(':text' , $text);
            $stmt->bindParam(':id' , $id);

            $stmt->execute();
            return $stmt;
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function delete($id) {
        try {
            $stmt = $this->storage->getConnection()->prepare("DELETE FROM kn_prispevok WHERE id=:id");
            $stmt->bindParam(':id',$id);
            $stmt->execute();
            return $stmt;
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function redirect($url)
    {
        header("location: $url");
        exit();
    }

    public function showAlert($type, $message)
    {
        return <<<HTML
                    <div class="alert alert-{$type} alert-dismissible fade show" role="alert">
                        {$message}
                        <span type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </span>
                    </div>
                  HTML;
    }

    public function checkInput($input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }
}