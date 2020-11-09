@if(count($messages))
  @foreach($messages as $cm)
    <blockquote class="blockquote{{ $cm->user->role->name == "admin" ? " blockquote-admin" : ""}}">
      @can('destroy', $cm)
        <div class="btn-group float-xs-right" role="group">
          {!! Form::open(['method' => 'DELETE', 'action' => ['ChannelMessageController@destroy', $cm->id]]) !!}
          <button type="submit" class="btn btn-danger-outline btn-sm">
            <i class="fa fa-times" aria-hidden="true"></i>
          </button>
          {!! Form::close() !!}
        </div>
      @endcan
      <p class="m-b-0">{{ $cm->message }}</p>
      <footer class="blockquote-footer"><strong>{{ $cm->user->name }}</strong>,
        <span data-toggle="tooltip" data-placement="bottom" title="{{ $cm->created_at }}">
          {{ $cm->created_at->diffForHumans() }}
        </span>
      </footer>
    </blockquote>
  @endforeach
@else
  <p>Brak wiadomości.</p>
@endif
