@extends('layouts.app')

@section('title')
    Prova
@endsection

@section('style')
    <!-- Custom styles for this page -->
    <link href="{{asset('plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection

@section('content')

    <div class="col-12 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center mb-3">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            provas cadastradas
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                    </div>
                    <div class="col-auto">
                        <a href="{{route('exams.create')}}" class="btn btn-info btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Adicionar prova</span>
                        </a>
                    </div>
                </div>
                <div class="card shadow mb-4">
                    <div class="card-body">

                        @if(session()->has('success'))
                            <div class="alert alert-success">
                                {{session('success')}}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if(session()->has('warning'))
                            <div class="alert alert-warning">
                                {{session('warning')}}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Categoria</th>
                                        <th>Tags</th>
                                        <th>Data da prova</th>
                                        <th>Data de cadastro</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Categoria</th>
                                        <th>Tags</th>
                                        <th>Data da prova</th>
                                        <th>Data de cadastro</th>
                                        <th>Ações</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($exams as $exam)
                                        <tr>
                                            <td class="exam_id" id="exam_id_{{$exam->id}}">{{$exam->id}}</td>
                                            <td class="exam_title">{{$exam->title}}</td>
                                            <td>{{$exam->Category->name}}</td>
                                            <td>{{$exam->tags_list_table}}</td>
                                            <td>{{$exam->exam_date}}</td>
                                            <td>{{$exam->created_at_formatted}}</td>
                                            <td class="actions">
                                                <button type="button" class="btn btn-primary btn-icon-split p-2 show_exam">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <a href="/exams/{{$exam->id}}/edit" class="btn btn-info btn-icon-split p-2">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger btn-icon-split p-2 btn-delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
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

@endsection

@section('js')
    <!-- Page level plugins -->
    <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <!-- Page level custom scripts -->
    <script src="{{asset('js/datatable.js')}}"></script>
    <script src="{{asset('js/exams/index.js')}}"></script>
@endsection
