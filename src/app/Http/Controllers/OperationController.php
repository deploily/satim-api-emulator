<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OperationController extends Controller
{
    public function sum(int $a , int $b){

        return $a + $b;
    }
    public function substract(int $a , int $b){

        return $a - $b;
    }
}
