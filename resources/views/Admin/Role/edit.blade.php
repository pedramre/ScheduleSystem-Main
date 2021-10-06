@extends('Admin.index')
@section('main')
    <edit-role :role="{{ $role }}" :permissions="{{ $permissions }}"></edit-role>
@endsection
