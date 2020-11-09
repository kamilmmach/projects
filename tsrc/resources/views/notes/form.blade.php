<!-- Message Form Input -->
<div class="form-group row{{ $errors->has('message') ? ' has-danger' : ''}}">
    {!! Form::label('message', trans('message.message'), ['class' => 'col-sm-2 col-form-label text-xs-right']) !!}
    <div class="col-sm-10">
    {!! Form::textarea('message', null, ['class' => ($errors->has('message') ? 'form-control form-control-danger' : 'form-control')]) !!}
        @if ($errors->has('message'))
        <small class="text-danger">
            {{ $errors->first('message') }}
        </small>
    @endif
    </div>
</div>

<!-- Send Form Input -->
<div class="form-group row">
    <div class="offset-sm-2 col-sm-10">
        {!! Form::submit(trans('message.btn_send_message'), ['class' => 'btn btn-primary']) !!}
    </div>
</div>
