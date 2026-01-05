<div style="text-align: center; margin-bottom: 20px;">
    <img src="<?= 'd:/Tecnologia/Project/sgh/public/assets/img/logo.png' ?>" alt="Logo SGH" style="max-height: 80px;">
</div>
<h1>
    <?= $title ?>
</h1> <!-- Título principal do relatório -->

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome Completo</th>
            <th>Data de Nascimento</th>
            <!-- <th>BI</th> -->
            <th>Telefone</th>
            <th>E-mail</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($medicos as $list): ?>
            <tr>
                <td><?= htmlspecialchars((string) $list->id) ?></td>
                <td><?= htmlspecialchars((string) $list->usuario->nome) ?></td>
                <td><?= htmlspecialchars(date('d/m/Y', strtotime((string) $list->data_nascimento))) ?></td>
                <!-- <td><?= htmlspecialchars((string) $list->bi) ?></td> -->
                <td><?= htmlspecialchars((string) $list->telefone) ?></td>
                <td><?= htmlspecialchars((string) $list->usuario->email) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>