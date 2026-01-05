<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Gerar PDF com DOMPDF e AJAX</title>
</head>

<body>

    <h1>Relatório de Vendas</h1>
    <p>Data de Geração: <span id="dataGeracao"></span></p>

    <button onclick="gerarPDF()">Gerar PDF</button>
    <p id="mensagem"></p>

    <script>
    document.getElementById('dataGeracao').innerText = new Date().toLocaleDateString('pt-BR');

    function gerarPDF() {
        const dadosParaPDF = {
            titulo: "Relatório Mensal de Vendas - Outubro",
            vendas: [{
                    produto: "Notebook X",
                    valor: 3500.00
                },
                {
                    produto: "Mouse Gamer",
                    valor: 150.00
                },
                {
                    produto: "Teclado Mecânico",
                    valor: 400.00
                }
            ],
            total: 4050.00
        };

        const mensagemElemento = document.getElementById('mensagem');
        mensagemElemento.innerText = 'Gerando PDF, por favor aguarde...';

        // Requisição AJAX para o script PHP
        fetch('/gerar_pdf', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(dadosParaPDF)
            })
            .then(response => {
                // Verifica se a resposta foi um blob (o PDF)
                if (response.ok && response.headers.get('Content-Type') === 'application/pdf') {
                    return response.blob();
                }
                // Se não for PDF, lança um erro ou processa a mensagem de erro do servidor
                return response.text().then(text => {
                    throw new Error(text || 'Erro desconhecido ao gerar PDF.');
                });
            })
            .then(blob => {
                // Cria um URL para o Blob (o PDF)
                const url = window.URL.createObjectURL(blob);

                // Cria um link temporário para forçar o download
                const a = document.createElement('a');
                a.style.display = 'none';
                a.href = url;
                a.download = 'relatorio_vendas.pdf'; // Nome do arquivo
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url); // Limpa o URL temporário

                mensagemElemento.innerText = 'PDF gerado com sucesso e download iniciado!';

            })
            .catch(error => {
                console.error('Erro:', error);
                mensagemElemento.innerText = 'Falha ao gerar o PDF. Verifique o console.';
            });
    }
    </script>
</body>

</html>