<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LevelModel extends Model
{
    protected $table = 'm_level';
    protected $primarykey = 'level_id';

    public function user():BelongsTo {
        return $this->belongsTo(UserModel::class);
    }
    public function index() {
        $user = UserModel::with('level')->get();
        dd($user);
    }
}