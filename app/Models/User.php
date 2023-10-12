<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    use HasUuids, HasApiTokens;

    public $timestamps = false;

    protected $fillable = ["username", "password"];
}
