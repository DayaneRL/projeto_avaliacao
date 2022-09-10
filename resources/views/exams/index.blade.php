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
                            <div class="alert alert-success">{{session('success')}}</div>
                        @endif

                        @if(session()->has('warning'))
                            <div class="alert alert-warning">{{session('warning')}}</div>
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
                                            <td class="exam_id">{{$exam->id}}</td>
                                            <td class="exam_title">{{$exam->title}}</td>
                                            <td>{{$exam->Category->name}}</td>
                                            <td>{{$exam->tags_list}}</td>
                                            <td>{{$exam->exam_date}}</td>
                                            <td>{{$exam->created_at_formatted}}</td>
                                            <td class="actions">
                                                <button type="button" class="btn btn-primary btn-icon-split p-2 show_exam">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-info btn-icon-split p-2 show_exam">
                                                    <i class="fas fa-pen"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-icon-split p-2">
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

    {{-- begin:modal --}}
    <div class="modal fade" id="examModal" tabindex="-1" role="dialog" aria-labelledby="examModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="examModalLabel">Dados da prova</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="content">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light border" data-dismiss="modal">Cancelar</button>
            </div>
          </div>
        </div>
    </div>
    {{-- end:modal --}}
@endsection

@section('js')
    <!-- Page level plugins -->
    <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <!-- Page level custom scripts -->
    <script src="{{asset('js/datatable.js')}}"></script>
    <script src="{{asset('js/exams/index.js')}}"></script>
@endsection
