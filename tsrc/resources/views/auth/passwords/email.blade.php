@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-8 offset-sm-2">
            <div class="card card-block card-body text-sm-center">
                <h4 class="card-title text-sm-center">{{ trans('user.password_reset_welcome') }}</h4>
                <p class="card-text">{{ trans('user.password_reset_p1') }}</p>

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form class="text-sm-right" role="form" method="POST" action="{{ url('/password/email') }}">
                    {!! csrf_field() !!}

                    <div class="form-group row{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label class="col-sm-4 col-form-label">{{ trans('user.email') }}</label>

                        <div class="col-sm-6">
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                            @if ($errors->has('email'))
                                <p class="text-muted">
                                <strong>{{ $errors->first('email') }}</strong>
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="form-group text-sm-left">
                        <div class="col-sm-6 offset-sm-4">
                            <button type="submit" class="btn btn-primary btn-lg btn-block">
                                <i class="fa fa-envelope" aria-hidden="true"></i> {{ trans('user.btn_send_password_reset') }}
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
