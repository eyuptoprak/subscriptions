<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThirdParty extends Model
{
    use HasFactory;

    protected $fillable = ['url','appId'];
    protected $table = "third_parties";
    protected $guarded = ['id'];
}
