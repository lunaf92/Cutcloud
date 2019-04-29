@extends('/inc.admin-template')

@section('content')
    <div class="wrapper-post">
        <h1 class="mb-5">Your Profile</h1>
        <div class="mb-3">
            <a href="/adminEmail">
                <div class="col-md-3 btn btn-outline-secondary m-auto">Update your email address</div>
            </a>
        </div>
        <div class="mb-3">
            <a href="/adminPassword">
                <div class="col-md-3 btn btn-outline-secondary m-auto">Update your password</div>
            </a>
        </div>
        <div class="mb-3">
            <a href="/manageUsers">
                <div class="col-md-3 btn btn-outline-secondary m-auto">Manage users</div>
            </a>
        </div>
    </div>
    
@endsection