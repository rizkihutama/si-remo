@extends('layouts.app-auth')

@section('content')
<div class="col-lg-12">
    <div class="p-5">
        <div class="text-center">
            <h1 class="h4 text-gray-900 mb-5">Welcome Back!</h1>
        </div>

        <form class="user" action="{{ route('login') }}" method="POST">
            @csrf

            <div class="form-group">
                <input type="email" class="form-control form-control-user" id="email" name="email"
                    aria-describedby="emailHelp" placeholder="Enter Email Address..." value="{{ old('email') }}"
                    required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control form-control-user" id="password" name="password"
                    placeholder="Password" required>
            </div>
            {{-- <div class="form-group">
                <div class="custom-control custom-checkbox small">
                    <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                    <label class="custom-control-label" for="remember">Remember Me</label>
                </div>
            </div> --}}
            <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
        </form>

        <hr>
        {{-- <div class="text-center">
            <a class="small" href="#">Forgot Password?</a>
        </div> --}}
        <div class="text-center">
            <a class="small" href="{{ route('register') }}">Create an Account!</a>
        </div>
    </div>
</div>
@endsection