<?php


interface ScreeningRepositoryV3
{
    public function findById( ScreeningId $screening_id );
    public function insert( ScreeningV3 $screening );
    public function update( ScreeningV3 $screening );
}