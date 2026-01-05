<div class="pc-container">
    <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Painel Hospitalar</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= root() ?>"><i class="feather icon-home"></i> Início</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
         <?= flash(['informar', 'success', 'danger'])?>

        <?php if ($auth->perfil === 'admin' || $auth->perfil === 'superadmin'): ?>
            <!-- [ Main Content ] start  Admin-->

            <div class="row">
                <!-- Indicadores -->
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-2 text-muted">Pacientes Atendidos</h6>
                            <h4 class="mb-3">1.234 <span class="badge bg-light-primary border border-primary"><i class="ti ti-trending-up"></i> 12%</span></h4>
                            <p class="mb-0 text-muted text-sm">Este mês</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-2 text-muted">Internamentos</h6>
                            <h4 class="mb-3">320 <span class="badge bg-light-success border border-success"><i class="ti ti-trending-up"></i> 8.2%</span></h4>
                            <p class="mb-0 text-muted text-sm">Total do ano</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-2 text-muted">Pacientes Críticos</h6>
                            <h4 class="mb-3">48 <span class="badge bg-light-danger border border-danger"><i class="ti ti-trending-down"></i> 3%</span></h4>
                            <p class="mb-0 text-muted text-sm">Atualizado hoje</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-2 text-muted">Altas Hospitalares</h6>
                            <h4 class="mb-3">752 <span class="badge bg-light-warning border border-warning"><i class="ti ti-trending-up"></i> 15%</span></h4>
                            <p class="mb-0 text-muted text-sm">Nos últimos 30 dias</p>
                        </div>
                    </div>
                </div>

                <!-- Gráfico de Consultas e Internamentos -->
                <div class="col-md-12 col-xl-8">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5>Consultas vs Internamentos</h5>
                            <select class="form-select w-auto">
                                <option>Mensal</option>
                                <option>Semanal</option>
                            </select>
                        </div>
                        <div class="card-body">
                            <div id="hospital-chart"></div> <!-- Aqui entra o gráfico real (Chart.js ou ApexCharts) -->
                        </div>
                    </div>
                </div>

                <!-- Lista de pacientes recentes -->
                <div class="col-md-12 col-xl-4">
                    <h5 class="mb-3">Pacientes Recentes</h5>
                    <div class="card">
                        <div class="list-group list-group-flush">
                            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <span>Joana Silva</span><span class="badge bg-success">Alta</span>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <span>Pedro Manuel</span><span class="badge bg-warning">Em tratamento</span>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <span>Cátia Lopes</span><span class="badge bg-danger">Crítico</span>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <span>Antônio Paulo</span><span class="badge bg-secondary">Observação</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Relatório de Ocupacao dos Leitos -->
                <div class="col-md-12">
                    <h5 class="mb-3">Ocupacão de Leitos</h5>
                    <div class="card">
                        <div class="card-body">
                            <div id="bed-occupancy-chart"></div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- [ Main Content ] end -->
        <?php elseif ($auth->perfil === 'medico'): ?>
            <!-- [ Main Content ] start  Medico-->
            <div class="row">
                <!-- Pacientes do Médico -->
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-2 text-muted">Meus Pacientes</h6>
                            <h4 class="mb-3">
                                <?=$count?>
                                <span class="badge bg-light-primary border border-primary">
                                    <i class="ti ti-trending-up"></i> 5%
                                </span>
                            </h4>
                            <p class="mb-0 text-muted text-sm">Atendidos este mês</p>
                        </div>
                    </div>
                </div>

                <!-- Consultas Marcadas -->
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-2 text-muted">Consultas Agendadas</h6>
                            <h4 class="mb-3">
                                <?=$count_consultas?>
                                <span class="badge bg-light-success border border-success">
                                    <i class="ti ti-calendar"></i>
                                </span>
                            </h4>
                            <p class="mb-0 text-muted text-sm">Próximos 7 dias</p>
                        </div>
                    </div>
                </div>

                <!-- Pacientes Críticos -->
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-2 text-muted">Pacientes Críticos</h6>
                            <h4 class="mb-3">
                                3
                                <span class="badge bg-light-danger border border-danger">
                                    <i class="ti ti-trending-down"></i> 1%
                                </span>
                            </h4>
                            <p class="mb-0 text-muted text-sm">Monitorados</p>
                        </div>
                    </div>
                </div>

                <!-- Alta de Pacientes -->
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-2 text-muted">Altas Concedidas</h6>
                            <h4 class="mb-3">
                                8
                                <span class="badge bg-light-warning border border-warning">
                                    <i class="ti ti-trending-up"></i> 10%
                                </span>
                            </h4>
                            <p class="mb-0 text-muted text-sm">Últimos 30 dias</p>
                        </div>
                    </div>
                </div>

                <div class="row">




                    <!-- Gráfico de Evolução de Pacientes -->
                    <div class="col-md-12 col-xl-8">
                        <div class="card">
                            <div class="card-header">
                                <h5>Evolução de Pacientes</h5>
                            </div>
                            <div class="card-body">
                                <div id="grafico-pacientes"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Próximos Atendimentos -->
                    <div class="col-md-12 col-xl-4">
                        <h5 class="mb-3">Próximos Atendimentos</h5>
                        <div class="card">
                            <div class="list-group list-group-flush">
                                <a href="#" class="list-group-item d-flex justify-content-between">
                                    <span>Maria Santos</span> <span>09:30</span>
                                </a>
                                <a href="#" class="list-group-item d-flex justify-content-between">
                                    <span>Jorge Lima</span> <span>10:15</span>
                                </a>
                                <a href="#" class="list-group-item d-flex justify-content-between">
                                    <span>Ana Paula</span> <span>11:00</span>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

            </div>



        <?php endif; ?>
    </div>