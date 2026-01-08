@extends('layouts.admin')

@section('content')
<div class="page-header mb-4">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h2 class="m-b-10">{{ isset($leito) ? 'Editar Leito' : 'Novo Leito' }}</h2>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ root() }}enfermeiro"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ root() }}enfermeiro/leitos">Gestão de Leitos</a></li>
                    <li class="breadcrumb-item active">{{ isset($leito) ? 'Editar' : 'Novo' }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5>Formulário de Leito</h5>
            </div>
            <div class="card-body">
                <form action="{{ isset($leito) ? root() . 'enfermeiro/leito/atualizar/' . $leito->id : root() . 'enfermeiro/leito/salvar' }}" method="POST">

                    {{-- Usando o helper de CSRF se existir, senão manual --}}
                    @if(function_exists('csrf_field'))
                    {!! csrf_field() !!}
                    @else
                    <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="numero" class="form-label">Número / Identificação *</label>
                            <input type="text" class="form-control" id="numero" name="numero" value="{{ $leito->numero ?? '' }}" required placeholder="Ex: 101-A">
                        </div>
                        <div class="col-md-6">
                            <label for="tipo" class="form-label">Tipo de Leito *</label>
                            <select class="form-select" id="tipo" name="tipo" required>
                                <option value="">Selecione o Tipo</option>
                                <option value="UTI Respiratória" {{ (isset($leito) && $leito->tipo == 'UTI Respiratória') ? 'selected' : '' }}>UTI Respiratória</option>
                                <option value="Enfermaria (O2)" {{ (isset($leito) && $leito->tipo == 'Enfermaria (O2)') ? 'selected' : '' }}>Enfermaria (Suporte O2)</option>
                                <option value="Isolamento Respiratório" {{ (isset($leito) && $leito->tipo == 'Isolamento Respiratório') ? 'selected' : '' }}>Isolamento Respiratório</option>
                                <option value="Ventilação Mecânica" {{ (isset($leito) && $leito->tipo == 'Ventilação Mecânica') ? 'selected' : '' }}>Leito com Ventilação Mecânica</option>
                                <option value="Recuperação Pós-Extubação" {{ (isset($leito) && $leito->tipo == 'Recuperação Pós-Extubação') ? 'selected' : '' }}>Recuperação Pós-Extubação</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="Livre" {{ ($leito->status ?? '') == 'Livre' ? 'selected' : '' }}>Livre</option>
                            <option value="Ocupado" {{ ($leito->status ?? '') == 'Ocupado' ? 'selected' : '' }}>Ocupado</option>
                            <option value="Manutenção" {{ ($leito->status ?? '') == 'Manutenção' ? 'selected' : '' }}>Manutenção</option>
                            <option value="Reservado" {{ ($leito->status ?? '') == 'Reservado' ? 'selected' : '' }}>Reservado</option>
                            <option value="Limpeza" {{ ($leito->status ?? '') == 'Limpeza' ? 'selected' : '' }}>Limpeza</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição / Observações</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="3">{{ $leito->descricao ?? '' }}</textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ root() }}enfermeiro/leitos" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">
                            {{ isset($leito) ? 'Atualizar Leito' : 'Salvar Leito' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection