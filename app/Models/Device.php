<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = ['uuid', 'appId', 'language_code', 'operating_system'];
    protected $table = "devices";
    protected $guarded = ['id'];

}
