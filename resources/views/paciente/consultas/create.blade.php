@extends('layouts.admin')

@section('content')
<div class="page-header mb-3">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 mb-2">
                        <li class="breadcrumb-item">
                            <a href="{{ root() }}paciente/dashboard"><i class="feather icon-home"></i> Painel</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ root() }}paciente/consultas">Consultas</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Agendar</li>
                    </ol>
                </nav>
                <h2 class="page-header-title">Agendar Nova Consulta</h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5>Formulário de Agendamento</h5>
            </div>
            <div class="card-body">
                <form action="{{ lnk('paciente/consultas/store') }}" method="POST" id="form-agendar">

                    {{-- CSRF Protection --}}
                    {{-- <input type="hidden" name="csrf_token" value="{{ csrf_token() }}"> --}}

                    <div class="mb-3">
                        <label for="medico" class="form-label">Médico / Especialidade *</label>
                        <select class="form-select" id="medico_id" name="medico_id" required>
                            <option value="">Selecione...</option>
                            @foreach ($especialidades as $especialidade)
                            <optgroup label="{{ $especialidade->nome }}">
                                @foreach ($especialidade->medicos as $medico)
                                <option value="{{ $medico->id }}">{{ $medico->usuario->nome }}</option>
                                @endforeach
                            </optgroup>
                            @endforeach
                        </select>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="data" class="form-label">Data Preferencial *</label>
                            <input type="date" class="form-control" id="data" name="data" required min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="hora" class="form-label">Horário Preferencial *</label>
                            <input type="time" class="form-control" id="hora" name="hora" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="motivo" class="form-label">Motivo / Sintomas</label>
                        <textarea class="form-control" id="motivo" name="observacao" rows="3" placeholder="Descreva brevemente o motivo da consulta..."></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ root() }}paciente/consultas" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Solicitar Agendamento</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            document.getElementById('form-agendar').addEventListener('submit', async function(e) {
                e.preventDefault();

                const form = this;
                const formData = new FormData(form);
                const data = Object.fromEntries(formData.entries());

                // Construct 'marcacao' from data and hora fields
                if (data.data && data.hora) {
                    data.marcacao = `${data.data} ${data.hora}`;
                }

                try {
                    const response = await fetch("{{ root() }}api/consulta-paciente/store", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('input[name="csrf_token"]')?.value || ''
                        },
                        body: JSON.stringify(data)
                    });

                    // Check if response is ok (status 200-299)
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const result = await response.json();

                    // console.log(result);

                    if (result.status) {
                        alert(result.message || 'Agendamento realizado!');
                        window.location.href = '{{ root() }}paciente/consultas';
                    } else {
                        alert('Erro: ' + (result.message || 'Falha ao agendar.'));
                    }

                } catch (error) {
                    console.error('Erro na requisição:', error);
                    alert('Erro ao comunicar com o servidor.');
                }
            });
        </script>
    </div>
</div>
@endsection