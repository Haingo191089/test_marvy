<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Closure;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Score;
use App\Models\Game;
use App\Interfaces\UserInterface;

use App\Utils\AppLog;


class UserController extends Controller
{
    
    public const REGISTER_URL = '/user/register';
    public const REGISTER_METHOD = 'register';

    public const GET_USER_INFO_URL = '/user/{user_id}';
    public const GET_USER_INFO_METHOD = 'getUserInfo';

    public const GET_ALL_USER_INFO_URL = '/user/all';
    public const GET_ALL_USER_INFO_METHOD = 'getAllUserInfo';

    public function __construct (protected UserInterface $userRepo) {

    }

    public function getAllUserInfo () {
        try {
            AppLog::logInfo('******* start api get all user info ***********');
            $users = $this->userRepo->all();
            if (empty($users)) {
                AppLog::logInfo('get user info success');
                return $this->reponseSuccess();
            }
            
            $data = [];
            foreach ($users as $user) {
                $data[] = [
                    User::NAME_COL => $user->{User::NAME_COL},
                    User::PHONE_NUMBER_COL => $user->{User::PHONE_NUMBER_COL},
                    SCORES => $this->getScoresOfUser($user)
                ];
            }
            
            AppLog::logInfo('get user info success');
            return $this->reponseSuccess($data);
        } catch (\Exception $e) {
            AppLog::logError($e->getMessage());
            return $this->reponseFail(__('messages.msg2'));
        }
    }

    public function getUserInfo (Request $request, $user_id) {
        try {
            AppLog::logInfo('******* start api get user info ***********', $user_id);
            $user = $this->userRepo->getById($user_id);
            if (empty($user)) {
                AppLog::logInfo('get user info success');
                return $this->reponseSuccess();
            }
            
            $data = [
                User::NAME_COL => $user->{User::NAME_COL},
                User::PHONE_NUMBER_COL => $user->{User::PHONE_NUMBER_COL},
                SCORES => $this->getScoresOfUser($user)
            ];

            AppLog::logInfo('get user info success');
            return $this->reponseSuccess($data);
        } catch (\Exception $e) {
            AppLog::logError($e->getMessage());
            return $this->reponseFail(__('messages.msg2'));
        }
    }

    private function getScoresOfUser ($user) {
        $result = [];
        $scores = $user->scores;
        foreach ($scores as $score) {
            $result[] = [
                SCORE => $score->{Score::SCORE_COL},
                GAME => $score->game->{Game::NAME_COL}
            ];
        }

        return $result;
    }

    public function register (Request $request) {
        try {
            AppLog::logInfo('******* start api register ***********', $request->all());
            $input = $request->all();
            $validate = $this->validateInputRegister($input);

            if ($validate[STATUS] == false) {
                AppLog::logInfo('validate fail');
                return $this->reponseFail($validate[ERR_MSG]);
            }
            DB::beginTransaction();
            $user = $this->userRepo->getByPhone($input[User::PHONE_NUMBER_COL]);

            if ($user) {
                if ($user->{User::NAME_COL} == $input[User::NAME_COL]) {
                    AppLog::logInfo('user existed', [USER_ID => $user->{User::ID_COL}]);
                    return $this->reponseSuccess([USER_ID => $user->{User::ID_COL}]);
                }
                AppLog::logInfo(__('messages.msg7'));
                return $this->reponseFail(__('messages.msg7'));
            }
            
            $user = $this->userRepo->create($input);
            DB::commit();
            AppLog::logInfo('user created', [USER_ID => $user->{User::ID_COL}]);
            return $this->reponseSuccess([USER_ID => $user->{User::ID_COL}]);
          
        } catch (\Exception $e) {
            AppLog::logError($e->getMessage());
            DB::rollBack();
            return $this->reponseFail(__('messages.msg2'));
        }
        
    }

    private function validateInputRegister ($input) {
        $result = [
            STATUS => true,
            ERR_MSG => []
        ];

        $messages = [
            'required' => __('messages.msg1'),
        ];

        $rules = [
            User::NAME_COL => 'required',
            User::PHONE_NUMBER_COL => ['required', function (string $attribute, mixed $value, Closure $fail) {
                $exp = "/^0\d{9,10}$/i";
                if (!preg_match($exp, $value)) {
                    $fail(__('messages.msg3'));
                }
            },],
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
