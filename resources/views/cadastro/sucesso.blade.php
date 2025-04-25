@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-success text-white">
            <h3>Cadastro Realizado com Sucesso!</h3>
        </div>
        <div class="card-body">
            <div class="alert alert-success">
                <h4>Dados do Usuário Cadastrado:</h4>
                <ul class="list-unstyled">
                    <li><strong>IME:</strong> {{ $usuario->ime }}</li>
                    <li><strong>Nome:</strong> {{ $usuario->nome }}</li>
                    <li><strong>Email:</strong> {{ $usuario->email }}</li>
                </ul>
                <p class="mt-3">
                    <i class="bi bi-envelope-check"></i> Um email foi enviado com as instruções para acesso ao sistema.
                </p>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <form method="POST" action="{{ route('cadastro.enviar-senha', $usuario->ime) }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-envelope"></i> Reenviar Email
                    </button>
                </form>

                <a href="{{ route('cadastro.etapa1') }}" class="btn btn-secondary">
                    <i class="bi bi-person-plus"></i> Cadastrar Novo Usuário
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 