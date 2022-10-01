@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section('style')
    <style>
        .dashboard-card{
            border-radius: 5px;
        }

        .dashboard-card i{
            font-size: 4em;
        }

        .dashboard-card .secondary{
            font-size: 1.2em !important;
            margin-left: -30px;
            background: #fff;
            color: #000;
            padding: 3px 1px;
            border-radius: 50%;
            width: 1.4em;
        }
    </style>
@endsection

@section('content')

@if(Auth::user()->admin)
    <div class="col-md-3">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Usuários cadastradas
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-600">{{$examsCount}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="col-md-3">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Avaliações cadastradas
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-600">{{$examsCount}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            perguntas privadas
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-600">{{$questionsCount}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            categorias
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-600">{{$categories->count()}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-secondary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            cabeçalhos
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-600">{{$headersCount}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-xl-8 col-lg-7 mt-3">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Avaliações</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <a class="col-md-3 border m-2 p-2 btn dashboard-card" href="{{route('exams.index')}}">
                        <i class="fas fa-fw fa-folder"></i>
                        <i class="fas fa-fw fa-plus secondary"></i>
                        <span class="text-secondary">Adicionar</span>
                    </a>
                    <a class="btn col-md-3 border m-2 p-2 dashboard-card" href="{{route('exams.index')}}">
                        <i class="fas fa-fw fa-folder"></i>
                        <i class="fas fa-fw fa-search secondary"></i>
                        <span class="text-secondary">Visualizar</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Pie Chart -->
    <div class="col-xl-4 col-lg-5 mt-3">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Prazos</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                Estão por vir
                Essa semana
                Já foram concluídas
            </div>
        </div>
    </div>

@endif

@endsection

@section('js')
    <script  src="{{asset('js/Chart.min.js')}}"></script>
    {{-- <script  src="{{asset('js/chart-pie-demo.js')}}"></script> --}}
@endsection
