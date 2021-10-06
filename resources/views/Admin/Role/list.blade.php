@extends('Admin.index')
@section('main')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Name</th>
                        <th>Created Date</th>
                        <th>Edit</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($roles as $role)
                        <tr>
                            <td>{{ $loop->index +1 }}</td>
                            <td>{{ $role->name }}</td>
                            <td>{{ date($role->created_at) }}</td>
                            <td>
                                @can('edit role')
                                    <a href="{{ route('admin.role.edit',$role->id) }}" class="btn btn-info white text-white"><i class="fa fa-edit"></i></a>
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
