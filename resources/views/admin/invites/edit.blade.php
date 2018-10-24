@extends('layouts.admin_app')

@section('content')
    <div class="container">
        <form class="form-group" action="{{route('admin.invites.update', $invite)}}" method="post">
            @csrf
            <input name="_method" type="hidden" value="PUT">
            @include('admin.invites.form')
        </form>
    </div>
@endsection