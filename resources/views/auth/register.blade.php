@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="col-md-5 mx-auto">
        <div class="card shadow">
            <div class="card-header bg-success text-white text-center">
                <h4>Register</h4>
            </div>
            <div class="card-body">
            <form action="{{ route('register.post') }}" method="POST">

                    @csrf
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <button class="btn btn-success w-100">Register</button>
                </form>
                <div class="text-center mt-3">
                <a href="{{ route('login') }}">Already have an account?</a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
