<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = ['receipt','status','client_token', 'appId', 'expire_date','store'];
    protected $table = "purchases";
    protected $guarded = ['id'];

    public function getExpireDateAttribute($date)
    {
        return Carbon::parse($date);
    }
}
