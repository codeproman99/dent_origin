@extends('layouts.app', ['activePage' => 'new_user', 'titlePage' => __('User Management')])

@section('content')
    @push('styles')
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" type="text/css" rel="stylesheet"/>
    @endpush
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
            <form id="frm_edit_user" method="POST" action="{{ route('user.update', $user) }}" autocomplete="off" class="form-horizontal">
                @csrf
                @method('put')
                <div class="card users">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">{{ __('User') }} - {{$user->name}} {{$user->surname}}</h4>
                        <p class="card-category"></p>
                    </div>
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('user.index') }}" class="btn btn-sm btn-primary">{{ __('Users list') }}</a>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 20px;">
                            <div class="col-md-12 ml-auto mr-auto">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-4 col-form-label">{{ __('Name:') }}</div>
                                            <div class="col-md-8">
                                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                                    <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="input_name" type="text" value="{{ old('name', $user->name) }}" required aria-required="true"/>
                                                    @if ($errors->has('name'))
                                                        <span id="name_error" class="error text-danger" for="input_name">{{ $errors->first('name') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-4 col-form-label">{{ __('Surname:') }}</div>
                                            <div class="col-md-8">
                                                <div class="form-group{{ $errors->has('surname') ? ' has-danger' : '' }}">
                                                    <input class="form-control{{ $errors->has('surname') ? ' is-invalid' : '' }}" name="surname" id="input_surname" type="text" value="{{ old('surname', $user->surname) }}" required aria-required="true"/>
                                                    @if ($errors->has('surname'))
                                                        <span id="surname_error" class="error text-danger" for="input_surname">{{ $errors->first('surname') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-4 col-form-label">{{ __('Email:') }}</div>
                                            <div class="col-md-8">
                                                <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                                    <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="input_email" type="email" value="{{ old('email', $user->email) }}" required />
                                                    @if ($errors->has('email'))
                                                        <span id="email_error" class="error text-danger" for="input_email">{{ $errors->first('email') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-4 col-form-label">{{ __('Phone Number:') }}</div>
                                            <div class="col-md-8">
                                                <div class="form-group{{ $errors->has('phone_number') ? ' has-danger' : '' }}">
                                                    <input class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" name="phone_number" id="input_phone_number" type="text" value="{{ old('phone_number', $user->phone_number) }}" />
                                                    @if ($errors->has('email'))
                                                        <span id="phone_number_error" class="error text-danger" for="input_email">{{ $errors->first('email') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-4 col-form-label">{{ __('Address:') }}</div>
                                            <div class="col-md-8">
                                                <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
                                                    <input class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" id="input_address" type="text" value="{{ old('address', $user->address) }}" />
                                                    @if ($errors->has('address'))
                                                        <span id="address_error" class="error text-danger" for="input_address">{{ $errors->first('address') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-4 col-form-label" for="role">{{ __('Role:') }}</div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <select class="form-control" name="role" id="role">
                                                        @foreach ($roles as $role)
                                                            <option value="{{ $role->id }}" @if ( $role->id == old('role', $user->role) ) selected @endif>{{ $role->role_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-4 col-form-label" for="status">{{ __('Status:') }}</div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <select class="form-control" name="status" id="status">
                                                        @foreach ($status as $st)
                                                            <option value="{{ $st->status_id }}" @if ( $st->status_id == old('status', $user->status) ) selected @endif>{{ $st->status_title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-4 col-form-label" for="active_due_date">{{ __('Active Till') }}</div>
                                            <div class="col-md-8">
                                                <div class="form-group{{ $errors->has('active_due_date') ? ' has-danger' : '' }}" >
                                                    <input class="form-control{{ $errors->has('active_due_date') ? ' is-invalid' : '' }}" type="date" name="active_due_date" id="active_due_date" value="{{ old('active_due_date', !empty($user->active_due_date) ? $user->active_due_date->format('Y-m-d') : '' ) }}">
                                                    @if ($errors->has('active_due_date'))
                                                        <span id="due_date_error" class="error text-danger" for="active_due_date">{{ $errors->first('active_due_date') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-4 col-form-label" for="input_password">{{ __(' Password') }}</div>
                                            <div class="col-md-8">
                                                <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                                    <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" name="password" id="input_password" value="" />
                                                    @if ($errors->has('password'))
                                                        <span id="password_error" class="error text-danger" for="input_password">{{ $errors->first('password') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-4 col-form-label" for="input_password_confirmation">{{ __('Confirm Password') }}</div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <input class="form-control" name="password_confirmation" id="input_password_confirmation" type="password" value="" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-4 col-form-label" for="input_business_name">{{ __('Business Name:')}}</div>
                                            <div class="col-md-8">
                                                <div class="form-group{{ $errors->has('business_name') ? ' has-danger' : '' }}">
                                                    <input class="form-control{{ $errors->has('business_name') ? ' is-invalid' : '' }}" type="text" name="business_name" id="input_business_name" value="{{ old('business_name', $user->business_name) }}" required />
                                                    @if ($errors->has('business_name'))
                                                        <span id="business_name_error" class="error text-danger" for="input_business_name">{{ $errors->first('business_name') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-4 col-form-label" for="input_piva">{{ __('P.IVA:')}}</div>
                                            <div class="col-md-8">
                                                <div class="form-group{{ $errors->has('piva') ? ' has-danger' : '' }}">
                                                    <input class="form-control{{ $errors->has('piva') ? ' is-invalid' : '' }}" type="text" name="piva" id="input_piva" value="{{ old('piva', $user->piva) }}" />
                                                    @if ($errors->has('piva'))
                                                        <span id="piva_error" class="error text-danger" for="input_piva">{{ $errors->first('piva') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-4 col-form-label" for="input_sdi_code">{{ __('SDI Code:')}}</div>
                                            <div class="col-md-8">
                                                <div class="form-group{{ $errors->has('sdi_code') ? ' has-danger' : '' }}">
                                                    <input class="form-control{{ $errors->has('sdi_code') ? ' is-invalid' : '' }}" type="text" name="sdi_code" id="input_sdi_code" value="{{ old('sdi_code', $user->sdi_code) }}" />
                                                    @if ($errors->has('sdi_code'))
                                                        <span id="sdi_code_error" class="error text-danger" for="input_sdi_code">{{ $errors->first('sdi_code') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-4 col-form-label" for="input_legal_address">{{ __('Legal Address')}}</div>
                                            <div class="col-md-8">
                                                <div class="form-group{{ $errors->has('legal_address') ? ' has-danger' : '' }}">
                                                    <input class="form-control{{ $errors->has('legal_address') ? ' is-invalid' : '' }}" type="text" name="legal_address" id="input_legal_address" value="{{ old('legal_address', $user->legal_address) }}" />
                                                    @if ($errors->has('legal_address'))
                                                        <span id="legal_address_error" class="error text-danger" for="input_legal_address">{{ $errors->first('legal_address') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-4 col-form-label" for="input_operative_address">{{ __('Operative Address')}}</div>
                                            <div class="col-md-8">
                                                <div class="form-group{{ $errors->has('operative_address') ? ' has-danger' : '' }}">
                                                    <input class="form-control{{ $errors->has('operative_address') ? ' is-invalid' : '' }}" type="text" name="operative_address" id="input_operative_address" value="{{ old('operative_address', $user->operative_address) }}" />
                                                    @if ($errors->has('operative_address'))
                                                        <span id="operative_address_error" class="error text-danger" for="input_operative_address">{{ $errors->first('operative_address') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row" id="self_manager_group" style="display:none">
                                            <div class="col-md-4 col-form-label" for="self_manager">{{ __('Self Manager:') }}</div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <select class="form-control" name="self_manager" id="self_manager">
                                                        <option value="0" @if ( old('self_manager', $user->self_manager) == false ) selected @endif>{{ __('No') }}</option>
                                                        <option value="1" @if ( old('self_manager', $user->self_manager) == true ) selected @endif>{{ __('Yes') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 ml-auto mr-auto">
                                <div class="row">
                                    <div class="col-md-12 form-group" style="text-align:right">
                                        <button class="btn btn-primary" id="btn_save">{{ __('Save') }}</button>
                                        <button class="btn btn-danger" id="btn_delete">{{ __('Delete') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}" > --}}
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
<span id="var_account_delete" style="display: none">{{ __('Are you sure you want to delete this user?') }}</span>
<span id="var_deleted_success" style="display:none">{{ __('User deleted successfully') }}</span>
<span id="var_success" style="display:none">{{__('Success')}}</span>

<input type="hidden" id="user_delete_url" value="{{ route('delete_user') }}" />
<input type="hidden" id="redirect_url" value="{{ route('users') }}" />
<input type="hidden" id="user_id" value="{{ $user->id }}" />

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>
    <script>
    $(document).ready(function() {
        var _token = $('meta[name="csrf-token"]').attr('content');
        var  _url = $('#user_delete_url').val();
        var user_id = $('#user_id').val();
        var redirect_url = $('#redirect_url').val();

        // var DatePicker = tui.DatePicker;
        var var_account_delete = $('#var_account_delete').text();
        var var_deleted_success = $('#var_deleted_success').text();
        var var_success = $('#var_success').text();

        if( $('#role').val() == 2 ){
            $('#self_manager_group').show();
        } else {
            $('#self_manager_group').hide();
        }

        $('#role').on('change', function(e){
            if( $(this).val() == 2 ){
                $('#self_manager_group').show();
            }else {
                $('#self_manager_group').hide();
            }
        });

        // $('#active_due_date').datepicker();


        $('#btn_delete').on('click', function(e){
            e.preventDefault();

            if( window.confirm(var_account_delete) ){
                $.post(_url, {
                    _token: _token,
                    id: user_id,
                })
                .done(function(response){
                    if(response.result == true){
                        toastr.success(var_success, var_deleted_success);
                        location.href = redirect_url;
                    }
                });
            }
        })
    });
  </script>
  @endpush

@endsection
