<div class="pc-container" id="medico_agenda">
    <div class="pc-content">
        <style>
    body {
      font-family: 'Inter', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f6f8;
      color: #2c3e50;
    }

    main {
      max-width: 960px;
      margin: 40px auto;
      padding: 0 20px;
    }

     .status-buttons {
      display: flex;
      justify-content: center;
      gap: 10px;
      flex-wrap: wrap;
      margin-bottom: 30px;
    }

    .status-buttons .btn {
      min-width: 120px;
    }
    .titulo {
      font-size: 26px;
      font-weight: 600;
      margin-bottom: 30px;
      text-align: center;
      color: #34495e;
    }

    .consulta {
      background-color: #ffffff;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
      padding: 20px 24px;
      margin-bottom: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      transition: box-shadow 0.2s;
    }

    .consulta:hover {
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
    }

    .info {
      flex: 1;
    }

    .info h2 {
      font-size: 20px;
      margin: 0 0 8px;
    }

    .info p {
      margin: 4px 0;
      font-size: 14px;
      color: #555;
    }

    .acoes {
      display: flex;
      flex-direction: column;
      gap: 8px;
      margin-left: 20px;
    }

    .acoes button {
      padding: 8px 14px;
      font-size: 14px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.3s ease;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .editar {
      background-color: #3498db;
      color: white;
    }

    .editar:hover {
      background-color: #2980b9;
    }

    .cancelar {
      background-color: #e74c3c;
      color: white;
    }

    .cancelar:hover {
      background-color: #c0392b;
    }

    .detalhes {
      background-color: #7f8c8d;
      color: white;
    }

    .detalhes:hover {
      background-color: #616a6b;
    }

    .acoes .ti {
      font-size: 16px;
    }

    @media (max-width: 600px) {
      .consulta {
        flex-direction: column;
        align-items: flex-start;
      }

      .acoes {
        flex-direction: row;
        flex-wrap: wrap;
        margin-left: 0;
        margin-top: 10px;
      }

        .status-buttons {
        flex-direction: column;
        align-items: center;
      }
    }
  </style>
</head>
 <main>
    <div class="titulo">Consultas Agendadas</div>
  <div class="status-buttons">
      <button class="btn btn-outline-primary">
        <i class="ti ti-calendar-check"></i> Agendado
      </button>
      <button class="btn btn-outline-danger">
        <i class="ti ti-x"></i> Cancelado
      </button>
      <button class="btn btn-outline-warning text-dark">
        <i class="ti ti-clock-hour-4"></i> Em Processo
      </button>
      <button class="btn btn-outline-success">
        <i class="ti ti-check"></i> Atendido
      </button>
    </div>
    <div class="consulta">
      <div class="info">
        <h2>João Silva</h2>
        <p><strong>Data:</strong> 25/08/2025</p>
        <p><strong>Hora:</strong> 14:00</p>
        <p><strong>Especialidade:</strong> Cardiologia</p>
      </div>
      <div class="acoes">
        <button class="editar">
          <i class="ti ti-edit"></i> Editar
        </button>
        <button class="cancelar">
          <i class="ti ti-x"></i> Cancelar
        </button>
        <button class="detalhes">
          <i class="ti ti-eye"></i> Detalhes
        </button>
      </div>
    </div>

    <div class="consulta">
      <div class="info">
        <h2>Maria Oliveira</h2>
        <p><strong>Data:</strong> 26/08/2025</p>
        <p><strong>Hora:</strong> 10:30</p>
        <p><strong>Especialidade:</strong> Dermatologia</p>
      </div>
      <div class="acoes">
        <button class="editar">
          <i class="ti ti-edit"></i> Editar
        </button>
        <button class="cancelar">
          <i class="ti ti-x"></i> Cancelar
        </button>
        <button class="detalhes">
          <i class="ti ti-eye"></i> Detalhes
        </button>
      </div>
    </div>

  </main>
    </div>
</div>