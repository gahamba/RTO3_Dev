@extends('layouts.app')

@section('content')

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="btn btn-outline-secondary" type="" id="nameicon"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" placeholder="Michel Stratchan" aria-label="Name" aria-describedby="nameicon" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="btn btn-outline-secondary" type="button" id="emailicon"><i class="fas fa-at"></i></span>
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
                            <input type="password" placeholder="Password" aria-label="Password" aria-describedby="passwordicon" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="btn btn-outline-secondary" type="button" id="passwordicon"><i class="fas fa-check-circle"></i></span>
                            </div>
                            <input type="password" placeholder="Confirm Password" aria-label="Password" aria-describedby="confirmpasswordicon" class="form-control" name="password_confirmation" required autocomplete="new-password">

                        </div>



                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>

@endsection
