<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitação Recebida - SMU Juiz de Fora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #0066cc;
            --secondary-color: #003366;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        
        .confirmation-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 2.5rem;
            text-align: center;
        }
        
        .header h1 {
            font-size: 2.2rem;
            margin-bottom: 0.5rem;
        }
        
        .header p {
            opacity: 0.9;
            font-size: 1.1rem;
        }
        
        .content {
            padding: 3rem;
        }
        
        .checkmark {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .checkmark i {
            font-size: 5rem;
            color: #28a745;
        }
        
        .protocolo-box {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: 2px dashed var(--primary-color);
            border-radius: 10px;
            padding: 2rem;
            text-align: center;
            margin: 2rem 0;
        }
        
        .protocolo-number {
            font-family: 'Courier New', monospace;
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            letter-spacing: 2px;
            margin: 1rem 0;
        }
        
        .steps {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
            margin: 2rem 0;
        }
        
        .steps h5 {
            color: var(--secondary-color);
            margin-bottom: 1rem;
        }
        
        .steps ol {
            padding-left: 1.5rem;
        }
        
        .steps li {
            margin-bottom: 0.5rem;
        }
        
        .contact-info {
            background-color: #e3f2fd;
            border-left: 5px solid var(--primary-color);
            border-radius: 8px;
            padding: 1.5rem;
            margin: 2rem 0;
        }
        
        .footer {
            text-align: center;
            padding: 2rem;
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
            color: #666;
            font-size: 0.9rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            padding: 0.75rem 2rem;
            font-weight: 600;
            border-radius: 8px;
        }
        
        @media (max-width: 768px) {
            .content {
                padding: 2rem;
            }
            
            .protocolo-number {
                font-size: 1.5rem;
            }
            
            .header h1 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="confirmation-container">
            <div class="header">
                <h1>Prefeitura de Juiz de Fora</h1>
                <p>Secretaria de Mobilidade Urbana</p>
            </div>
            
            <div class="content">
                <div class="checkmark">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                
                <h2 class="text-center mb-4" style="color: var(--secondary-color);">Solicitação Recebida com Sucesso!</h2>
                
                <p class="text-center lead">Sua solicitação de autorização para evento foi registrada em nosso sistema.</p>
                
                <div class="protocolo-box">
                    <h5 class="mb-3">Número do Protocolo</h5>
                    <div class="protocolo-number">
                        <?php 
                        $protocolo = htmlspecialchars($_GET['protocolo'] ?? 'N/A');
                        echo $protocolo;
                        ?>
                    </div>
                    <p class="text-muted">Guarde este número para acompanhar o status da sua solicitação.</p>
                </div>
                
                <div class="steps">
                    <h5><i class="bi bi-list-check me-2"></i>Próximos Passos</h5>
                    <ol>
                        <li><strong>Análise Técnica:</strong> Nossa equipe analisará sua solicitação</li>
                        <li><strong>Prazo:</strong> O prazo para análise é de até <strong>10 dias úteis</strong></li>
                        <li><strong>Notificação:</strong> Você receberá uma resposta por e-mail</li>
                        <li><strong>Aprovação:</strong> Em caso de aprovação, serão enviadas orientações finais</li>
                    </ol>
                </div>
                
                <div class="contact-info">
                    <h5><i class="bi bi-telephone me-2"></i>Para Dúvidas</h5>
                    <p class="mb-1"><strong>Telefone:</strong> (32) 3690-8400</p>
                    <p class="mb-1"><strong>E-mail:</strong> smu@pjf.mg.gov.br</p>
                    <p class="mb-0"><strong>Horário de Atendimento:</strong> Segunda a Sexta, 8h às 17h</p>
                </div>
                
                <div class="text-center mt-4">
                    <a href="formulario_evento.html" class="btn btn-primary me-2">
                        <i class="bi bi-plus-circle"></i> Nova Solicitação
                    </a>
                    <a href="index.html" class="btn btn-outline-primary">
                        <i class="bi bi-house"></i> Página Inicial
                    </a>
                </div>
            </div>
            
            <div class="footer">
                <p class="mb-0">
                    <strong>Prefeitura de Juiz de Fora | Secretaria de Mobilidade Urbana</strong><br>
                    Av. Brasil, nº 2001/4º andar - Centro | CEP: 36010-001
                </p>
            </div>
        </div>
    </div>
</body>
</html>