<?php

namespace App\Http\Controllers;

use App\Models\Schedules;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        Carbon::setWeekStartsAt(Carbon::SUNDAY);
        Carbon::setWeekEndsAt(Carbon::SATURDAY);
    }

    public function login()
    {
        return view('Admin.login');
    }

    public function register()
    {
        return view('Admin.register');
    }

    public function dashboard(Request $request)
    {
        $now = Carbon::now();
        if (isset($request->week)) {
            $now = $now->addWeeks($request->week);
        }

        $startOfWeek = $now->startOfWeek();
        $schedules = Schedules::with('job')
            ->accept()
            ->whereBetween('set_date', [$now->startOfWeek()->toDateTimeString(), $now->endOfWeek()->toDateTimeString()])
            ->orderBy('set_date', 'desc')
            ->get()->groupBy('job.name');

        return view('Admin.dashboard', compact('schedules', 'now'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('login'));
    }

    function list() {
        $users = User::get();
        return view('Admin.User.list', compact('users'));
    }

    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all();
        return view('Admin.User.edit', compact('user', 'roles'));
    }

}
