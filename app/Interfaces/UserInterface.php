<?php
namespace App\Interfaces;

interface UserInterface extends BaseInterface 
{
    public function getByPhone ($phoneNumber);
    public function all ();
}