@extends('layouts.admin')

@section('content')
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">{{ trans('admin.channel_list') }}</h3>
    </div>
    <div class="box-body">
      <table id="channels-table" class="table table-bordered table-hover">
        <thead class="thead-inverse">
          <tr>
            <th>Id</th>
            <th>{{ trans('channel.name') }}</th>
            <th>{{ trans('channel.password') }}</th>
            <th>{{ trans('channel.owner') }}</th>
            <th>{{ trans('channel.created_at') }}</th>
            <th>{{ trans('channel.status') }}</th>
            <th>{{ trans('channel.responder') }}</th>
            <th>{{ trans('admin.action') }}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($channels as $channel)
            <tr>
              <td>{{ $channel->id }}</td>
              <td><a href="{{ route('admin.channels.show', $channel->id) }}">{{ $channel->name }}</a></td>
              <td>{{ $channel->password }}</td>
              <td><a href="{{ route('admin.users.show', $channel->owner->id) }}">{{ $channel->owner->name }}</a></td>
              <td>{{ $channel->created_at }}</td>
              <td>
                <span class="label label-{{ $channel->status->getCSSClassSuffix() }}">
                  {{ trans('channel.status_' . $channel->status->name) }}
                </span> 
              </td>
              <td>
                @if($channel->responder)
                <a href="{{ route('admin.users.show', $channel->responder->id) }}">{{ $channel->responder->name }}</a>
                @endif            
              </td>
              <td>
                {!! Form::open(['route' => ['admin.channels.destroy', $channel->id], 'method' => 'delete']) !!}
                <div class="btn-group">
                    <a href="{{ route('admin.channels.edit', ['channel'=> $channel->id]) }}" class="btn btn-default">
                      <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </a>
                  {!! Form::button('<i class="fa fa-trash" aria-hidden="true"></i>', [
                      'type' => 'submit',
                      'class' => 'btn btn-danger',
                    ]) !!}
                </div>
                {!! Form::close() !!}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
@section('scripts')
  $(function () {
  $("#channels-table").DataTable();
  });
@endsection
