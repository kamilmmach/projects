@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-8 offset-sm-2">
            <div class="card card-block card-body">
                <h4 class="card-title text-sm-center">{{ trans('user.edit_welcome') }}</h4>
                    {!! Form::model($user, ['method' => 'PATCH', 'route' => ['user.update', $user->id]]) !!}

                            <!-- Name Form Input -->
                    <div class="form-group row{{ $errors->has('name') ? ' has-danger' : ''}}">
                        {!! Form::label('name', trans('user.name'), ['class' => 'col-sm-4 form-control-label text-xs-right']) !!}
                        <div class="col-sm-6">
                            {!! Form::text('name', null, ['class' => ($errors->has('name') ? 'form-control disabled form-control-danger' : 'form-control'), 'disabled']) !!}
                            @if ($errors->has('name'))
                                <small class="text-danger">
                                    {{ $errors->first('name') }}
                                </small>
                            @endif
                        </div>
                    </div>

                    <!-- Email Form Input -->
                    <div class="form-group row{{ $errors->has('email') ? ' has-danger' : ''}}">
                        {!! Form::label('email', trans('user.email'), ['class' => 'col-sm-4 form-control-label text-xs-right']) !!}
                        <div class="col-sm-6">
                            {!! Form::text('email', null, ['class' => ($errors->has('email') ? 'form-control form-control-danger' : 'form-control'), 'disabled']) !!}
                            @if ($errors->has('email'))
                                <small class="text-danger">
                                    {{ $errors->first('email') }}
                                </small>
                            @endif
                        </div>
                    </div>


                    <!-- Password Form Input -->
                    <div class="form-group row{{ $errors->has('password') ? ' has-danger' : ''}}">
                        {!! Form::label('password', trans('user.password'), ['class' => 'col-sm-4 form-control-label text-xs-right']) !!}
                        <div class="col-sm-6">
                            {!! Form::password('password', ['class' => ($errors->has('password') ? 'form-control form-control-danger' : 'form-control')]) !!}
                            @if ($errors->has('password'))
                                <small class="text-danger">
                                    {{ $errors->first('password') }}
                                </small>
                            @endif
                        </div>
                    </div>

                    <!-- Password confirm Form Input -->
                    <div class="form-group row{{ $errors->has('password_confirmation') ? ' has-danger' : ''}}">
                        {!! Form::label('password_confirmation', trans('user.password_confirmation'), ['class' => 'col-sm-4 form-control-label text-xs-right']) !!}
                        <div class="col-sm-6">
                            {!! Form::password('password_confirmation', ['class' => ($errors->has('password_confirmation') ? 'form-control form-control-danger' : 'form-control')]) !!}
                            @if ($errors->has('password_confirmation'))
                                <small class="text-danger">
                                    {{ $errors->first('password_confirmation') }}
                                </small>
                            @endif
                        </div>
                    </div>

                    <!-- ts_uid Form Input -->
                    <div class="form-group row{{ $errors->has('ts_uid') ? ' has-danger' : ''}}">
                        {!! Form::label('ts_uid', trans('user.ts_uid'), ['class' => 'col-sm-4 form-control-label text-xs-right']) !!}
                        <div class="col-sm-6">
                            {!! Form::text('ts_uid', null, ['class' => ($errors->has('ts_uid') ? 'form-control form-control-danger' : 'form-control'), 'maxlength' => 28]) !!}
                            @if ($errors->has('ts_uid'))
                                <small class="text-danger">
                                    {{ $errors->first('ts_uid') }}
                                </small>
                            @endif
                        </div>
                    </div>

                    <!-- Send Form Input -->
                    <div class="form-group row">
                        <div class="offset-sm-4 col-sm-6">
                            {!! Form::submit(trans('user.btn_edit'), ['class' => 'btn btn-primary btn-lg btn-block']) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
