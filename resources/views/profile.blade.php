@extends('layouts.authlayout')

@section('content')

    <!-- breadcrumb -->

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">User Account</a></li>
            <li class="breadcrumb-item active" aria-current="page">Action</li>
        </ol>
    </nav>

    <!--breadcrumb ends -->

    <div class="container-fluid">


        <!--<div>-->



        @if(auth::user()->user_type == 0 || auth::user()->user_type === "0")
        @if(Session::has('global'))

            <div class="alert alert-{{ session('global') == 0 ? 'success' : 'danger' }} alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


        @endif
        <div class="card card-body">



            <h4>Company Name</h4>
            <form method="post" action="{{ route('companyname-post') }}">
                @csrf


                    <div class="form-group">
                        <label htmlFor="company_name"><i class="fas fa-building"></i>&nbsp;Company Name </label>
                        <input type="text" class="form-control" id="company_name" name="company_name"
                               aria-describedby="companyNameHelp" placeholder="Specify company name"
                               value="{{ \App\Company::find(auth::user()->company_id)->company_name }}" required />
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>





            </form>

        </div>
        @endif


        <div class="clearfix">&nbsp;</div>

        <div class="card card-body">

            @if(Session::has('global2'))

                <div class="alert alert-{{ session('global2') == 0 ? 'success' : 'danger' }} alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>


            @endif
            <h4>User Profile</h4>
            <form method="post" action="{{ route('profile-post') }}">
                @csrf


                <div class="form-group">
                    <label htmlFor="user_name"><i class="fas fa-user"></i>&nbsp;Full Name </label>
                    <input type="text" class="form-control" id="user_name" name="fullname"
                           aria-describedby="fullNameHelp" placeholder="Full name"
                           value="{{ \App\User::find(auth::user()->id)->name }}" required />
                </div>

                <div class="form-group">
                    <label htmlFor="email"><i class="fas fa-at"></i>&nbsp;Email </label>
                    <input type="email" class="form-control" id="email" name="email"
                           aria-describedby="emailHelp" placeholder="Email"
                           value="{{ \App\User::find(auth::user()->id)->email }}" disabled required />
                </div>

                <div class="form-group">
                    <label htmlFor="phone"><i class="fas fa-phone"></i>&nbsp;Phone </label>
                    <input type="text" class="form-control" id="phone" name="phone"
                           aria-describedby="phoneHelp" placeholder="Phone"
                           value="{{ \App\User::find(auth::user()->id)->phone }}" required />
                </div>

                <div class="form-group">
                    <label><i class="fas fa-comment-slash"></i>&nbsp;Receive Message </label>
                    <select  class="form-control" name="message">
                        <option value="0" @if(\App\User::find(auth::user()->id)->send == 0) selected @endif>Yes</option>
                        <option value="1" @if(\App\User::find(auth::user()->id)->send == 1) selected @endif>No</option>

                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Save</button>





            </form>



        </div>

        <div class="clearfix">&nbsp;</div>

        <div class="card card-body">
            @if(Session::has('global3'))

                <div class="alert alert-{{ session('global3') == 0 ? 'success' : 'danger' }} alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>


            @endif
            <h4>Password</h4>
            <form method="post" action="{{ route('password-post') }}">
                @csrf
                @foreach ($errors->all() as $error)
                    <p class="text-danger">{{ $error }}</p>
                @endforeach

                <div class="form-group">
                    <label htmlFor="password"><i class="fas fa-lock"></i>&nbsp;Old Password </label>
                    <input type="password" class="form-control" id="password" name="oldpassword"
                           aria-describedby="oldpasswordHelp" placeholder="Old Password" required />
                </div>

                <div class="form-group">
                    <label htmlFor="newpassword"><i class="fas fa-lock"></i>&nbsp;New Password </label>
                    <input type="password" class="form-control" id="newpassword" name="newpassword"
                           aria-describedby="newpasswordHelp" placeholder="New Password" required />
                </div>

                <div class="form-group">
                    <label htmlFor="confirm"><i class="fas fa-check-double"></i>&nbsp;Confirm Password </label>
                    <input type="password" class="form-control" id="confirm" name="confirm"
                           aria-describedby="confirmHelp" placeholder="Confirm Password" required />
                </div>

                <button type="submit" class="btn btn-primary">Save</button>





            </form>



        </div>


    <!--</div>-->







    </div>




@endsection
