@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="col-sm-8 offset-sm-2">
      <div class="card card-body card-block">
        <h4 class="card-title text-sm-center">{{ trans('user.password_change_welcome') }}</h4>
        <form class="text-sm-right" role="form" method="POST" action="{{ url('/password/reset') }}">
          {!! csrf_field() !!}

          <input type="hidden" name="token" value="{{ $token }}">

          <div class="row form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
            <label class="col-sm-4 col-form-label">{{ trans('user.email') }}</label>

            <div class="col-sm-6">
              <input type="email" class="form-control" name="email"
                                                       value="{{ $email or old('email') }}">

              @if ($errors->has('email'))
                <p class="text-muted">
                <strong>{{ $errors->first('email') }}</strong>
                </p>
              @endif
            </div>
          </div>

          <div class="row form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
            <label class="col-sm-4 col-form-label">{{ trans('user.password') }}</label>

            <div class="col-sm-6">
              <input type="password" class="form-control" name="password">

              @if ($errors->has('password'))
                <p class="text-muted">
                <strong>{{ $errors->first('password') }}</strong>
                </p>
              @endif
            </div>
          </div>

          <div class="row form-group{{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
            <label class="col-sm-4 col-form-label">{{ trans('user.password_confirmation') }}</label>
            <div class="col-sm-6">
              <input type="password" class="form-control" name="password_confirmation">

              @if ($errors->has('password_confirmation'))
                <p class="text-muted">
                <strong>{{ $errors->first('password_confirmation') }}</strong>
                </p>
              @endif
            </div>
          </div>

          <div class="row form-group">
            <div class="col-sm-6 offset-sm-4">
              <button type="submit" class="btn btn-block btn-lg btn-primary">
                <i class="fa fa-refresh" aria-hidden="true"></i> {{ trans('user.btn_change_password') }}
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
