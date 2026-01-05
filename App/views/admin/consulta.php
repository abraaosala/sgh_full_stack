 <!-- CSS Incorporado -->
 <link rel="stylesheet" href="<?= asset("css/parts/consult-admin.css") ?>">
 <div class="pc-container" id="medico_agenda">
     <div class="pc-content">
         <div class="container">
             <header class="header">
                 <h1>Agenda de Consultas</h1>

                 <p>Visualize e gerencie os próximos agendamentos.</p>

                 <button type="button" class="btn btn-primary" id="btnCadastrar">Nova Consulta</button>
                 <button type="button" class="btn btn-danger" id="btnZerar">Zerar a Consulta</button>

             </header>
             <input type="search" id="search-input" placeholder="Pesquisar por paciente ou especialidade...">

             <div class="filter-controls">
                 <input type="radio" id="filter-todos" name="status-filter" value="Todos" checked>
                 <label for="filter-todos">Todos</label>

                 <input type="radio" id="filter-confirmado" name="status-filter" value="Confirmado">
                 <label for="filter-confirmado">Confirmados</label>

                 <input type="radio" id="filter-realizado" name="status-filter" value="Realizado">
                 <label for="filter-realizado">Realizados</label>

                 <input type="radio" id="filter-cancelado" name="status-filter" value="Cancelado">
                 <label for="filter-cancelado">Cancelados</label>
             </div>

             <div id="timeline-container" class="timeline">
                 <!-- A timeline será gerada aqui pelo JavaScript -->
             </div>

             <div id="no-results" class="no-results" style="display: none;">
                 Nenhuma consulta encontrada.
             </div>
         </div>
     </div>
 </div>

 <!-- JavaScript Incorporado -->
 <script src="<?= asset('js/parts/consult-admin.js') ?>"></script>


 <!-- Modal de Add  Consultas-->
 <div class="modal fade" id="VisulizarConsultaModal" tabindex="-1" aria-labelledby="VisulizarConsultaModalLabel"
     aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
             <div class="modal-header">
                 <h1 class="modal-title fs-5" id="VisulizarConsultaModalLabel" style="display: block;">Visualizar A
                     Consulta do Paciante #<span id="consulta-pid"></span><span id="title-ver"></span></h1>
                 <h1 class="modal-title fs-5" id="editarModalLabel" style="display: none;">Editar Evento</h1>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 <!-- Visualizar  -->
                 <div id="consulta-info">

                     <div class="mb-3">
                         <label class="form-label"><strong>Paciente:</strong></label>
                         <span id="consulta-paciente"></span>
                     </div>
                     <div class="mb-3">
                         <label class="form-label"><strong>Data:</strong></label>
                         <span id="consulta-data"></span>
                     </div>
                     <div class="mb-3">
                         <label class="form-label"><strong>Hora:</strong></label>
                         <span id="consulta-hora"></span>
                     </div>
                     <div class="mb-3">
                         <label class="form-label"><strong>Estado:</strong></label>
                         <span id="consulta-status"></span>
                     </div>

                     <!-- </div> -->
                 </div>

             </div>
             <div class="modal-footer">
                 <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button> -->
             </div>
         </div>
     </div>
 </div>
 <div class="modal fade" id="cadConsultaModal" tabindex="-1" aria-labelledby="cadConsultaModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered modal-lg">
         <div class="modal-content">
             <div class="modal-header">
                 <h1 class="modal-title fs-5" id="cadConsultaModalLabel" style="display: block;">Cadastro A Consulta do
                     Paciante #<span id="consulta-pid"></span><span id="title-ver"></span></h1>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 <!-- Visualizar  -->
                 <div id="consulta-info">

                     <?php include iViewForm('consulta') ?>

                     <!-- </div> -->
                 </div>

             </div>
             <div class="modal-footer">
                 <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button> -->
             </div>
         </div>
     </div>
 </div>

 <!-- 
                       <p>${consulta.especialidade} - <span style="font-weight: bold;">${consulta.status}</span></p>

 -->