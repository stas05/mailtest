@extends('layouts.admin_app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Invites
                        <a href="{{route('admin.invites.create')}}" class="btn btn-success float-right"><i class="fas fa-plus"></i> New</a>
                    </div>
                    @if(count($invites) > 0)
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Invite From</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Sent Data</th>
                                <th scope="col">Status</th>
                                <th scope="col">Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($invites as $invite)
                                <tr>
                                    <td>{{$invite->id}}</td>
                                    <td>{{$invite->getUser['name']}}</td>
                                    <td>{{$invite->name}}</td>
                                    <td>{{$invite->email}}</td>
                                    <td>{{$invite->sent_date}}</td>
                                    <td>{{$invite->status['name']}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a  class="btn btn-primary btn-sm" href="{{route('admin.invites.edit', $invite)}}"><i class="fas fa-edit"></i></a>
                                            @if(Auth::user()->isAdmin())
                                                <form action="{{route('admin.invites.destroy', $invite)}}" onsubmit="if(confirm('Are you sure that you want Delete Invite?')){return true}else{return false}" method="POST">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm" ><i class="fas fa-trash-alt"></i></button>
                                                </form>
                                                @if($invite->status['name'] != 'invited')
                                                    <form action="{{route('admin.invites.send')}}" method="POST">
                                                        @csrf
                                                        <input  hidden name="invite_id" id="invite_id" value="{{$invite->id}}">
                                                        <button type="submit" class="btn btn-info btn-sm" ><i class="fas fa-comments"></i></button>
                                                    </form>
                                                @endif
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
                        <div class="text-center">No data</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

