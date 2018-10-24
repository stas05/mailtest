@extends('layouts.admin_app')

@section('content')
    <div class="container">
        <form class="form-group" action="{{route('admin.users.update', $user)}}" method="post">
            @csrf
            <input name="_method" type="hidden" value="PUT">
            @include('admin.users.form')
        </form>
    </div>
@endsection