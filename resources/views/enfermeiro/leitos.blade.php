@extends('layouts.admin')

@section('content')
<div class="page-header mb-4">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h2 class="m-b-10">Gestão de Leitos</h2>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ root() }}enfermeiro"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item active">Leitos</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Controle de Ocupação em Tempo Real</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @forelse($leitos as $leito)
                    <div class="col-md-4 col-xl-3">
                        <div class="card border {{ $leito->status == 'Ocupado' ? 'border-danger' : 'border-success' }} mb-4">
                            <div class="card-body text-center">
                                <i class="feather icon-sidebar f-40 {{ $leito->status == 'Ocupado' ? 'text-danger' : 'text-success' }} mb-3 d-block"></i>
                                <h4 class="mb-1">Leito {{ $leito->numero }}</h4>
                                <p class="text-muted small mb-3">{{ $leito->tipo }}</p>

                                <div class="badge border {{ $leito->status == 'Ocupado' ? 'border-danger text-danger' : 'border-success text-success' }} mb-3 px-3 py-2">
                                    {{ $leito->status }}
                                </div>

                                <div class="d-grid gap-2">
                                    @if($leito->status == 'Livre')
                                    <button onclick="updateStatus({{ $leito->id }}, 'Ocupado')" class="btn btn-sm btn-danger">
                                        <i class="feather icon-user-minus me-1"></i> Ocupar
                                    </button>
                                    @else
                                    <button onclick="updateStatus({{ $leito->id }}, 'Livre')" class="btn btn-sm btn-success">
                                        <i class="feather icon-user-plus me-1"></i> Liberar
                                        </a>
                                        @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">Nenhum leito cadastrado no sistema.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function updateStatus(id, newStatus) {
        if (!confirm(`Deseja alterar o status do leito para ${newStatus}?`)) return;

        try {
            const response = await fetch('{{ root() }}enfermeiro/leito/status', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: id,
                    status: newStatus
                })
            });
            const result = await response.json();

            if (result.status) {
                alert(result.message);
                location.reload();
            } else {
                alert('Erro: ' + result.message);
            }
        } catch (e) {
            alert('Erro ao processar solicitação.');
            console.error(e);
        }
    }
</script>
@endsection