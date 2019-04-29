@extends('/inc.template')

@section('content')
<div class="wrapper-post container-fluid">
    <h1 class="mb-5">Update your email</h1>
    {!! Form::open(['action' => ['UserAccount@updateEmail', $user->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('oldMail', 'Please enter your old email address: ')}}
            {{Form::text('oldMail', '', ['class' => 'form-control col-md-4 col-xs-12', 'placeholder' => 'oldEmail@email.com'])}}
        </div>
        <div class="form-group">
            {{Form::label('email', 'Please enter your new email address: ')}}
            {{Form::text('email', '', ['class' => 'form-control col-md-4 col-xs-12', 'placeholder' => 'newEmail@email.com'])}}
        </div>
        {{Form::hidden('_method', 'PUT')}}
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
</div>
    
@endsection