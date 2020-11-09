@extends('layouts.admin')

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('admin.user_data') }}</h3>
        </div>
        {{ Form::model($user, ['method' => 'put', 'route' => ['admin.users.update', $user->id]]) }}
        <div class="box-body">
            <!-- name Input field -->
            <div class="form-group{{ $errors->has('name') ? ' has-error' : ''}}">
                {!! Form::label('name', trans('user.name')) !!}
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
                @if ($errors->has('name'))
                    <span class="help-block">
                        {{ $errors->first('name') }}
                    </span>
                @endif
            </div>

            <!-- email Input field -->
            <div class="form-group{{ $errors->has('email') ? ' has-error' : ''}}">
                {!! Form::label('email', trans('user.email')) !!}
                {!! Form::text('email', null, ['class' => 'form-control']) !!}
                @if ($errors->has('email'))
                    <span class="help-block">
                        {{ $errors->first('email') }}
                    </span>
                @endif
            </div>

            <!-- password Input field -->
            <div class="form-group{{ $errors->has('password') ? ' has-error' : ''}}">
                {!! Form::label('password', trans('user.password')) !!}
                {!! Form::password('password', ['class' => 'form-control']) !!}
                @if ($errors->has('password'))
                    <span class="help-block">
                        {{ $errors->first('password') }}
                    </span>
                @endif
            </div>

            <!-- ts_uid Input field -->
            <div class="form-group{{ $errors->has('ts_uid') ? ' has-error' : ''}}">
                {!! Form::label('ts_uid', trans('user.ts_uid')) !!}
                {!! Form::text('ts_uid', null, ['class' => 'form-control', 'maxlength' => 28]) !!}
                @if ($errors->has('ts_uid'))
                    <span class="help-block">
                        {{ $errors->first('ts_uid') }}
                    </span>
                @endif
            </div>

            <!-- role Select field -->
            <div class="form-group{{ $errors->has('role') ? ' has-error' : ''}}">
                {!! Form::label('role', trans('user.role')) !!}
                {!! Form::select('role', $role_names, $user->role->id, ['class' => 'form-control']) !!}
                @if ($errors->has('role'))
                    <span class="help-block">
                        {{ $errors->first('role') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="box-footer">
            <!-- Submit button -->
            {!! Form::button(trans('user.btn_edit'), ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
        </div>
        {{ Form::close() }}
    </div>
@endsection
