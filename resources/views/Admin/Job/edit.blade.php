@extends('Admin.index')
@section('main')
    <edit-job :job="{{ $job }}"></edit-job>
@endsection
