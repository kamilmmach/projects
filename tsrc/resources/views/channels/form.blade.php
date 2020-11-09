<!-- Name Form Input -->
<div class="form-group row{{ $errors->has('name') ? ' has-danger' : ''}}">
    {!! Form::label('name', trans('channel.name'), ['class' => 'col-sm-2 col-form-label text-xs-right']) !!}
    <div class="col-sm-10">
    {!! Form::text('name', null, ['class' => ($errors->has('name') ? 'form-control form-control-danger' : 'form-control')]) !!}
        @if ($errors->has('name'))
        <small class="text-danger">
            {{ $errors->first('name') }}
        </small>
    @endif
    </div>
</div>

<!-- Password Form Input -->
<div class="form-group row{{ $errors->has('password') ? ' has-danger' : ''}}">
    {!! Form::label('password', trans('channel.password'), ['class' => 'col-sm-2 col-form-label text-xs-right']) !!}
    <div class="col-sm-10">
    {!! Form::text('password', null, ['class' => ($errors->has('password') ? 'form-control form-control-danger' : 'form-control')]) !!}
    @if ($errors->has('password'))
        <small class="text-danger">
            {{ $errors->first('password') }}
        </small>
    @endif
    <small class="text-muted">{{ trans('channel.password_remark') }}</small>
    </div>
</div>
@if (!isset($edit))
<!-- Message to admin Form Input -->
<div class="form-group row{{ $errors->has('message') ? ' has-danger' : ''}}">
    {!! Form::label('message', trans('channel.message'), ['class' => 'col-sm-2 col-form-label text-xs-right']) !!}
    <div class="col-sm-10 ">
    {!! Form::textarea('message', null, ['class' => ($errors->has('message') ? 'form-control form-control-danger' : 'form-control')]) !!}
        @if ($errors->has('message'))
        <small class="text-danger">
            {{ $errors->first('message') }}
        </small>
    @endif
    </div>
</div>
@else
@can('edit-admin', $channel)
<div class="form-group row{{ $errors->has('status') ? ' has-danger' : ''}}">
    {!! Form::label('status', trans('channel.status'), ['class' => 'col-sm-2 col-form-label text-xs-right']) !!}
    <div class="col-sm-10 ">
        {!! Form::select('status', $statuses, $channel->status->id, ['class' => ($errors->has('message') ? 'form-control form-control-danger' : 'form-control')]) !!}
        @if ($errors->has('status'))
            <small class="text-danger">
                {{ $errors->first('status') }}
            </small>
        @endif
    </div>
</div>
@endcan
@endif

<!-- Send Form Input -->
<div class="form-group row">
    <div class="offset-sm-2 col-sm-10">
        {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']) !!}
    </div>
</div>
