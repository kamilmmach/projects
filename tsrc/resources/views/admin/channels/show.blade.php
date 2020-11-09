@extends('layouts.admin')
@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">{{ trans('admin.channel_request') }}</h3>
      <div class="box-tools pull-right">
        <span class="label label-{{ $channel->status->getCSSClassSuffix() }}">
          {{ trans('channel.status_' . $channel->status->name) }}
        </span> 
        <span class="label label-default">
          {{ count($channel->messages) }}
        </span>
      </div>
    </div>
    <div class="box-body no-padding">
      <div class="mailbox-read-info">
        <dl class="dl-horizontal">
          <dt>{{ trans('channel.name') }}</dt>
          <dd>{{ $channel->name }}</dd>
          <dt>{{ trans('channel.password') }}</dt>
          <dd>{{ $channel->password }}</dd>
          <dt>{{ trans('channel.owner') }}</dt>
          <dd><a href="{{ route('admin.users.show', $channel->owner->id) }}">{{$channel->owner->name}}</a></dd>
          <dt>{{ trans('channel.created_at') }}</dt>
          <dd><span class="mailbox-read-time">{{ $channel->created_at->formatLocalized('%d %b %Y %H:%M') }}</span></dd>
          <dt>{{ trans('channel.status') }}</dt>
          <dd>
          <span class="label label-{{ $channel->status->getCSSClassSuffix() }}">
            {{ trans('channel.status_' . $channel->status->name) }}
          </span> 
          </dd>
          @if($channel->responder)
            <dt>{{ trans('channel.responder') }}</dt>
          <dd><a href="{{ route('admin.users.show', $channel->responder->id) }}">{{$channel->responder->name}}</a></dd>
          @endif
        </dl>
      </div>
    </div>
    @if(count($channel->messages))
      <div class="box-footer box-comments">
        @foreach($channel->messages as $msg)
          <div class="box-comment">
            <div class="comment-text">
        {!! Form::open(['route' => ['admin.messages.destroy', $msg->id], 
        'method' => 'delete', 'id' => 'destroy-msg-' . $msg->id . '-form', 'style' => 'display: none']) !!}
        {!! Form::close() !!}
              <span class="username">{{ $msg->user->name }} 
                <span class="text-muted">
                  <time title="{{$msg->created_at}}" datetime="{{$msg->created_at->toIso8601String()}}" pubdate>
                    {{ $msg->created_at->diffForHumans() }}
                  </time>
                </span>
                <small>
          <a class="text-muted hover-red" href="{{ route('admin.messages.destroy', $msg->id) }}"
            onclick="event.preventDefault(); document.getElementById('{{ 'destroy-msg-' . $msg->id . '-form'}}').submit();">
            {{ trans('message.delete') }}
    </a></small>
              </span>
              {{ $msg->message }}
            </div>
          </div>
        @endforeach
      </div>
    @endif

    <div class="box-footer">
      {!! Form::open(['route' => ['admin.channels.message', $channel->id], 'method' => 'post']) !!}
      {!! Form::text('message', null, ['class' => 'form-control input-sm', 'placeholder' => trans('admin.type_message'), 'required']) !!}
      @if ($errors->has('message'))
        <span class="help-block">
          {{ $errors->first('message') }}
        </span>
      @endif
      {!! Form::close() !!}
    </div>

    <div class="box-footer">
      <ul class="respond-bar">
        @if($channel->status->isPending())
        {!! Form::open(['route' => ['admin.channels.accept', $channel->id], 
        'method' => 'post', 'id' => 'accept-' . $channel->id . '-form', 'style' => 'display: none']) !!}
        {!! Form::close() !!}

        {!! Form::open(['route' => ['admin.channels.reject', $channel->id], 
        'method' => 'post', 'id' => 'reject-' . $channel->id . '-form', 'style' => 'display: none']) !!}
        {!! Form::close() !!}
        @endif

        {!! Form::open(['route' => ['admin.channels.destroy', $channel->id], 
        'method' => 'delete', 'id' => 'destroy-' . $channel->id . '-form', 'style' => 'display: none']) !!}
        {!! Form::close() !!}
          @if($channel->status->isPending())
        <li>
          <a class="text-muted hover-green" href="{{ route('admin.channels.accept', $channel->id) }}"
            onclick="event.preventDefault(); document.getElementById('{{ 'accept-' . $channel->id . '-form'}}').submit();">
            <i class="fa fa-check"></i>
          </a>
        </li>
        <li>
          <a class="text-muted hover-red" href="{{ route('admin.channels.reject', $channel->id) }}"
            onclick="event.preventDefault(); document.getElementById('{{ 'reject-' . $channel->id . '-form'}}').submit();">
            <i class="fa fa-ban"></i>
          </a>
        </li>
      @endif
        <li>
          <a class="text-muted hover-blue" href="{{ route('admin.channels.edit', $channel->id)}}">
            <i class="fa fa-pencil"></i>
          </a>
        </li>
        <li>
          <a class="text-muted hover-red" href="{{ route('admin.channels.destroy', $channel->id) }}"
            onclick="event.preventDefault(); document.getElementById('{{ 'destroy-' . $channel->id . '-form'}}').submit();">
            <i class="fa fa-trash"></i>
          </a>
        </li>
      </ul>
    </div>
  </div>
  </div>
@endsection
