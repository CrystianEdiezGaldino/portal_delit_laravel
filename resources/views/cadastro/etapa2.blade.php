@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h3>Cadastro de Usuário - Etapa 2</h3>
        </div>
        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('cadastro.etapa2.process', $ime) }}">
                @csrf
                
                @php
                    $dadosFormulario = session('cadastro.etapa2', []);
                    $dadosEtapa1 = session('cadastro.etapa1', []);
                @endphp

                <h4 class="mb-3">Dados Pessoais</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="cadastro">Nome de Cadastro</label>
                            <input type="text" class="form-control @error('cadastro') is-invalid @enderror" 
                                   id="cadastro" name="cadastro" 
                                   value="{{ old('cadastro', $dadosFormulario['cadastro'] ?? $dadosEtapa1['nome']) }}" required>
                            @error('cadastro')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="cic">CPF</label>
                            <input type="text" class="form-control @error('cic') is-invalid @enderror" 
                                   id="cic" name="cic" 
                                   value="{{ old('cic', $dadosFormulario['cic'] ?? $dadosEtapa1['cpf']) }}" 
                                   placeholder="000.000.000-00" required>
                            @error('cic')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="pai">Nome do Pai</label>
                            <input type="text" class="form-control @error('pai') is-invalid @enderror" 
                                   id="pai" name="pai" 
                                   value="{{ old('pai', $dadosFormulario['pai'] ?? '') }}">
                            @error('pai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="mae">Nome da Mãe</label>
                            <input type="text" class="form-control @error('mae') is-invalid @enderror" 
                                   id="mae" name="mae" 
                                   value="{{ old('mae', $dadosFormulario['mae'] ?? '') }}">
                            @error('mae')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="nascimento">Data de Nascimento</label>
                            <input type="date" class="form-control @error('nascimento') is-invalid @enderror" 
                                   id="nascimento" name="nascimento" 
                                   value="{{ old('nascimento', $dadosFormulario['nascimento'] ?? '') }}">
                            @error('nascimento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="cidade1">Cidade de Nascimento</label>
                            <input type="text" class="form-control @error('cidade1') is-invalid @enderror" 
                                   id="cidade1" name="cidade1" 
                                   value="{{ old('cidade1', $dadosFormulario['cidade1'] ?? '') }}">
                            @error('cidade1')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="estado1">Estado de Nascimento</label>
                            <input type="text" class="form-control @error('estado1') is-invalid @enderror" 
                                   id="estado1" name="estado1" 
                                   value="{{ old('estado1', $dadosFormulario['estado1'] ?? '') }}" maxlength="2">
                            @error('estado1')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="nacionalidade">Nacionalidade</label>
                            <input type="text" class="form-control @error('nacionalidade') is-invalid @enderror" 
                                   id="nacionalidade" name="nacionalidade" 
                                   value="{{ old('nacionalidade', $dadosFormulario['nacionalidade'] ?? '') }}">
                            @error('nacionalidade')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="profissao">Profissão</label>
                            <input type="text" class="form-control @error('profissao') is-invalid @enderror" 
                                   id="profissao" name="profissao" 
                                   value="{{ old('profissao', $dadosFormulario['profissao'] ?? '') }}">
                            @error('profissao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <h4 class="mb-3 mt-4">Endereço</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="endereco_residencial">Endereço Residencial</label>
                            <input type="text" class="form-control @error('endereco_residencial') is-invalid @enderror" 
                                   id="endereco_residencial" name="endereco_residencial" 
                                   value="{{ old('endereco_residencial', $dadosFormulario['endereco_residencial'] ?? '') }}">
                            @error('endereco_residencial')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="bairro">Bairro</label>
                            <input type="text" class="form-control @error('bairro') is-invalid @enderror" 
                                   id="bairro" name="bairro" 
                                   value="{{ old('bairro', $dadosFormulario['bairro'] ?? '') }}">
                            @error('bairro')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="cidade">Cidade</label>
                            <input type="text" class="form-control @error('cidade') is-invalid @enderror" 
                                   id="cidade" name="cidade" 
                                   value="{{ old('cidade', $dadosFormulario['cidade'] ?? '') }}">
                            @error('cidade')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="estado">Estado</label>
                            <input type="text" class="form-control @error('estado') is-invalid @enderror" 
                                   id="estado" name="estado" 
                                   value="{{ old('estado', $dadosFormulario['estado'] ?? '') }}" maxlength="2">
                            @error('estado')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="cep">CEP</label>
                            <input type="text" class="form-control @error('cep') is-invalid @enderror" 
                                   id="cep" name="cep" 
                                   value="{{ old('cep', $dadosFormulario['cep'] ?? '') }}" placeholder="00000-000">
                            @error('cep')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <h4 class="mb-3 mt-4">Contatos</h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="telefone_residencial">Telefone Residencial</label>
                            <input type="text" class="form-control @error('telefone_residencial') is-invalid @enderror" 
                                   id="telefone_residencial" name="telefone_residencial" 
                                   value="{{ old('telefone_residencial', $dadosFormulario['telefone_residencial'] ?? '') }}">
                            @error('telefone_residencial')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="telefone_comercial">Telefone Comercial</label>
                            <input type="text" class="form-control @error('telefone_comercial') is-invalid @enderror" 
                                   id="telefone_comercial" name="telefone_comercial" 
                                   value="{{ old('telefone_comercial', $dadosFormulario['telefone_comercial'] ?? '') }}">
                            @error('telefone_comercial')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="celular">Celular</label>
                            <input type="text" class="form-control @error('celular') is-invalid @enderror" 
                                   id="celular" name="celular" 
                                   value="{{ old('celular', $dadosFormulario['celular'] ?? '') }}">
                            @error('celular')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <h4 class="mb-3 mt-4">Dados Familiares</h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="estado_civil">Estado Civil</label>
                            <select class="form-control @error('estado_civil') is-invalid @enderror" 
                                    id="estado_civil" name="estado_civil">
                                <option value="">Selecione</option>
                                <option value="Solteiro" {{ old('estado_civil', $dadosFormulario['estado_civil'] ?? '') == 'Solteiro' ? 'selected' : '' }}>Solteiro</option>
                                <option value="Casado" {{ old('estado_civil', $dadosFormulario['estado_civil'] ?? '') == 'Casado' ? 'selected' : '' }}>Casado</option>
                                <option value="Divorciado" {{ old('estado_civil', $dadosFormulario['estado_civil'] ?? '') == 'Divorciado' ? 'selected' : '' }}>Divorciado</option>
                                <option value="Viúvo" {{ old('estado_civil', $dadosFormulario['estado_civil'] ?? '') == 'Viúvo' ? 'selected' : '' }}>Viúvo</option>
                            </select>
                            @error('estado_civil')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="numero_filhos">Número de Filhos</label>
                            <input type="text" class="form-control @error('numero_filhos') is-invalid @enderror" 
                                   id="numero_filhos" name="numero_filhos" 
                                   value="{{ old('numero_filhos', $dadosFormulario['numero_filhos'] ?? '0') }}">
                            @error('numero_filhos')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="casamento">Data de Casamento</label>
                            <input type="date" class="form-control @error('casamento') is-invalid @enderror" 
                                   id="casamento" name="casamento" 
                                   value="{{ old('casamento', $dadosFormulario['casamento'] ?? '') }}">
                            @error('casamento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="esposa">Nome da Esposa</label>
                            <input type="text" class="form-control @error('esposa') is-invalid @enderror" 
                                   id="esposa" name="esposa" 
                                   value="{{ old('esposa', $dadosFormulario['esposa'] ?? '') }}">
                            @error('esposa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="nascida">Data de Nascimento da Esposa</label>
                            <input type="date" class="form-control @error('nascida') is-invalid @enderror" 
                                   id="nascida" name="nascida" 
                                   value="{{ old('nascida', $dadosFormulario['nascida'] ?? '') }}">
                            @error('nascida')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <h4 class="mb-3 mt-4">Documentos</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="rg">RG</label>
                            <input type="text" class="form-control @error('rg') is-invalid @enderror" 
                                   id="rg" name="rg" 
                                   value="{{ old('rg', $dadosFormulario['rg'] ?? '') }}">
                            @error('rg')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="orgao_expedidor">Órgão Expedidor</label>
                            <input type="text" class="form-control @error('orgao_expedidor') is-invalid @enderror" 
                                   id="orgao_expedidor" name="orgao_expedidor" 
                                   value="{{ old('orgao_expedidor', $dadosFormulario['orgao_expedidor'] ?? '') }}">
                            @error('orgao_expedidor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <h4 class="mb-3 mt-4">Dados Maçônicos</h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="iniciado_loja">Data de Iniciação</label>
                            <input type="text" class="form-control @error('iniciado_loja') is-invalid @enderror" 
                                   id="iniciado_loja" name="iniciado_loja" 
                                   value="{{ old('iniciado_loja', $dadosFormulario['iniciado_loja'] ?? '') }}">
                            @error('iniciado_loja')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="numero_loja">Número da Loja</label>
                            <input type="text" class="form-control @error('numero_loja') is-invalid @enderror" 
                                   id="numero_loja" name="numero_loja" 
                                   value="{{ old('numero_loja', $dadosFormulario['numero_loja'] ?? '') }}">
                            @error('numero_loja')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="potencia_inicial">Potência Inicial</label>
                            <input type="text" class="form-control @error('potencia_inicial') is-invalid @enderror" 
                                   id="potencia_inicial" name="potencia_inicial" 
                                   value="{{ old('potencia_inicial', $dadosFormulario['potencia_inicial'] ?? '') }}">
                            @error('potencia_inicial')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="cidade2">Cidade da Loja</label>
                            <input type="text" class="form-control @error('cidade2') is-invalid @enderror" 
                                   id="cidade2" name="cidade2" 
                                   value="{{ old('cidade2', $dadosFormulario['cidade2'] ?? '') }}">
                            @error('cidade2')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="estado2">Estado da Loja</label>
                            <input type="text" class="form-control @error('estado2') is-invalid @enderror" 
                                   id="estado2" name="estado2" 
                                   value="{{ old('estado2', $dadosFormulario['estado2'] ?? '') }}" maxlength="2">
                            @error('estado2')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="membro_ativo_loja">Membro Ativo</label>
                            <select class="form-control @error('membro_ativo_loja') is-invalid @enderror" 
                                    id="membro_ativo_loja" name="membro_ativo_loja">
                                <option value="S" {{ old('membro_ativo_loja', $dadosFormulario['membro_ativo_loja'] ?? '') == 'S' ? 'selected' : '' }}>Sim</option>
                                <option value="N" {{ old('membro_ativo_loja', $dadosFormulario['membro_ativo_loja'] ?? '') == 'N' ? 'selected' : '' }}>Não</option>
                            </select>
                            @error('membro_ativo_loja')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="numero_da_loja">Número da Loja Atual</label>
                            <input type="text" class="form-control @error('numero_da_loja') is-invalid @enderror" 
                                   id="numero_da_loja" name="numero_da_loja" 
                                   value="{{ old('numero_da_loja', $dadosFormulario['numero_da_loja'] ?? '') }}">
                            @error('numero_da_loja')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="cidade3">Cidade da Loja Atual</label>
                            <input type="text" class="form-control @error('cidade3') is-invalid @enderror" 
                                   id="cidade3" name="cidade3" 
                                   value="{{ old('cidade3', $dadosFormulario['cidade3'] ?? '') }}">
                            @error('cidade3')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="estado3">Estado da Loja Atual</label>
                            <input type="text" class="form-control @error('estado3') is-invalid @enderror" 
                                   id="estado3" name="estado3" 
                                   value="{{ old('estado3', $dadosFormulario['estado3'] ?? '') }}" maxlength="2">
                            @error('estado3')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="apr_em">Data de Aprendiz</label>
                            <input type="date" class="form-control @error('apr_em') is-invalid @enderror" 
                                   id="apr_em" name="apr_em" 
                                   value="{{ old('apr_em', $dadosFormulario['apr_em'] ?? '') }}">
                            @error('apr_em')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="comp_em">Data de Companheiro</label>
                            <input type="date" class="form-control @error('comp_em') is-invalid @enderror" 
                                   id="comp_em" name="comp_em" 
                                   value="{{ old('comp_em', $dadosFormulario['comp_em'] ?? '') }}">
                            @error('comp_em')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="mest_em">Data de Mestre</label>
                            <input type="date" class="form-control @error('mest_em') is-invalid @enderror" 
                                   id="mest_em" name="mest_em" 
                                   value="{{ old('mest_em', $dadosFormulario['mest_em'] ?? '') }}">
                            @error('mest_em')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="mi_em">Data de Mestre Instalado</label>
                            <input type="date" class="form-control @error('mi_em') is-invalid @enderror" 
                                   id="mi_em" name="mi_em" 
                                   value="{{ old('mi_em', $dadosFormulario['mi_em'] ?? '') }}">
                            @error('mi_em')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="potencia_corpo_filosofico">Potência do Corpo Filosófico</label>
                            <input type="text" class="form-control @error('potencia_corpo_filosofico') is-invalid @enderror" 
                                   id="potencia_corpo_filosofico" name="potencia_corpo_filosofico" 
                                   value="{{ old('potencia_corpo_filosofico', $dadosFormulario['potencia_corpo_filosofico'] ?? '') }}">
                            @error('potencia_corpo_filosofico')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="ativo_no_grau">Grau Atual</label>
                            <select class="form-control @error('ativo_no_grau') is-invalid @enderror" 
                                    id="ativo_no_grau" name="ativo_no_grau" required>
                                @for($i = 1; $i <= 33; $i++)
                                    <option value="{{ $i }}" {{ old('ativo_no_grau', $dadosFormulario['ativo_no_grau'] ?? $dadosEtapa1['grau']) == $i ? 'selected' : '' }}>
                                        {{ $i }}°
                                    </option>
                                @endfor
                            </select>
                            @error('ativo_no_grau')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="codigo">Código</label>
                            <input type="text" class="form-control @error('codigo') is-invalid @enderror" 
                                   id="codigo" name="codigo" 
                                   value="{{ old('codigo', $dadosFormulario['codigo'] ?? '') }}">
                            @error('codigo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="tipo_categoria">Tipo de Categoria</label>
                            <input type="text" class="form-control @error('tipo_categoria') is-invalid @enderror" 
                                   id="tipo_categoria" name="tipo_categoria" 
                                   value="{{ old('tipo_categoria', $dadosFormulario['tipo_categoria'] ?? '') }}">
                            @error('tipo_categoria')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <h4 class="mb-3 mt-4">Graus Adicionais</h4>
                @php
                    $graus = [
                        4 => ['col_corpo_1', 'diploma_4_num'],
                        5 => ['col_corpo_05', 'diploma_5_num'],
                        7 => ['col_corpo_14', 'diploma_7_num'],
                        9 => ['col_corpo_2', 'diploma_9_num'],
                        10 => ['col_corpo_3', 'diploma_10_num'],
                        14 => ['col_corpo_4', 'diploma_14_num'],
                        15 => ['col_corpo_5', 'diploma_15_num'],
                        16 => ['col_corpo_15', 'diploma_16_num'],
                        17 => ['col_corpo_16', 'diploma_17_num'],
                        18 => ['col_corpo_6', 'breve_18_num'],
                        19 => ['col_corpo_7', 'diploma_19_num'],
                        22 => ['col_corpo_8', 'diploma_22_num'],
                        29 => ['col_corpo_9', 'diploma_29_num'],
                        30 => ['col_corpo_10', 'patente_30_num'],
                        31 => ['col_corpo_11', 'patente_31_num'],
                        32 => ['col_corpo_12', 'patente_32_num'],
                        33 => ['col_corpo_13', 'patente_33_num']
                    ];
                @endphp

                @foreach($graus as $grau => $campos)
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="grau_{{ $grau }}_em">Data do Grau {{ $grau }}°</label>
                                <input type="date" class="form-control @error('grau_' . $grau . '_em') is-invalid @enderror" 
                                       id="grau_{{ $grau }}_em" name="grau_{{ $grau }}_em" 
                                       value="{{ old('grau_' . $grau . '_em', $dadosFormulario['grau_' . $grau . '_em'] ?? '') }}">
                                @error('grau_' . $grau . '_em')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="{{ $campos[0] }}">Colégio do Corpo</label>
                                <input type="text" class="form-control @error($campos[0]) is-invalid @enderror" 
                                       id="{{ $campos[0] }}" name="{{ $campos[0] }}" 
                                       value="{{ old($campos[0], $dadosFormulario[$campos[0]] ?? '') }}">
                                @error($campos[0])
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="{{ $campos[1] }}">Número do Documento</label>
                                <input type="text" class="form-control @error($campos[1]) is-invalid @enderror" 
                                       id="{{ $campos[1] }}" name="{{ $campos[1] }}" 
                                       value="{{ old($campos[1], $dadosFormulario[$campos[1]] ?? '') }}">
                                @error($campos[1])
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                @endforeach

                <h4 class="mb-3 mt-4">Cargos e Condecorações</h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="cond_rec">Condição de Recebedor</label>
                            <input type="text" class="form-control @error('cond_rec') is-invalid @enderror" 
                                   id="cond_rec" name="cond_rec" 
                                   value="{{ old('cond_rec', $dadosFormulario['cond_rec'] ?? '') }}">
                            @error('cond_rec')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="cond_gr_rec">Condição de Grande Recebedor</label>
                            <input type="text" class="form-control @error('cond_gr_rec') is-invalid @enderror" 
                                   id="cond_gr_rec" name="cond_gr_rec" 
                                   value="{{ old('cond_gr_rec', $dadosFormulario['cond_gr_rec'] ?? '') }}">
                            @error('cond_gr_rec')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="cond_mont">Condição de Montezuma</label>
                            <input type="text" class="form-control @error('cond_mont') is-invalid @enderror" 
                                   id="cond_mont" name="cond_mont" 
                                   value="{{ old('cond_mont', $dadosFormulario['cond_mont'] ?? '') }}">
                            @error('cond_mont')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="rec">Recebedor</label>
                            <input type="text" class="form-control @error('rec') is-invalid @enderror" 
                                   id="rec" name="rec" 
                                   value="{{ old('rec', $dadosFormulario['rec'] ?? '') }}">
                            @error('rec')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="gr_rec">Grande Recebedor</label>
                            <input type="text" class="form-control @error('gr_rec') is-invalid @enderror" 
                                   id="gr_rec" name="gr_rec" 
                                   value="{{ old('gr_rec', $dadosFormulario['gr_rec'] ?? '') }}">
                            @error('gr_rec')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="monte">Montezuma</label>
                            <input type="text" class="form-control @error('monte') is-invalid @enderror" 
                                   id="monte" name="monte" 
                                   value="{{ old('monte', $dadosFormulario['monte'] ?? '') }}">
                            @error('monte')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label for="condecoracoes_scb">Condecorações SCB</label>
                            <textarea class="form-control @error('condecoracoes_scb') is-invalid @enderror" 
                                      id="condecoracoes_scb" name="condecoracoes_scb" rows="3">{{ old('condecoracoes_scb', $dadosFormulario['condecoracoes_scb'] ?? '') }}</textarea>
                            @error('condecoracoes_scb')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('cadastro.etapa1') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Voltar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check"></i> Finalizar Cadastro
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 