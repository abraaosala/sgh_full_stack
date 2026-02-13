@extends('layouts.admin')

@section('content')
<div class="pc-container" id="medicos-agenda">
    <div class="pc-content">
        <div class="page-header mb-4">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb bg-transparent p-0 mb-2">
                                <li class="breadcrumb-item">
                                    <a href="{{ lnk('admin/dashboard') }}"><i class="feather icon-home"></i> Painel</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Escala Médica</li>
                            </ol>
                        </nav>
                        <h2 class="page-header-title">Gestão de Escala</h2>
                        <p class="text-muted">Gerencie turnos e horários de atendimento dos médicos.</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <button class="btn btn-primary btn-sm" id="generate">
                            <i class="feather icon-refresh-cw me-1"></i> Gerar Escala Aleatória
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div id='calendar'></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Visualização/Edição -->
<div class="modal fade" id="visualizarModal" tabindex="-1" aria-labelledby="visualizarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="visualizarModalLabel">Visualizar Turno - <span id="title-ver"></span></h5>
                <h5 class="modal-title" id="editarModalLabel" style="display: none;">Editar Turno</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Visualizar -->
                <div id="medico-info">
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold text-uppercase mb-1">Médico</label>
                        <div id="medico-nome" class="fw-bold fs-5 text-primary"></div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label text-muted small fw-bold text-uppercase mb-1">Especialidade</label>
                            <div id="medico-especialidade" class="fw-semibold"></div>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted small fw-bold text-uppercase mb-1">Cédula/Ordem</label>
                            <div id="medico-ordem"></div>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label text-muted small fw-bold text-uppercase mb-1">Entrada</label>
                            <div id="medico-entrada" class="text-success fw-semibold"></div>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted small fw-bold text-uppercase mb-1">Saída</label>
                            <div id="medico-saida" class="text-danger fw-semibold"></div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-muted small fw-bold text-uppercase mb-1">Contato</label>
                        <div id="medico-contato"></div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-primary btn-sm flex-fill" id="editar-btn">
                            <i class="feather icon-edit-2 me-1"></i> Editar
                        </button>
                        <form id="form-eliminar" class="flex-fill">
                            <input type="hidden" name="id" id="eliminar-id-input">
                            <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                <i class="feather icon-trash-2 me-1"></i> Eliminar
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Editar -->
                <div id="medico-edit" style="display: none;">
                    <form id="medico-edit-form">
                        <span id="msg-edit"></span>
                        <div class="mb-3">
                            <label for="medico-titulo-input" class="form-label small fw-bold text-uppercase">Título do Turno</label>
                            <select id="medico-titulo-input" name="title" class="form-select shadow-none border-light focus-ring">
                                <option value="Turno Matinal">Turno Matinal</option>
                                <option value="Turno Vespertino">Turno Vespertino</option>
                                <option value="Turno Noturno">Turno Noturno</option>
                            </select>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label for="medico-entrada-input" class="form-label small fw-bold text-uppercase">Entrada</label>
                                <input type="datetime-local" class="form-control shadow-none border-light focus-ring" id="medico-entrada-input" name="start">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="medico-saida-input" class="form-label small fw-bold text-uppercase">Saída</label>
                                <input type="datetime-local" class="form-control shadow-none border-light focus-ring" id="medico-saida-input" name="end">
                            </div>
                        </div>
                        <input type="hidden" name="id" id="medico-id-input">
                        <div class="d-flex gap-2 mt-3">
                            <button type="button" class="btn btn-light btn-sm flex-fill" id="first-btn">Cancelar</button>
                            <button type="submit" class="btn btn-primary btn-sm flex-fill">Salvar Alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Cadastro -->
<div class="modal fade" id="cadastrarModal" tabindex="-1" aria-labelledby="cadastrarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="cadastrarModalLabel">Agendar Novo Turno</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body p-4">
                <form id="cadastrar-evento-form">
                    <span id="msg-cad"></span>
                    <div class="mb-3">
                        <label for="cadastrar-medico-select" class="form-label small fw-bold text-uppercase">Médico responsável</label>
                        <select class="form-select shadow-none border-light focus-ring" id="cadastrar-medico-select" name="medico_id" required>
                            <option value="">Selecione o médico...</option>
                            @foreach ($medicos as $medico)
                            <option value="{{ $medico->id }}">{{ $medico->usuario->nome ?? 'Médico #'.$medico->id }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="cadastrar-titulo-input" class="form-label small fw-bold text-uppercase">Tipo de Turno</label>
                        <select id="cadastrar-titulo-input" name="title" class="form-select shadow-none border-light focus-ring" required>
                            <option value="">Selecionar...</option>
                            <option value="Turno Matinal">Turno Matinal</option>
                            <option value="Turno Vespertino">Turno Vespertino</option>
                            <option value="Turno Noturno">Turno Noturno</option>
                        </select>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label for="cadastrar-medico-entrada" class="form-label small fw-bold text-uppercase">Horário de Entrada</label>
                            <input type="datetime-local" class="form-control shadow-none border-light focus-ring" id="cadastrar-medico-entrada" name="start" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="cadastrar-medico-saida" class="form-label small fw-bold text-uppercase">Horário de Saída</label>
                            <input type="datetime-local" class="form-control shadow-none border-light focus-ring" id="cadastrar-medico-saida" name="end" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="color" class="form-label small fw-bold text-uppercase">Etiqueta de Cor</label>
                        <div class="d-flex gap-2 flex-wrap">
                            <input type="radio" class="btn-check" name="color" id="color-blue" value="#0d6efd" autocomplete="off" checked>
                            <label class="btn btn-outline-primary btn-sm rounded-circle p-2" for="color-blue" style="width: 32px; height: 32px;"></label>

                            <input type="radio" class="btn-check" name="color" id="color-green" value="#198754" autocomplete="off">
                            <label class="btn btn-outline-success btn-sm rounded-circle p-2" for="color-green" style="width: 32px; height: 32px;"></label>

                            <input type="radio" class="btn-check" name="color" id="color-red" value="#dc3545" autocomplete="off">
                            <label class="btn btn-outline-danger btn-sm rounded-circle p-2" for="color-red" style="width: 32px; height: 32px;"></label>

                            <input type="radio" class="btn-check" name="color" id="color-yellow" value="#ffc107" autocomplete="off">
                            <label class="btn btn-outline-warning btn-sm rounded-circle p-2" for="color-yellow" style="width: 32px; height: 32px;"></label>

                            <input type="radio" class="btn-check" name="color" id="color-purple" value="#6610f2" autocomplete="off">
                            <label class="btn btn-outline-info btn-sm rounded-circle p-2" for="color-purple" style="width: 32px; height: 32px; border-color: #6610f2;"></label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm w-100 py-2 fw-bold">
                        <i class="feather icon-plus me-1"></i> Confirmar Agendamento
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    window.APP_URL = "{{ root() }}";
</script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js"></script>
<script src="{{ asset('js/ajax/admin_agenda_med.js') }}"></script>
@endpush

<style>
    .fc-event {
        cursor: pointer;
        border: none !important;
        padding: 2px 5px !important;
    }

    .fc-toolbar-title {
        font-size: 1.25rem !important;
        font-weight: 700 !important;
        color: #333;
    }

    .fc-button-primary {
        background-color: #0d6efd !important;
        border-color: #0d6efd !important;
        font-weight: 600 !important;
    }

    .focus-ring:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
        border-color: #0d6efd;
    }
</style>
@endsection