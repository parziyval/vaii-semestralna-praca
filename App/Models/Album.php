<?php

namespace App\Models;

class Album extends \App\Core\Model
{
    public function __construct(
        public int $id = 0,
        public string $thumbnail = "",
        public string $popisok = ""
    )
    {
    }

    static public function setDbColumns()
    {
        return ["id","thumbnail","popisok"];
    }

    static public function setTableName()
    {
        return "album";
    }

    public function getObrazky()
    {
        return Obrazok::getAll('album_id = ?', [$this->id]);
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
    public function getThumbnail(): string
    {
        return $this->thumbnail;
    }

    /**
     * @param string $thumbnail
     */
    public function setThumbnail(string $thumbnail): void
    {
        $this->thumbnail = $thumbnail;
    }

    /**
     * @return string
     */
    public function getPopisok(): string
    {
        return $this->popisok;
    }

    /**
     * @param string $popisok
     */
    public function setPopisok(string $popisok): void
    {
        $this->popisok = $popisok;
    }
}