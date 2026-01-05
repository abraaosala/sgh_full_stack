
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .error-container {
            display: flex;
            min-height: 100vh;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
            padding: 20px;
        }

        .img-erro {
            max-width: 300px;
            width: 100%;
            height: auto;
            margin-bottom: 20px;
        }

        .error-title {
            font-size: 2rem;
            font-weight: bold;
            color: #dc3545;
            margin-bottom: 10px;
        }

        .error-message {
            font-size: 1.1rem;
            color: #555;
            margin-bottom: 30px;
        }

        .btn-home {
            padding: 10px 25px;
            font-size: 1rem;
        }
    </style>
</head>
<body>

    <div class="error-container">
        <img class="img-erro" src="<?= root() ?>public/ui/assets/images/pages/erro403.png" alt="Erro 403">
        
        <div class="error-title">Erro 403 - Acesso Negado</div>
        <div class="error-message">
            Você não tem permissão para acessar esta página ou recurso.
        </div>
        
        <a href="/" class="btn btn-primary btn-home">Voltar para o Início</a>
    </div>

