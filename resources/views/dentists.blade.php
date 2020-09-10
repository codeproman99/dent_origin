@extends('layouts.app', ['activePage' => 'dentists', 'titlePage' => __('List of all Dentists')])

@section('content')
    @push('styles')
      <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" type="text/css" rel="stylesheet"/>
      <link href="{{asset('css/custom.css')}}" type="text/css" rel="stylesheet"/>
    @endpush
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title ">{{ __('Studio List') }}</h4>
              <p class="card-category"> {{ __('List of All registered Studios') }}</p>
            </div>
            <div class="card-body">
                <table id="dentists_table" class="table table-striped table-bordered" style="width:100%">
                @if (Auth::user()->role == 3)
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <!--<th>{{__('Name Surname')}}</th>-->
                            <th>{{__('Business Name')}}</th>
                            <th>{{__('Phone n.')}}</th>
                            <!--<th>{{__('Address')}}</th>-->
                            <!--<th>{{__('P.IVA')}}</th>-->
                            <!--<th>{{__('SDI Code')}}</th>-->
                            <!--<th>{{__('Legal Address')}}</th>-->
                            <th>{{__('Operative Address')}}</th>
                            <th>{{__('Total Leads')}}</th>
                            <th style="width: 80px !important;">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $index = 0 ;?>
                    @foreach($dentists as $dentist)
                        <?php $index++ ;?>
                        <tr>
                            <td class="text-center">{{$index}}</td>
                            <!--<td><a href="{{ route('patient_book', $dentist->id) }}">{{$dentist->name}} {{$dentist->surname}}</a></td>-->
                            <td><a href="{{ route('patient_book', $dentist->id) }}">{{$dentist->business_name}}</a></td>
                            <td>{{$dentist->phone_number}}</td>
                            <!--<td>{{$dentist->address}}</td>-->
                            <!--<td>{{$dentist->piva}}</td>-->
                            <!--<td>{{$dentist->sdi_code}}</td>-->
                            <!--<td>{{$dentist->legal_address}}</td>-->
                            <td>{{$dentist->operative_address}}</td>
                            <td>{{$total_leads[$dentist->id]}}</td>
                            <td class="text-center" style="width: 180px;">
                                <div class="btn-group">
                                    <a href="{{ route('report', $dentist->id) }}"><i class="fas fa-chart-pie"></i></a>
                                </div>
                            </td>
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
    <script src="{{asset('js/custom/dentists.js')}}" type="text/javascript"></script>
  @endpush

@endsection
