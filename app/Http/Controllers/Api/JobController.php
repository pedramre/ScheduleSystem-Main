<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Response;
use App\Models\Job;
use App\Models\Schedules;
use Illuminate\Http\Request;
use Validator;

class JobController extends Controller
{
    public function create(Request $request, Response $response)
    {
        $input = $request->all();
        $validator = Validator::make($input['job'], [
            'name' => 'required|max:30',
        ]);
        if ($validator->fails()) {
            return $response->setSuccess(false)
                ->setMessage('Please Enter Valid Character')
                ->setData(['errorMessages' => $validator->messages()])
                ->send();
        }

        $input['job']['user_id'] = auth()->user()->id;
        $job = Job::create($input['job']);

        if (!empty($job)) {
            return $response->setMessage('Add Successfully')->send();
        } else {
            return $response->setSuccess(false)
                ->setMessage('Please try again ...')
                ->send();
        }

    }

    public function edit(Request $request, Response $response)
    {
        $input = $request->all();
        $validator = Validator::make($input['job'], [
            'name' => 'required|max:30',
        ]);

        if ($validator->fails()) {
            return $response->setSuccess(false)
                ->setMessage('Please Enter Valid Character')
                ->setData(['errorMessages' => $validator->messages()])
                ->send();
        }

        if (Job::whereUuid($input['job']['uuid'])->update($input['job'])) {
            return $response->setMessage('Edit Successfully')->send();
        } else {
            return $response->setSuccess(false)
                ->setMessage('Please try again ...')
                ->send();
        }

    }

    public function delete(Request $request, Response $response)
    {
        $job = Job::whereUuid($request->id)->first();
        if (!empty($job)) {
            $schedule = Schedules::where('job_id',$job->id);
            if($schedule->count()>0){
                return $response->setSuccess(false)
                    ->setMessage('This job is used in schedule so ypu can not delete it')
                    ->send();
            }
            else{
                $job->delete();
                return $response->setMessage('Delete Successfully')->send();
            }
        } else {
            return $response->setSuccess(false)
                ->setMessage('Dont have any job')
                ->send();
        }
    }


}
