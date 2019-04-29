@extends('/inc.admin-template')

@section('content')
    <h1 class="jumbotron mb-5 text-center">Add SOP description</h1>
    {!! Form::open(['action' => 'SOPController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="container">
        <div class="form-group col-3">
            <select name="category" id="category">
                <option value="">please choose the category</option>
                <option value="Service">Service</option>
                <option value="Communication">Communication</option>
                <option value="Health & Safety">Healt & Safety</option>
                <option value="Facilities">Facilities</option>
                <option value="Grooming">Grooming</option>
            </select>
        </div>
        <div class="form-group col-3">
            {{Form::label('name', 'Name')}}
            {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'name to be displayed'])}}
        </div>
        <div class="form-group col-3 mb-5">
            {{Form::file('SOP_description')}}
        </div>
        <div class="col-4">
            {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
        </div>
    </div>
        
        
    {!! Form::close() !!}
@endsection

