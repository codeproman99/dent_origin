@extends('layouts.app', ['activePage' => 'patients', 'titlePage' => __('Patients')])

@section('content')
    @push('styles')
      <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" type="text/css" rel="stylesheet"/>
      <link href="{{ asset('css/custom.css') }}" type="text/css" rel="stylesheet"/>
    @endpush
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title ">{{ __('Patients List') }}</h4>
            <p class="card-category"> {{ __('Patients Of ') }} {{ $business_name }}</p>
            </div>
            <div class="card-body">
                <table id="patients_table" class="table table-striped table-bordered" style="width:100%">
                @if (Auth::user()->role == 2)
                    <thead>
                        <tr style="text-align: center">
                            <th width="50px">{{ __('No') }}</th>
                            <th>{{ __('Name Surname') }}</th>
                            <th>{{ __('Phone n.') }}</th>
                            <th>{{ __('First visit') }}</th>
                            <!--<th>{{ __('Reminder FV.') }}</th>-->
                            <th>{{ __('Visit status') }}</th>
                            <th>{{ __('Quotation status') }}</th>
                            <th>{{ __('Total accepted quotation (€)') }}</th>
                            <th>{{ __('Total collected (€)') }}</th>
                            @if (Auth::user()->role == 2)
                            {{-- <th style="width: 80px !important;">Actions</th> --}}
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                    <?php $index = 0 ;?>
                    @foreach($patients as $patient)
                        <?php
                            $index++ ;
                            $reminder_date = $patient->first_visit_start->sub(new DateInterval('P2D'));
                        ?>
                        <tr style="text-align: center">
                            <td class="text-center">{{ $index }}</td>
                            <td><a href="{{ route('patients.edit', [$patient->id]) }}">{{ $patient->name_surname }}</a></td>
                            <td>{{ $patient->phone_number }}</td>
                            <td>{{ $patient->first_visit_start->format('d/m/Y') }}</td>
                            <!--<td>{{ $reminder_date->format('d/m/Y') }}</td>-->
                            <td>{{ __($patient->visit_status_title) }}</td>
                            <td>{{ __($patient->quotation_status_title) }}</td>
                            <td>{{ $patient->total_accepted_quotation }}</td>
                            <td>{{ $patient->total_collected }}</td>
                            @if (Auth::user()->role == 2)
                                {{-- <td class="text-center" style="width: 180px;">
                                    <div class="btn-group">
                                        <button class="btn btn-primary btn-sm btn-badge{{$patient['status'] == 1 ? ' permission-active' : ''}} action_button" permission="1" onclick="changeStatus(1, '{{$patient['subdomain']}}');">UNBLOCK</button>
                                        <button class="btn btn-warning btn-sm btn-badge{{$patient['status'] == 0 ? ' permission-active' : ''}} action_button" permission="0" onclick="changeStatus(0, '{{$patient['subdomain']}}');">BLOCK</button>
                                        <button button="button" class="btn btn-success btn-sm btn-badge action_button" onclick="changeLimited( {{$patient['id']}} );">UnLimited</button>
                                        <button button="button" class="btn btn-danger btn-sm btn-badge action_button" permission="-1" onclick="changeStatus(-1, '{{$patient['subdomain']}}');">DELETE</button>
                                    </div>
                                </td> --}}
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                @endif
                </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.css"/>
  @endpush
  @push('scripts')
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>
    <script src="{{asset('js/custom/patients.js')}}" type="text/javascript"></script>
  @endpush

@endsection
