@extends('Admin.index')
@section('main')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                @can('create schedule')
                    <a href="{{ route('admin.schedule.create') }}" class="btn btn-success float-right text-white"><i class="fa fa-plus-circle"></i></a>
                @endcan
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Name</th>
                        <th>Creator</th>
                        <th>Job</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Created Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($schedules as $schedule)
                        <tr>
                            <td>{{ $loop->index +1 }}</td>
                            <td>{{ $schedule->name }}</td>
                            <td>{{ $schedule->user->name }}</td>
                            <td>{{ $schedule->job->name }}</td>
                            <td>
                                <span class="{{$schedule->status == App\Http\Enum::SCHEDULE_STATUS_PENDING?'text-red':'text-green' }}">{{ $schedule->status }}</span>
                            </td>
                            <td>{{ date($schedule->set_date) }}</td>
                            <td>{{ date($schedule->created_at) }}</td>
                            <td>
                                @can('edit schedule')
                                    <a href="{{ route('admin.schedule.edit',$schedule->uuid) }}" class="btn btn-info white text-white"><i class="fa fa-edit"></i></a>
                                @endcan
                                @can('delete schedule')
                                    <delete-button address="admin/schedule/delete" id="{{$schedule->uuid}}"></delete-button>
                                @endcan
                                @can('publish schedule')
                                    <status-button address="admin/schedule/status" id="{{$schedule->uuid}}"></status-button>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
