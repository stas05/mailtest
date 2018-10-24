@extends('layouts.admin_app')

@section('content')
    <div class="container">
        <form class="form-group" action="{{route('admin.invites.store')}}" method="post">
            @csrf
            @include('admin.invites.form')
        </form>
    </div>
@endsection
