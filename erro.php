<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erro - SMU Juiz de Fora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #0066cc;
            --danger-color: #dc3545;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        
        .error-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, var(--danger-color) 0%, #c82333 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        
        .content {
            padding: 3rem;
        }
        
        .error-icon {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .error-icon i {
            font-size: 5rem;
            color: var(--danger-color);
        }
        
        .error-details {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 8px;
            padding: 1.5rem;
            margin: 2rem 0;
        }
        
        .contact-info {
            background-color: #e3f2fd;
            border-left: 5px solid var(--primary-color);
            border-radius: 8px;
            padding: 1.5rem;
            margin: 2rem 0;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, #003366 100%);
            border: none;
            padding: 0.75rem 2rem;
            font-weight: 600;
            border-radius: 8px;
        }
        
        .btn-outline-primary {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="error-container">
            <div class="header">
                <h1><i class="bi bi-exclamation-triangle"></i> Ocorreu um Erro</h1>
                <p class="mb-0">Prefeitura de Juiz de Fora - Secretaria de Mobilidade Urbana</p>
            </div>
            
            <div class="content">
                <div class="error-icon">
                    <i class="bi bi-x-circle-fill"></i>
                </div>
                
                <h2 class="text-center mb-4" style="color: var(--danger-color);">Erro no Processamento</h2>
                
                <p class="text-center">Desculpe, ocorreu um erro ao processar sua solicitação.</p>
                
                <div class="error-details">
                    <h5><i class="bi bi-info-circle me-2"></i>Detalhes do Erro:</h5>
                    <p class="mb-0">
                        <?php 
                        $msg = htmlspecialchars($_GET['msg'] ?? 'Erro desconhecido. Por favor, tente novamente.');
                        echo $msg;
                        ?>
                    </p>
                </div>
                
                <div class="contact-info">
                    <h5><i class="bi bi-telephone me-2"></i>Precisa de Ajuda?</h5>
                    <p class="mb-1"><strong>Telefone:</strong> (32) 3690-8400</p>
                    <p class="mb-1"><strong>E-mail:</strong> smu@pjf.mg.gov.br</p>
                    <p class="mb-0"><strong>Horário:</strong> Segunda a Sexta, 8h às 17h</p>
                </div>
                
                <div class="text-center mt-4">
                    <a href="formulario_evento.html" class="btn btn-primary me-2">
                        <i class="bi bi-arrow-clockwise"></i> Tentar Novamente
                    </a>
                    <a href="index.html" class="btn btn-outline-primary">
                        <i class="bi bi-house"></i> Voltar para Início
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>