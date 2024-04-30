@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Login</h2>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
            @error('username')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required autocomplete="current-password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary mt-3">Submit</button>
        

    </form>
    <a href="/" class="btn btn-secondary mt-3"><i class="fas fa-arrow-left mr-2"></i>Back</a>
</div>
@endsection
