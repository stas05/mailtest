@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-group">
    <label for="">Password</label>
    <input class="form-control" type="text" name="password" placeholder="Enter New Password" value="">
</div>
<div class="form-group">
    <label for="">Password Confirm</label>
    <input class="form-control" type="text" name="password_confirmation" placeholder="confirm youre password" value="">
</div>
@php
    $arr = ['woman', 'man'];
@endphp

<div class="form-group">
    <label for="">SEX</label>
    <select class="form-control" name="sex">
        @if(!isset($user->sex))
            <option selected value="">Chose ..</option>
        @endif
        @foreach($arr as $i => $val)
            <option @if(isset($user->sex) && $user->sex == $i)selected @endif value="{{$i}}">{{$val}}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="">Location</label>
    <input class="form-control" type="text" name="location" placeholder="Enter Location" value="@if(old('location')){{old('location')}}@else{{$user->location ?? ""}}@endif">
</div>

<input class="btn btn-primary" type="submit" value="Save">
<a class="btn btn-dark" href="{{route('admin.users.index')}}" >Back</a>