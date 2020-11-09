@foreach (array_chunk($channels->all(), 2) as $channel_group)
  <div class="card-deck">
    @foreach ($channel_group as $channel)
      <div class="card">
        <div class="card-block card-body">
          <div class="card-title">
            <h4>
              <span class="badge badge-secondary">{{ count($channel->messages) }}</span>
              <span class="badge badge-{{ $channel->status->getCSSClassSuffix() }}">
                      {{ trans('channel.status_' . $channel->status->name) }}</span>
            </h4>
            <h4><a href="{{action('ChannelController@show', $channel->id)}}">{{$channel->name}}</a></h4>
          </div>
          <hr>
          @if(count($channel->messages) && $channel->messages->first()->user == $channel->owner)
            <p class="card-text">{{$channel->messages->first()->message}}</p>
          @endif
          <p class="card-text">
          <small class="text-muted" title="{{  $channel->created_at }}">
            {{ trans('channel.created') }} {{ $channel->created_at->diffForHumans() }}</small>
          </p>
        </div>
      </div>
    @endforeach
  </div>
@endforeach
