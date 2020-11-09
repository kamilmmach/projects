@extends('layouts.app')

@section('content')
    <h1>{{ trans('channel.welcome_channel_create') }}</h1>
    {!! Form::open(['url'=>action('ChannelController@index')]) !!}
        @include('channels.form', ['submitButtonText' => trans('channel.btn_send_request')])
    {!! Form::close() !!}
@endsection

