@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section('content')

    <!-- Area Chart -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Pie Chart -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Provas</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-pie pt-4 pb-2">
                    <canvas id="myPieChart"></canvas>
                </div>
                <div class="mt-4 text-center small">
                    @foreach ($categories as $key => $category)
                    <span class="mr-2">
                        <i class="fas fa-circle text-{{($key==0)?'primary':(($key==1)?'success':'info')}}"></i> {{$category->name}}
                    </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script  src="{{asset('js/Chart.min.js')}}"></script>
    <script  src="{{asset('js/chart-pie-demo.js')}}"></script>
@endsection
