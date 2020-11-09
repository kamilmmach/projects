@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-8 offset-sm-2">
            <div class="card card-block card-body">
                <h4 class="card-title text-sm-center">{{ trans('user.register_welcome') }}</h4>
                <form class="text-sm-right" role="form" method="POST" action="{{ url('/register') }}">
                    {!! csrf_field() !!}

                    <div class="form-group row{{ $errors->has('name') ? ' has-danger' : '' }}">
                        <label class="col-sm-4 col-form-label">{{ trans('user.name') }}</label>

                        <div class="col-sm-6">
                            <input required type="text" class="form-control" name="name" value="{{ old('name') }}">

                            @if ($errors->has('name'))
                                <small class="text-danger">
                                    {{ $errors->first('name') }}
                                </small>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row{{ $errors->has('email') ? ' has-danger' : '' }}">
                        <label class="col-sm-4 col-form-label">{{ trans('user.email') }}</label>

                        <div class="col-sm-6">
                            <input required type="email" class="form-control" name="email"
                                                                              value="{{ old('email') }}">
                            @if ($errors->has('email'))
                                <small class="text-danger">
                                    {{ $errors->first('email') }}
                                </small>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row{{ $errors->has('password') ? ' has-danger' : '' }}">
                        <label class="col-sm-4 col-form-label">{{ trans('user.password') }}</label>

                        <div class="col-sm-6">
                            <input required type="password" class="form-control" name="password">
                            @if ($errors->has('password'))
                                <small class="text-danger">
                                    {{ $errors->first('password') }}
                                </small>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row{{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
                        <label class="col-sm-4 col-form-label">{{ trans('user.password_confirmation') }}</label>

                        <div class="col-sm-6">
                            <input required type="password" class="form-control" name="password_confirmation">
                            @if ($errors->has('password_confirmation'))
                                <small class="text-danger">
                                    {{ $errors->first('password_confirmation') }}
                                </small>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row{{ $errors->has('ts_uid') ? ' has-danger' : '' }}">
                        <label class="col-sm-4 col-form-label">{{ trans('user.ts_uid') }}</label>

                        <div class="col-sm-6">
                            <input required type="text" class="form-control" name="ts_uid"
                                                                             maxlength="28" value="{{ old('ts_uid') }}">
                            @if ($errors->has('ts_uid'))
                                <small class="text-danger">
                                    {{ $errors->first('ts_uid') }}
                                </small>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row text-sm-left">
                        <div class="col-sm-6 offset-sm-4">
                            <button type="submit" class="btn btn-primary btn-lg btn-block">
                                <i class="fa fa-user" aria-hidden="true"></i> {{ trans('user.btn_register') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
