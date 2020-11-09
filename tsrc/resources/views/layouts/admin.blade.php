<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ $page['title'] or null }} | TSRC</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/v/bs/dt-1.10.12/datatables.min.css" />
  <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dist/css/custom-AdminLTE.css') }}">
  
  <link rel="stylesheet" href="{{ asset('dist/css/skins/skin-blue.min.css') }}">

  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    @include('layouts.admin_header')

    @include('layouts.admin_sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          {{ $page['title'] or "Page Title" }}
        <small>{{ $page['description'] or null }}</small>
      </h1>
      <ol class="breadcrumb">
        @foreach(generateBreadcrumbs(Route::currentRouteName()) as $bc)
        <li{{ $bc['last'] ? ' class="active"' : null }}>
        @if(!$bc['last'])
        <a href="{{ $bc['url'] }}">
            @if ($bc['first'])
            <i class="fa fa-dashboard"></i> 
            @endif
            {{ $bc['name'] }}
        </a>
        @else
            @if ($bc['first'])
            <i class="fa fa-dashboard"></i> 
            @endif
            {{ $bc['name'] }}
        </li>
    @endif
        @endforeach
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	@if(Session::has('flash_message'))
		<div class="alert alert-{{ Session::get('flash_message_level') }} alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<h4><i class="icon fa fa-check"></i> Alert!</h4>
			{{ Session::get('flash_message') }}
		</div>
	@endif

        @yield('content')

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  @include('layouts.admin_footer')

</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->
<script
      src="https://code.jquery.com/jquery-3.1.1.min.js"
      integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
      crossorigin="anonymous"></script>
<!-- Bootstrap 3.3.6 -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<!-- DataTables -->
<script type="text/javascript" src="//cdn.datatables.net/v/bs/dt-1.10.12/datatables.min.js"></script>

<!-- AdminLTE App -->
<script src="{{ asset('dist/js/app.min.js') }}"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->

<script>
@yield('scripts')
</script>
</body>
</html>

