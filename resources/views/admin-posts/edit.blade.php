@extends('/inc.admin-template')

@section('content')
    <div class="wrapper-post">
        <a href="/admin-post" class="btn btn-outline-secondary mb-3">Go Back</a>
        <h1>Edit Post</h1>
        {!! Form::open(['action' => ['AdminPostsController@update', $post->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            <div class="form-group">
                {{Form::label('title', 'Title')}}
                {{Form::text('title', $post->title, ['class' => 'form-control', 'placeholder' => 'title'])}}
            </div>
            <div class="form-group">
                {{Form::label('article-ckeditor', 'Body')}}
                {{Form::textarea('body', $post->body, ['id'  => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'insert your text here'])}}
            </div>
            <div class="form-group">
                {{Form::file('cover_image')}}
            </div>
            {{Form::hidden('_method', 'PUT')}}
            {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
        {!! Form::close() !!}
        </div>
    
@endsection