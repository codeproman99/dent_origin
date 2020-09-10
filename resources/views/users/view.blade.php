@extends('layouts.app', ['activePage' => 'view_user', 'titlePage' => __('User Management')])

@section('content')
  @push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" type="text/css" rel="stylesheet"/>
  @endpush
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card users">
                <div class="card-header card-header-primary">
                    <h4 class="card-title ">{{ __('User') }}</h4>
                    <p class="card-category"> {{ __('Detail page') }}</p>
                </div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="row">
                        <div class="col-sm-12">
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <i class="material-icons">close</i>
                            </button>
                            <span>{{ session('status') }}</span>
                        </div>
                        </div>
                    </div>
                    @endif

                    <!-- content -->
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
  <span id="var_unblock" style="display:none">{{__('Are you sure you want to Unblock this user?')}}</span>
  <span id="var_block" style="display:none">{{__('Are you sure you want to Block this user?')}}</span>
  <span id="var_account_changed" style="display:none">{{__('Account status changed')}}</span>
  <span id="var_account_success" style="display:none">{{__('Success')}}</span>
@push('styles')
   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.css"/>
@endpush
@push('scripts')
  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>
  <script src="{{asset('js/custom/dentists.js')}}" type="text/javascript"></script>
  @endpush
@endsection
