@extends('/inc.hometemplate')

@section('content')
<div class="wrapper-post">
    <div class="text-center">
        <div class="text-center">
                <img class="d-none d-md-inline" src="https://www.superyachts.com/syv2/newsimages/584/290/90/c/3e74/cms/luxury_style/8322-the-original-celebrity-chef-an-interview-with-wolfgang-puck.jpg" alt="">
        </div>
        <div class="text-center">
                <img class="d-xs-inline d-sm-inline d-md-none d-lg-none" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRK0gukBvVJK1lycgdlzQ534wKSgH0i4Ba13PnAnxxrW38u6Mpw" alt="CUT at 45 park lane">
        </div>
        <br>
        <h1 class="mt-5">Welcome to CUT!</h1>
        <br><br>
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-3">
                {{-- <p>
                    <a href="{{ route('login') }}" class="btn btn-success btn-lrg" role="button">{{ __('Login') }}</a>
                </p>
                <p>
                    <a href="{{ route('admin.login') }}"  class="d-none d-lg-block">(log in as Admin)</a>
                </p>     --}}
            </div>
            <div class="col-sm-2"></div>
            <div class="col-sm-3">
            </div>
            <div class="col-sm-2"></div>
        </div> 
    </div>
    </div>

@endsection