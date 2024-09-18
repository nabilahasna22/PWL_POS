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

        /*$user = UserModel::findOr(20, ['username', 'nama'], function(){
            abort(404);
        });*/

        //$user = UserModel::findOrFail(1);

        //$user = UserModel::where('username', 'manager9')->firstOrFail();
        
        //$user = UserModel::where('level_id', 2)->count();
        //dd($user);

        /*$user = UserModel::firstOrCreate(
            [
                'username' => 'manager22',
                'nama' => 'Manager Dua Dua',
                'password' => Hash::make('12345'),
                'level_id' => 2
            ],
        );*/
        $user = UserModel::firstOrNew(
            [
                'username' => 'manager33',
                'nama' => 'Manager Tiga Tiga',
                'password' => Hash::make('12345'),
                'level_id' => 2
            ],
        );
        $user->save();
        return view('user', ['data' => $user]);
    }
}
