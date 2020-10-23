<?php


interface ScreeningRepositoryV4
{
    public function findById( ScreeningId $screening_id );
    public function insert( ScreeningV4 $screening );
    public function update( ScreeningV4 $screening );
}