@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h3>Cadastro de Usuário</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('cadastro.etapa1.process') }}">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="ime">IME (CIM)</label>
                            <input type="text" class="form-control @error('ime') is-invalid @enderror" 
                                   id="ime" name="ime" value="{{ old('ime') }}" 
                                   placeholder="000.000" maxlength="7" required>
                            @error('ime')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="cpf">CPF</label>
                            <input type="text" class="form-control @error('cpf') is-invalid @enderror" 
                                   id="cpf" name="cpf" value="{{ old('cpf') }}" 
                                   placeholder="000.000.000-00" maxlength="14" required>
                            @error('cpf')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="nome">Nome Completo</label>
                            <input type="text" class="form-control @error('nome') is-invalid @enderror" 
                                   id="nome" name="nome" value="{{ old('nome') }}" required>
                            @error('nome')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="role">Tipo de Usuário</label>
                            <select class="form-control @error('role') is-invalid @enderror" 
                                    id="role" name="role" required>
                                <option value="">Selecione...</option>
                                <option value="usuario" {{ old('role') == 'usuario' ? 'selected' : '' }}>Usuário</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
                                <option value="atendente" {{ old('role') == 'atendente' ? 'selected' : '' }}>Atendente</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="grau">Grau</label>
                            <select class="form-control @error('grau') is-invalid @enderror" 
                                    id="grau" name="grau" required>
                                <option value="">Selecione...</option>
                                @for($i = 1; $i <= 33; $i++)
                                    <option value="{{ $i }}" {{ old('grau') == $i ? 'selected' : '' }}>{{ $i }}º Grau</option>
                                @endfor
                            </select>
                            @error('grau')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check"></i> Cadastrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 