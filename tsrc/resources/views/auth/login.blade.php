@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-8 offset-sm-2">
            <div class="card card-block card-body">
                <h4 class="card-title text-sm-center">{{ trans('user.login_welcome') }}</h4>
                <form role="form" method="POST" action="{{ url('/login') }}">
                    {!! csrf_field() !!}

                    <div class="text-sm-right form-group row{{ $errors->has('email') ? ' has-danger' : '' }}">
                        <label class="col-sm-4 col-form-label">{{ trans('user.email') }}</label>

                        <div class="col-sm-6">
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                            @if ($errors->has('email'))
                                <small class="text-danger">
                                    {{ $errors->first('email') }}
                                </small>
                            @endif
                        </div>
                    </div>

                    <div class="text-sm-right form-group row{{ $errors->has('password') ? ' has-danger' : '' }}">
                        <label class="col-sm-4 col-form-label">{{ trans('user.password') }}</label>

                        <div class="col-sm-6">
                            <input type="password" class="form-control" name="password">

                            @if ($errors->has('password'))
                                <small class="text-danger">
                                    {{ $errors->first('password') }}
                                </small>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6 offset-sm-4">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember"> {{ trans('user.remember_me') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6 offset-sm-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-sign-in" aria-hidden="true"></i> {{ trans('user.btn_login') }}
                            </button>

                            <a class="btn btn-link" href="{{ url('/password/reset') }}">{{ trans('user.forgot_password') }}</a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection
