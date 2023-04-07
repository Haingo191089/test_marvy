<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\User;

class UserRepository implements UserInterface 
{
    public function getById ($id) {
        try {
            return User::find($id);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getByPhone ($phoneNumber) {
        try {
            return User::where(User::PHONE_NUMBER_COL, $phoneNumber)->first();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function create ($data) {
        try {
            return User::create([
                User::NAME_COL => $data[User::NAME_COL],
                User::PHONE_NUMBER_COL => $data[User::PHONE_NUMBER_COL],
            ]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function all () {
        try {
            return User::all();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}