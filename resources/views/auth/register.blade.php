@extends('layouts.app-auth')

@section('content')
<div class="col-lg-12">
    <div class="p-5">
        <div class="text-center">
            <h1 class="h4 text-gray-900 mb-5">Create an Account!</h1>
        </div>
        <form action="{{ route('register') }}" method="POST" class="form-user">
            @csrf

            <div class="form-group">
                <input type="text" class="form-control form-control-user @error('name') is-invalid @enderror" id="name"
                    name="name" placeholder="Name" value="{{ old('name') }}" required>

                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <input type="number" class="form-control form-control-user @error('phone') is-invalid @enderror"
                    id="phone" name="phone" placeholder="Phone Number"
                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0,this.maxLength);"
                    maxlength="13" value="{{ old('phone') }}" required>

                @error('phone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror"
                    id="email" name="email" placeholder="Email Address" required>

                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="password"
                        class="form-control form-control-user @error('password') is-invalid @enderror" id="password"
                        name="password" placeholder="Password" required>

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-sm-6">
                    <input type="password" class="form-control form-control-user" id="password_confirmation"
                        name="password_confirmation" placeholder="Repeat Password" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-user btn-block">Register Account</button>
        </form>
        <hr>
        {{-- <div class="text-center">
            <a class="small" href="#">Forgot Password?</a>
        </div> --}}
        <div class="text-center">
            <a class="small" href="{{ route('login') }}">Already have an account? Login!</a>
        </div>
    </div>
</div>
@endsection