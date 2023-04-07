<?php

namespace App\Repositories;

use App\Interfaces\ScoreInterface;
use App\Models\Score;

class ScoreRepository implements ScoreInterface 
{
    public function getById ($id) {
        try {
            return Score::find($id);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function create ($data) {
        try {
            if ($data[Score::SCORE_COL] < 0) {
                $data[Score::SCORE_COL] = 0;
            }
            return Score::create([
                Score::USER_ID_COL => $data[Score::USER_ID_COL],
                Score::GAME_ID_COL => $data[Score::GAME_ID_COL],
                Score::SCORE_COL => $data[Score::SCORE_COL],
            ]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function update ($userId, $gameId, $score) {
        try {
            return Score::where(Score::USER_ID_COL, $userId)
                ->where(Score::GAME_ID_COL, $gameId)
                ->update([
                    Score::SCORE_COL => $score
                ]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getByUserAndGame ($userId, $gameId) {
        try {
            return Score::where(Score::USER_ID_COL, $userId)
                ->where(Score::GAME_ID_COL, $gameId)
                ->first();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}