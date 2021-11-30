<?php
    require_once "Prispevok.php";

class DBStorage
{
    private $connection;

    public function __construct()
    {
        try {
            $this->connection = new PDO("mysql:host=localhost;dbname=db", "root", "dtb456");
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Chyba: " . $e->getMessage());
        }
    }

    public function getAllPosts()
    {
        $statement = $this->connection->prepare("SELECT * FROM kn_prispevok");
        $statement->execute();
        //FETCH_PROPS_LATE - najprv sa zavola konstuktor  potom sa priradia properties
        $posts = $statement->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Prispevok::class);


        return $posts;
    }

    /**
     * @return PDO
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }

    /**
     * @param PDO $connection
     */
    public function setConnection(PDO $connection): void
    {
        $this->connection = $connection;
    }


}