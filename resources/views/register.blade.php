@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Sign Up</h2>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" required>
            @error('username')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success mt-3">Register</button>

    </form>
    <a href="/" class="btn btn-secondary mt-3"><i class="fas fa-arrow-left mr-2"></i>Back</a>

</div>
@endsection
