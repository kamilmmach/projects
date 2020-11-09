  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">
        <li class="header">MENU</li>
        <!-- Optionally, you can add icons to the links -->
        <li class="{{ isActiveRoute('admin.index') }}"><a href="{{ route('admin.index') }}"><i class="fa fa-link"></i> <span>{{ trans('admin.menu_dashboard') }}</span></a></li>
        <li class="{{ containsActiveRoute('admin.channels') }}"><a href="{{ route('admin.channels.index') }}"><i class="fa fa-link"></i> <span>{{ trans('admin.requests') }}</span></a></li>
        <li class="{{ containsActiveRoute('admin.users') }}"><a href="{{ route('admin.users.index') }}"><i class="fa fa-link"></i> <span>{{ trans('admin.menu_users') }}</span></a></li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>

