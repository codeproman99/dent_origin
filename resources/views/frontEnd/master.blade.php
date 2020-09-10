@extends('theme::layouts.app_apex')

@section('content')

<body data-col="2-columns" class=" 2-columns ">
  <div class="wrapper">

    @include('theme::menus.studio')
    @include('theme::layouts.headers.apex(header)')
    <div class="main-panel">
      <!-- BEGIN : Main Content-->
      <div class="main-content">
        <div class="contain-wrapper">
          <select name="" id="dom">
            <div class="col-sm-12">
              <div class="content-header">{{ __("Studio Payments")}}</div>
              <p class="mt-1">{{ __("Settings")}} | {{ __("Studio Payments")}}</p>
            </div>
            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="form-action col-md-9 top">
                    <p class="form-section mb-0">{{ __("This is Studio Payments Page")}}({{ __("page description")}}).</p>
                  </div>

                  <div class="alert col-md-3" role="alert">
                    <span style="float:right;">{{$dayTime = date('Y-m-d H:i:s')}}</span>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="px-3">
                  <form class="form">
                    <div class="form-body">

                      <div class="row">
                        <div class="form-group col-md-8 mb-2">
                          <h6 class="card-title">{{ __("PayPal")}}:</h6>
                          <p>{{ __("This is part of description for paypal")}}.</p>
                          <label for="projectinput1">{{ __("PayPal Account")}}:</label>
                          <input type="text" id="" class="form-control" placeholder="PayPal" name="paypal" value="{{$paymentData->paypal_account}}">
                        </div>
                        <div class="col-md-1"></div>
                        <div class="form-group col-md-3">
                          <!-- Default switch -->
                          <div class="custom-control custom-switch mt-2">
                            <input type="checkbox" class="custom-control-input" id="customSwitches">
                            <label class="custom-control-label" for="customSwitches">{{ __("Off/On")}}</label>
                          </div>
                          <div class="mt-5">
                            <a href="#">{{ __("How to set up a PayPal Account")}}?</a>
                          </div>

                        </div>

                        <div class="row mt-3">
                          <div class="form-group col-md-8 mb-2">
                            <h6 class="card-title">{{ __("Stripe")}}:</h6>
                            <p>{{ __("This is part of description for stripe")}}.</p>
                            <label for="projectinput1">{{ __("Stripe Account")}}:</label>
                            <input type="text" id="" class="form-control" placeholder="Stripe" name="paypal" value="{{$paymentData->paypal_account}}">
                          </div>
                          <div class="col-md-1"></div>
                          <div class="form-group col-md-3">
                            <!-- Default switch -->
                            <div class="custom-control custom-switch mt-2">
                              <input type="checkbox" class="custom-control-input" id="customSwitches1">
                              <label class="custom-control-label" for="customSwitches1">{{ __("Off/On")}}</label>
                            </div>
                            <div class="mt-5">
                              <a href="#">{{ __("How to set up a Stripe Account")}}?</a>
                            </div>

                          </div>
                        </div>

                        <div class="row mt-3">
                          <div class="form-group col-md-8 mb-2">
                            <h6 class="card-title">{{ __("Bank Transfer")}}:</h6>
                            <p>{{ __("This is part of description for bank")}}.</p>

                          </div>
                          <div class="col-md-1"></div>
                          <div class="form-group col-md-3">
                            <!-- Default switch -->
                            <div class="custom-control custom-switch mt-2">
                              <input type="checkbox" class="custom-control-input" id="customSwitches2">
                              <label class="custom-control-label" for="customSwitches2">{{ __("Off/On")}}</label>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-8">
                            <label for="projectinput1">{{ __("IBAN")}}:</label>
                            <input type="text" id="" class="form-control" placeholder="IBAN" name="iban" value="{{$paymentData->iban}}">
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-8">
                            <label for="projectinput1">{{ __("Account beneficiary")}}:</label>
                            <input type="text" id="" class="form-control" placeholder="Account beneficiary" name="beneficiary" value="{{$paymentData->benificary}}">
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-8">
                            <label for="projectinput1">{{ __("Payment Istructions")}}:</label>
                            <input type="text" id="" class="form-control" placeholder="Payment Istructions" name="istruction" value="{{$paymentData->istruction}}">
                          </div>
                        </div>
                      </div>
                  </form>
                </div>
              </div>
            </div>
          </select>
          <footer class="footer footer-static footer-light">
            <p class="clearfix text-muted text-sm-center px-2"><span>Copyright &copy; 2019 <a href="https://themeforest.net/user/pixinvent/portfolio?ref=pixinvent" id="pixinventLink" target="_blank" class="text-bold-800 primary darken-2">PIXINVENT </a>, All rights reserved. </span></p>
          </footer>
        </body>
@endsection