@extends('layouts.admin_app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Users
                        <a href="{{route('admin.users.create')}}" class="btn btn-success float-right"><i class="fas fa-plus"></i> New</a>
                    </div>
                    @if(count($users) > 0)
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Registration Date</th>
                                <th scope="col">Last Sign In</th>
                                <th scope="col">Status</th>
                                <th scope="col">Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->registration_date}}</td>
                                <td>{{$user->date_of_last_sign_in}}</td>
                                <td>{{$user->status['name']}}</td>
                                <td>
                                    <div class="btn-group">
                                        <a  class="btn btn-success btn-sm" href="{{route('admin.users.edit', $user)}}"><i class="fas fa-edit"></i></a>
                                       @if(!$user->isAdmin())
                                            <form action="{{route('admin.users.destroy', $user)}}" onsubmit="if(confirm('Are you sure that you want Delete User?')){return true}else{return false}" method="POST">
                                                <input type="hidden" name="_method" value="DELETE">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                            </form>
                                       @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                            <tfoot>

                            </tfoot>
                        </table>
                    @else
                        <div>No data</div>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection