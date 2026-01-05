<div class="pc-container">
    <div class="pc-content">
        <!-- Breadcrumb -->
        <div class="page-header mb-3">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb bg-transparent p-0 mb-2">
                                <li class="breadcrumb-item">
                                    <a href="<?php echo root(); ?>medico/home"><i class="feather icon-home"></i> Painel Hospitalar</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <i class="feather icon-users"></i> Gerenciar Pacientes
                                </li>
                            </ol>
                        </nav>
                        <h2 class="page-header-title mb-1">Meus Pacientes</h2>
                        <div class="d-flex align-items-center text-primary">
                            <i class="feather icon-user me-2"></i>
                            <strong><?= DoctorTitle($auth->genero) . " " . htmlspecialchars((string) $auth->nome) ?></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Botão Flutuante Adicionar Paciente -->
        <button id="adicionar-paciente"
            class="btn btn-primary btn-sm rounded-circle position-fixed"
            style="bottom: 45px; right: 32px; z-index: 1050; box-shadow: 0 4px 16px rgba(0,0,0,0.15);"
            title="Adicionar Paciente">
            <i class="ti ti-plus" style="font-size: 1.5rem;"></i>
        </button>
        <!-- Tabela de Pacientes -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover align-middle text-nowrap">
                <thead class="table-light text-center">
                    <tr>
                        <th>#</th>
                        <th>Avatar</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Data de Nascimento</th>
                        <th>Sexo</th>
                        <th>Telefone</th>
                        <th>Endereço</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pacientes as $i => $paciente) { ?>
                        <tr>
                            <td class="text-center"><?php echo $i + 1; ?></td>
                            <td class="text-center">
                                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode((string) $paciente->usuario); ?>&background=0D8ABC&color=fff&size=40"
                                    alt="avatar"
                                    class="rounded-circle" width="40" height="40">
                            </td>
                            <td><?php echo htmlspecialchars((string) $paciente->usuario) ?? ''; ?></td>
                            <td><?php echo htmlspecialchars((string) $paciente->email) ?? ''; ?></td>
                            <td><?php echo htmlspecialchars((string) $paciente->data_nascimento) ?? ''; ?></td>
                            <td><?php echo htmlspecialchars(genero($paciente->genero)) ?? ''; ?></td>
                            <td><?php echo htmlspecialchars((string) $paciente->telefone) ?? ''; ?></td>
                            <td><?php echo htmlspecialchars((string) $paciente->endereco) ?? ''; ?></td>
                            <td class="text-center">
                                <a href="<?php echo root(); ?>medico/paciente-editar/<?php echo $paciente->id; ?>"
                                    class="btn btn-sm btn-outline-warning me-1" title="Editar">
                                    <i class="feather icon-edit"></i>
                                </a>

                            </td>
                        </tr>
                    <?php } ?>
                    <?php if (empty($pacientes)) { ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted">Nenhum paciente cadastrado.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php if (!empty($pacientes)) { ?>
            <div class="d-flex flex-column gap-2 mt-3">
                <!-- Info (à esquerda) -->
                <div class="text-start">
                    <?php echo str_replace('text-end', 'text-start', $tools->info); ?>
                </div>

                <!-- Paginação (centralizada corretamente) -->
                <div class="d-flex justify-content-center">
                    <?php echo $tools->paginacao; ?>
                </div>
            </div>
        <?php } ?>


    </div>
</div>

<!--  -->
<!--  -->
<div class="modal fade" id="CadastraModal" tabindex="-1" aria-labelledby="CadastraModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="CadastraModalLabel" style="display: block;"> <i class="feather icon-user-plus me-2"></i> Cadastro de Novo Paciente
                </h1>
                <h1 class="modal-title fs-5" id="editarModalLabel" style="display: none;">Editar Evento</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form de Create -->
                <!-- <div class="card shadow-lg border-0 col-sm-12 col-md-8 offset-md-2 mt-5 rounded-2"> -->
                <form id="paciente-store" method="post" autocomplete="off"><!-- class="needs-validation" novalidate -->
                    <div class="card-body px-4 py-4">
                        <div id="msg"></div>

                        <div class="mb-4">
                            <h5 class="text-primary fw-semibold">Informações Pessoais</h5>
                            <hr>
                            <?php include iViewForm('paciente-medico') ?>
                        </div>
                        <input type="hidden" name="medico_id" value="<?= $userPerfil->id ?>">

                        <div class="card-footer text-center bg-light ">
                            <button type="submit" class="btn btn-success px-5 py-2 fw-bold shadow-sm mt-4">
                                <i class="feather icon-save me-2"></i>Salvar Cadastro
                            </button>
                        </div>
                </form>
            </div>
            <!-- Form de Create END-->
        </div>
        <div class="modal-footer">
            <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button> -->
        </div>
    </div>
</div>
</div>
<!--  -->
<script>
    const btnCriar = document.getElementById('adicionar-paciente');
    const btnCadSubmit = document.getElementById('paciente-store');

    if (btnCriar) {
        btnCriar.addEventListener('click', function() {
            const model = new bootstrap.Modal(document.getElementById('CadastraModal'));
            model.show();

        });
    }
    if (btnCadSubmit) {
        btnCadSubmit.addEventListener('submit', async function(e) {
            e.preventDefault();
            // alert('Submetido');
            const Fdata = new FormData(btnCadSubmit);
            const data = Object.fromEntries(Fdata);

            // console.log(data);
            const response = await fetch('/medico/paciente-criar', {
                method: 'post',
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(data)
            });
            const res = await response.json();


            if (!res.status) {
                document.getElementById('msg').innerHTML =
                    ` <div class="alert alert-danger text-center" role="alert">
        ${res.msg}
        </div>`;
                setInterval(function() {
                    document.getElementById('msg').innerHTML = '';
                }, 3000);
            } else {
                document.getElementById('msg').innerHTML = '';
                // Fecha o modal
                const modal = bootstrap.Modal.getInstance(document.getElementById("CadastraModal"));
                modal.hide();

                // Swal.fire
                Swal.fire({
                    title: 'Rigistro de Usuario',
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
            console.log(res);
        });
    }
</script>