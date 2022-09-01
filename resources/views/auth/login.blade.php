
@extends('layouts.auth')

@section('title')
Login
@endsection

@section('content')
    <div class="container w-50">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Área de login</h1>
                            </div>
                            <form class="user" action="" method="POST">
                                @csrf

                                @if(session()->has('success'))
                                    <div class="alert alert-success">{{session('success')}}</div>
                                @endif

                                @if(session()->has('warning'))
                                    <div class="alert alert-warning">{{session('warning')}}</div>
                                @endif

                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user {{$errors->has('email') ? 'is-invalid' : ''}}" placeholder="Digite seu e-mail" value="{{old('email')}}" name="email">
                                    <div class="invalid-feedback">{{  $errors->first('email') }}</div>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user {{$errors->has('password') ? 'is-invalid' : ''}}"  placeholder="Digite sua senha" name="password">
                                    <div class="invalid-feedback">{{  $errors->first('password') }}</div>
                                </div>
                                <button href="index.html" type="submit" class="btn btn-primary btn-user btn-block">
                                    Login
                                </button>
                                <hr>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>

@endsection
