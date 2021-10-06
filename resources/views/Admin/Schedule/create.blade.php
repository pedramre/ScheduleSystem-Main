@extends('Admin.index')
@section('main')
    <create-schedule :jobs="{{ $jobs }}"></create-schedule>
@endsection
