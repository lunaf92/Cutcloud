@extends('/inc.admin-template')

@section('content')
    <h1 class="jumbotron mb-5 text-center">Add menu item description</h1>
    {!! Form::open(['action' => 'MenuController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="container">
        <div class="form-group col-3">
            <select name="category" id="category">
                <option value="">please choose the category</option>
                <option value="breakfast">breakfast</option>
                <option value="starters">starters</option>
                <option value="mains">mains</option>
                <option value="desserts">desserts</option>
                <option value="rough cuts">rough cuts</option>
                <option value="wine">wine</option>
                <option value="cocktails">cocktails</option>
                <option value="spirits">spirits</option>
            </select>
        </div>
        <div class="form-group col-3">
            {{Form::label('name', 'Name')}}
            {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'name to be displayed'])}}
        </div>
        <div class="form-group col-3 mb-5">
            {{Form::file('menu_description')}}
        </div>
        <div class="col-4">
            {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
        </div>
    </div>
        
        
    {!! Form::close() !!}
@endsection

