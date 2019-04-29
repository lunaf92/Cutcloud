@extends('/inc.admin-template')

@section('content')
    <h1 class="jumbotron mb-5 text-center">UPdate menu description</h1>
    {!! Form::open(['action' => ['MenuController@update', $menu->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="container">
        <div class="form-group col-3">
            <span>Category: </span>{{$menu->category}}
        </div>
        <div class="form-group col-3">
                <span>Name: </span>{!!$menu->name!!}
        </div>
        <div class="form-group col-3 mb-5">
            <span>Choose the updated file: </span>{{Form::file('menu_description')}}
        </div>
        <div class="col-4">
            {{Form::hidden('_method', 'PUT')}}
            {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
        </div>
    </div>
        
        
    {!! Form::close() !!}
@endsection

