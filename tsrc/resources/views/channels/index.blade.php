@extends('layouts.app')

@section('content')
  <div class="row justify-content-between">
    <p class="h2">{{ trans('channel.welcome_channel') }}</p>
    <a href="{{ action('ChannelController@create') }}" class="btn btn-primary">{{ trans('channel.btn_add_request') }}</a>
  </div>
  <div class="row">
    @if(count($channels))
        @include('channels.partials.list')
    @else
        <h2>{{ trans('channel.no_requests') }}</h2>
    @endif
  </div>
    
@endsection

