@extends('layouts.default')

@section('title', 'Click')

@push('css')
	<link href="/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css" rel="stylesheet" />
	<link href="/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css" rel="stylesheet" />
	<link href="/assets/plugins/ion-rangeslider/css/ion.rangeSlider.min.css" rel="stylesheet" />
	<link href="/assets/plugins/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css" rel="stylesheet" />
	<link href="/assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" />
	<link href="/assets/plugins/@danielfarrell/bootstrap-combobox/css/bootstrap-combobox.css" rel="stylesheet" />
	<link href="/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" />
	<link href="/assets/plugins/tag-it/css/jquery.tagit.css" rel="stylesheet" />
	<link href="/assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet" />
	<link href="/assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
	<link href="/assets/plugins/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
	<link href="/assets/plugins/bootstrap-colorpalette/css/bootstrap-colorpalette.css" rel="stylesheet" />
	<link href="/assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker.css" rel="stylesheet" />
	<link href="/assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker-fontawesome.css" rel="stylesheet" />
	<link href="/assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker-glyphicons.css" rel="stylesheet" />
@endpush

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Рабочий стол</a></li>
        <li class="breadcrumb-item active">Click</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header"><img src="{{ asset('assets/img/logo/click_logo.png') }}" width="150"></h1>
    <!-- end page-header -->

    <!-- begin col-6 -->
    <div class="col-xl-12">
        <!-- begin panel -->
        <div class="panel panel-inverse" data-sortable-id="form-plugins-16">
            <!-- begin panel-heading -->
            <div class="panel-heading">
                <h4 class="panel-title">Тип счета: Накопительный</h4>
                <a href="{{ route('admin.click.edit', ['psystem' => 'click_user']) }}" class="btn btn-xs btn-primary mr-3">
                    <i class="fa fa-edit"></i> Редактировать
                </a>
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                </div>
            </div>
            <!-- end panel-heading -->
            <!-- begin panel-body -->
            <div class="panel-body panel-form">
                <form class="form-horizontal form-bordered">
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label">API Prepare URL</label>
                        <div class="col-lg-10">
                            <div class="input-group">
                                <div id="clipboard-default-user-prepare" class="form-control"> {{ url('/').'/api/click/user/prepare' }} </div>
                                <span class="input-group-append">
										<button class="btn btn-inverse" type="button" data-clipboard-target="#clipboard-default-user-prepare"><i class="fa fa-clipboard"></i></button>
									</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label">API Complete URL</label>
                        <div class="col-lg-10">
                            <div class="input-group">
                                <div id="clipboard-default-user-complete" class="form-control"> {{ url('/').'/api/click/user/complete' }} </div>
                                <span class="input-group-append">
										<button class="btn btn-inverse" type="button" data-clipboard-target="#clipboard-default-user-complete"><i class="fa fa-clipboard"></i></button>
									</span>
                            </div>
                        </div>
                    </div>

                    @foreach($user_settings as $item)
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label">{{ $item->name }}</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <div id="{{ $item->key }}" class="form-control"> {{ $item->value }} </div>
                                    <span class="input-group-append">
                                            <button class="btn btn-inverse" type="button" data-clipboard-target="#{{ $item->key }}"><i class="fa fa-clipboard"></i></button>
                                        </span>
                                </div>
                            </div>
                        </div>
                    @endforeach


                </form>
            </div>
            <!-- end panel-body -->
        </div>
        <!-- end panel -->
    </div>

    <div class="col-xl-12">
        <!-- begin panel -->
        <div class="panel panel-inverse" data-sortable-id="form-plugins-16">
            <!-- begin panel-heading -->
            <div class="panel-heading">
                <h4 class="panel-title">Тип счета: Однаразовый платеж</h4>
                <a href="{{ route('admin.click.edit', ['psystem' => 'click_order']) }}" class="btn btn-xs btn-primary mr-3">
                    <i class="fa fa-edit"></i> Редактировать
                </a>
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                </div>
            </div>
            <!-- end panel-heading -->
            <!-- begin panel-body -->
            <div class="panel-body panel-form">
                <form class="form-horizontal form-bordered">
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label">API Prepare URL</label>
                        <div class="col-lg-10">
                            <div class="input-group">
                                <div id="clipboard-default-order-prepare" class="form-control"> {{ url('/').'/api/click/order/prepare' }} </div>
                                <span class="input-group-append">
										<button class="btn btn-inverse" type="button" data-clipboard-target="#clipboard-default-order-prepare"><i class="fa fa-clipboard"></i></button>
									</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label">API Complete URL</label>
                        <div class="col-lg-10">
                            <div class="input-group">
                                <div id="clipboard-default-order-complete" class="form-control"> {{ url('/').'/api/click/order/complete' }} </div>
                                <span class="input-group-append">
										<button class="btn btn-inverse" type="button" data-clipboard-target="#clipboard-default-order-complete"><i class="fa fa-clipboard"></i></button>
									</span>
                            </div>
                        </div>
                    </div>

                    @foreach($order_settings as $item)
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label">{{ $item->name }}</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <div id="{{ $item->key }}" class="form-control"> {{ $item->value }} </div>
                                    <span class="input-group-append">
                                            <button class="btn btn-inverse" type="button" data-clipboard-target="#{{ $item->key }}"><i class="fa fa-clipboard"></i></button>
                                        </span>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </form>
            </div>
            <!-- end panel-body -->
        </div>
        <!-- end panel -->
    </div>

    <!-- end col-6 -->
    </div>
    <!-- end row -->
@endsection

@push('scripts')
	<script src="/assets/plugins/jquery-migrate/dist/jquery-migrate.min.js"></script>
	<script src="/assets/plugins/moment/moment.js"></script>
	<script src="/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>
	<script src="/assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js"></script>
	<script src="/assets/plugins/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
	<script src="/assets/plugins/jquery.maskedinput/src/jquery.maskedinput.js"></script>
	<script src="/assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
	<script src="/assets/plugins/pwstrength-bootstrap/dist/pwstrength-bootstrap.min.js"></script>
	<script src="/assets/plugins/@danielfarrell/bootstrap-combobox/js/bootstrap-combobox.js"></script>
	<script src="/assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
	<script src="/assets/plugins/tag-it/js/tag-it.min.js"></script>
	<script src="/assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
	<script src="/assets/plugins/select2/dist/js/select2.min.js"></script>
	<script src="/assets/plugins/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
	<script src="/assets/plugins/bootstrap-show-password/dist/bootstrap-show-password.js"></script>
	<script src="/assets/plugins/bootstrap-colorpalette/js/bootstrap-colorpalette.js"></script>
	<script src="/assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker.js"></script>
	<script src="/assets/plugins/clipboard/dist/clipboard.min.js"></script>
	<script src="/assets/js/demo/form-plugins.demo.js"></script>
@endpush
