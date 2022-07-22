@extends('template')
@section('title', 'Login Page')

@section('content')
    <div class="row">
        <div class="col-md-9">
            <h1>Login Button</h1>
            <div class="form-control" style="margin:20px">

                <input type="text" class="input-group input-group-lg" value="Login" disabled>
                <input type="password" class="input-group input-group-lg" value="Password" disabled>
            </div>
            <a href="{{ route('authenticate') }}" class="btn btn-lg btn-success">LOGIN</a>
        </div>
    </div>
</div>
@endsection