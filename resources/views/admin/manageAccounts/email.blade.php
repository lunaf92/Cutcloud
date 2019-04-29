@extends('/inc.admin-template')

@section('content')
    <h1 class="mb-5">Update your email</h1>
    {!! Form::open(['action' => ['AccountsController@updateEmail', $user->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('oldMail', 'Please enter your old email address: ')}}
            {{Form::text('oldMail', '', ['class' => 'form-control', 'placeholder' => 'oldEmail@email.com'])}}
        </div>
        <div class="form-group">
            {{Form::label('email', 'Please enter your new email address: ')}}
            {{Form::text('email', '', ['class' => 'form-control', 'placeholder' => 'newEmail@email.com'])}}
        </div>
        {{Form::hidden('_method', 'PUT')}}
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection