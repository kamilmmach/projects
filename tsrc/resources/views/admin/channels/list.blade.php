@foreach (array_chunk($channels->all(), 2) as $channel_group)
    <div class="row">
        @foreach ($channel_group as $channel)
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <a href="{{route('admin.channels.show', $channel->id)}}">
                                {{$channel->name}}
                            </a>
                        </h3>
                        <div class="box-tools pull-right">
                            <span class="label label-{{ $channel->status->getCSSClassSuffix() }}">
                                {{ trans('channel.status_' . $channel->status->name) }}
                            </span>
                            <span class="label label-default">
                                {{ count($channel->messages) }}
                            </span>
                        </div>
                    </div>
                    <div class="box-body">
                        @if(count($channel->messages) && $channel->messages->first()->user == $channel->owner)
                            <p class="lead">
                                {{$channel->messages->first()->message}}
                            </p>
                        @endif
                        <p>
                        <small class="text-muted" title="{{  $channel->created_at }}">
                            {{ trans('channel.created') }} {{ $channel->created_at->diffForHumans() }} by 
                        <a href="{{ route('admin.users.show', $channel->owner->id) }}">
                            {{$channel->owner->name}}
                        </a>
                        </small>
                        </p>
                    </div>
                    @if($channel->status->isPending())
                        <div class="box-footer">
                            <ul class="respond-bar">
                                {!! Form::open(['route' => ['admin.channels.accept', $channel->id], 
                                'method' => 'post', 'id' => 'accept-' . $channel->id . '-form', 'style' => 'display: none']) !!}
                                {!! Form::close() !!}
                                {!! Form::open(['route' => ['admin.channels.reject', $channel->id], 
                                'method' => 'post', 'id' => 'reject-' . $channel->id . '-form', 'style' => 'display: none']) !!}
                                {!! Form::close() !!}
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
                                <li>
                                  <a class="text-muted hover-blue" href="{{ route('admin.channels.show', $channel->id) }}">
                                    <i class="ion ion-reply">
                                    </i>
                                  </a>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endforeach
