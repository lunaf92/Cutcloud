@extends('/inc.template')

@section('content')
<div class="wrapper-post">
    <a href="/home" class="btn btn-outline-secondary mb-3">Back</a>
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
</div>
    
@endsection
