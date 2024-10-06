<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LevelModel extends Model
{
    protected $table = 'm_level';
    protected $primaryKey = 'level_id';

    protected $fillable = ['level_kode','level_nama'];
    public function user():HasMany{
        return $this->hasMany(UserModel::class, 'user_id', 'user_id');
    }
    
    /*public function user():BelongsTo {
        return $this->belongsTo(UserModel::class);
    }
    public function index() {
        $user = UserModel::with('level')->get();
        dd($user);
    }*/
}