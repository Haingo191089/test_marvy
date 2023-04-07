<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Closure;
use Illuminate\Support\Facades\DB;

use App\Models\Score;
use App\Interfaces\ScoreInterface;

use App\Utils\AppLog;

class ScoreController extends Controller
{
    public const SAVE_SCORE_URL = '/score/save';
    public const SAVE_SCORE_METHOD = 'save';

    public function __construct (protected ScoreInterface $scoreRepo) {

    }

    public function save (Request $request) {
        try {
            AppLog::logInfo('******* start api save score ***********', $request->all());
            
            $validateRequestOrigin = $this->validateRequestOrigin($request);

            if ($validateRequestOrigin[STATUS] == false) {
                AppLog::logInfo('origin is not allowed');
                return $this->reponseFail($validateRequestOrigin[ERR_MSG]);
            }
            
            $input = $request->all();
            $validate = $this->validateInputSaveScore($input);

            if ($validate[STATUS] == false) {
                AppLog::logInfo('validate fail');
                return $this->reponseFail($validate[ERR_MSG]);
            }

            DB::beginTransaction();
            $userId = $input[Score::USER_ID_COL];
            $gameId = $input[Score::GAME_ID_COL];
            $scoreInput = $input[Score::SCORE_COL];

            $scoreDB = $this->scoreRepo->getByUserAndGame($userId, $gameId);
            if ($scoreDB) {
                $updatedScore = $scoreInput + $scoreDB->{Score::SCORE_COL};
                
                if ($updatedScore < 0) {
                    $updatedScore = 0;
                }

                $this->scoreRepo->update($userId, $gameId, $updatedScore);
                DB::commit();
                AppLog::logInfo('update score success', $input);
                return $this->reponseSuccess();
            }

            $this->scoreRepo->create($input);
            DB::commit();
            AppLog::logInfo('save score success', $input);
            return $this->reponseSuccess();
        } catch (\Exception $e) {
            AppLog::logError($e->getMessage());
            DB::rollBack();
            return $this->reponseFail(__('messages.msg2'));
        }
        
    }

    private function validateRequestOrigin ($request) {
        $result = [
            STATUS => true,
            ERR_MSG => []
        ];

        $origin = $request->getHttpHost();
        $allowOrigins = config('app.allowed_origins');

        if (!in_array($origin, $allowOrigins)) {
            $result[STATUS] = false;
            $result[ERR_MSG] = __('messages.msg6');
            return $result;
        }

        return $result;
    }

    private function validateInputSaveScore ($input) {
        $result = [
            STATUS => true,
            ERR_MSG => []
        ];

        $messages = [
            'required' => __('messages.msg1'),
            'integer' => __('messages.msg4')
        ];

        $rules = [
            Score::USER_ID_COL => 'bail|required|integer',
            Score::GAME_ID_COL => 'bail|required|integer',
            Score::SCORE_COL => 'bail|required|integer',
        ];

        $validator = Validator::make($input, $rules, $messages);
 
        if ($validator->fails()) {
            $errors = $validator->errors();
            $result[STATUS] = false;
            $result[ERR_MSG] = $this->formatValidatorError($errors->getMessages());
        }

        return $result;
    }
}
