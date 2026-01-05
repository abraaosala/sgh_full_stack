<div class="toolbar">
    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
            <form id="filters" class="row g-3 align-items-end">
                <div class="col-12 col-md-4">
                    <label class="form-label" for="q">Buscar</label>
                    <input type="search" id="q" class="form-control" placeholder="Médico, especialidade, clínica…" />
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label" for="status">Estado</label>
                    <select id="status" class="form-select">
                        <option value="">Todos</option>
                        <option value="agendada">Agendada</option>
                        <option value="concluida">Concluída</option>
                        <option value="cancelada">Cancelada</option>
                        <option value="faltou">Faltou</option>
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <label class="form-label" for="de">De</label>
                    <input type="date" id="de" class="form-control" />
                </div>
                <div class="col-6 col-md-2">
                    <label class="form-label" for="ate">Até</label>
                    <input type="date" id="ate" class="form-control" />
                </div>
                <div class="col-6 col-md-1 d-grid">
                    <button type="reset" class="btn btn-light border"><i class="bi bi-x-circle"></i>
                        Limpar</button>
                </div>
            </form>
        </div>
    </div>
</div>