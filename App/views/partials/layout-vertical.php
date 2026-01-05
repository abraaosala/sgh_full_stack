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
            <a href="<?php echo root(); ?>dashboard" class="b-brand text-primary wid-135">
                <!-- ========   Altere seu logo aqui   ============ -->
                <img src="<?php echo asset('img/logo.png'); ?>" class="img-fluid" alt="logo">
            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                <li class="pc-item">

                    <?php if ($perfil === 'admin' || $perfil == 'superadmin'): ?>
                    <a href="<?php echo root(); ?>admin/dashboard" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                        <span class="pc-mtext">Dashboard</span>
                    </a>
                    <?php elseif ($perfil === 'medico'): ?>
                    <a href="<?php echo root().$perfil;?>/home" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                        <span class="pc-mtext">Dashboard</span>
                        <?php else: ?>
                        <a href="<?php echo root(); ?>dashboard" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                            <span class="pc-mtext">Dashboard</span>
                            <?php endif ?>

                        </a>
                        <? ?>

                </li>
                <?php // Refacturando por swift switch      
        ?>
                <?php if ($auth->perfil == 'superadmin') { ?>
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
                        <li class="pc-item"><a href="<?php echo root(); ?>superadmin/config/geral"
                                class="pc-link">Parâmetros Gerais</a></li>
                        <li class="pc-item"><a href="<?php echo root(); ?>superadmin/config/integracoes"
                                class="pc-link">Integrações e APIs</a></li>
                    </ul>
                </li>
                <li class="pc-item">
                    <a href="<?php echo root(); ?>superadmin/logs" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-file-text"></i></span>
                        <span class="pc-mtext">Logs de Auditoria</span>
                    </a>
                </li>

                <?php } ?>


                <?php // --- SEÇÃO DE ADMINISTRAÇÃO (Admin e Super Admin) --- ?>
                <?php // Funções de gerenciamento do dia a dia acessíveis por ambos. ?>
                <?php // Apenas o superadmin pode ver estas opções críticas.   ?>
                <?php if ($auth->perfil == 'superadmin' || $auth->perfil == 'admin') { ?>

                <li class="pc-item pc-caption">
                    <label>Administração</label>
                    <i class="ti ti-settings"></i>
                </li>

                <?php if ($auth->perfil == 'superadmin') { ?>
                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-users"></i></span>
                        <span class="pc-mtext">Usuários</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a href="<?php echo lnk('admin/usuarios'); ?>" class="pc-link">Todos os
                                Usuários</a></li>
                        <li class="pc-item"><a href="<?php echo lnk('admin/usuarios-criar'); ?>"
                                class="pc-link">Adicionar
                                Usuário</a></li>
                    </ul>
                </li>
                <?php } ?>

                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-user-plus"></i></span>
                        <span class="pc-mtext">Gerir Funcionarios</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a href="<?php echo lnk("admin/funcionarios"); ?>" class="pc-link">Todos
                            </a>
                        </li>
                        <li class="pc-item"><a href="<?php echo lnk('admin/funcionario-criar'); ?>"
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
                        <li class="pc-item"><a href="<?php echo lnk('admin/medicos'); ?>" class="pc-link">Todos </a>
                        </li>
                        <li class="pc-item"><a href="<?php echo lnk('admin/medico-criar'); ?>" class="pc-link">Cadastrar
                            </a></li>
                        <li class="pc-item"><a href="<?php echo lnk('admin/agenda'); ?>" class="pc-link">Agenda </a>
                        </li>
                    </ul>
                </li>

                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-users"></i></span>
                        <span class="pc-mtext">Gerir Pacientes</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a href="<?php echo lnk('admin/pacientes'); ?>" class="pc-link">Todos
                            </a></li>
                        <li class="pc-item"><a href="<?php echo lnk('admin/paciente-criar'); ?>"
                                class="pc-link">Cadastrar </a></li>
                    </ul>
                </li>

                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-bed"></i></span>
                        <span class="pc-mtext">Leitos</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a href="<?php echo lnk('admin/leitos'); ?>" class="pc-link">Ocupação de
                                Leitos</a></li>
                        <li class="pc-item"><a href="<?php echo lnk('admin/leito-criar'); ?>" class="pc-link">Cadastrar
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
                        <li class="pc-item"><a href="<?php echo lnk('admin/consultas'); ?>"
                                class="pc-link">Consultas</a>
                        </li>
                        <li class="pc-item"><a href="<?php echo lnk('admin/diagnosticos'); ?>"
                                class="pc-link">Diagnósticos</a></li>
                    </ul>
                </li>

                <li class="pc-item">
                    <a href="<?php echo lnk('admin/relatorios'); ?>" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-chart-bar"></i></span>
                        <span class="pc-mtext">Relatórios Gerenciais</span>
                    </a>
                </li>

                <?php } ?>

                <?php // Menu para Médico  ?>
                <?php if ($auth->perfil == 'medico') { ?>
                <li class="pc-item pc-caption">
                    <label>Área do Médico</label>
                    <i class="ti ti-stethoscope"></i>
                </li>

                <li class="pc-item">
                    <a href="<?php echo root(); ?>medico/agenda" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-calendar-event"></i></span>
                        <span class="pc-mtext">Minha Agenda</span>
                    </a>
                </li>

                <li class="pc-item">
                    <a href="<?php echo root(); ?>medico/pacientes" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-users"></i></span>
                        <span class="pc-mtext">Meus Pacientes</span>
                    </a>
                </li>

                <li class="pc-item">
                    <a href="<?php echo root(); ?>medico/prontuarios" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-notes-medical"></i></span>
                        <span class="pc-mtext">Prontuários</span>
                    </a>
                </li>

                <li class="pc-item">
                    <a href="<?php echo root(); ?>medico/exames" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-test-pipe"></i></span>
                        <span class="pc-mtext">Resultados de Exames</span>
                    </a>
                </li>

                <li class="pc-item">
                    <a href="<?php echo root(); ?>medico/diagnosticos" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-report-medical"></i></span>
                        <span class="pc-mtext">Diagnósticos</span>
                    </a>
                </li>

                <li class="pc-item">
                    <a href="<?php echo root(); ?>medico/consultas" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-stethoscope"></i></span>
                        <span class="pc-mtext">Consultas Agendadas</span>
                    </a>
                </li>

                <?php } ?>

                <?php // Menu para Recepcionista 
        ?>
                <?php if ($auth->perfil == 'recepcionista') { ?>
                <li class="pc-item pc-caption">
                    <label>Recepção</label>
                    <i class="ti ti-user-check"></i>
                </li>
                <li class="pc-item">
                    <a href="<?php echo root(); ?>recepcao/agenda" class="pc-link">
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
                        <li class="pc-item"><a href="<?php echo root(); ?>recepcao/pacientes" class="pc-link">Buscar
                                Paciente</a></li>
                        <li class="pc-item"><a href="<?php echo root(); ?>recepcao/paciente/cadastrar"
                                class="pc-link">Novo Paciente</a></li>
                    </ul>
                </li>
                <?php } ?>

                <?php // Menu para Enfermagem 
        ?>
                <?php if ($auth->perfil == 'enfermeiro') { ?>
                <li class="pc-item pc-caption">
                    <label>Área do Enfermeiro</label>
                    <i class="ti ti-nurse"></i>
                </li>

                <li class="pc-item">
                    <a href="<?php echo root(); ?>enfermeiro/pacientes" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-users"></i></span>
                        <span class="pc-mtext">Pacientes Internados</span>
                    </a>
                </li>

                <li class="pc-item">
                    <a href="<?php echo root(); ?>enfermeiro/leitos" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-bed"></i></span>
                        <span class="pc-mtext">Gestão de Leitos</span>
                    </a>
                </li>

                <li class="pc-item">
                    <a href="<?php echo root(); ?>enfermeiro/internacoes" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-hospital"></i></span>
                        <span class="pc-mtext">Internações</span>
                    </a>
                </li>

                <li class="pc-item">
                    <a href="<?php echo root(); ?>enfermeiro/exames" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-test-pipe"></i></span>
                        <span class="pc-mtext">Resultados de Exames</span>
                    </a>
                </li>

                <li class="pc-item">
                    <a href="<?php echo root(); ?>enfermeiro/medicacoes" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-pill"></i></span>
                        <span class="pc-mtext">Controle de Medicação</span>
                    </a>
                </li>
                <?php } ?>


                <?php // Menu para Fisioterapeuta Respiratório 
        ?>
                <?php if ($auth->perfil == 'fisioterapeuta') { ?>
                <li class="pc-item pc-caption">
                    <label>Fisioterapia Respiratória</label>
                    <i class="ti ti-lung"></i>
                </li>
                <li class="pc-item">
                    <a href="<?php echo root(); ?>fisio/agenda" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-calendar-time"></i></span>
                        <span class="pc-mtext">Agenda de Sessões</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="<?php echo root(); ?>fisio/pacientes" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-users"></i></span>
                        <span class="pc-mtext">Pacientes Atendidos</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="<?php echo root(); ?>fisio/evolucao" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-trending-up"></i></span>
                        <span class="pc-mtext">Registro de Evolução</span>
                    </a>
                </li>
                <?php } ?>

                <?php // Menu para Técnico de Laboratório 
        ?>
                <?php if ($auth->perfil == 'laboratorio') { ?>
                <li class="pc-item pc-caption">
                    <label>Laboratório</label>
                    <i class="ti ti-flask"></i>
                </li>
                <li class="pc-item">
                    <a href="<?php echo root(); ?>laboratorio/coletas" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-virus-search"></i></span>
                        <span class="pc-mtext">Exames a Realizar</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="<?php echo root(); ?>laboratorio/resultados" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-file-analytics"></i></span>
                        <span class="pc-mtext">Lançar Resultados</span>
                    </a>
                </li>
                <?php } ?>

                <?php // Menu para Paciente 
        ?>
                <?php if ($auth->perfil == 'paciente') { ?>
                <li class="pc-item pc-caption">
                    <label>Área do Paciente</label>
                    <i class="ti ti-user-heart"></i>
                </li>
                <li class="pc-item">
                    <a href="<?php echo root(); ?>paciente/consultas" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-calendar-due"></i></span>
                        <span class="pc-mtext">Minhas Consultas</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="<?php echo root(); ?>paciente/exames" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-file-text"></i></span>
                        <span class="pc-mtext">Meus Exames</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="<?php echo root(); ?>paciente/prescricoes" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-pill"></i></span>
                        <span class="pc-mtext">Minhas Prescrições</span>
                    </a>
                </li>
                <?php } ?>


                <li class="pc-item pc-caption">
                    <label>Conta</label>
                    <i class="ti ti-user-circle"></i>
                </li>
                <li class="pc-item">
                    <a href="<?php echo root(); ?>meu-perfil" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-user"></i></span>
                        <span class="pc-mtext">Meu Perfil</span>
                    </a>
                </li>
                <li class="pc-item">
                    <button type="button" class="pc-link btn" onclick="sair()">
                        <span class="pc-micon"><i class="ti ti-logout"></i></span>
                        <span class="pc-mtext">Sair</span>
                    </button>
                    <!--  <a href="<?php echo root(); ?>logout" class="pc-link">
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
                <!-- <li class="dropdown pc-h-item">
          <a
            class="pc-head-link dropdown-toggle arrow-none me-0"
            data-bs-toggle="dropdown"
            href="#"
            role="button"
            aria-haspopup="false"
            aria-expanded="false">
            <i class="ti ti-mail"></i>
          </a>
          <div class="dropdown-menu dropdown-notification dropdown-menu-end pc-h-dropdown">
            <div class="dropdown-header d-flex align-items-center justify-content-between">
              <h5 class="m-0">Message</h5>
              <a href="#!" class="pc-head-link bg-transparent"><i class="ti ti-x text-danger"></i></a>
            </div>
            <div class="dropdown-divider"></div>
            <div class="dropdown-header px-0 text-wrap header-notification-scroll position-relative" style="max-height: calc(100vh - 215px)">
              <div class="list-group list-group-flush w-100">
                <a class="list-group-item list-group-item-action">
                  <div class="d-flex">
                    <div class="flex-shrink-0">
                      <img src="../assets/images/user/avatar-2.jpg" alt="user-image" class="user-avtar">
                    </div>
                    <div class="flex-grow-1 ms-1">
                      <span class="float-end text-muted">3:00 AM</span>
                      <p class="text-body mb-1">It's <b>Cristina danny's</b> birthday today.</p>
                      <span class="text-muted">2 min ago</span>
                    </div>
                  </div>
                </a>
                <a class="list-group-item list-group-item-action">
                  <div class="d-flex">
                    <div class="flex-shrink-0">
                      <img src="../assets/images/user/avatar-1.jpg" alt="user-image" class="user-avtar">
                    </div>
                    <div class="flex-grow-1 ms-1">
                      <span class="float-end text-muted">6:00 PM</span>
                      <p class="text-body mb-1"><b>Aida Burg</b> commented your post.</p>
                      <span class="text-muted">5 August</span>
                    </div>
                  </div>
                </a>
                <a class="list-group-item list-group-item-action">
                  <div class="d-flex">
                    <div class="flex-shrink-0">
                      <img src="../assets/images/user/avatar-3.jpg" alt="user-image" class="user-avtar">
                    </div>
                    <div class="flex-grow-1 ms-1">
                      <span class="float-end text-muted">2:45 PM</span>
                      <p class="text-body mb-1"><b>There was a failure to your setup.</b></p>
                      <span class="text-muted">7 hours ago</span>
                    </div>
                  </div>
                </a>
                <a class="list-group-item list-group-item-action">
                  <div class="d-flex">
                    <div class="flex-shrink-0">
                      <img src="../assets/images/user/avatar-4.jpg" alt="user-image" class="user-avtar">
                    </div>
                    <div class="flex-grow-1 ms-1">
                      <span class="float-end text-muted">9:10 PM</span>
                      <p class="text-body mb-1"><b>Cristina Danny </b> invited to join <b> Meeting.</b></p>
                      <span class="text-muted">Daily scrum meeting time</span>
                    </div>
                  </div>
                </a>
              </div>
            </div>
            <div class="dropdown-divider"></div>
            <div class="text-center py-2">
              <a href="#!" class="link-primary">View all</a>
            </div>
          </div>
        </li> -->
                <li class="dropdown pc-h-item header-user-profile">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0 d-flex align-items-center gap-2"
                        data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                        data-bs-auto-close="outside" aria-expanded="false">

                        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode((string) $auth->nome); ?>&background=0D8ABC&color=fff&size=40"
                            alt="Avatar" class="rounded-circle shadow" width="35" height="35">

                        <span class="fw-semibold text-dark">
                            <?php echo $auth->nome; ?>
                        </span>

                    </a>


                    <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                        <div class="dropdown-header">
                            <div class="d-flex mb-1">
                                <div class="flex-shrink-0">
                                    <!-- <img src="../assets/images/user/avatar-2.jpg" alt="user-image" class="user-avtar wid-35"> -->

                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">
                                        <?php echo $auth->nome; ?>
                                    </h6>
                                    <span>
                                        <?php echo ucfirst((string) $auth->perfil); ?>
                                    </span>
                                </div>
                                <!--  <a href="" class="pc-head-link bg-transparent"><i class="ti ti-power text-danger"></i></a> -->
                                <!-- <form action="<?php echo root(); ?>logout" method="post">
                  <button type="submit" class="pc-head-link bg-transparent"><i class="ti ti-power text-danger"></i></button>
                </form> -->
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
                                <a href="<?php echo root(); ?>profile-edit" class=" dropdown-item">
                                    <i class="ti ti-edit-circle"></i>
                                    <span>Editar Perfil</span>
                                </a>
                                <a href="<?php echo root(); ?>meu-perfil" class="dropdown-item">
                                    <i class="ti ti-user"></i>
                                    <span>Ver Perfil</span>
                                </a>
                                <a href="#!" class="dropdown-item">
                                    <i class="ti ti-clipboard-list"></i>
                                    <span>Perfil Social</span>
                                </a>
                                <!--  <a href="#!" class="dropdown-item">
                  <i class="ti ti-wallet"></i>
                  <span>Billing</span>
                </a> 
               <a href="#!" class="dropdown-item">
                  <i class="ti ti-power"></i>
                  <span>Logout</span>
                </a> -->
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