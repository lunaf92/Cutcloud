@extends('/inc.admin-template')

@section('content')
    <h1 class="mb-5">Update your password</h1>
    {!! Form::open(['action' => ['AccountsController@updatePassword', $user->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('current', 'Please enter your old password: ')}}
            <input id="current" type="password" class="form-control" name="current" required>

        </div>
        <div class="form-group">
            {{Form::label('password', 'Please enter your new password: ')}}
            <input id="password" type="password" class="form-control" name="password" required>
        </div>
        <div class="form-group">
            {{Form::label('password_confirmation', 'Please confirm your new password: ')}}
            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
        </div>
        {{Form::hidden('_method', 'PUT')}}
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection