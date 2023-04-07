<?php
namespace App\Interfaces;

interface ScoreInterface extends BaseInterface 
{
    public function update ($userId, $gameId, $score);
    public function getByUserAndGame ($userId, $gameId);
}