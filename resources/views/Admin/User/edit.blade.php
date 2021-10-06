@extends('Admin.index')
@section('main')
    <edit-user :user="{{ $user }}" :roles="{{ $roles }}"></edit-user>
@endsection
