@extends('layouts.default')

@section('title', 'Bills')

@push('css')
	<link href="/assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
	<link href="/assets/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" />
	<link href="/assets/plugins/datatables.net-scroller-bs4/css/scroller.bootstrap4.min.css" rel="stylesheet" />
    <link href="/assets/plugins/datatables.net-fixedcolumns-bs4/css/fixedcolumns.bootstrap4.min.css" rel="stylesheet" />
@endpush

@section('content')
	<!-- begin breadcrumb -->
	<ol class="breadcrumb float-xl-right">
		<li class="breadcrumb-item"><a href="javascript:;">Рабочий стол</a></li>
		<li class="breadcrumb-item active">Платежи</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">Платежи</h1>
	<!-- end page-header -->
	<!-- begin row -->
	<div class="row">
		<!-- begin col-12 -->
		<div class="col-xl-12">
			<!-- begin panel -->
			<div class="panel panel-inverse">
				<!-- begin panel-heading -->
				<div class="panel-heading">
					<h4 class="panel-title">Платежи</h4>
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
					</div>
				</div>
				<!-- end panel-heading -->
				<!-- begin panel-body -->
				<div class="panel-body">
                    <table id="data-table-fixed-columns" class="table table-striped table-bordered table-td-valign-middle">
						<thead>
							<tr>
								<th>№</th>
								<th>Платежная система</th>
								<th>User ID | Order ID</th>
								<th>Сумма</th>
								<th>Тип</th>
                                <th>Статус</th>
                                <th>Описание</th>
                                <th>Создано в | Обновлено в</th>
                            </tr>
						</thead>
                        <tbody>
                        @php
                            $status = [
                                'created' => 'Созданный',
                                'canceled' => 'Отменено',
                                'completed' => 'Оплаченный',
                                'canceled after complete' => 'Отменено после завершения'
                            ];

                            $logo = [
                                'Payme' => 'assets/img/logo/payme_logo.png',
                                'Click' => 'assets/img/logo/click_logo.png'
                            ]
                        @endphp
                            @foreach($response as $item)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td> <img src="{{ asset($logo[$item->psystem]) }}" width="80"> </td>
                                    <td>{{ $item->user_id }}</td>
                                    <td>{{ $item->amount }}</td>
                                    <td>{{ $item->type == 'order' ? 'Однаразовый платеж' : 'Накопительный' }}</td>
                                    <td>{{ $status[ $item->status ] }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td>{{ $item->created_at->format('H:i d.m.Y') }}  <br> {{ $item->updated_at->format('H:i d.m.Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
					</table>
				</div>
				<!-- end panel-body -->
			</div>
			<!-- end panel -->
		</div>
		<!-- end col-12 -->
	</div>
	<!-- end row -->
@endsection

@push('scripts')
	<script src="/assets/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="/assets/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="/assets/plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
	<script src="/assets/plugins/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
	<script src="/assets/plugins/datatables.net-scroller-bs4/js/scroller.bootstrap4.min.js"></script>
    <script src="/assets/js/demo/table-manage-fixed-columns.demo.js"></script>
@endpush
