@extends('auth.head')

@section('content')
    
    <div class="card border-0">
        <div class="card-header">
            <div class="edit-profile__title">
                <h6>Forgot Password?</h6>
            </div>
        </div>
        <div class="card-body">
            <div class="edit-profile__body">
                <p>Enter the email address you used when you joined and we’ll send you instructions to reset your password.</p>
                <div class="form-group mb-20">
                    <label for="email">Email Adress</label>
                    <input type="text" class="form-control" id="email" placeholder="name@example.com">
                </div>
                <div class="d-flex">
                    <button class="btn btn-primary btn-default btn-squared text-capitalize lh-normal px-md-50 py-15 signIn-createBtn">
                        Send Reset Instructions
                    </button>
                </div>
            </div>
        </div>
        <div class="admin-topbar">
            <p class="mb-0">
                Have an account?
                <a href="{{ route('login') }}" class="color-primary">
                    Sign In
                </a>
            </p>
        </div>
    </div>

@endsection
