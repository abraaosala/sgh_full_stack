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
                            <a href="{{ lnk('admin/funcionarios') }}">Funcionários</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Novo</li>
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
                    <i class="feather icon-user-plus text-info fs-1"></i>
                </div>
                <h4 class="mb-1">Novo Membro da Equipe</h4>
                <p class="text-muted small">Defina o perfil e as credenciais do novo funcionário</p>
            </div>

            <div class="card-body p-4">
                {!! flash('error') !!}

                <form action="{{ lnk('admin/funcionario-store') }}" method="POST" autocomplete="off" class="needs-validation" novalidate>
                    <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">

                    <div class="mb-4">
                        <h6 class="text-info text-uppercase small fw-bold mb-3">Informações de Login</h6>
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="nome" class="form-label">Nome Completo <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="feather icon-user"></i></span>
                                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Ex: Carlos Alberto Duarte" value="{{ old('nome') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">E-mail Profissional <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="feather icon-mail"></i></span>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="nome@hospital.com" value="{{ old('email') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="perfil" class="form-label">Função / Perfil <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="feather icon-briefcase"></i></span>
                                    <select class="form-select" id="perfil" name="perfil" required>
                                        <option value="">Selecione...</option>
                                        @foreach($funcionarios as $func_type)
                                        <option value="{{ strtolower($func_type) }}" {{ old('perfil') == strtolower($func_type) ? 'selected' : '' }}>
                                            {{ $func_type }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-info text-uppercase small fw-bold mb-3">Dados Complementares</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="numero_ordem" class="form-label">Nº Registro / Matrícula <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="numero_ordem" name="numero_ordem" value="{{ old('numero_ordem') }}" placeholder="Ex: EF-9982" required>
                            </div>

                            <div class="col-md-6">
                                <label for="genero" class="form-label">Gênero <span class="text-danger">*</span></label>
                                <select class="form-select" id="genero" name="genero" required>
                                    <option value="">Selecione...</option>
                                    <option value="M" {{ old('genero') == 'M' ? 'selected' : '' }}>Masculino</option>
                                    <option value="F" {{ old('genero') == 'F' ? 'selected' : '' }}>Feminino</option>
                                    <option value="O" {{ old('genero') == 'O' ? 'selected' : '' }}>Outro</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="provincia_id" class="form-label">Província de Atuação <span class="text-danger">*</span></label>
                                <select class="form-select" id="provincia_id" name="provincia_id" required>
                                    <option value="">Selecione...</option>
                                    @foreach($provincias as $provincia)
                                    <option value="{{ $provincia->id }}" {{ old('provincia_id') == $provincia->id ? 'selected' : '' }}>
                                        {{ $provincia->nome }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ lnk('admin/funcionarios') }}" class="btn btn-secondary shadow-sm">Cancelar</a>
                        <button type="submit" class="btn btn-info text-white shadow-sm px-4">
                            <i class="feather icon-check-circle me-2"></i> Criar Conta de Funcionário
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection