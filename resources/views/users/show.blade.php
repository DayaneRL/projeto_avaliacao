@extends('layouts.app')

@section('title')
    Meu Perfil
@endsection

@section('style')
    <link href="{{asset('plugins/select2/select2.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="col-12 mb-4">
    <div class="card  border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center mb-3">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">

                    </div>
                </div>
                <div class="col-auto">
                    <a href="{{route('users.edit',$user->id)}}" class="btn btn-info btn-icon-split">
                        <span class="icon">
                            <i class="fas fa-pen"></i>
                        </span>
                        <span class="text">Editar</span>
                    </a>
                </div>
            </div>

            <div class="col-12 text-center">
                <h3>{{$user->name}}</h3>

                <p><b>E-mail:</b> {{$user->email}} </p>
                <p><b>Tipo:</b>
                    @if($user->admin==1)
                        <span class="badge badge-danger">Administrador</span>
                    @else
                        <span class="badge badge-success">Usuário</span>
                    @endif
                </p>
                <p><b>Data de cadastro:</b> {{$user->created_at->format('d/m/Y')}} </p>

            </div>

        </div>
    </div>
</div>
@endsection

@section('js')
@endsection
