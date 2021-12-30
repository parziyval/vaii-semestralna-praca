<?php

namespace App\Models;

class Obrazok extends \App\Core\Model
{
    public function __construct(
        public int $id = 0,
        public string $subor = "",
        public int $album_id = 0
    )
    {
    }

    static public function setDbColumns()
    {
        return ["id","subor","album_id"];
    }

    static public function setTableName()
    {
        return "obrazok";
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
    public function getSubor(): string
    {
        return $this->subor;
    }

    /**
     * @param string $subor
     */
    public function setSubor(string $subor): void
    {
        $this->subor = $subor;
    }

    /**
     * @return int
     */
    public function getAlbumId(): int
    {
        return $this->album_id;
    }

    /**
     * @param int $album_id
     */
    public function setAlbumId(int $album_id): void
    {
        $this->album_id = $album_id;
    }
}