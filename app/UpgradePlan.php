<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UpgradePlan extends Model
{
    protected $guarded = [];

    protected $table = "upgrade_plan";


    public function scopeThisMonth(Builder $query): Builder
    {

        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        return $query->whereBetween('updated_at', [$startDate, $endDate]);
    }
}
