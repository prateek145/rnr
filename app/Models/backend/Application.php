<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Application extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function username1()
    {
        return $this->hasOne(User::class);
    }
}
