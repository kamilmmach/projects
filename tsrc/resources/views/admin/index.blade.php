@extends('layouts.admin')
@section('content')

      <!-- Small boxes (Stat box) -->
      <div class="row">
          <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                  <span class="info-box-icon bg-aqua"><i class="fa fa-clock-o"></i></span>
                  <div class="info-box-content">
                      <span class="info-box-text">{{ trans('admin.requests_awaiting') }}</span>
                      <span class="info-box-number">{{$stats['requests_pending']}}</span>
                  </div>
              </div>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                  <span class="info-box-icon bg-green"><i class="fa fa-check"></i></span>
                  <div class="info-box-content">
                      <span class="info-box-text">{{ trans('admin.requests_accepted') }}</span>
                      <span class="info-box-number">{{$stats['requests_accepted']}}</span>
                  </div>
              </div>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                  <span class="info-box-icon bg-red"><i class="fa fa-ban"></i></span>
                  <div class="info-box-content">
                      <span class="info-box-text">{{ trans('admin.requests_rejected') }}</span>
                      <span class="info-box-number">{{$stats['requests_rejected']}}</span>
                  </div>
              </div>
          </div>
          <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                  <span class="info-box-icon bg-yellow"><i class="ion ion-document-text"></i></span>
                  <div class="info-box-content">
                      <span class="info-box-text">{{ trans('admin.requests_total') }}</span>
                      <span class="info-box-number">{{$stats['requests_total']}}</span>
                  </div>
              </div>
          </div>
      </div>
      <!-- /.row -->
    @if(count($pending_channels))
        @include('admin.channels.list', ['channels' => $pending_channels])
    @else
        <div class="box">
            <div class="box-header text-center">
                <h1 class="box-title box-title-big"> {{ trans('admin.yippee') }}</h1>
            </div>
            <div class="box-body text-center">
                <div class="icon-huge"><i class="ion ion-android-happy" aria-hidden="true"></i></div>
                <h1>{{ trans('admin.no_pending_requests') }}</p>
            </div>
        </div>
    @endif
@endsection
