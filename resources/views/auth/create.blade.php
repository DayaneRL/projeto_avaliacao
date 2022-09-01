@extends('layouts.auth')

@section('title')
Cadastro de usuário
@endsection

@section('content')

    <div class="container w-50">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="px-5 py-4">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Criação de conta de usuário</h1>
                            </div>
                            <form class="user" action="{{route('auth.register.store')}}" method="post">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <input type="text" value="{{old('name')}}" class="form-control form-control-user {{$errors->has('name') ? 'is-invalid' : ''}}" id="exampleFirstName" name="name" placeholder="Nome do usuário">
                                        <div class="invalid-feedback">{{  $errors->first('name') }}</div>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <input type="email" value="{{old('email')}}" class="form-control form-control-user {{$errors->has('email') ? 'is-invalid' : ''}}" id="exampleInputEmail" name="email" placeholder="Email do usuário">
                                    <div class="invalid-feedback">{{  $errors->first('email') }}</div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password"  class="form-control form-control-user {{$errors->has('password') ? 'is-invalid' : ''}}" id="exampleInputPassword" name="password" placeholder="Senha">
                                        <div class="invalid-feedback">{{  $errors->first('password') }}</div>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user" id="exampleRepeatPassword" name="password_confirmation" placeholder="Confirme a senha">
                                    </div>

                                </div>
                                <button type="submit"  class="btn btn-primary btn-user btn-block">
                                    Cadastrar
                                </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="{{route('dashboard.index')}}">Voltar a dashboard</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
