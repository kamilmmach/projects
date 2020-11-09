@extends('layouts.admin')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{ trans('admin.user_list') }}</h3>
            <div class="box-tools">
                <a href="{{ route('admin.users.create') }}">
                <button class="btn btn-primary" type="button">{{ trans('admin.btn_add_user') }}</button>
            </a>
            </div>
        </div>
        <div class="box-body">
            <table id="users-table" class="table table-bordered table-hover">
                <thead class="thead-inverse">
                    <tr>
                        <th>Id</th>
                        <th>{{ trans('user.name') }}</th>
                        <th>{{ trans('user.email') }}</th>
                        <th>{{ trans('user.ts_uid') }}</th>
                        <th>{{ trans('user.role') }}</th>
                        <th>{{ trans('admin.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>
                                <a href="{{ route('admin.users.show', $user->id) }}">
                                {{ $user->name }}
                                </a>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->ts_uid }}</td>
                            <td>{{ $user->role->name }}</td>
                            <td>
                                {!! Form::open(['route' => ['admin.users.destroy', $user->id], 'method' => 'delete']) !!}
                                <div class="btn-group">
                                    <a href="{{ route('admin.users.edit', ['user'=> $user->id]) }}" class="btn btn-default">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
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
    $("#users-table").DataTable();
});
@endsection
