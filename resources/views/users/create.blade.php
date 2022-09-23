@extends('layouts.app')

@section('title')
    Cadastrar Usuário
@endsection

@section('content')
    <div class="col-12 mb-4">
        <div class="card shadow h-100 py-2">
            <div class="card-body">

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="row mb-3">
                    <form action="{{isset($user)?route('users.update',$user->id):route('users.store')}}" method="POST" class="col-12">
                        @csrf
                        @if(isset($user))
                            @method('PUT')
                            <input type="hidden" name="user[id]" value="{{$user->id}}"/>
                        @endif
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputName">Nome<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="inputName" name="user[name]"
                                placeholder="Nome do usuário" value="{{$user->name??old('user.name')}}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputEmail">E-mail<span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="inputEmail" name="user[email]"
                                placeholder="Email do usuário" value="{{$user->email??old('user.email')}}">
                            </div>

                            <div class="form-group col-md-2">
                                <label for="inputType">Tipo<span class="text-danger">*</span></label>
                                <select class="form-control" id="inputType" name="user[admin]">
                                    <option value="0" @if(isset($user) && !$user->admin) selected @endif>Usuário</option>
                                    <option value="1" @if(isset($user) && $user->admin) selected @endif>Administrador</option>
                                </select>
                            </div>
                            <div class="form-group col-md-5">
                                <label for="inputPassword">Senha<span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="inputPassword" name="user[password]" placeholder="********"
                                value="{{old('user.password')}}">
                            </div>
                            <div class="form-group col-md-5">
                                <label for="inputConfirmPassword">Confirmar Senha<span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="inputConfirmPassword" name="user[confirm_password]" placeholder="********"
                                value="{{isset($user->confirm_password)?$user->confirm_password:old('exam.confirm_password')}}">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">{{isset($user)?'Salvar':'Cadastrar'}}</button>
                        <a href="{{route('users.index')}}" class="btn btn-light border">Cancelar</a>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection
