@extends('layouts.app')

@section('title')
    Cadastrar Cabeçalho
@endsection

@section('style')
    <link rel="stylesheet" href="{{asset('plugins/croppie/croppie.css')}}" />
    <style>
        .img-preview{
            width:120px;
            height:120px
        }
    </style>
@endsection

@section('content')
    <div class="col-12 mb-4">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="row mb-3">
                    <form action="{{isset($header)?route('headers.update',$header->id):route('headers.store')}}" method="POST" class="col-12" enctype="multipart/form-data">
                        @csrf
                        @if(isset($header))
                            @method('PUT')
                        @endif
                        <div class="form-row mb-2">
                            <div class="form-group col-md-12">
                                <label for="inputName">Descrição</label>
                                <input type="text" class="form-control" id="inputName" name="header[description]"
                                value={{$header->description??''}}>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="upload_image">Imagem de logo</label>
                                <div class="col-md-12 p-0">
                                @if(isset($header)&&isset($header->logo))
                                    <input type="file" class="form-control-file d-none" id="" name="header[logo]" />
                                    <img src={{asset('storage/'.$header->logo)}} class="rounded img-preview" alt={{$header->description}}/>
                                    <button type="button" class="btn btn-info" id="add_img"><i class="fas fa-pen"></i></button>
                                @else
                                    {{-- id="upload_image" --}}
                                    <input type="file" class="form-control-file d-none" id="" name="header[logo]" />
                                    <button type="button" class="btn btn-secondary" id="add_img"><i class="fas fa-plus"></i> Adicionar imagem</button>
                                @endif
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                        <a href="{{route('headers.index')}}" class="btn btn-light border">Cancelar</a>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <!-- beggin upload modal -->
    <div id="uploadimageModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload & Crop Image</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div id="image_demo" style="width:400px; height: 370px; margin-top:0px"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 ">
                            <button class="btn btn-success crop_image">Crop & Upload Image</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end modal -->

@endsection

@section('js')
<script src={{asset('plugins/croppie/croppie.js')}}></script>
<script src={{asset('js/headers/create.js')}}></script>
@endsection
