<?php

namespace App\Http\Controllers\Api;

use App\Events\AddSchedule;
use App\Http\Controllers\Controller;
use App\Http\Enum;
use App\Http\Response;
use App\Models\Schedules;
use Illuminate\Http\Request;
use Validator;

class ScheduleController extends Controller
{
    public function create(Request $request, Response $response)
    {
        $input = $request->all();
        $validator = Validator::make($input['schedule'], [
            'name' => 'required|max:30',
            'job_id' => 'required|exists:jobs,id',
            'set_date' => 'required',
        ]);
        if ($validator->fails()) {
            return $response->setSuccess(false)
                ->setMessage('Please Enter Valid Character')
                ->setData(['errorMessages' => $validator->messages()])
                ->send();
        }

        if (Schedules::hasScheduleThisDay($input['schedule']['set_date'], $input['schedule']['job_id'])) {
            return $response->setSuccess(false)
                ->setMessage('Schedule has been registered in this day , Please choose another date')
                ->send();
        }

        $input['schedule']['user_id'] = auth()->user()->id;
        $schedule = Schedules::create($input['schedule']);

        if (!empty($schedule)) {
            event(new AddSchedule($schedule));
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
        $validator = Validator::make($input['schedule'], [
            'name' => 'required|max:30',
            'job_id' => 'required|exists:jobs,id',
            'set_date' => 'required',
        ]);

        if ($validator->fails()) {
            return $response->setSuccess(false)
                ->setMessage('Please Enter Valid Character')
                ->setData(['errorMessages' => $validator->messages()])
                ->send();
        }

        if (Schedules::hasScheduleThisDay($input['schedule']['set_date'], $input['schedule']['job_id'], $input['schedule']['id'])) {
            return $response->setSuccess(false)
                ->setMessage('Schedule has been registered in this day , Please choose another date')
                ->send();
        }

        if (Schedules::whereUuid($input['schedule']['uuid'])->update($input['schedule'])) {
            return $response->setMessage('Edit Successfully')->send();
        } else {
            return $response->setSuccess(false)
                ->setMessage('Please try again ...')
                ->send();
        }
    }

    public function delete(Request $request, Response $response)
    {
        $job = Schedules::whereUuid($request->id)->first();
        if (!empty($job)) {
            $job->delete();
            return $response->setMessage('Delete Successfully')->send();
        } else {
            return $response->setSuccess(false)
                ->setMessage('Dont have any schedule')
                ->send();
        }
    }

    public function status(Request $request, Response $response)
    {
        $job = Schedules::whereUuid($request->id)->first();
        if (!empty($job)) {
            $job->status = $job->status == Enum::SCHEDULE_STATUS_PENDING ? Enum::SCHEDULE_STATUS_ACCEPT : Enum::SCHEDULE_STATUS_PENDING;
            $job->save();
            return $response->setMessage('Change Status Successfully')->send();
        } else {
            return $response->setSuccess(false)
                ->setMessage('Dont have any schedule')
                ->send();
        }
    }

}
