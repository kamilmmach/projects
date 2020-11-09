@extends('layouts.app')

@section('content')
    <h1>{{ trans('channel.welcome_channel_edit') }}</h1>
    {!! Form::model($channel, ['method' => 'PATCH', 'action' => ['ChannelController@update', $channel->id]]) !!}
        @include('channels.form', ['submitButtonText' => trans('channel.btn_edit_request'), 'edit' => true, 'channel' => $channel])
    {!! Form::close() !!}
@endsection

