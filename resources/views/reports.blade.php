@extends('layouts.app', ['activePage' => 'reports', 'titlePage' => __('Reports')])

@section('content')
    @push('styles')
      <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" type="text/css" rel="stylesheet"/>
      <link href="{{asset('css/custom.css')}}" type="text/css" rel="stylesheet"/>
    @endpush
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card report-form">
            <div class="card-header card-header-primary">
              <h4 class="card-title ">{{ __('Reports') }} {{ Auth::user()->role == 3 ? 'of '.$user_info->business_name : " " }}</h4>
              <p class="card-category"> {{ __('Management Reports') }}</p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form id="frm_report" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="row">
                                        <div class="col-md-6 col-form-label">{{__('Select Year:')}}</div>
                                        <div class="col-md-6 form-group">
                                            <select class="form-control" name="year" id="year" required>
                                                @foreach ($years as $year)
                                                    <option value="{{$year}}" @if ($year == $current_year) selected @endif>{{$year}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-form-label">{{__('Select Month:')}}</div>
                                        <div class="col-md-6 form-group">
                                            <select class="form-control" name="month" id="month" required>
                                                <option value="all">{{__('All the year')}}</option>
                                                @for ($i = 1; $i <= 12; $i++)
                                                    <option value="{{$i}}" @if ($i == $current_month) selected @endif>{{__($months[$i-1])}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                @if (Auth::user()->role == 3 || Auth::user()->self_manager == true)
                                <div class="col-md-5">
                                    <div class="row">
                                        <div class="col-md-6 col-form-label">{{__('Flat price month')}}</div>
                                        <div class="col-md-6 form-group">
                                            <input class="form-control" type="text" name="flat_price_month" id="flat_price_month" value="{{ $report ? $report->flat_price_month : '' }}" required >
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-form-label">{{__('% month')}}</div>
                                        <div class="col-md-6 form-group">
                                            <input class="form-control" type="text" name="rate_month" id="rate_month" value="{{ $report ? $report->rate_month : ''}}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2" style="display: flex; align-items: flex-end; padding-bottom: 1rem;">
                                    <button class="btn btn-primary" id="btn_save">save</button>
                                </div>
                                @endif
                                <input type="hidden" name="dentist_id" id="dentist_id" value="{{ $dentist_id }}" />
                                <input type="hidden" name="auth_role" id="auth_role" value="{{ Auth::user()->role }}" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
          <div class="col-md-12">
              <div class="card reports">
                  <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <p>{{__('Total LEADS:')}} <span id="total_leads">{{ $report_data['total_count']}}</span></p>
                            <p>{{__('Total Visited Patients (first visit):')}} <span id="total_visited">{{ $report_data['visited_patients']}}</span></p>
                            <p>{{__('Total cancelled visits:')}} <span id="total_cancelled_visits">{{ $report_data['cancelled_visits']}}</span></p>
                            <p>{{__('Total n. quotations given:')}} <span id="total_quotations_given">{{ $report_data['quotations_given']}}</span></p>
                            <p>{{__('Total n. accepted quotations:')}} <span id="total_accepted_quotations">{{ $report_data['accepted_quotation']}}</span></p>
                            <p>{{__('Total n. not accepted quotations or in waiting:')}} <span id="total_not_accepted_quotation">{{ $report_data['not_accepted_quotation']}}</span></p>
                            <p>{{__('Total € accepted quotation:')}} <span id="total_accepted_quotation_amount">{{ $report_data['total_accepted_quotation_amount']}}</span></p>
                        </div>
                        <div class="col-md-8 charts">
                            <div class="row">
                                <div class="col-md-6">
                                    <div id="chart_1" class="chart"></div>
                                </div>
                                <div class="col-md-6">
                                    <div id="chart_2" class="chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="row">
          <div class="col-md-12">
              <div class="card">
                  <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="report-table" width="100%">
                                <thead>
                                    <tr>
                                        <th class="tr-result"></th>
                                        <th>{{__('Flat Price')}}</th>
                                        <th>{{__('Gaining')}}</th>
                                        <th><span id="gaining_percent"></span> {{__('% gaining')}}</th>
                                        <th>{{__('ROI')}}</th>
                                        <th>{{__('ROI %')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="tr-result">
                                        <td>{{__('R.O.I')}}</td>
                                        <td><span id="flat_price"></span>€</td>
                                        <td><span id="gaining"></span>€</td>
                                        <td><span id="calculated_gaining"></span>€</td>
                                        <td><span id="roi"></span>€</td>
                                        <td><span id="roi_percent"></span></td>
                                    </tr>
                                    <tr class="tr-result">
                                        <td>{{__('To. investment')}}</td>
                                        <td><span id="total_flat_price"></span>€</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr class="tr-error">
                                        <td colspan="6">
                                            {{__('No all the Rate are set')}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                  </div>
              </div>
          </div>
      </div>
    </div>
  </div>
  <span id="var-total" style="display:none">{{__('Total')}}</span>
  <span id="var-visited-patients" style="display:none">{{__('Visited patients')}}</span>
  <span id="var-cancelled-patients" style="display:none">{{__('Cancelled Patients')}}</span>
  <span id="var-quotation-given" style="display:none">{{__('Quotation Given')}}</span>
  <span id="var-waiting" style="display:none">{{__('Waiting or Cancelled')}}</span>
  <span id="var-accepted-quotations" style="display:none">{{__('Accepted Quotations')}}</span>
  <span id="var-success" style="display:none">{{__('Success')}}</span>
  <span id="var-saved-successfully" style="display:none">{{__('Saved successfully!')}}</span>
  <span id="var-error" style="display: none">{{__('Error')}}</span>


  @push('styles')
    {{-- <link href="{{ asset('vendor/apexcharts/dist/apexcharts.js') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendor/apexcharts/dist/apexcharts.amd.js') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('vendor/apexcharts/dist/apexcharts.esm.js') }}" rel="stylesheet" type="text/css"/> --}}
    <link href="{{ asset('vendor/apexcharts/dist/apexcharts.css') }}" rel="stylesheet" type="text/css"/>
  @endpush
  @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>
    <script src="{{ asset('vendor/apexcharts/dist/apexcharts.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/custom/reports.js') }}" type="text/javascript"></script>
  @endpush

@endsection
