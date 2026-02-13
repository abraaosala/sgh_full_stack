document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var base_api = window.APP_URL || '/';
    var url_api = base_api + 'api/agenda/medico';

    var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'timeGridWeek,dayGridMonth,multiMonthYear'
            // right: 'timeGridDay,timeGridWeek,dayGridMonth,list'
        },
        initialView: 'dayGridMonth',
        locale: 'pt-br',
        // initialDate: '2023-01-12',
        navLinks: true, // can click day/week names to navigate views
        selectable: true,
        themeSystem: 'bootstrap5',
        selectMirror: true,
        select: function (arg) {
            const modal = new bootstrap.Modal(document.getElementById('cadastrarModal'));

            // Preenche os inputs com as datas selecionadas
            document.getElementById('cadastrar-medico-entrada').value = arg.start ? arg.start
                .toISOString().slice(0, 16) : '';
            document.getElementById('cadastrar-medico-saida').value = arg.end ? arg.end
                .toISOString().slice(0, 16) : '';


            modal.show();

            calendar.unselect()
        },
        eventClick: function (arg) {
            const props = arg.event.extendedProps;
            const event = arg.event;
            const model = new bootstrap.Modal(document.getElementById('visualizarModal'));
            // Exibir informações do médico
            document.getElementById('title-ver').innerText = event.title;
            document.getElementById('medico-nome').innerText = props.medico;
            document.getElementById('medico-especialidade').innerText = props.especialidade;
            document.getElementById('medico-entrada').innerText = event.start ? event.start
                .toLocaleString() : '';
            document.getElementById('medico-saida').innerText = event.end ? event.end
                .toLocaleString() : '';
            document.getElementById('medico-ordem').innerText = props.numero_ordem;
            document.getElementById('medico-contato').innerText = props.telefone;

            //atribuir valor no input para update
            // document.getElementById('medico-nome-input').value = props.medico;
            document.getElementById('medico-titulo-input').value = event.title;
            // document.getElementById('medico-especialidade-input').value = props.especialidade;
            document.getElementById('medico-entrada-input').value = event.start ? event.start
                .toISOString().slice(0, 16) : '';
            document.getElementById('medico-id-input').value = event.id;
            document.getElementById('medico-saida-input').value = event.end ? event.end
                .toISOString().slice(0, 16) : '';
            // document.getElementById('medico-ordem-input').value = props.numero_ordem;
            // document.getElementById('medico-contato-input').value = props.telefone; 
            document.getElementById('eliminar-id-input').value = event.id;



            model.show();

        },
        editable: true,
        dayMaxEvents: true, // allow "more" link when too many events
        events: url_api
    });

    calendar.render();


    document.getElementById('editar-btn').addEventListener('click', function () {
        // alert('Editar evento');
        // Alternar entre visualizar e editar
        document.getElementById('medico-info').style.display = 'none';
        document.getElementById('visualizarModalLabel').style.display = 'none';
        document.getElementById('editarModalLabel').style.display = 'block';
        document.getElementById('medico-edit').style.display = 'block';
    });


    document.getElementById('first-btn').addEventListener('click', function () {
        document.getElementById('medico-info').style.display = 'block';
        document.getElementById('visualizarModalLabel').style.display = 'block';
        document.getElementById('editarModalLabel').style.display = 'none';
        document.getElementById('medico-edit').style.display = 'none';
    });

    //cadastrar evento
    const btnCadastrar = document.getElementById('cadastrar-evento-form');


    if (btnCadastrar) {
        btnCadastrar.addEventListener('submit', async function (event) {
            event.preventDefault();


            const formData = new FormData(btnCadastrar);
            const data = Object.fromEntries(
                formData); // Converte os dados do formulário para um objeto
            // console.log(data);


            const response = await fetch(base_api + 'api/agenda/medico/store', {
                method: 'post',
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(data)
                // body: data
            });

            const res = await response.json();



            if (!res.status) {

                document.getElementById('msg-cad').innerHTML =
                    ` <div class="alert alert-danger text-center" role="alert">
        ${res.msg}
        </div>`;
            } else {
                document.getElementById('msg-cad').innerHTML = '';

                // Fecha o modal
                const modal = bootstrap.Modal.getInstance(document.getElementById(
                    "cadastrarModal"));
                modal.hide();

                Swal.fire({
                    title: 'Escala de Trabalho',
                    text: res.msg,
                    icon: 'success',
                    // width: "350px",
                    // heght: '140px',
                    padding: "1.5rem",
                    /*  customClass: {
                       popup: "small-sweetalert",
                       confirmButton: "btn-primary",
                     }, */
                }).then(() => {
                    // Recarregar a página após o SweetAlert ser fechado
                    location.reload();
                });




            }
            console.log(res);

        });
    }

    const btnAtualizar = document.getElementById('medico-edit-form');

    if (btnAtualizar) {
        btnAtualizar.addEventListener('submit', async function (event) {
            event.preventDefault();
            // console.log('Submetido')
            const dataForm = new FormData(btnAtualizar);
            const data = Object.fromEntries(dataForm);

            const response = await fetch(base_api + 'api/agenda/medico/save', {
                method: 'put',
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(data)
            });

            const res = await response.json();
            // console.log(res); 
            if (res.status) {
                document.getElementById('msg-edit').innerHTML = '';
                // Fecha o modal
                const modal = bootstrap.Modal.getInstance(document.getElementById(
                    "visualizarModal"));
                modal.hide();

                // Swal.fire
                Swal.fire({
                    title: 'Escala de Trabalho',
                    text: res.msg,
                    icon: 'success',
                    /* width: "350px",
                    heght:'300px', */
                    padding: "1.5rem",
                    /*  customClass: {
                       popup: "small-sweetalert",
                       confirmButton: "btn-primary",
                     }, */
                }).then(() => {
                    // Recarregar a página após o SweetAlert ser fechado
                    location.reload();
                });
            } else {
                document.getElementById('msg-edit').innerHTML =
                    ` <div class="alert alert-danger text-center" role="alert">
        ${res.msg}
        </div>`;
            }

        });
    }

    const btnEleminar = document.getElementById('form-eliminar');

    if (btnEleminar) {
        btnEleminar.addEventListener('submit', async function (e) {

            e.preventDefault();
            const formData = new FormData(btnEleminar);
            const data = Object.fromEntries(formData);

            const response = await fetch(base_api + 'api/agenda/medico/deletar', {
                method: 'delete',
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(data)
            });

            const res = await response.json();
            // console.log(res);
            if (res.status) {
                const modal = bootstrap.Modal.getInstance(document.getElementById(
                    "visualizarModal"));
                modal.hide();

                Swal.fire({
                    title: 'Escala de Trabalho',
                    text: res.msg,
                    icon: 'success',
                    /* width: "350px",
                    heght:'300px', */
                    padding: "1.5rem",
                    /*  customClass: {
                       popup: "small-sweetalert",
                       confirmButton: "btn-primary",
                     }, */
                }).then(() => {
                    // Recarregar a página após o SweetAlert ser fechado
                    location.reload();
                });
            }

        });
    }

    const btnGenerate = document.getElementById('generate');


    if (btnGenerate) {
        btnGenerate.addEventListener('click', async function () {
            const confirm = await Swal.fire({
                title: 'Gerar Escala?',
                text: "Iso criará turnos aleatórios para os médicos no próximo mês.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0d6efd',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sim, gerar!',
                cancelButtonText: 'Cancelar'
            });

            if (confirm.isConfirmed) {
                Swal.fire({
                    title: 'Gerando...',
                    didOpen: () => {
                        Swal.showLoading()
                    },
                    allowOutsideClick: false
                });

                try {
                    const response = await fetch(base_api + 'api/agenda/medico/gerar-aleatorio', {
                        method: 'POST'
                    });
                    const res = await response.json();

                    if (res.status !== false) {
                        Swal.fire('Sucesso!', res.msg, 'success').then(() => location.reload());
                    } else {
                        Swal.fire('Erro', res.msg || 'Falha ao gerar escala', 'error');
                    }
                } catch (error) {
                    Swal.fire('Erro', 'Ocorreu um erro na requisição', 'error');
                }
            }
        });
    }



});