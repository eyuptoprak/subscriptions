<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class AppleSubscription extends Model
{
    protected $fillable = ['receipt', 'expire_date'];
    protected $table = "apple_subscriptions";
    protected $guarded = ['id'];

    /**
     * @param $date
     * @return Carbon
     */
    public function getExpireDateAttribute($date): Carbon
    {
        return Carbon::parse($date);
    }
}
