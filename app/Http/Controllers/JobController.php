<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class JobController extends Controller
{
    public function list(){
        $jobs = Job::get();
        return view('Admin.Job.list',compact('jobs'));
    }

    public function create(){
        return view('Admin.Job.create');
    }

    public function edit($uuid){
        $job = Job::whereUuid($uuid)->first();
        return view('Admin.Job.edit',compact('job'));
    }

}
