@extends('/inc.admin-template')

@section('content')
    <div class="wrapper-post">
        <h1>Posts</h1>
        <a href="/admin-post/create" class="btn btn-outline-secondary mb-3">Create Post</a>
        @if (count($posts) >= 1)
            @foreach ($posts as $post)
                <div class="card card-title">
                    <div class="row">   
                        <div class="col-md-2 col-sm-2 ml-5">
                            <img style="min-height:150px; height:150px; min-width: 150px; width:150px" src="/storage/cover_images/{{$post->cover_image}}" alt="">
                        </div>    
                        <div class="col-md-8 col-sm-8">
                            <h3><a href="admin-post/{{$post['id']}}">{{$post['title']}}</a></h3>
                            <small>Written on {{$post['created_at']}}</small>
                        </div>
                    </div>
                    
                </div>
            @endforeach
            {!! $posts->render() !!}
        @else
            <p>No posts found</p>
        @endif
    </div>
    
@endsection