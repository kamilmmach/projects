@extends('layouts.admin')
@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">{{ trans('admin.user_data') }}</h3>
    </div>
    <div class="box-body no-padding">
      <div class="mailbox-read-info">
        <dl class="dl-horizontal">
          <dt>{{ trans('user.name') }}</dt>
          <dd>{{ $user->name }}</dd>
          <dt>{{ trans('user.email') }}</dt>
          <dd>{{ $user->email }}</dd>
          <dt>{{ trans('user.ts_uid') }}</dt>
          <dd>{{ $user->ts_uid }}</dd>
          <dt>{{ trans('user.role') }}</dt>
          <dd>{{ trans('user.role_' . $user->role->name) }}</dd>
          <dt>{{ trans('user.created_at') }}</dt>
          <dd><span class="mailbox-read-time">{{ $user->created_at->formatLocalized('%d %b %Y %H:%M') }}</span></dd>
        </dl>
      </div>
    </div>
    <div class="box-footer">
      <ul class="respond-bar">
        {!! Form::open(['route' => ['admin.users.destroy', $user->id], 
        'method' => 'delete', 'id' => 'destroy-' . $user->id . '-form', 'style' => 'display: none']) !!}
        {!! Form::close() !!}
        <li>
          <a class="text-muted hover-blue" href="{{ route('admin.users.edit', $user->id)}}">
            <i class="fa fa-pencil"></i>
          </a>
        </li>
        <li>
          <a class="text-muted hover-red" href="{{ route('admin.users.destroy', $user->id) }}"
              onclick="event.preventDefault(); document.getElementById('{{ 'destroy-' . $user->id . '-form'}}').submit();">
              <i class="fa fa-trash"></i>
          </a>
        </li>
      </ul>
    </div>
  </div>
  </div>
@endsection
