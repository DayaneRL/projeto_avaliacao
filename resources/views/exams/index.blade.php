@extends('layouts.app')

@section('title')
    Prova
@endsection

@section('style')
    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
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
                        {{-- <i class="fas fa-calendar fa-2x text-gray-300"></i> --}}
                        <a href="{{route('exams.create')}}" class="btn btn-success btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Adicionar prova</span>
                        </a>
                    </div>
                </div>
                <div class="">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Categoria</th>
                                            <th>Data de cadastro</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Categoria</th>
                                            <th>Data de cadastro</th>
                                            <th>Ações</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Geografia</td>
                                            <td>{{date('d/m/Y')}}</td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-icon-split p-2">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-icon-split p-2">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>História</td>
                                            <td>{{date('d/m/Y')}}</td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-icon-split p-2">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-icon-split p-2">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="js/datatable.js"></script>
@endsection
