@extends('Admin.index')
@section('main')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                @can('create job')
                    <a href="{{ route('admin.job.create') }}" class="btn btn-success float-right text-white"><i class="fa fa-plus-circle"></i></a>
                @endcan
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Name</th>
                        <th>Creator</th>
                        <th>Created Date</th>
                        <th>Edit</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($jobs as $job)
                        <tr>
                            <td>{{ $loop->index +1 }}</td>
                            <td>{{ $job->name }}</td>
                            <td>{{ $job->user->name }}</td>
                            <td>{{ date($job->created_at) }}</td>
                            <td>
                                @can('edit job')
                                    <a href="{{ route('admin.job.edit',$job->uuid) }}" class="btn btn-info white text-white"><i class="fa fa-edit"></i></a>
                                @endcan
                                @can('delete job')
                                    <delete-button address="admin/job/delete" id="{{$job->uuid}}"></delete-button>
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
