@extends('auth.head')

@push('js')
    <script>
        document.getElementById('doSignin').addEventListener('click', function(e) {
            e.preventDefault();
            var btn = this
            this.disabled = true

            let xhr = new XMLHttpRequest();

            let data = [];
            data.push(document.getElementById('email').value, document.getElementById('password-field').value)

            xhr.open("POST", "/dologin", false);

            let csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
            let csrfToken = csrfTokenMeta.getAttribute('content');

            xhr.setRequestHeader("X-CSRF-TOKEN", csrfToken);

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.responseText == "yes") {
                        location.replace('/dashboard');
                    } else {
                        alert(xhr.responseText)
                        btn.disabled = false
                    }
                }
            };

            xhr.send(JSON.stringify(data));
        })
    </script>
@endpush

@section('content')
    <div class="card border-0">
        <div class="card-header">
            <div class="edit-profile__title">
                <h6>Sign in {{env('APP_NAME')}}</h6>
            </div>
        </div>
        <div class="card-body">
            <div class="edit-profile__body">
                @if(session()->has('error'))
                    <p class="text-danger m-0">{{session()->get('error')}}</p>
                @endif
                <form action="/dologin" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group mb-20">
                        <label for="email">Username Or Email Address</label>
                        <input type="text" class="form-control" id="email" name="email" value="" placeholder="Email address">
                    </div>
                    <div class="form-group mb-15">
                        <label for="password-field">password</label>
                        <div class="position-relative">
                            <input id="password-field" type="password" class="form-control" name="password" placeholder="Password" value="">
                            <span toggle="#password-field" class="uil uil-eye-slash text-lighten fs-15 field-icon toggle-password2"></span>
                        </div>
                        @if($errors->has('password'))
                            <p class="text-danger">{{$errors->first('password')}}</p>
                        @endif
                    </div>
                    <div class="admin-condition">
                        {{-- <div class="checkbox-theme-default custom-checkbox ">
                            <input class="checkbox" type="checkbox" id="check-1">
                            <label for="check-1">
                                <span class="checkbox-text">Keep me logged in</span>
                            </label>
                        </div> --}}
                        <a href="{{ route('forget_password') }}">forget password?</a>
                    </div>
                    <div class="admin__button-group button-group d-flex pt-1 justify-content-md-start justify-content-center">
                        <button id="doSignin" class="btn btn-primary btn-default w-100 btn-squared text-capitalize lh-normal px-50 signIn-createBtn ">
                            sign in
                        </button>
                    </div>
                </form>
            </div>
        </div>
        {{-- <div class="px-20">
            <p class="social-connector social-connector__admin text-center">
                <span>Or</span>
            </p>
            <div class="button-group d-flex align-items-center justify-content-center">
                <ul class="admin-socialBtn">
                    <li>
                        <button class="btn text-dark google">
                            <img class="svg" src="{{ asset('assets/img/google-Icon.svg') }}" alt="img" />
                        </button>
                    </li>
                    <li>
                        <button class=" radius-md wh-48 content-center facebook">
                            <i class="uil uil-facebook-f"></i>
                        </button>
                    </li>
                    <li>
                        <button class="radius-md wh-48 content-center twitter">
                            <i class="uil uil-twitter"></i>
                        </button>
                    </li>
                    <li>
                        <button class="radius-md wh-48 content-center github">
                            <i class="uil uil-github"></i>
                        </button>
                    </li>
                </ul>
            </div>
        </div> --}}
            {{-- <div class="admin-topbar">
                <p class="mb-0">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="color-primary">
                        Sign up
                    </a>
                </p>
            </div> --}}
    </div>
@endsection
