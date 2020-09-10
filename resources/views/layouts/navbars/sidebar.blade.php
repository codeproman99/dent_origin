<div class="sidebar" data-color="azure" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="/" class="simple-text logo-normal">
        <img src="{{ asset('/images/logo.png') }}" alt="{{ __('Patient') }}" />
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
    {{--  <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('Dashboard') }}</p>
        </a>
      </li> --}}

      @if (Auth::user()->role == 2)
      <li class="nav-item{{ $activePage == 'calendar' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('calendar') }}">
          <i class="fas fa-calendar-alt"></i>
            <p>{{ __('Calendar') }}</p>
        </a>
      </li>

      <li class="nav-item{{ $activePage == 'patients' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('patients') }}">
          <i class="fa fa-users"></i>
            <p>{{ __('Patients') }}</p>
        </a>
      </li>

      <li class="nav-item{{ $activePage == 'reports' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('reports') }}">
          <i class="fas fa-file-alt"></i>
            <p>{{ __('Reports') }}</p>
        </a>
      </li>

      <li class="nav-item{{ $activePage == 'reminder' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('calendar.downloadcsv') }}" >
          <i class="fas fa-bell"></i>
            <p>{{ __('Reminder') }}</p>
        </a>
      </li>
      @endif

      @if (Auth::user()->role == 3)
      {{-- <li class="nav-item{{ $activePage == 'calendar' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('calendar') }}">
          <i class="fas fa-calendar-alt"></i>
            <p>{{ __('Calendar') }}</p>
        </a>
      </li> --}}

      <li class="nav-item{{ $activePage == 'dentists' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('dentists') }}">
          <i class="fas fa-tooth"></i>
            <p>{{ __('Studios') }}</p>
        </a>
      </li>
      @endif

      @if (Auth::user()->role == 1)
      <li class="nav-item{{ $activePage == 'users' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('users') }}">
          <i class="fas fa-users"></i>
            <p>{{ __('Users') }}</p>
        </a>
      </li>

      <li class="nav-item{{ $activePage == 'new_user' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('new_user') }}">
          <i class="fas fa-user"></i>
            <p>{{ __('New User') }}</p>
        </a>
      </li>

      <li class="nav-item{{ $activePage == 'dentists_management' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('dentists_management') }}">
          <i class="fas fa-tooth"></i>
            <p>{{ __('Studios Management') }}</p>
        </a>
      </li>

      <li class="nav-item {{ $activePage == 'profile' ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('profile.edit') }}">
              <i class="fas fa-user-tie"></i>
              <p>{{ __('User Profile') }}</p>
          </a>
        </li>
      @endif
    </ul>
  </div>
  <div class="manager-logo">
    <div>
      @if( Auth::user()->role == 2 && Auth::user()->self_manager == false )
      <?php
        $manager_logo_file_path = public_path().'/images/users/'.Auth::user()->assigned_manager.'.png';
        $manager_logo_path = asset('/images/users/'.Auth::user()->assigned_manager.'.png');
      ?>
        @if(file_exists($manager_logo_file_path))
          <img src="{{ $manager_logo_path }}" alt="">
        @endif
      @endif
    </div>
  </div>

</div>
