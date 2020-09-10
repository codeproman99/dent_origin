@extends('layouts.app', ['activePage' => 'calendar', 'titlePage' => __('Calendar')])

@section('content')
    @push('styles')
      <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" type="text/css" rel="stylesheet"/>
    @endpush
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title ">{{ __('Calendar') }}</h4>
              <p class="card-category"> {{ __('calendar of ') }} {{ $business_name }}</p>
            </div>
            <div class="card-body">
                <div class="row" style="padding-top:20px;">
                    <div id="lnb" class="col-lg-2 col-md-12 col-12">
                        <div id="lnb-calendars" class="lnb-calendars">
                            <div>
                                <div class="lnb-calendars-item">
                                    <label>
                                        <input class="tui-full-calendar-checkbox-square" type="checkbox" value="all" checked="">
                                        <span></span>
                                        <strong>{{ __('View all') }}</strong>
                                    </label>
                                </div>
                            </div>
                            <div id="calendarList" class="lnb-calendars-d1">
                            </div>
                        </div>
                    </div>
                    <div id="right" class="col-lg-10 col-md-12 col-12">
                        <div id="menu">
                            <span class="dropdown">
                                <button id="dropdownMenu-calendarType" class="btn btn-primary btn-sm btn-pill dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <i id="calendarTypeIcon" class="calendar-icon ic_view_month" style="margin-right: 4px;"></i>
                                    <span id="calendarTypeName">Dropdown</span>&nbsp;
                                    <i class="calendar-icon tui-full-calendar-dropdown-arrow"></i>
                                </button>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu-calendarType">
                                    <li role="presentation">
                                        <a class="dropdown-menu-title" role="menuitem" data-action="toggle-daily" href="javascript:void(0)">
                                            <i class="calendar-icon ic_view_day"></i>{{ __('Daily') }}
                                        </a>
                                    </li>
                                    <li role="presentation">
                                        <a class="dropdown-menu-title" role="menuitem" data-action="toggle-weekly" href="javascript:void(0)">
                                            <i class="calendar-icon ic_view_week"></i>{{ __('Weekly') }}
                                        </a>
                                    </li>
                                    <li role="presentation">
                                        <a class="dropdown-menu-title" role="menuitem" data-action="toggle-monthly" href="javascript:void(0)">
                                            <i class="calendar-icon ic_view_month"></i>{{ __('Month') }}
                                        </a>
                                    </li>
                                    <li role="presentation">
                                        <a class="dropdown-menu-title" role="menuitem" data-action="toggle-weeks2" href="javascript:void(0)">
                                            <i class="calendar-icon ic_view_week"></i>{{ __('2 weeks') }}
                                        </a>
                                    </li>
                                    <li role="presentation">
                                        <a class="dropdown-menu-title" role="menuitem" data-action="toggle-weeks3" href="javascript:void(0)">
                                            <i class="calendar-icon ic_view_week"></i>{{ __('3 weeks') }}
                                        </a>
                                    </li>
                                    <li role="presentation" class="dropdown-divider"></li>
                                    <li role="presentation">
                                        <a role="menuitem" data-action="toggle-workweek" href="javascript:void(0)">
                                            <input type="checkbox" class="tui-full-calendar-checkbox-square" value="toggle-workweek" checked="">
                                            <span class="checkbox-title"></span>{{ __('Show weekends') }}
                                        </a>
                                    </li>
                                    <li role="presentation">
                                        <a role="menuitem" data-action="toggle-start-day-1" href="javascript:void(0)">
                                            <input type="checkbox" class="tui-full-calendar-checkbox-square" value="toggle-start-day-1">
                                            <span class="checkbox-title"></span>{{ __('Start Week on Monday') }}
                                        </a>
                                    </li>
                                    <li role="presentation">
                                        <a role="menuitem" data-action="toggle-narrow-weekend" href="javascript:void(0)">
                                            <input type="checkbox" class="tui-full-calendar-checkbox-square" value="toggle-narrow-weekend">
                                            <span class="checkbox-title"></span>{{ __('Narrower than weekdays') }}
                                        </a>
                                    </li>
                                </ul>
                            </span>
                            <span id="menu-navi">
                                <button type="button" class="btn btn-success btn-sm btn-pill move-today" data-action="move-today">{{ __('Today') }}</button>
                                <button type="button" class="btn btn-primary btn-pill btn-sm move-day" data-action="move-prev">
                                    <i class="calendar-icon ic-arrow-line-left" data-action="move-prev"></i>
                                </button>
                                <button type="button" class="btn btn-primary btn-pill btn-sm move-day" data-action="move-next">
                                    <i class="calendar-icon ic-arrow-line-right" data-action="move-next"></i>
                                </button>
                            </span>
                            <span id="renderRange" class="render-range"></span>
                        </div>
                        <div id="calendar" class="calendar col-md-12" style="height: 800px;"></div>

                        <input type="hidden" name="current_user" id="current_user" value="{{ Auth::user()->id }}" >
                        <input type="hidden" name="user_role" id="user_role" value="{{ Auth::user()->role }}" >
                        <input type="hidden" name="dentist_id" id="dentist_id" value="{{ $dentist_id }}" >
                        <input type="hidden" name="self_manager" id="self_manager" value="{{ $self_manager }}" >
                        <input type="hidden" name="patient_base_url" id="patient_base_url" value="{{ route('patients') }}" >

                        <input type="hidden" id="current_selected_schedule_id" value="">
                        <input type="hidden" id="current_selected_calendar_id" value="">
                        {{-- Popup Modals --}}
                        {{-- Dentist Schedule Modal --}}
                        <div class="tui-full-calendar-popup" id="dentist_schedule_modal">
                            <div class="tui-full-calendar-popup-container">
                                <div class="tui-full-calendar-popup-section tui-full-calendar-dropdown tui-full-calendar-close tui-full-calendar-section-calendar tui-full-calendar-hide">
                                    <button class="tui-full-calendar-button tui-full-calendar-dropdown-button tui-full-calendar-popup-section-item">
                                        <span class="tui-full-calendar-icon tui-full-calendar-calendar-dot" style="background-color: #5ed84f"></span>
                                        <span id="tui-full-calendar-schedule-calendar" class="tui-full-calendar-content">{{ __('Dentist Free Time') }}</span>
                                    </button>
                                </div>
                                <div class="tui-full-calendar-popup-section">
                                    <div class="tui-full-calendar-popup-section-item tui-full-calendar-section-title">
                                        <span class="tui-full-calendar-icon tui-full-calendar-ic-title"></span>
                                        <input id="tui-full-calendar-schedule-title" class="tui-full-calendar-content" placeholder="{{ __('Name Surname') }}" value="{{ Auth::user()->name }} {{ Auth::user()->surname }}"></span>
                                    </div>
                                </div>
                                <div class="tui-full-calendar-popup-section">
                                    <div class="tui-full-calendar-popup-section-item tui-full-calendar-section-start-date">
                                        <span class="tui-full-calendar-icon tui-full-calendar-ic-date"></span>
                                        <input id="tui-full-calendar-schedule-start-date" class="tui-full-calendar-content" autocomplete="off" placeholder="{{ __('Start Date Time') }}"></span>
                                        <div id="tui-full-calendar-startpicker-container" style="margin-left: -1px; position: relative"></div>
                                    </div>
                                    <span class="tui-full-calendar-section-date-dash">-</span>
                                    <div class="tui-full-calendar-popup-section-item tui-full-calendar-section-end-date">
                                        <span class="tui-full-calendar-icon tui-full-calendar-ic-date"></span>
                                        <input id="tui-full-calendar-schedule-end-date" class="tui-full-calendar-content" autocomplete="off" placeholder="{{ __('End Date Time') }}"></span>
                                        <div id="tui-full-calendar-endpicker-container" style="margin-left: -1px; position: relative"></div>
                                    </div>
                                </div>
                                <button class="tui-full-calendar-button tui-full-calendar-popup-close"><span class="tui-full-calendar-icon tui-full-calendar-ic-close"></span></button>
                                <div class="tui-full-calendar-section-button-save"><button class="tui-full-calendar-button tui-full-calendar-confirm tui-full-calendar-popup-save"><span>{{ __('Save') }}</span></button></div>
                            </div>
                            {{-- <div id="tui-full-calendar-popup-arrow" class="tui-full-calendar-popup-arrow tui-full-calendar-arrow-bottom">
                                <div class="tui-full-calendar-popup-arrow-border">
                                    <div class="tui-full-calendar-popup-arrow-fill"></div>
                                </div>
                            </div> --}}
                        </div>

                        {{-- Patient Book Modal --}}
                        <div class="tui-full-calendar-popup" id="patient_book_modal">
                            <div class="tui-full-calendar-popup-container">
                                <div class="tui-full-calendar-popup-section tui-full-calendar-dropdown tui-full-calendar-close tui-full-calendar-section-calendar tui-full-calendar-hide">
                                    <button class="tui-full-calendar-button tui-full-calendar-dropdown-button tui-full-calendar-popup-section-item">
                                        <span class="tui-full-calendar-icon tui-full-calendar-calendar-dot" style="background-color: #fdb901"></span>
                                        <span id="tui-full-calendar-schedule-calendar" class="tui-full-calendar-content">{{ __('Patient') }}</span>
                                    </button>
                                </div>
                                <div class="tui-full-calendar-popup-section">
                                    <div class="tui-full-calendar-popup-section-item tui-full-calendar-section-title">
                                        <span class="tui-full-calendar-icon tui-full-calendar-ic-title"></span>
                                        <input id="tui-full-calendar-schedule-title" class="tui-full-calendar-content" placeholder="{{ __('Name Surname') }}" value=""></span>
                                    </div>
                                </div>
                                <div class="tui-full-calendar-popup-section">
                                    <div class="tui-full-calendar-popup-section-item tui-full-calendar-section-location">
                                    <span class="tui-full-calendar-icon tui-full-calendar-ic-location"></span>
                                        <input id="tui-full-calendar-schedule-phone" class="tui-full-calendar-content" placeholder="{{ __('Phone Number') }}" value=""></span>
                                    </div>
                                </div>
                                <div class="tui-full-calendar-popup-section">
                                    <div class="tui-full-calendar-popup-section-item tui-full-calendar-section-start-date">
                                        <span class="tui-full-calendar-icon tui-full-calendar-ic-date"></span>
                                        <input id="tui-full-calendar-schedule-start-date" class="tui-full-calendar-content" placeholder="{{ __('Start Date Time') }}"></span>
                                        <div id="tui-full-calendar-startpicker-container" style="margin-left: -1px; position: relative"></div>
                                    </div>
                                    <span class="tui-full-calendar-section-date-dash">-</span>
                                    <div class="tui-full-calendar-popup-section-item tui-full-calendar-section-end-date">
                                        <span class="tui-full-calendar-icon tui-full-calendar-ic-date"></span>
                                        <input id="tui-full-calendar-schedule-end-date" class="tui-full-calendar-content" placeholder="{{ __('End Date Time') }}"></span>
                                        <div id="tui-full-calendar-endpicker-container" style="margin-left: -1px; position: relative"></div>
                                    </div>
                                </div>
                                <button class="tui-full-calendar-button tui-full-calendar-popup-close"><span class="tui-full-calendar-icon tui-full-calendar-ic-close"></span></button>
                                <div class="tui-full-calendar-section-button-save"><button class="tui-full-calendar-button tui-full-calendar-confirm tui-full-calendar-popup-save"><span>{{ __('Save') }}</span></button></div>
                            </div>
                            {{-- <div id="tui-full-calendar-popup-arrow" class="tui-full-calendar-popup-arrow tui-full-calendar-arrow-bottom">
                                <div class="tui-full-calendar-popup-arrow-border">
                                    <div class="tui-full-calendar-popup-arrow-fill"></div>
                                </div>
                            </div> --}}
                        </div>


                        {{-- Dentist Schedule Details --}}
                        <div class="tui-full-calendar-popup tui-full-calendar-popup-detail tui-full-calendar-close" id="detail_modal">
                            <div class="tui-full-calendar-popup-container">
                                <div class="tui-full-calendar-popup-section tui-full-calendar-section-header">
                                    <div>
                                        <span class="tui-full-calendar-schedule-title"></span>
                                    </div>
                                    <div class="tui-full-calendar-popup-detail-date tui-full-calendar-content"></div>
                                </div>
                                <div class="tui-full-calendar-section-detail">
                                    <div class="tui-full-calendar-popup-detail-item phone"><span class="tui-full-calendar-icon tui-full-calendar-ic-location-b"></span><span class="tui-full-calendar-content"></span></div>
                                    <div class="tui-full-calendar-popup-detail-item calendar-type"><span class="tui-full-calendar-icon tui-full-calendar-calendar-dot"></span><span class="tui-full-calendar-content"></span></div>
                                </div>
                                <button class="tui-full-calendar-button tui-full-calendar-popup-close"><span class="tui-full-calendar-icon tui-full-calendar-ic-close"></span></button>
                                <div class="tui-full-calendar-section-button">
                                    <button class="tui-full-calendar-popup-edit"><span class="tui-full-calendar-icon tui-full-calendar-ic-edit"></span><span class="tui-full-calendar-content">{{ __('Edit') }}</span></button>
                                    <div class="tui-full-calendar-popup-vertical-line"></div>
                                    <button class="tui-full-calendar-popup-delete"><span class="tui-full-calendar-icon tui-full-calendar-ic-delete"></span><span class="tui-full-calendar-content">{{ __('Delete') }}</span></button>
                                </div>
                                <a href="patients/" id="patient-link">{{ __('Patient Details') }}</a>
                            </div>
                        </div>
                        {{-- End Popup Modals --}}
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <span id="var_error_add" style="display:none">{{__('Can not create patient book, check the timeline')}}</span>
  <span id="var_error_modify" style="display:none">{{__('Can not update patient book, check the timeline')}}</span>
  <span id="var_cal_daily" style="display:none">{{__('Daily')}}</span>
  <span id="var_cal_weekly" style="display:none">{{__('Weekly')}}</span>
  <span id="var_cal_2weeks" style="display:none">{{__('2 weeks')}}</span>
  <span id="var_cal_3weeks" style="display:none">{{__('3 weeks')}}</span>
  <span id="var_cal_monthly" style="display:none">{{__('Monthly')}}</span>


  @push('styles')
    <link href="{{ asset('vendor/calendar/css/tui-time-picker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/calendar/css/tui-date-picker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/calendar/css/tui-calendar.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/calendar/css/default.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/calendar/css/icons.css') }}" rel="stylesheet" type="text/css" />
  @endpush
  @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>
    <script src="{{ asset('vendor/calendar/js/tui-code-snippet.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('vendor/calendar/js/tui-time-picker.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('vendor/calendar/js/tui-date-picker.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('vendor/calendar/js/moment.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('vendor/calendar/js/chance.min.js')}}" type="text/javascript"></script>
    {{-- <script src="{{ asset('vendor/calendar/js/timezone.js')}}" type="text/javascript"></script> --}}
    <script src="{{ asset('vendor/calendar/js/tui-calendar.js')}}" type="text/javascript"></script>
    <script src="{{ asset('vendor/calendar/js/calendars.js')}}" type="text/javascript"></script>
    <script src="{{ asset('vendor/calendar/js/schedules.js')}}" type="text/javascript"></script>
    <script src="{{ asset('vendor/calendar/js/dooray.js')}}" type="text/javascript"></script>
    <script src="{{ asset('vendor/calendar/js/default.js')}}" type="text/javascript"></script>
  @endpush

@endsection
