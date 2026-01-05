<div class="pc-container" id="medico_agenda">
    <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <!-- ... seu breadcrumb ... -->
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <h2 class="page-header-title">Minha Agenda</h2>

        <div id='calendar'></div>
    </div>
</div>

<script>
function fullcalender() {
    const id = 1;

    var calendarEl = document.getElementById('calendar');
    const apiUrl = `http://sgh.test/api/agenda/medico?id=1`;
    var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'timeGridWeek,dayGridMonth,list'
        },
        initialView: 'list',
        locale: 'pt',
        // initialDate: '2023-01-12',
        navLinks: true, // can click day/week names to navigate views
        selectable: true,
        themeSystem: 'bootstrap5',
        selectMirror: true,
        select: function(arg) {
            const modal = new bootstrap.Modal(document.getElementById('cadastrarModal'));

            // Preenche os inputs com as datas selecionadas
            document.getElementById('cadastrar-medico-entrada').value = arg.start ? arg.start
                .toISOString().slice(0, 16) : '';
            document.getElementById('cadastrar-medico-saida').value = arg.end ? arg.end
                .toISOString().slice(0, 16) : '';


            modal.show();


            // Função para adicionar um evento ao clicar e arrastar
            // var title = prompt('Event Title:');
            if (title) {
                calendar.addEvent({
                    title: title,
                    start: arg.start,
                    end: arg.end,
                    allDay: arg.allDay
                });
            }
            calendar.unselect()
        },
        eventClick: function(arg) {
            const props = arg.event.extendedProps;
            const event = arg.event;


            const model = new bootstrap.Modal(document.getElementById('visualizarModal'));
            model.show();
            // alert('Clicado');
            /* if (confirm('Are you sure you want to delete this event?')) {
              arg.event.remove()
            } */
            // Exibir informações do médico
            document.getElementById('medico-turno').innerText = event.title;
            // document.getElementById('medico-nome').innerText = props.medico;
            // document.getElementById('medico-especialidade').innerText = props.especialidade;
            document.getElementById('medico-entrada').innerText = event.start ? event.start
                .toLocaleString() : '';
            document.getElementById('medico-saida').innerText = event.end ? event.end
                .toLocaleString() : '';
            document.getElementById('medico-ordem').innerText = props.numero_ordem;
            // document.getElementById('medico-contato').innerText = props.telefone;



        },
        editable: true,
        dayMaxEvents: true, // allow "more" link when too many events
        events: apiUrl
    });

    calendar.render();

}
document.addEventListener('DOMContentLoaded', fullcalender);
</script>


<!--  -->
<div class="modal fade" id="visualizarModal" tabindex="-1" aria-labelledby="visualizarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="visualizarModalLabel" style="display: block;">Visualizar Evento
                    - <span id="medico-turno"></span>

                </h1>
                <h1 class="modal-title fs-5" id="editarModalLabel" style="display: none;">Editar Evento</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Visualizar  -->
                <div id="medico-info">

                    <!-- <div class="mb-3">
                        <label class="form-label"><strong>Turno:</strong></label>
                        <span id="medico-turno"></span>
                    </div> -->
                    <div class="mb-3">
                        <label class="form-label"><strong>Entrada:</strong></label>
                        <span id="medico-entrada"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Saída:</strong></label>
                        <span id="medico-saida"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Numero da Ordem:</strong></label>
                        <strong><span id="medico-ordem"></span></strong>
                    </div>
                    <!-- </div> -->
                </div>

                <!-- Fim -->
                <!-- Editar -->

                <!-- Fim -->




            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button> -->
            </div>
        </div>
    </div>
</div>
<!--  -->