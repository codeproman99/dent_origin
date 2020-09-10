@extends('layouts.app', ['activePage' => 'patients', 'titlePage' => __('Patient')])

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
              <h4 class="card-title ">{{ __('Patient') }} - {{ $patient->name_surname }}</h4>
              <p class="card-category"> {{ __('Create or Edit Patient Information') }}</p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-10 ml-auto mr-auto">
                        <form id="frm_patient" method="POST" action="{{ route('patients.update_info') }}" >
                            @csrf
                            <input type="hidden" id="patient_id" name="id" value="{{ $patient->id }}">
                            <div class="row">
                                <div class="col-md-4 col-form-label">{{ __('First Visit:') }}</div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ $patient->first_visit_start->format('d/m/Y H:i') }} ~ {{ $patient->first_visit_end->format('d/m/Y H:i') }}" readonly style="border:0; background: transparent;" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-form-label">{{ __('Reminder First Visit:') }}</div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ $patient->first_visit_start->sub(new DateInterval('P2D'))->format('d/m/Y') }}" readonly style="border:0; background:transparent;">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-form-label">{{ __('Visit Status:') }}</div>
                                <div class="col-md-8 form-group">
                                    <select class="form-control" name="visit_status" id="visit_status">
                                        <option value="">{{ __('Select Visit Status') }}</option>
                                        @foreach($visit_status as $vs)
                                            <option value="{{ $vs->id }}" @if ($vs->id == $patient->visit_status) selected @endif>{{ __($vs->status_title) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-form-label">{{ __('Quotation Status:') }}</div>
                                <div class="col-md-8 form-group">
                                    <select class="form-control" name="quotation_status" id="quotation_status">
                                        <option value="">{{ __('Select Quotation Status') }}</option>
                                        @foreach($quotation_status as $qs)
                                            <option value="{{ $qs->id }}" @if ($qs->id == $patient->quotation_status) selected @endif>{{ __($qs->status_title) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-form-label">{{ __('Total accepted quotation €:') }}</div>
                                <div class="col-md-8 form-group">
                                    <input type="text" class="form-control" name="total_accepted_quotation" id="total_accepted_quotation" value="{{ $patient->total_accepted_quotation }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-form-label">{{ __('Total collected €:') }}</div>
                                <div class="col-md-8 form-group">
                                    <input type="text" class="form-control" name="total_collected" id="total_collected" value="{{ $patient->total_collected }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="offset-md-4 col-md-8 col-form-label" style="text-align:right;">
                                    <button class="btn btn-primary" type="submit" id="btn_save">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <span id="var_saved_saved" style="display:none">{{__('Saved successfully!')}}</span>
  <span id="var_saved_fail" style="display:none">{{__('An Error Occurred')}}</span>
  <span id="var_saved_success" style="display:none">{{__('Success')}}</span>
  <span id="var_saved_warning" style="display:none">{{__('Warning')}}</span>


  @push('styles')
    {{-- <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/> --}}
    <link href="https://nightly.datatables.net/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>
  @endpush
  @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>
    <script src="{{asset('js/custom/patient.js')}}" type="text/javascript"></script>
  @endpush

@endsection
