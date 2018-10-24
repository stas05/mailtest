@extends('layouts.app')

@section('content')
    <div class="container">
        <form class="form-group" action="{{route('user-change', $user)}}" method="post">
            @csrf
            @include('form')
        </form>
    </div>
@endsection