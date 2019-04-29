@extends('/inc.admin-template')

@section('content')
<div class="wrapper-post"> 
    <a href="/admin-post" class="btn btn-outline-secondary mb-3">Go Back</a>
    <div class="card">
        <h1 class="card title">
            {{$post['title']}}
        </h1>
        <img style="max-width:20rem" src="/storage/cover_images/{{$post['cover_image']}}" alt="">
        <div class="card-body">
            {!!$post['body']!!}
        </div>
        <hr>
            <small>written on {{$post['created_at']}} </small>
    </div>
    <hr>
    <a href="/admin-post/{{$post->id}}/edit" class="btn btn-success float-left">Edit</a>

            {!! Form::open(['action' => ['AdminPostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'float-left ml-3']) !!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!! Form::close() !!}
</div>
@endsection