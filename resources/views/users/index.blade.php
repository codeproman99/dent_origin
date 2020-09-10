@extends('layouts.app', ['activePage' => 'users', 'titlePage' => __('User Management')])

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
                    <h4 class="card-title ">{{ __('Users') }}</h4>
                    <p class="card-category"> {{ __('List of All registered Users') }}</p>
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
                    <div class="row">
                        <div class="col-12 text-right">
                            <a href="{{ route('user.create') }}" class="btn btn-sm btn-primary">{{ __('Add user') }}</a>
                        </div>
                    </div>
                    <div class="table-responsive" style="padding-top:15px">
                        <table id="users" class="table">
                            <thead class=" text-primary">
                                <tr>
                                    <th width="5%">ID</th>
                                    <th>{{ __('Business Name')}}</th>
                                    <th>{{ __('Name Surname') }}</th>
                                    <th>{{ __('Phone n.') }}</th>
                                    <!--<th>{{ __('Address') }}</th>-->
                                    <!--<th>{{ __('P.IVA') }}</th>-->
                                    <!--<th>{{ __('SDI Code') }}</th>-->
                                    <!--<th>{{ __('Legal Address') }}</th>-->
                                    <!--<th>{{ __('Operative Address') }}</th>-->
                                    <th>{{ __('Role') }}</th>
                                    <th>{{ __('Active status') }}</th>
                                    <th>{{ __('Active till') }}</th>
                                    <th style="width: 95px !important;">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $index = 0; ?>
                            @foreach($users as $user)
                                <?php $index++; ?>
                                <tr>
                                    <td>{{ $index }}</td>
                                    <td>{{ $user->business_name }}</td>
                                    <td>{{ $user->name }} {{ $user->surname }}</td>
                                    <td>{{ $user->phone_number }}</td>
                                    <!--<td>{{ $user->address }}</td>-->
                                    <!--<td>{{ $user->piva }}</td>-->
                                    <!--<td>{{ $user->sdi_code }}</td>-->
                                    <!--<td>{{ $user->legal_address }}</td>-->
                                    <!--<td>{{ $user->operative_address }}</td>-->
                                    <td style="text-transform:capitalize">
                                        {{ $user->role_name }}
                                        @if($user->self_manager == true)
                                        &nbsp;&nbsp;({{ __('self manager')}})
                                        @endif
                                    </td>
                                    <td>{{ $user->status_title }}</td>
                                    <td>{{ !empty($user->active_due_date) ? $user->active_due_date->format('d/m/Y') : " " }}</td>
                                    <td class="td-actions text-right">
                                        @if ($user->id != auth()->id())
                                        <form action="{{ route('user.destroy', $user) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            @if($user->status == false)
                                            <a rel="tooltip" id="{{ $user->id }}" class="btn btn-danger btn-link" data-original-title="" title="Unblock User" onclick="changeStatus({{$user->id}}, {{$user->status}})">
                                                <i class="material-icons">block</i>
                                                <div class="ripple-container"></div>
                                            </a>
                                            @else
                                            <a rel="tooltip" id="{{ $user->id }}" class="btn btn-success btn-link" data-original-title="" title="Block User" onclick="changeStatus({{$user->id}}, {{$user->status}})">
                                                <i class="material-icons">check_circle</i>
                                                <div class="ripple-container"></div>
                                            </a>
                                            @endif

                                            <a rel="tooltip" class="btn btn-success btn-link" href="{{ route('user.edit', $user) }}" data-original-title="" title="Edit User">
                                                <i class="material-icons">edit</i>
                                                <div class="ripple-container"></div>
                                            </a>

                                            <input type="hidden" id="updatestatus" name="updatestatus" value="{{ route('update_status')}}" />
                                            <button type="button" class="btn btn-danger btn-link" data-original-title="" title="Delete User" onclick="confirm('{{ __("Are you sure you want to delete this user?") }}') ? this.parentElement.submit() : ''">
                                                <i class="material-icons">close</i>
                                                <div class="ripple-container"></div>
                                            </button>
                                        </form>
                                        @else
                                        <a rel="tooltip" class="btn btn-success btn-link" href="{{ route('profile.edit') }}" data-original-title="" title="">
                                            <i class="material-icons">edit</i>
                                            <div class="ripple-container"></div>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
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
  <script>
    var _token = $('meta[name="csrf-token"]').attr('content');
    var _url = $('#updatestatus').val();

    var var_unblock = $('#var_unblock').text();
    var var_block = $('#var_block').text();
    var var_account_changed = $('#var_account_changed').text();
    var var_account_success = $('#var_account_success').text();


    $("#users").DataTable({
        language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Italian.json"
        },
        fixedHeader: true,
        pageLength: 15,
        lengthMenu: [5, 15, 25, 50, 100],
        ordering: true,
        columnDefs: [{
            "targets": [0,],
            "orderable": true
        }],
        responsive: true,
    });

    function changeStatus(id,status){
        var msg = (status == 0) ?var_unblock: var_block;

        if(confirm(msg)){
            $.post(_url, {
                id: id,
                status: status,
                _token:_token
            })
            .done(function (data) {
                if(data.result == true){
                    toastr.success(var_account_changed, var_account_success);
                    setTimeout(function(){
                        location.reload();
                    }, 1500);
                }
            });
        }
    }
  </script>
  @endpush
@endsection
