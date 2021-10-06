<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Schedules;

class ScheduleController extends Controller
{
    function list() {
        $schedules = Schedules::orderBy('created_at', 'desc')->get();
        return view('Admin.Schedule.list', compact('schedules'));
    }

    public function create()
    {
        $jobs = Job::all();
        return view('Admin.Schedule.create', compact('jobs'));
    }

    public function edit($uuid)
    {
        $jobs = Job::all();
        $schedule = Schedules::whereUuid($uuid)->first();
        return view('Admin.Schedule.edit', compact('jobs', 'schedule'));
    }
}
