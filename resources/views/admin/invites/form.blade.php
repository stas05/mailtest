@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif

<input hidden name="author" type="text" value="{{Auth::user()->id}}">
<div class="form-group">
    <label for="">Name</label>
    <input class="form-control" type="text" name="name" placeholder="Enter Name" value="@if(old('name')){{old('name')}}@else{{$invite->name ?? ""}}@endif">
</div>
<div class="form-group">
    <label for="">Email</label>
    <input class="form-control" type="email" name="email" placeholder="Enter Email" value="@if(old('email')){{old('email')}}@else{{$invite->email ?? ""}}@endif">
</div>
<div class="form-group">
    <label for="">Text of Invite</label>
    <textarea class="form-control" type="text" id="invite_text" name="invite_text" >@if(old('invite_text')){{old('invite_text')}}@else{{$invite->text_of_invite ?? ""}}@endif</textarea>
</div>
<input class="btn btn-primary" type="submit" value="Save">
<a class="btn btn-dark" href="{{route('admin.invites.index')}}" >Back</a>
