<?php

namespace App;

class Dummy
{
    private string $dummyString;

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

}