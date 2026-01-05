<h1>
    <?= $title?> -
    <?=  $doctor->medico_nome?> </h1>
<!-- Título principal do relatório -->

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome Completo do Paciente</th>
            <th>Data de Nascimento</th>
            <th>Data de Marcação</th>
            <th>Hota </th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($lists as $list): ?>
        <tr>
            <td><?= $list['id'] ?></td>
            <td><?= htmlspecialchars((string) $list->paciente_nome ) ?></td>
            <td><?=  htmlspecialchars(date('d/m/Y', strtotime((string) $list->paciente_nascimento))) ?></td>
            <td><?=  htmlspecialchars(date('d/m/Y', strtotime((string) $list->data))) ?></td>
            <td><?=  htmlspecialchars(date('H:i:s', strtotime((string) $list->hora))) ?></td>
            <td><?=  htmlspecialchars((string) $list->estado_formatado) ?></td>

        </tr>
        <?php endforeach; ?>
    </tbody>
</table>