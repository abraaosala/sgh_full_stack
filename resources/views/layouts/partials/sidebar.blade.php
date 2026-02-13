<!-- [ Pre-loader ] start -->
<div class="loader-bg">
    <div class="loader-track">
        <div class="loader-fill"></div>
    </div>
</div>
<!-- [ Pre-loader ] End -->
<!-- [ Sidebar Menu ] start -->
<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ lnk_dashboard() }}" class="b-brand text-primary wid-135">
                <!-- ========   Altere seu logo aqui   ============ -->
                <img src="{{ asset('img/logo.png') }}" class="img-fluid" alt="logo">
            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                <li class="pc-item">
                    <a href="{{ lnk_dashboard() }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                        <span class="pc-mtext">Dashboard</span>
                    </a>
                </li>

                <!-- @if ($auth->perfil == 'superadmin')
                <li class="pc-item pc-caption">
                    <label>Configuração Mestra</label>
                    <i class="ti ti-shield-cog"></i>
                </li>
                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-settings-automation"></i></span>
                        <span class="pc-mtext">Configurações do Sistema</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a href="{{ root() }}superadmin/config/geral"
                                class="pc-link">Parâmetros Gerais</a></li>
                        <li class="pc-item"><a href="{{ root() }}superadmin/config/integracoes"
                                class="pc-link">Integrações e APIs</a></li>
                    </ul>
                </li>
                <li class="pc-item">
                    <a href="{{ root() }}superadmin/logs" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-file-text"></i></span>
                        <span class="pc-mtext">Logs de Auditoria</span>
                    </a>
                </li>

                @endif -->


                {{-- --- SEÇÃO DE ADMINISTRAÇÃO (Admin e Super Admin) --- --}}

                @if ($auth->perfil == 'superadmin' || $auth->perfil == 'admin')

                <li class="pc-item pc-caption">
                    <label>Administração</label>
                    <i class="ti ti-settings"></i>
                </li>

                @if ($auth->perfil == 'superadmin')
                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-users"></i></span>
                        <span class="pc-mtext">Usuários</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a href="{{ lnk('admin/usuarios') }}" class="pc-link">Todos os
                                Usuários</a></li>
                        <li class="pc-item"><a href="{{ lnk('admin/usuarios-criar') }}"
                                class="pc-link">Adicionar
                                Usuário</a></li>
                    </ul>
                </li>
                @endif

                  {{-- Gerir Paciente --}}
                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-users"></i></span>
                        <span class="pc-mtext">Gerir Pacientes</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a href="{{ lnk('admin/pacientes') }}" class="pc-link">Todos
                            </a></li>
                        <li class="pc-item"><a href="{{ lnk('admin/paciente-criar') }}"
                                class="pc-link">Cadastrar </a></li>
                    </ul>
                </li>
                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-user-plus"></i></span>
                        <span class="pc-mtext">Gerir Funcionarios</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a href="{{ lnk('admin/funcionarios') }}" class="pc-link">Todos
                            </a>
                        </li>
                        <li class="pc-item"><a href="{{ lnk('admin/funcionario-criar') }}"
                                class="pc-link">Cadastrar
                            </a></li>

                    </ul>
                </li>
                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-users"></i></span>
                        <span class="pc-mtext">Gerir Médicos</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a href="{{ lnk('admin/medicos') }}" class="pc-link">Todos </a>
                        </li>
                        <li class="pc-item"><a href="{{ lnk('admin/medico-criar') }}" class="pc-link">Cadastrar
                            </a></li>
                        <li class="pc-item"><a href="{{ lnk('admin/agenda') }}" class="pc-link">Agenda </a>
                        </li>
                    </ul>
                </li>
              
                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-bed"></i></span>
                        <span class="pc-mtext">Leitos</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a href="{{ lnk('admin/leitos') }}" class="pc-link">Ocupação de
                                Leitos</a></li>
                        <li class="pc-item"><a href="{{ lnk('admin/leito-criar') }}" class="pc-link">Cadastrar
                                Leito</a></li>
                    </ul>
                </li>

                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-stethoscope"></i></span>
                        <span class="pc-mtext">Consultas & Diagnósticos</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a href="{{ lnk('admin/consultas') }}"
                                class="pc-link">Consultas</a>
                        </li>
                        <li class="pc-item"><a href="{{ lnk('admin/diagnosticos') }}"
                                class="pc-link">Diagnósticos</a></li>
                    </ul>
                </li>

                <li class="pc-item">
                    <a href="{{ lnk('admin/relatorios') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-chart-bar"></i></span>
                        <span class="pc-mtext">Relatórios Gerenciais</span>
                    </a>
                </li>

                @endif

                {{-- Menu para Médico  --}}
                @if ($auth->perfil == 'medico')
                <li class="pc-item pc-caption">
                    <label>Área do Médico</label>
                    <i class="ti ti-stethoscope"></i>
                </li>

                <li class="pc-item">
                    <a href="{{ root() }}medico/agenda" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-calendar-event"></i></span>
                        <span class="pc-mtext">Minha Agenda</span>
                    </a>
                </li>

                <li class="pc-item">
                    <a href="{{ root() }}medico/pacientes" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-users"></i></span>
                        <span class="pc-mtext">Meus Pacientes</span>
                    </a>
                </li>

                <li class="pc-item">
                    <a href="{{ root() }}medico/prontuarios" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-notes-medical"></i></span>
                        <span class="pc-mtext">Prontuários</span>
                    </a>
                </li>

                <li class="pc-item">
                    <a href="{{ root() }}medico/exames" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-test-pipe"></i></span>
                        <span class="pc-mtext">Resultados de Exames</span>
                    </a>
                </li>

                <li class="pc-item">
                    <a href="{{ root() }}medico/diagnosticos" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-report-medical"></i></span>
                        <span class="pc-mtext">Diagnósticos</span>
                    </a>
                </li>

                <li class="pc-item">
                    <a href="{{ root() }}medico/consultas" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-stethoscope"></i></span>
                        <span class="pc-mtext">Consultas Agendadas</span>
                    </a>
                </li>

                @endif

                {{-- Menu para Recepcionista --}}
                @if ($auth->perfil == 'recepcionista')
                <li class="pc-item pc-caption">
                    <label>Recepção</label>
                    <i class="ti ti-user-check"></i>
                </li>
                <li class="pc-item">
                    <a href="{{ root() }}recepcao/agenda" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-calendar-event"></i></span>
                        <span class="pc-mtext">Agendamento de Consultas</span>
                    </a>
                </li>
                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-users"></i></span>
                        <span class="pc-mtext">Pacientes</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a href="{{ root() }}recepcao/pacientes" class="pc-link">Buscar
                                Paciente</a></li>
                        <li class="pc-item"><a href="{{ root() }}recepcao/paciente/cadastrar"
                                class="pc-link">Novo Paciente</a></li>
                    </ul>
                </li>
                @endif

                {{-- Menu para Enfermagem --}}
                @if ($auth->perfil == 'enfermeiro')
                <li class="pc-item pc-caption">
                    <label>Área do Enfermeiro</label>
                    <i class="ti ti-nurse"></i>
                </li>

                <li class="pc-item">
                    <a href="{{ root() }}enfermeiro/pacientes" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-users"></i></span>
                        <span class="pc-mtext">Pacientes Internados</span>
                    </a>
                </li>

                <li class="pc-item">
                    <a href="{{ root() }}enfermeiro/leitos" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-bed"></i></span>
                        <span class="pc-mtext">Gestão de Leitos</span>
                    </a>
                </li>

                <li class="pc-item">
                    <a href="{{ root() }}enfermeiro/internacoes" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-hospital"></i></span>
                        <span class="pc-mtext">Internações</span>
                    </a>
                </li>

                <li class="pc-item">
                    <a href="{{ root() }}enfermeiro/exames" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-test-pipe"></i></span>
                        <span class="pc-mtext">Resultados de Exames</span>
                    </a>
                </li>

                <li class="pc-item">
                    <a href="{{ root() }}enfermeiro/medicacoes" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-pill"></i></span>
                        <span class="pc-mtext">Controle de Medicação</span>
                    </a>
                </li>
                @endif


                {{-- Menu para Fisioterapeuta Respiratório --}}
                @if ($auth->perfil == 'fisioterapeuta')
                <li class="pc-item pc-caption">
                    <label>Fisioterapia Respiratória</label>
                    <i class="ti ti-lung"></i>
                </li>
                <li class="pc-item">
                    <a href="{{ root() }}fisio/agenda" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-calendar-time"></i></span>
                        <span class="pc-mtext">Agenda de Sessões</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="{{ root() }}fisio/pacientes" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-users"></i></span>
                        <span class="pc-mtext">Pacientes Atendidos</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="{{ root() }}fisio/evolucao" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-trending-up"></i></span>
                        <span class="pc-mtext">Registro de Evolução</span>
                    </a>
                </li>
                @endif

                {{-- Menu para Técnico de Laboratório --}}
                @if ($auth->perfil == 'laboratorio')
                <li class="pc-item pc-caption">
                    <label>Laboratório</label>
                    <i class="ti ti-flask"></i>
                </li>
                <li class="pc-item">
                    <a href="{{ root() }}laboratorio/coletas" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-virus-search"></i></span>
                        <span class="pc-mtext">Exames a Realizar</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="{{ root() }}laboratorio/resultados" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-file-analytics"></i></span>
                        <span class="pc-mtext">Lançar Resultados</span>
                    </a>
                </li>
                @endif

                {{-- Menu para Paciente --}}
                @if ($auth->perfil == 'paciente')
                <li class="pc-item pc-caption">
                    <label>Área do Paciente</label>
                    <i class="ti ti-user-heart"></i>
                </li>
                <li class="pc-item">
                    <a href="{{ root() }}paciente/consultas" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-calendar-due"></i></span>
                        <span class="pc-mtext">Minhas Consultas</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="{{ root() }}paciente/exames" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-file-text"></i></span>
                        <span class="pc-mtext">Meus Exames</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="{{ root() }}paciente/prescricoes" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-pill"></i></span>
                        <span class="pc-mtext">Minhas Prescrições</span>
                    </a>
                </li>
                @endif


                <li class="pc-item pc-caption">
                    <label>Conta</label>
                    <i class="ti ti-user-circle"></i>
                </li>
                <li class="pc-item">
                    <a href="{{ root() }}meu-perfil" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-user"></i></span>
                        <span class="pc-mtext">Meu Perfil</span>
                    </a>
                </li>
                <li class="pc-item">
                    <button type="button" class="pc-link btn" onclick="sair()">
                        <span class="pc-micon"><i class="ti ti-logout"></i></span>
                        <span class="pc-mtext">Sair</span>
                    </button>
                    <!--  <a href="{{ root() }}logout" class="pc-link">
            <span class="pc-micon"><i class="ti ti-logout"></i></span>
            <span class="pc-mtext">Sair</span>
          </a> -->
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- [ Sidebar Menu ] end -->

<!-- [ Header Topbar ] start -->
<header class="pc-header">
    <div class="header-wrapper">
        <!-- [Mobile Media Block] start -->
        <div class="me-auto pc-mob-drp">
            <ul class="list-unstyled">
                <!-- ======= Menu collapse Icon ===== -->
                <li class="pc-h-item pc-sidebar-collapse">
                    <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
                <li class="pc-h-item pc-sidebar-popup">
                    <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
                <li class="dropdown pc-h-item d-inline-flex d-md-none">
                    <a class="pc-head-link dropdown-toggle arrow-none m-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="ti ti-search"></i>
                    </a>
                    <div class="dropdown-menu pc-h-dropdown drp-search">
                        <form class="px-3">
                            <div class="form-group mb-0 d-flex align-items-center">
                                <i data-feather="search"></i>
                                <input type="search" class="form-control border-0 shadow-none"
                                    placeholder="Search here. . .">
                            </div>
                        </form>
                    </div>
                </li>
                <li class="pc-h-item d-none d-md-inline-flex">
                    <form class="header-search">
                        <i data-feather="search" class="icon-search"></i>
                        <input type="search" class="form-control" placeholder="Search here. . .">
                    </form>
                </li>
            </ul>
        </div>
        <!-- [Mobile Media Block end] -->
        <div class="ms-auto">
            <ul class="list-unstyled">

                <li class="dropdown pc-h-item header-user-profile">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0 d-flex align-items-center gap-2"
                        data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                        data-bs-auto-close="outside" aria-expanded="false">

                        <img src="https://ui-avatars.com/api/?name={{ urlencode($auth->nome) }}&background=0D8ABC&color=fff&size=40"
                            alt="Avatar" class="rounded-circle shadow" width="35" height="35">

                        <span class="fw-semibold text-dark">
                            {{ $auth->nome }}
                        </span>

                    </a>


                    <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                        <div class="dropdown-header">
                            <div class="d-flex mb-1">
                                <div class="flex-shrink-0">


                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">
                                        {{ $auth->nome }}
                                    </h6>
                                    <span>
                                        {{ ucfirst($auth->perfil) }}
                                    </span>
                                </div>

                                <button type="button" class="btn pc-head-link bg-transparen" onclick="sair()">
                                    <span class="pc-micon"><i class="ti ti-power text-danger"></i></i></span>
                                    <span class="pc-mtext">Sair</span>
                                </button>
                            </div>
                        </div>
                        <ul class="nav drp-tabs nav-fill nav-tabs" id="mydrpTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="drp-t1" data-bs-toggle="tab"
                                    data-bs-target="#drp-tab-1" type="button" role="tab" aria-controls="drp-tab-1"
                                    aria-selected="true"><i class="ti ti-user"></i> Perfil</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="drp-t2" data-bs-toggle="tab" data-bs-target="#drp-tab-2"
                                    type="button" role="tab" aria-controls="drp-tab-2" aria-selected="false"><i
                                        class="ti ti-settings"></i> Configurações</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="mysrpTabContent">
                            <div class="tab-pane fade show active" id="drp-tab-1" role="tabpanel"
                                aria-labelledby="drp-t1" tabindex="0">
                                <a href="{{ root() }}profile-edit" class=" dropdown-item">
                                    <i class="ti ti-edit-circle"></i>
                                    <span>Editar Perfil</span>
                                </a>
                                <a href="{{ root() }}meu-perfil" class="dropdown-item">
                                    <i class="ti ti-user"></i>
                                    <span>Ver Perfil</span>
                                </a>
                                <a href="#!" class="dropdown-item">
                                    <i class="ti ti-clipboard-list"></i>
                                    <span>Perfil Social</span>
                                </a>

                            </div>
                            <div class="tab-pane fade" id="drp-tab-2" role="tabpanel" aria-labelledby="drp-t2"
                                tabindex="0">
                                <a href="#!" class="dropdown-item">
                                    <i class="ti ti-help"></i>
                                    <span>Support</span>
                                </a>
                                <a href="#!" class="dropdown-item">
                                    <i class="ti ti-user"></i>
                                    <span>Account Settings</span>
                                </a>
                                <a href="#!" class="dropdown-item">
                                    <i class="ti ti-lock"></i>
                                    <span>Privacy Center</span>
                                </a>
                                <a href="#!" class="dropdown-item">
                                    <i class="ti ti-messages"></i>
                                    <span>Feedback</span>
                                </a>
                                <a href="#!" class="dropdown-item">
                                    <i class="ti ti-list"></i>
                                    <span>History</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>
<!-- [ Header ] end -->