<?php

namespace App\Interfaces;

interface BaseInterface 
{
    public function getById ($id);
    public function create ($data);
}