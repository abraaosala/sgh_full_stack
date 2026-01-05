  <div style="text-align: center; margin-bottom: 20px;">
      <img src="<?= 'd:/Tecnologia/Project/sgh/public/assets/img/logo.png' ?>" alt="Logo SGH" style="max-height: 80px;">
  </div>
  <h1>Lista de Pacientes </h1> <!-- Título principal do relatório -->

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
          <?php foreach ($pacientes as $paciente): ?>
              <tr>
                  <td><?= htmlspecialchars((string) $paciente->id) ?></td>
                  <td><?= htmlspecialchars((string) $paciente->usuario->nome) ?></td>
                  <td><?= htmlspecialchars(date('d/m/Y', strtotime((string) $paciente->data_nascimento))) ?></td>
                  <!-- <td><?= htmlspecialchars((string) $paciente->bi) ?></td> -->
                  <td><?= htmlspecialchars((string) $paciente->telefone) ?></td>
                  <td><?= htmlspecialchars((string) $paciente->usuario->email) ?></td>
              </tr>
          <?php endforeach; ?>
      </tbody>
  </table>