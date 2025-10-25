<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $table = 'user'; // ✅ Nếu bảng là 'user' không có 's'

    protected $fillable = [
        'username',
        'email',
        'phone',
        'username',
        'password',
        'address',
        'avatar',
        'roles',        // ✅ đúng tên cột trong migration
        'created_by',
        'updated_by',
        'status',
        'avatar',
        'created_by',
        'name'

    ];
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    
}