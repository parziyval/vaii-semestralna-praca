<?php

class Prispevok
{
    public function __construct(private int $id = 0,
                                private string $meno = "",
                                private string $text="",
                                private string $datum="")
    {

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
    public function getMeno(): string
    {
        return $this->meno;
    }

    /**
     * @param string $meno
     */
    public function setMeno(string $meno): void
    {
        $this->meno = $meno;
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
    public function getDatum(): string
    {
        return $this->datum;
    }

    /**
     * @param string $datum
     */
    public function setDatum(string $datum): void
    {
        $this->datum = $datum;
    }

}