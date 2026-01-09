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
                            <a href="{{ lnk('admin/pacientes') }}">Pacientes</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ isset($paciente) ? 'Editar' : 'Novo' }}
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
                    <i class="feather icon-user-plus text-purple fs-1" style="color: #6f42c1;"></i>
                </div>
                <h4 class="mb-1">{{ isset($paciente) ? 'Atualizar Perfil do Paciente' : 'Cadastro de Novo Paciente' }}</h4>
                <p class="text-muted small">Insira as informações básicas de saúde e contato</p>
            </div>

            <div class="card-body p-4">
                {!! flash('error') !!}

                <form action="{{ isset($paciente) ? lnk('admin/paciente-update/' . $paciente->id) : lnk('admin/paciente-store') }}" method="POST" autocomplete="off" class="needs-validation" novalidate>
                    <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">
                    @if(isset($paciente))
                    <input type="hidden" name="id" value="{{ $paciente->id }}">
                    @endif

                    @php $errors = $_SESSION['input_errors'] ?? []; @endphp

                    <div class="mb-4">
                        <h6 class="text-purple text-uppercase small fw-bold mb-3" style="color: #6f42c1;">Informações Pessoais</h6>
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="nome" class="form-label">Nome Completo <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="feather icon-user"></i></span>
                                    <input type="text" class="form-control {{ isset($errors['nome']) ? 'is-invalid' : '' }}" id="nome" name="nome" placeholder="Ex: João Manuel dos Santos"
                                        value="{{ $paciente->nome ?? old('nome') }}" required>
                                    @if(isset($errors['nome']))
                                    <div class="invalid-feedback">{{ is_array($errors['nome']) ? implode(', ', $errors['nome']) : $errors['nome'] }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">E-mail de Contato <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="feather icon-mail"></i></span>
                                    <input type="email" class="form-control {{ isset($errors['email']) ? 'is-invalid' : '' }}" id="email" name="email" placeholder="paciente@exemplo.com"
                                        value="{{ $paciente->email ?? old('email') }}" required>
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
                                        <option value="M" {{ ($paciente->genero ?? old('genero')) === 'M' ? 'selected' : '' }}>Masculino</option>
                                        <option value="F" {{ ($paciente->genero ?? old('genero')) === 'F' ? 'selected' : '' }}>Feminino</option>
                                        <option value="O" {{ ($paciente->genero ?? old('genero')) === 'O' ? 'selected' : '' }}>Outro</option>
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
                                        value="{{ $paciente->data_nascimento ?? old('data_nascimento') }}" required>
                                    @if(isset($errors['data_nascimento']))
                                    <div class="invalid-feedback">{{ is_array($errors['data_nascimento']) ? implode(', ', $errors['data_nascimento']) : $errors['data_nascimento'] }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="telefone" class="form-label">Telefone / WhatsApp <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="feather icon-phone"></i></span>
                                    <input type="tel" class="form-control {{ isset($errors['telefone']) ? 'is-invalid' : '' }}" id="telefone" name="telefone" placeholder="Ex: 923 000 000"
                                        value="{{ $paciente->telefone ?? old('telefone') }}" required>
                                    @if(isset($errors['telefone']))
                                    <div class="invalid-feedback">{{ is_array($errors['telefone']) ? implode(', ', $errors['telefone']) : $errors['telefone'] }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-purple text-uppercase small fw-bold mb-3" style="color: #6f42c1;">Localização e Endereço</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="provincia_id" class="form-label">Província de Residência <span class="text-danger">*</span></label>
                                <select class="form-select {{ isset($errors['provincia_id']) ? 'is-invalid' : '' }}" id="provincia_id" name="provincia_id" required>
                                    <option value="">Selecione...</option>
                                    @foreach($provincias as $provincia)
                                    <option value="{{ $provincia->id }}" {{ ($paciente->provincia_id ?? old('provincia_id')) == $provincia->id ? 'selected' : '' }}>
                                        {{ $provincia->nome }}
                                    </option>
                                    @endforeach
                                </select>
                                @if(isset($errors['provincia_id']))
                                <div class="invalid-feedback">{{ is_array($errors['provincia_id']) ? implode(', ', $errors['provincia_id']) : $errors['provincia_id'] }}</div>
                                @endif
                            </div>

                            <div class="col-md-12">
                                <label for="endereco" class="form-label">Endereço Completo</label>
                                <textarea name="endereco" id="endereco" class="form-control {{ isset($errors['endereco']) ? 'is-invalid' : '' }}" rows="2" placeholder="Ex: Bairro Talatona, Rua 5, Casa 21">{{ $paciente->endereco ?? old('endereco') }}</textarea>
                                @if(isset($errors['endereco']))
                                <div class="invalid-feedback">{{ is_array($errors['endereco']) ? implode(', ', $errors['endereco']) : $errors['endereco'] }}</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ lnk('admin/pacientes') }}" class="btn btn-secondary shadow-sm">Cancelar</a>
                        <button type="submit" class="btn btn-primary shadow-sm px-4" style="background-color: #6f42c1; border-color: #6f42c1;">
                            <i class="feather icon-save me-2"></i> {{ isset($paciente) ? 'Atualizar Registro' : 'Salvar Paciente' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection