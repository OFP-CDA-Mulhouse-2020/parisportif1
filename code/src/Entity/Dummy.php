<?php

namespace App\Entity;

class Dummy
{
    private string $dummyString;
    private int $dummyInteger;

    /**
     * @return string
     */
    public function getDummyString(): string
    {
        return $this->dummyString;
    }

    /**
     * @param string $dummyString
     */
    public function setDummyString(string $dummyString): void
    {
        if (!preg_match("/^[a-zA-Z]+$/", $dummyString)) {
            throw new \InvalidArgumentException('is not string');
        }
        $this->dummyString = $dummyString;
    }

    /**
     * @return int
     */
    public function getDummyInteger(): int
    {
        return $this->dummyInteger;
    }

    /**
     * @param int $dummyInteger
     */
    public function setDummyInteger(int $dummyInteger): void
    {
        if (!preg_match("/^[0-9]+$/", $dummyInteger)) {
            throw new \InvalidArgumentException('is not string');
        }
        $this->dummyInteger = $dummyInteger;
    }
}
