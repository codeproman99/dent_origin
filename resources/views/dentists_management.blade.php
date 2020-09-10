@extends('layouts.app', ['activePage' => 'dentists_management', 'titlePage' => __('Studios Management')])

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
              <h4 class="card-title ">{{ __('Studios Management') }}</h4>
              <p class="card-category"> {{ __('List of All Studios') }}</p>
            </div>
            <div class="card-body">
                <table id="dentists_table" class="table table-striped table-bordered" style="width:100%">
                @if (Auth::user()->role == 1)
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>{{__('Business Name')}}</th>
                            <th width="35%">{{ __('Assign Manager') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $index = 0 ;?>
                    @foreach($dentists as $dentist)
                        <?php $index++ ;?>
                        <tr>
                            <td class="text-center">{{$index}}</td>
                            <td>{{ $dentist['business_name'] }}</td>
                            <td class="text-center">
                                <div class="">
                                    <select class="manager_id" name="manager_id[]" id="assignTo_{{ $dentist->id }}" style="width: 70%; ">
                                      <option value="">{{ __('Not Assigned') }}</option>
                                        @foreach( $managers as $manager )
                                          <?php
                                            $selected = "";
                                            if( $dentist->assigned_manager == $manager->id ){
                                              $selected = "selected";
                                            }
                                          ?>
                                          <option value="{{ $manager->id }}" {{ $selected }} >{{ __($manager->business_name) }}</option>
                                        @endforeach
                                    </select>
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
  <span id="var_save_success" style="display:none">{{ __('Updated Successfully!')}}</span>
  <span id="var_success" style="display:none">{{ __('Success')}}</span>


  @push('styles')
   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.css"/>
  @endpush
  @push('scripts')
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>
    <script src="{{asset('js/custom/dentists.js')}}" type="text/javascript"></script>
  @endpush

@endsection
