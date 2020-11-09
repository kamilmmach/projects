@extends('layouts.admin')

@section('content')
<div class="box">
    <div class="box-header">
        <h3 class="box-title">{{ trans('admin.add_user_form') }}</h3>
    </div>
    {!! Form::open(['route' => 'admin.users.store', 'method' => 'post']) !!}
    <div class="box-body">
       <!-- name Input field -->
       <div class="form-group{{ $errors->has('name') ? ' has-error' : ''}}">
           {!! Form::label('name', trans('user.name')) !!}
           {!! Form::text('name', null, ['class' => 'form-control']) !!}
           @if ($errors->has('name'))
           <span class="help-block">
               {{ $errors->first('name') }}
           </span>
           @endif
       </div> 

       <!-- email input field -->
       <div class="form-group{{ $errors->has('email') ? ' has-error' : ''}}">
           {!! Form::label('email', trans('user.email')) !!}
           {!! Form::text('email', null, ['class' => 'form-control']) !!}
           @if ($errors->has('email'))
           <span class="help-block">
               {{ $errors->first('email') }}
           </span>
           @endif
       </div>
       
       <!-- password password field -->
       <div class="form-group{{ $errors->has('password') ? ' has-error' : ''}}">
           {!! Form::label('password', trans('user.password')) !!}
           {!! Form::password('password', ['class' => 'form-control']) !!}
           @if ($errors->has('password'))
           <span class="help-block">
               {{ $errors->first('password') }}
           </span>
           @endif
       </div>
       
       <!-- password_confirmation password field -->
       <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : ''}}">
           {!! Form::label('password_confirmation', trans('user.password_confirmation')) !!}
           {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
           @if ($errors->has('password_confirmation'))
           <span class="help-block">
               {{ $errors->first('password_confirmation') }}
           </span>
           @endif
       </div>
       
       <!-- ts_uid input field -->
       <div class="form-group{{ $errors->has('ts_uid') ? ' has-error' : ''}}">
           {!! Form::label('ts_uid', trans('user.ts_uid')) !!}
           {!! Form::text('ts_uid', null, ['class' => 'form-control']) !!}
           @if ($errors->has('ts_uid'))
           <span class="help-block">
               {{ $errors->first('ts_uid') }}
           </span>
           @endif
       </div>
       <!-- role password field -->
       <div class="form-group{{ $errors->has('role') ? ' has-error' : ''}}">
           {!! Form::label('role', trans('user.role')) !!}
           {!! Form::select('role', $role_names, App\Role::getByName('member')->id, ['class' => 'form-control']) !!}
           @if ($errors->has('role'))
           <span class="help-block">
               {{ $errors->first('role') }}
           </span>
           @endif
       </div>
    </div>
    <div class="box-footer">
        <!-- Submit button -->
        {!! Form::button(trans('user.btn_create'), ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
    </div>
    {!! Form::close() !!}
    
    
</div>
@endsection
