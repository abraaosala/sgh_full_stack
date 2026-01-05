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
      <li class="pc-item"><a href="<?php echo root(); ?>superadmin/config/geral" class="pc-link">Parâmetros Gerais</a></li>
      <li class="pc-item"><a href="<?php echo root(); ?>superadmin/config/integracoes" class="pc-link">Integrações e APIs</a></li>
    </ul>
  </li>
  <li class="pc-item">
    <a href="<?php echo root(); ?>superadmin/logs" class="pc-link">
      <span class="pc-micon"><i class="ti ti-file-text"></i></span>
      <span class="pc-mtext">Logs de Auditoria</span>
    </a>
  </li>

<?php } ?>


<?php // --- SEÇÃO DE ADMINISTRAÇÃO (Admin e Super Admin) --- 
?>
<?php // Funções de gerenciamento do dia a dia acessíveis por ambos. 
?>
<?php // Apenas o superadmin pode ver estas opções críticas.  
?>
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
        <li class="pc-item"><a href="<?php echo root(); ?>admin/usuarios" class="pc-link">Todos os Usuários</a></li>
        <li class="pc-item"><a href="<?php echo root(); ?>admin/usuario/criar" class="pc-link">Adicionar Usuário</a></li>
      </ul>
    </li>
  <?php } ?>

  <li class="pc-item pc-hasmenu">
    <a href="#!" class="pc-link">
      <span class="pc-micon"><i class="ti ti-user-plus"></i></span>
      <span class="pc-mtext">Médicos</span>
      <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
    </a>
    <ul class="pc-submenu">
      <li class="pc-item"><a href="<?php echo root(); ?>admin/medicos" class="pc-link">Todos os Médicos</a></li>
      <li class="pc-item"><a href="<?php echo root(); ?>admin/medico-criar" class="pc-link">Cadastrar Médico</a></li>
    </ul>
  </li>

  <li class="pc-item pc-hasmenu">
    <a href="#!" class="pc-link">
      <span class="pc-micon"><i class="ti ti-user-plus"></i></span>
      <span class="pc-mtext">Pacientes</span>
      <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
    </a>
    <ul class="pc-submenu">
      <li class="pc-item"><a href="<?php echo root(); ?>admin/pacientes" class="pc-link">Todos os Pacientes</a></li>
      <li class="pc-item"><a href="<?php echo root(); ?>admin/paciente-criar" class="pc-link">Cadastrar Paciente</a></li>
    </ul>
  </li>

  <li class="pc-item pc-hasmenu">
    <a href="#!" class="pc-link">
      <span class="pc-micon"><i class="ti ti-bed"></i></span>
      <span class="pc-mtext">Leitos</span>
      <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
    </a>
    <ul class="pc-submenu">
      <li class="pc-item"><a href="<?php echo root(); ?>admin/leitos" class="pc-link">Ocupação de Leitos</a></li>
      <li class="pc-item"><a href="<?php echo root(); ?>admin/leito-criar" class="pc-link">Cadastrar Leito</a></li>
    </ul>
  </li>

  <li class="pc-item pc-hasmenu">
    <a href="#!" class="pc-link">
      <span class="pc-micon"><i class="ti ti-stethoscope"></i></span>
      <span class="pc-mtext">Consultas & Diagnósticos</span>
      <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
    </a>
    <ul class="pc-submenu">
      <li class="pc-item"><a href="<?php echo root(); ?>admin/consultas" class="pc-link">Consultas</a></li>
      <li class="pc-item"><a href="<?php echo root(); ?>admin/diagnosticos" class="pc-link">Diagnósticos</a></li>
    </ul>
  </li>

  <li class="pc-item">
    <a href="<?php echo root(); ?>admin/relatorios" class="pc-link">
      <span class="pc-micon"><i class="ti ti-chart-bar"></i></span>
      <span class="pc-mtext">Relatórios Gerenciais</span>
    </a>
  </li>

<?php } ?>

<?php // Menu para Médico  
?>
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
      <li class="pc-item"><a href="<?php echo root(); ?>recepcao/pacientes" class="pc-link">Buscar Paciente</a></li>
      <li class="pc-item"><a href="<?php echo root(); ?>recepcao/paciente/cadastrar" class="pc-link">Novo Paciente</a></li>
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