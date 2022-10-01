@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section('style')
    <link href={{asset('css/dashboard.css')}} rel="stylesheet">
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
                        <div class="h5 mb-0 font-weight-bold text-gray-600">{{$usersCount}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-9"></div>

    <div class="col-xl-7 col-lg-6 mt-3">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Usuários</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <a class="col-md-3 border btn dashboard-card" href="{{route('users.create')}}">
                        <i class="fas fa-fw fa-user"></i>
                        <i class="fas fa-fw fa-plus secondary"></i>
                        <span class="text-secondary">Adicionar</span>
                    </a>
                    <a class="btn col-md-3 border dashboard-card" href="{{route('users.index')}}">
                        <i class="fas fa-fw fa-user"></i>
                        <i class="fas fa-fw fa-search secondary"></i>
                        <span class="text-secondary">Visualizar</span>
                    </a>
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
                    <a class="col-md-3 border btn dashboard-card" href="{{route('exams.create')}}">
                        <i class="fas fa-fw fa-folder"></i>
                        <i class="fas fa-fw fa-plus secondary"></i>
                        <span class="text-secondary">Adicionar</span>
                    </a>
                    <a class="btn col-md-3 border dashboard-card" href="{{route('exams.index')}}">
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
                <h4 class="small font-weight-bold">Estão por vir  ({{$deadlines['yet_to_come'][0]}})<span
                    class="float-right">{{$deadlines['yet_to_come'][1]}}%</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar" role="progressbar" style="width: {{$deadlines['yet_to_come'][1]}}%"
                        aria-valuenow="{{$deadlines['yet_to_come'][1]}}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <h4 class="small font-weight-bold">Essa semana ({{$deadlines['this_week'][0]}})<span
                        class="float-right">{{$deadlines['this_week'][1]}}%</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-info" role="progressbar" style="width: {{$deadlines['this_week'][1]}}%"
                        aria-valuenow="{{$deadlines['this_week'][1]}}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <h4 class="small font-weight-bold">Já foram concluídas ({{$deadlines['passed'][0]}})<span
                        class="float-right">{{$deadlines['passed'][1]}}%</span></h4>
                <div class="progress">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{$deadlines['passed'][1]}}%"
                        aria-valuenow="{{$deadlines['passed'][1]}}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>

@endif

@endsection

@section('js')
    <script  src="{{asset('js/Chart.min.js')}}"></script>
    {{-- <script  src="{{asset('js/chart-pie-demo.js')}}"></script> --}}
@endsection
