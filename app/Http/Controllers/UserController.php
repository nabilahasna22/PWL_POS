<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {

        //$user = UserModel::find(1);

        //$user = UserModel::Where('level_id', 1)->first;

        //$user = UserModel::firstWhere('level_id', 1);

        $user = UserModel::findOr(20, ['username', 'nama'], function(){
            abort(404);
        });
        return view('user', ['data' => $user]);

    }
}
