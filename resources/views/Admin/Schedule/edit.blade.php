@extends('Admin.index')
@section('main')
    <edit-schedule :schedule="{{ $schedule }}" :jobs="{{ $jobs }}"></edit-schedule>
@endsection
