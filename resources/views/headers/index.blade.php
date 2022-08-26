@extends('layouts.app')

@section('title')
    Cabeçalho
@endsection

@section('content')

<div class="col-12 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center mb-3">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Cabeçalhos cadastradas
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                </div>
                <div class="col-auto">
                    <a href="{{route('headers.create')}}" class="btn btn-info btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Adicionar Cabeçalho</span>
                    </a>
                </div>
            </div>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Descrição</th>
                                    <th>Data de cadastro</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Descrição</th>
                                    <th>Data de cadastro</th>
                                    <th>Ações</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <tr>
                                    <td class="header_id">1</td>
                                    <td class="header descriprion">Geografia</td>
                                    <td class="header_date">{{date('d/m/Y')}}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-icon-split p-2 show_exam">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-icon-split p-2">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="header_id">2</td>
                                    <td class="header descriprion">História</td>
                                    <td class="header_date">{{date('d/m/Y')}}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-icon-split p-2 show_exam">
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
        <!-- End of Main Content -->
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
    <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('js/datatable.js')}}"></script>
@endsection

