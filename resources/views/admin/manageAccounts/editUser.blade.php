@extends('/inc.admin-template')

@section('content')
    <h1 class="mb-5">Edit User Data</h1>
    <div class="wrapper">
        {!! Form::open(['action' => ['AccountsController@updateUser', $user->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            <div class="form-group row">
                <span class="col-md-6 border-right">
                    Old User Data Here:
                </span>
                <span class="col-md-6">
                    New User Data Here:
                </span>
            </div>
            <div class="form-group row">
                <span class="col-md-3">
                    First name:
                </span>
                <span class="col-md-3">
                    {{$user->first_name}}
                </span>
                <span class="col-md-6">
                    <input type="text" name="first_name" id="first_name" value="{{$user->first_name}}">
                </span>
            </div>
            <div class="form-group row">
                <span class="col-md-3">
                    Last name:
                </span>
                <span class="col-md-3">
                    {{$user->last_name}}
                </span>
                <span class="col-md-6">
                    <input type="text" name="last_name" id="last_name" value="{{$user->last_name}}">
                </span>
            </div>
            <div class="form-group row">
                <span class="col-md-3">
                    Email Address:
                </span>
                <span class="col-md-3">
                    {{$user->email}}
                </span>
                <span class="col-md-6">
                    <input type="text" name="email" id="email" value="{{$user->email}}">
                </span>
            </div>
            <div class="form-group row">
                <span class="col-md-3">
                    Position
                </span>
                <span class="col-md-3">
                    {{$user->position}}
                </span>
                <span class="col-md-6">
                    <select name="position" id="position">
                        <option value="{{$user->position}}">{{$user->position}}</option>
                        <option value="manager">manager</option>
                        <option value="supervisor">supervisor</option>
                        <option value="hostess">hostess</option>
                        <option value="sommelier">sommelier</option>
                        <option value="chef de rang">chef de rang</option>
                        <option value="expo">expo</option>
                        <option value="commis">commis</option>
                        <option value="casual">casual</option>
                    </select>
                </span>
            </div>
            {{Form::hidden('_method', 'PUT')}}
            {{Form::submit('Submit', ['class' => 'btn btn-primary text-center'])}}
        {!! Form::close() !!}
    </div>
    
@endsection