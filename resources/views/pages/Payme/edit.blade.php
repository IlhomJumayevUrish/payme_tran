@extends('layouts.default')

@section('title', 'Payme')

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Рабочий стол</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.payme.index') }}">Payme</a></li>
        <li class="breadcrumb-item active">Редактировать</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Payme</h1>
    <!-- end page-header -->

    <!-- begin col-6 -->
    @if ($errors->any())
        <ul class="alert alert-danger mr-2">
            @foreach ($errors->all() as $error)
                <li >{{ $error }}</li>
            @endforeach
        </ul>

    @endif
    <div class="col-xl-12">
        <form method="post" action="{{ route('admin.payme.update', ['psystem' => $psystem]) }}" class="form-horizontal form-bordered">
        @csrf
        <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-plugins-16">
                <!-- begin panel-heading -->
                <div class="panel-heading">
                    <h4 class="panel-title">Тип счета: {{ $psystem=='payme_user' ? 'Накопительный' : 'Однаразовый платеж'}}</h4>

                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                </div>
                <!-- end panel-heading -->
                <!-- begin panel-body -->

                <div class="panel-body panel-form">
                    @foreach($response as $item)
                        @if($item->key != $psystem.'_name')
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">{{ $item->name }}</label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <input id="{{ $item->key }}" name="{{ $item->key }}" type="text" class="form-control" value="{{ $item->value }}"/>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    <input name="psystem" type="text" hidden value="{{ $psystem }}"/>
                </div>

                <!-- end panel-body -->
            </div>
            <button type="submit" class="btn btn-primary float-right">
                Сохранить
            </button>
            <a href="{{route('admin.payme.index')}}" class="btn btn-danger float-right m-r-10">
                <i class="fas fa-arrow-circle-left"></i>
                Назад
            </a>
        </form>
    </div>
    <!-- end panel -->

@endsection

@push('scripts')
	<script src="/assets/plugins/clipboard/dist/clipboard.min.js"></script>
	<script src="/assets/js/demo/form-plugins.demo.js"></script>
@endpush
