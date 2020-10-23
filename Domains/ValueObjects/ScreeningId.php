<?php


class ScreeningId
{
    private $value;

    public function __construct()
    {
        $this->value = uniqid();
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    public function reconstruct( $value )
    {
        $screening_id = new ScreeningId();
        $screening_id->value = $value;

        return $screening_id;
    }
}