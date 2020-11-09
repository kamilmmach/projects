@extends('layouts.app')

@section('content')
  <div class="card">
    <div class="card-block card-body">
      <div class="card-title">
        <h4><span class="badge badge-{{ $channel->status->getCSSClassSuffix() }}">
            {{ trans('channel.status_' . $channel->status->name) }}</span></h4>
        <h4>{{$channel->name}}</h4>
        <p class="text-muted">Hasło: {{$channel->password}}</p>
      </div>
      <hr>
      @include('messages.partials.list', ['messages' => $channel->messages])
      <p class="card-text">
      <small class="text-muted" data-toggle="tooltip" data-placement="bottom" title="{{ $channel->created_at }}">{{ trans('channel.created') }} {{ $channel->created_at->diffForHumans() }}</small>
      </p>

    </div>
  </div>

  <h2>{{ trans('channel.add_message') }} </h2>
  {!! Form::open(['url'=>action('ChannelMessageController@store', $channel->id)]) !!}
  @include('notes.form')
  {!! Form::close() !!}
@endsection
