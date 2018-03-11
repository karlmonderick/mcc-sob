@extends('layouts.app-login')

@section('content')

    @include('errors.message')
        

    <div class="login-box animated fadeInDown">
        <div class="login-logo"></div>
        <div class="login-body">
            <div class="login-title"><strong>Log In</strong> to your account</div>
                <form class="form-horizontal" method="POST" action="{{ route('login_user') }}">
                                {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('es_id') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <input id="es_id" type="text" class="form-control" name="es_id" placeholder="Employee No./Student No." required autofocus>
                                @if ($errors->has('es_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('es_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <div class="col-md-12">
                            <input id="password" type="password" class="form-control" placeholder="Password" name="password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <!-- <div class="col-md-6">
                            <a href="{{ route('password.request') }}" class="btn btn-link btn-block">Forgot your password?</a>
                        </div> -->
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-info btn-block">Log In</button>
                        </div>
                    </div>
                
                </form>
            </div>
            <div class="login-footer">
                <div class="pull-left">
                    &copy; 2017-2018 SOB
                </div>
            </div>
        </div>
    </div>


@endsection
