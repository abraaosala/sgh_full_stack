@extends('layouts.admin')

@section('content')
<div class="page-header mb-3">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 mb-2">
                        <li class="breadcrumb-item">
                            <a href="{{ lnk('admin/dashboard') }}"><i class="feather icon-home"></i> Painel</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ lnk('admin/medicos') }}">Médicos</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ isset($medico) ? 'Editar' : 'Novo' }}
                        </li>
                    </ol>
                </nav>
                <h2 class="page-header-title">{{ $title }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 text-center">
                <div class="avatar-icon mb-2">
                    <i class="feather icon-user-plus text-primary fs-1"></i>
                </div>
                <h4 class="mb-1">{{ isset($medico) ? 'Atualizar Médico' : 'Cadastro de Novo Médico' }}</h4>
                <p class="text-muted small">Preencha os dados abaixo com atenção</p>
            </div>

            <div class="card-body p-4">
                {!! flash('error') !!}

                <form action="{{ isset($medico) ? lnk('admin/medico-update/' . $medico->id) : lnk('admin/medico-store') }}" method="POST" autocomplete="off" class="needs-validation" novalidate>
                    <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">

                    @php $errors = $_SESSION['input_errors'] ?? []; @endphp

                    <div class="mb-4">
                        <h6 class="text-primary text-uppercase small fw-bold mb-3">Informações Pessoais</h6>
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="nome" class="form-label">Nome Completo <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="feather icon-user"></i></span>
                                    <input type="text" class="form-control {{ isset($errors['nome']) ? 'is-invalid' : '' }}" id="nome" name="nome" placeholder="Ex: Maria Clara Silva"
                                        value="{{ $medico->nome ?? old('nome') }}" required>
                                    @if(isset($errors['nome']))
                                    <div class="invalid-feedback">{{ is_array($errors['nome']) ? implode(', ', $errors['nome']) : $errors['nome'] }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">E-mail <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="feather icon-mail"></i></span>
                                    <input type="email" class="form-control {{ isset($errors['email']) ? 'is-invalid' : '' }}" id="email" name="email" placeholder="email@exemplo.com"
                                        value="{{ $medico->email ?? old('email') }}" required>
                                    @if(isset($errors['email']))
                                    <div class="invalid-feedback">{{ is_array($errors['email']) ? implode(', ', $errors['email']) : $errors['email'] }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="genero" class="form-label">Gênero <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="feather icon-users"></i></span>
                                    <select class="form-select {{ isset($errors['genero']) ? 'is-invalid' : '' }}" id="genero" name="genero" required>
                                        <option value="">Selecione...</option>
                                        <option value="M" {{ ($medico->genero ?? old('genero')) === 'M' ? 'selected' : '' }}>Masculino</option>
                                        <option value="F" {{ ($medico->genero ?? old('genero')) === 'F' ? 'selected' : '' }}>Feminino</option>
                                        <option value="O" {{ ($medico->genero ?? old('genero')) === 'O' ? 'selected' : '' }}>Outro</option>
                                    </select>
                                    @if(isset($errors['genero']))
                                    <div class="invalid-feedback">{{ is_array($errors['genero']) ? implode(', ', $errors['genero']) : $errors['genero'] }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="data_nascimento" class="form-label">Data de Nascimento <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="feather icon-calendar"></i></span>
                                    <input type="date" class="form-control {{ isset($errors['data_nascimento']) ? 'is-invalid' : '' }}" id="data_nascimento" name="data_nascimento"
                                        value="{{ $medico->data_nascimento ?? old('data_nascimento') }}" required>
                                    @if(isset($errors['data_nascimento']))
                                    <div class="invalid-feedback">{{ is_array($errors['data_nascimento']) ? implode(', ', $errors['data_nascimento']) : $errors['data_nascimento'] }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="telefone" class="form-label">Telefone <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="feather icon-phone"></i></span>
                                    <input type="tel" class="form-control {{ isset($errors['telefone']) ? 'is-invalid' : '' }}" id="telefone" name="telefone" placeholder="(00) 00000-0000"
                                        value="{{ $medico->telefone ?? old('telefone') }}" required>
                                    @if(isset($errors['telefone']))
                                    <div class="invalid-feedback">{{ is_array($errors['telefone']) ? implode(', ', $errors['telefone']) : $errors['telefone'] }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-primary text-uppercase small fw-bold mb-3">Informações Profissionais</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="numero_ordem" class="form-label">Nº Ordem / CRM <span class="text-danger">*</span></label>
                                <input type="text" class="form-control {{ isset($errors['numero_ordem']) ? 'is-invalid' : '' }}" id="numero_ordem" name="numero_ordem"
                                    value="{{ $medico->numero_ordem ?? old('numero_ordem') }}" placeholder="Ex: 12345-AO" required>
                                @if(isset($errors['numero_ordem']))
                                <div class="invalid-feedback">{{ is_array($errors['numero_ordem']) ? implode(', ', $errors['numero_ordem']) : $errors['numero_ordem'] }}</div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <label for="especialidade_id" class="form-label">Especialidade <span class="text-danger">*</span></label>
                                <select class="form-select {{ isset($errors['especialidade_id']) ? 'is-invalid' : '' }}" id="especialidade_id" name="especialidade_id" required>
                                    <option value="">Selecione...</option>
                                    @foreach($especialidades as $especialidade)
                                    <option value="{{ $especialidade->id }}" {{ ($medico->especialidade_id ?? old('especialidade_id')) == $especialidade->id ? 'selected' : '' }}>
                                        {{ $especialidade->nome }}
                                    </option>
                                    @endforeach
                                </select>
                                @if(isset($errors['especialidade_id']))
                                <div class="invalid-feedback">{{ is_array($errors['especialidade_id']) ? implode(', ', $errors['especialidade_id']) : $errors['especialidade_id'] }}</div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <label for="nivel" class="form-label">Nível <span class="text-danger">*</span></label>
                                <select class="form-select {{ isset($errors['nivel']) ? 'is-invalid' : '' }}" id="nivel" name="nivel" required>
                                    <option value="">Selecione...</option>
                                    <option value="Generalista" {{ ($medico->nivel ?? old('nivel')) === 'Generalista' ? 'selected' : '' }}>Generalista</option>
                                    <option value="Especialista" {{ ($medico->nivel ?? old('nivel')) === 'Especialista' ? 'selected' : '' }}>Especialista</option>
                                    <option value="Interno" {{ ($medico->nivel ?? old('nivel')) === 'Interno' ? 'selected' : '' }}>Interno</option>
                                </select>
                                @if(isset($errors['nivel']))
                                <div class="invalid-feedback">{{ is_array($errors['nivel']) ? implode(', ', $errors['nivel']) : $errors['nivel'] }}</div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <label for="provincia_id" class="form-label">Província <span class="text-danger">*</span></label>
                                <select class="form-select {{ isset($errors['provincia_id']) ? 'is-invalid' : '' }}" id="provincia_id" name="provincia_id" required>
                                    <option value="">Selecione...</option>
                                    @foreach($provincias as $provincia)
                                    <option value="{{ $provincia->id }}" {{ ($medico->provincia_id ?? old('provincia_id')) == $provincia->id ? 'selected' : '' }}>
                                        {{ $provincia->nome }}
                                    </option>
                                    @endforeach
                                </select>
                                @if(isset($errors['provincia_id']))
                                <div class="invalid-feedback">{{ is_array($errors['provincia_id']) ? implode(', ', $errors['provincia_id']) : $errors['provincia_id'] }}</div>
                                @endif
                            </div>

                            <div class="col-md-12">
                                <label for="hospital" class="form-label">Hospital / Unidade Sanitária</label>
                                <input type="text" class="form-control" id="hospital" name="hospital" value="{{ $medico->hospital ?? old('hospital') }}" placeholder="Nome do Hospital">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ lnk('admin/medicos') }}" class="btn btn-secondary shadow-sm">Cancelar</a>
                        <button type="submit" class="btn btn-primary shadow-sm px-4">
                            <i class="feather icon-save me-2"></i> {{ isset($medico) ? 'Salvar Alterações' : 'Finalizar Cadastro' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection