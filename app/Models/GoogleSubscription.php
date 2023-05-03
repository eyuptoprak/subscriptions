<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class GoogleSubscription extends Model
{
    protected $fillable = ['receipt', 'expire_date'];
    protected $table = "google_subscriptions";
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
