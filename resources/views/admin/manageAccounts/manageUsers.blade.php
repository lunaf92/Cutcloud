@extends('/inc.admin-template')

@section('content')
    <h1 class="mb-5">Manage Users</h1>
    <div class="wrapper">
        @foreach ($users as $user)
            <div class="mb-2 border-bottom row">
                <span class="col-md-4 text-left">{{$user->first_name. ' '.$user->last_name}}</span>
                <a href="{{action('AccountsController@editUser', "$user->id")}}" class="btn btn-success col-md-1">Edit</a>
                    {!! Form::open(['action' => ['AccountsController@deleteUser', $user->id], 'method' => 'POST', 'class' => 'float-right col-md-1']) !!}
                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                    {!! Form::close() !!}
            </div>       
        @endforeach
    </div>
    
@endsection