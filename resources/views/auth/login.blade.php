@extends('layouts.app')

@section('content')
                        <!--Logo div ends-->
                        <!-- Login Form div -->
                        <!--<div class="row">-->
                            <form class="login_form_right" method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="btn btn-outline-secondary" type="button" id="emailicon"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="email" placeholder="me@greatermail.com" aria-label="Email Address" aria-describedby="emailicon" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="btn btn-outline-secondary" type="button" id="passwordicon"><i class="fas fa-unlock"></i></span>
                                    </div>
                                    <input type="password" placeholder="password" aria-label="Password" aria-describedby="passwordicon" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>


                                <div class="input-group mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                
                                </div>

                                <button type="submit" class="btn contrast_component2 float-right">Login</button>
                                <br />
                                @if (Route::has('password.request'))
                                    <p align="center"><a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a></p>
                                @endif
                            </form>
                        <!--</div>-->
                        <!--Login form div ends -->
@endsection
