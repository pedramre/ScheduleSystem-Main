<?php

namespace App\Models;

use App\Http\Enum;
use App\Http\Traits\Uuid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedules extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'name', 'user_id', 'job_id', 'description', 'set_date',
    ];

    public function scopeAccept($q)
    {
        return $q->where('status', Enum::SCHEDULE_STATUS_ACCEPT);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public static function hasScheduleThisDay($date, $jobId, $id = 0)
    {
        return Schedules::accept()->whereDate('set_date', Carbon::parse($date)->format('Y-m-d'))
            ->where('job_id', $jobId)
            ->where('id', '<>', $id)
            ->count() > 0;
    }

}
