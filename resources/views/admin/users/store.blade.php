@extends('layouts.admin_app')

@section('content')
    <div class="container">
        <form class="" action="{{route('admin.users.store')}}" method="post">
            @csrf
            @include('admin.users.form')
        </form>
    </div>
@endsection