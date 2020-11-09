@extends('layouts.admin')

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('admin.channel_data') }}</h3>
        </div>
        {{ Form::model($channel, ['method' => 'put', 'route' => ['admin.channels.update', $channel->id]]) }}
        <div class="box-body">
            <!-- name Input field -->
            <div class="form-group{{ $errors->has('name') ? ' has-error' : ''}}">
                {!! Form::label('name', trans('channel.name')) !!}
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
                @if ($errors->has('name'))
                    <span class="help-block">
                        {{ $errors->first('name') }}
                    </span>
                @endif
            </div>

            <!-- password Input field -->
            <div class="form-group{{ $errors->has('password') ? ' has-error' : ''}}">
                {!! Form::label('password', trans('channel.password')) !!}
                {!! Form::text('password', null, ['class' => 'form-control']) !!}
                @if ($errors->has('password'))
                    <span class="help-block">
                        {{ $errors->first('password') }}
                    </span>
                @endif
            </div>

            <!-- status Select field -->
            <div class="form-group{{ $errors->has('status') ? ' has-error' : ''}}">
                {!! Form::label('status', trans('channel.status')) !!}
                {!! Form::select('status', $status_names, $channel->status->id, ['class' => 'form-control']) !!}
                @if ($errors->has('status'))
                    <span class="help-block">
                        {{ $errors->first('status') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="box-footer">
            <!-- Submit button -->
            {!! Form::button(trans('channel.btn_edit'), ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
        </div>
        {{ Form::close() }}
    </div>
@endsection
