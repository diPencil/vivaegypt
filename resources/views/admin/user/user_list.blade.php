@extends('admin.master_layout')
@section('title')
    <title>{{ $title }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ $title }}</h3>
    <p class="crancy-header__text">{{ __('translate.Manage User') }} >> {{ $title }}</p>
@endsection

@section('body-content')
    <!-- crancy Dashboard -->
    <section class="crancy-adashboard crancy-show">
        <div class="container container__bscreen">
            <div class="row">
                <div class="col-12">
                    <div class="crancy-body">
                        <div class="crancy-dsinner">

                            <div class="crancy-table crancy-table--v3 mg-top-30">

                                    <div class="crancy-customer-filter__single crancy-customer-filter__single--csearch d-flex items-center justify-between create_new_btn_box">
                                        <div class="crancy-header__form crancy-header__form--customer create_new_btn_inline_box">
                                            <h4 class="crancy-product-card__title">{{ $title }}</h4>
                                        </div>
                                        <div class="crancy-customer-filter__single" id="create_new_btn_container">
                                            <a href="{{ route('admin.user-create') }}" class="crancy-btn crancy-sb-btn crancy-sb-btn--v2">
                                                <span>
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M8 1V15" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        <path d="M1 8H15" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg>
                                                </span>
                                                {{ __('translate.Add New User') }}
                                            </a>
                                        </div>
                                    </div>

                                <!-- crancy Table -->
                                <div id="crancy-table__main_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">

                                    <table class="crancy-table__main crancy-table__main-v3 dataTable no-footer" id="dataTable">
                                        <!-- crancy Table Head -->
                                        <thead class="crancy-table__head">
                                            <tr>

                                                <th class="crancy-table__column-2 crancy-table__h2 sorting" >
                                                    {{ __('translate.Serial') }}
                                                </th>

                                                <th class="crancy-table__column-2 crancy-table__h2 sorting" >
                                                    {{ __('translate.Name') }}
                                                </th>

                                                <th class="crancy-table__column-2 crancy-table__h2 sorting" >
                                                    {{ __('translate.Email') }}
                                                </th>

                                                <th class="crancy-table__column-2 crancy-table__h2 sorting crancy-table__head-phone">
                                                    {{ __('translate.Phone') }}
                                                </th>



                                                <th class="crancy-table__column-2 crancy-table__h2 sorting" >
                                                    {{ __('translate.Status') }}
                                                </th>

                                                <th class="crancy-table__column-3 crancy-table__h3 sorting">
                                                    {{ __('translate.Action') }}
                                                </th>

                                            </tr>
                                        </thead>
                                        <!-- crancy Table Body -->
                                        <tbody class="crancy-table__body">
                                            @foreach ($users as $index => $user)
                                                <tr class="odd">

                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <h4 class="crancy-table__product-title">{{ ++$index }}</h4>
                                                    </td>

                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <h4 class="crancy-table__product-title">{{ html_decode($user->name) }}</h4>
                                                    </td>

                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <h4 class="crancy-table__product-title">{{ html_decode($user->email) }}</h4>
                                                    </td>

                                                    <td class="crancy-table__column-2 crancy-table__data-2 crancy-table__cell-phone">
                                                        <h4 class="crancy-table__product-title">{{ html_decode($user->phone) }}</h4>
                                                    </td>

                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        <div class="crancy-ptabs__notify-switch  crancy-ptabs__notify-switch--two">
                                                            <label class="crancy__item-switch">
                                                            <input onClick="manageStatus({{ $user->id }})" name="status" type="checkbox" {{ $user->status == 'enable' ? 'checked' : '' }}>
                                                            <span class="crancy__item-switch--slide crancy__item-switch--round"></span>
                                                            </label>
                                                        </div>
                                                    </td>

                                                    <td class="crancy-table__column-2 crancy-table__data-2">
                                                        @if ($user->username)
                                                            <a href="{{ route('admin.user-show', $user->username ) }}" class="crancy-btn"><i class="fas fa-eye"></i> {{ __('translate.Show') }}</a>
                                                        @else
                                                            <span class="badge bg-secondary text-white">{{ __('translate.No Username') }}</span>
                                                        @endif

                                                        <a onclick="itemDeleteConfrimation({{ $user->id }})" href="javascript:;" data-bs-toggle="modal" data-bs-target="#exampleModal" class="crancy-btn delete_danger_btn"><i class="fas fa-trash"></i> </a>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                        <!-- End crancy Table Body -->
                                    </table>
                                </div>
                                <!-- End crancy Table -->
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- End crancy Dashboard -->



  <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('translate.Delete Confirmation') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ __('translate.Are you realy want to delete this item?') }}</p>
                </div>
                <div class="modal-footer">
                    <form action="" id="item_delect_confirmation" class="delet_modal_form" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('translate.Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('translate.Yes, Delete') }}</button>

                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('js_section')
    <script>
        "use strict"
        $(document).ready(function() {
            // Wait for DataTables to initialize
            setTimeout(function() {
                var btn = $('#create_new_btn_container').detach();
                btn.show().css({
                    'margin': '0',
                    'padding': '0',
                    'display': 'inline-block'
                });
                
                $('.dataTables_filter').css({
                    'display': 'flex',
                    'align-items': 'center',
                    'gap': '15px',
                    'justify-content': 'flex-end'
                }).append(btn);
                
                $('.dataTables_filter label').css({
                    'margin-bottom': '0',
                    'display': 'flex',
                    'align-items': 'center',
                    'gap': '5px'
                });
            }, 100);
        });

        function itemDeleteConfrimation(id){
            $("#item_delect_confirmation").attr("action",'{{ url("admin/user-delete/") }}'+"/"+id)
        }

        function manageStatus(id){
            var appMODE = "{{ env('APP_MODE') }}"
            if(appMODE == 'DEMO'){
                toastr.error('This Is Demo Version. You Can Not Change Anything');
                return;
            }

            $.ajax({
                type:"put",
                data: { _token : '{{ csrf_token() }}' },
                url:"{{url('/admin/user-status/') }}"+"/"+id,
                success:function(response){
                    toastr.success(response)
                },
                error:function(err){}
            })
        }

    </script>
@endpush
