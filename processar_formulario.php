<?php
// processar_formulario.php
require_once 'config.php';

// Conexão com o banco de dados
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}

// Criar diretório de uploads se não existir
if (!file_exists(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0777, true);
}

// Criar subdiretório por ano
$upload_dir = UPLOAD_DIR . date('Y') . '/';
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Função para fazer upload de arquivos
function uploadArquivo($file, $tipo, $id_solicitacao, $descricao = '') {
    global $upload_dir, $pdo;
    
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }
    
    // Verificar tipo de arquivo
    $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    if (!in_array($file_ext, ALLOWED_FILE_TYPES)) {
        return false;
    }
    
    // Verificar tamanho
    if ($file['size'] > MAX_FILE_SIZE) {
        return false;
    }
    
    // Gerar nome único
    $novo_nome = 'EVENTO_' . $id_solicitacao . '_' . strtoupper($tipo) . '_' . time() . '_' . uniqid() . '.' . $file_ext;
    $destino = $upload_dir . $novo_nome;
    
    if (move_uploaded_file($file['tmp_name'], $destino)) {
        // Salvar no banco
        $stmt = $pdo->prepare("INSERT INTO arquivos_eventos 
                              (id_solicitacao, tipo_arquivo, nome_arquivo, caminho_arquivo, 
                               tamanho_arquivo, tipo_mime, descricao) 
                              VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $id_solicitacao,
            $tipo,
            $file['name'],
            $destino,
            $file['size'],
            mime_content_type($destino),
            $descricao
        ]);
        
        return $destino;
    }
    
    return false;
}

// Processar o formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo->beginTransaction();
        
        // Coletar e sanitizar dados
        $protocolo = sanitizar($_POST['protocolo'] ?? '');
        $nome_evento = sanitizar($_POST['nome_evento'] ?? '');
        $tipo_evento = sanitizar($_POST['tipo_evento'] ?? '');
        $nome_responsavel = sanitizar($_POST['nome_responsavel'] ?? '');
        $telefone_responsavel = sanitizar($_POST['telefone_responsavel'] ?? '');
        $email_responsavel = sanitizar($_POST['email_responsavel'] ?? '');
        $total_participantes = intval($_POST['total_participantes'] ?? 0);
        
        // Períodos - Período 1
        $data_evento_1 = !empty($_POST['data_evento_1']) ? $_POST['data_evento_1'] : null;
        $hora_interdicao_1 = !empty($_POST['hora_interdicao_1']) ? $_POST['hora_interdicao_1'] : null;
        $hora_inicio_1 = !empty($_POST['hora_inicio_1']) ? $_POST['hora_inicio_1'] : null;
        $hora_fim_1 = !empty($_POST['hora_fim_1']) ? $_POST['hora_fim_1'] : null;
        $data_liberacao_1 = !empty($_POST['data_liberacao_1']) ? $_POST['data_liberacao_1'] : null;
        $hora_liberacao_1 = !empty($_POST['hora_liberacao_1']) ? $_POST['hora_liberacao_1'] : null;
        
        // Períodos adicionais (2 e 3)
        $data_evento_2 = !empty($_POST['data_evento_2']) ? $_POST['data_evento_2'] : null;
        $hora_interdicao_2 = !empty($_POST['hora_interdicao_2']) ? $_POST['hora_interdicao_2'] : null;
        $hora_inicio_2 = !empty($_POST['hora_inicio_2']) ? $_POST['hora_inicio_2'] : null;
        $hora_fim_2 = !empty($_POST['hora_fim_2']) ? $_POST['hora_fim_2'] : null;
        $data_liberacao_2 = !empty($_POST['data_liberacao_2']) ? $_POST['data_liberacao_2'] : null;
        $hora_liberacao_2 = !empty($_POST['hora_liberacao_2']) ? $_POST['hora_liberacao_2'] : null;
        
        $data_evento_3 = !empty($_POST['data_evento_3']) ? $_POST['data_evento_3'] : null;
        $hora_interdicao_3 = !empty($_POST['hora_interdicao_3']) ? $_POST['hora_interdicao_3'] : null;
        $hora_inicio_3 = !empty($_POST['hora_inicio_3']) ? $_POST['hora_inicio_3'] : null;
        $hora_fim_3 = !empty($_POST['hora_fim_3']) ? $_POST['hora_fim_3'] : null;
        $data_liberacao_3 = !empty($_POST['data_liberacao_3']) ? $_POST['data_liberacao_3'] : null;
        $hora_liberacao_3 = !empty($_POST['hora_liberacao_3']) ? $_POST['hora_liberacao_3'] : null;
        
        // Interdição
        $interditar_via = sanitizar($_POST['interditar_via'] ?? 'nao');
        $ruas_interditadas = $interditar_via === 'sim' ? sanitizar($_POST['ruas_interditadas'] ?? '') : '';
        
        // Quantidades de sinalização
        $qtd_cones = intval($_POST['qtd_cones'] ?? 0);
        $qtd_cavalete = intval($_POST['qtd_cavalete'] ?? 0);
        $qtd_fita_zebrada_metros = intval($_POST['qtd_fita_zebrada_metros'] ?? 0);
        $qtd_pantografica = intval($_POST['qtd_pantografica'] ?? 0);
        $qtd_outros_sinalizacao = intval($_POST['qtd_outros_sinalizacao'] ?? 0);
        $desc_outros_sinalizacao = sanitizar($_POST['desc_outros_sinalizacao'] ?? '');
        
        // Veículos
        $quantidade_veiculos = intval($_POST['quantidade_veiculos'] ?? 0);
        $tipo_veiculos = sanitizar($_POST['tipo_veiculos'] ?? '');
        
        // Segurança
        $tem_seguranca = sanitizar($_POST['tem_seguranca'] ?? 'nao');
        $qtd_seguranca = $tem_seguranca === 'sim' ? intval($_POST['qtd_seguranca'] ?? 0) : 0;
        $empresa_seguranca = $tem_seguranca === 'sim' ? sanitizar($_POST['empresa_seguranca'] ?? '') : '';
        
        // Apoio com agentes de trânsito
        $apoio_agentes_transito = sanitizar($_POST['apoio_agentes_transito'] ?? 'nao');
        $qtd_agentes_transito = $apoio_agentes_transito === 'sim' ? intval($_POST['qtd_agentes_transito'] ?? 0) : 0;
        $observacoes_agentes = $apoio_agentes_transito === 'sim' ? sanitizar($_POST['observacoes_agentes'] ?? '') : '';
        
        // Sanitários
        $tem_sanitarios = sanitizar($_POST['tem_sanitarios'] ?? 'nao');
        $qtd_sanitarios = $tem_sanitarios === 'sim' ? intval($_POST['qtd_sanitarios'] ?? 0) : 0;
        $tipo_sanitarios = $tem_sanitarios === 'sim' ? sanitizar($_POST['tipo_sanitarios'] ?? '') : '';
        
        // Acessibilidade
        $acessibilidade = sanitizar($_POST['acessibilidade'] ?? 'nao');
        $desc_acessibilidade = $acessibilidade === 'sim' ? sanitizar($_POST['desc_acessibilidade'] ?? '') : '';
        
        $observacoes = sanitizar($_POST['observacoes'] ?? '');
        
        // Inserir no banco
        $stmt = $pdo->prepare("INSERT INTO solicitacoes_eventos 
            (protocolo, nome_evento, tipo_evento, nome_responsavel, telefone_responsavel,
             email_responsavel, total_participantes_estimado, data_evento_1, hora_interdicao_1,
             hora_inicio_1, hora_fim_1, data_liberacao_1, hora_liberacao_1,
             data_evento_2, hora_interdicao_2, hora_inicio_2, hora_fim_2, data_liberacao_2, hora_liberacao_2,
             data_evento_3, hora_interdicao_3, hora_inicio_3, hora_fim_3, data_liberacao_3, hora_liberacao_3,
             interditar_via, ruas_interditadas, qtd_cones, qtd_cavalete, qtd_fita_zebrada_metros,
             qtd_pantografica, qtd_outros_sinalizacao, desc_outros_sinalizacao,
             quantidade_veiculos, tipo_veiculos, tem_seguranca, qtd_seguranca, empresa_seguranca,
             apoio_agentes_transito, qtd_agentes_transito, observacoes_agentes,
             tem_sanitarios, qtd_sanitarios, tipo_sanitarios,
             acessibilidade, desc_acessibilidade, observacoes)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->execute([
            $protocolo, $nome_evento, $tipo_evento, $nome_responsavel, $telefone_responsavel,
            $email_responsavel, $total_participantes, 
            $data_evento_1, $hora_interdicao_1, $hora_inicio_1, $hora_fim_1, $data_liberacao_1, $hora_liberacao_1,
            $data_evento_2, $hora_interdicao_2, $hora_inicio_2, $hora_fim_2, $data_liberacao_2, $hora_liberacao_2,
            $data_evento_3, $hora_interdicao_3, $hora_inicio_3, $hora_fim_3, $data_liberacao_3, $hora_liberacao_3,
            $interditar_via, $ruas_interditadas, $qtd_cones, $qtd_cavalete, $qtd_fita_zebrada_metros,
            $qtd_pantografica, $qtd_outros_sinalizacao, $desc_outros_sinalizacao,
            $quantidade_veiculos, $tipo_veiculos, $tem_seguranca, $qtd_seguranca, $empresa_seguranca,
            $apoio_agentes_transito, $qtd_agentes_transito, $observacoes_agentes,
            $tem_sanitarios, $qtd_sanitarios, $tipo_sanitarios,
            $acessibilidade, $desc_acessibilidade, $observacoes
        ]);
        
        $id_solicitacao = $pdo->lastInsertId();
        
        // Upload de arquivos obrigatórios para interdição
        if ($interditar_via === 'sim') {
            if (isset($_FILES['file_oficio']) && $_FILES['file_oficio']['error'] === UPLOAD_ERR_OK) {
                uploadArquivo($_FILES['file_oficio'], 'oficio_ciencia', $id_solicitacao, 'Ofício SPM ou Baixo-assinado');
            }
            
            if (isset($_FILES['file_croqui']) && $_FILES['file_croqui']['error'] === UPLOAD_ERR_OK) {
                uploadArquivo($_FILES['file_croqui'], 'croqui', $id_solicitacao, 'Croqui do trecho interditado');
            }
        }
        
        // Upload de CRLVs (múltiplos)
        if (isset($_FILES['file_crlv'])) {
            if (is_array($_FILES['file_crlv']['name'])) {
                for ($i = 0; $i < count($_FILES['file_crlv']['name']); $i++) {
                    if ($_FILES['file_crlv']['error'][$i] === UPLOAD_ERR_OK) {
                        $file = [
                            'name' => $_FILES['file_crlv']['name'][$i],
                            'type' => $_FILES['file_crlv']['type'][$i],
                            'tmp_name' => $_FILES['file_crlv']['tmp_name'][$i],
                            'error' => $_FILES['file_crlv']['error'][$i],
                            'size' => $_FILES['file_crlv']['size'][$i]
                        ];
                        uploadArquivo($file, 'crlv', $id_solicitacao, 'CRLV do veículo ' . ($i + 1));
                    }
                }
            } elseif ($_FILES['file_crlv']['error'] === UPLOAD_ERR_OK) {
                uploadArquivo($_FILES['file_crlv'], 'crlv', $id_solicitacao, 'CRLV do veículo');
            }
        }
        
        // Upload de outros documentos (múltiplos)
        if (isset($_FILES['file_outros'])) {
            if (is_array($_FILES['file_outros']['name'])) {
                for ($i = 0; $i < count($_FILES['file_outros']['name']); $i++) {
                    if ($_FILES['file_outros']['error'][$i] === UPLOAD_ERR_OK) {
                        $file = [
                            'name' => $_FILES['file_outros']['name'][$i],
                            'type' => $_FILES['file_outros']['type'][$i],
                            'tmp_name' => $_FILES['file_outros']['tmp_name'][$i],
                            'error' => $_FILES['file_outros']['error'][$i],
                            'size' => $_FILES['file_outros']['size'][$i]
                        ];
                        uploadArquivo($file, 'outro', $id_solicitacao, 'Documento adicional ' . ($i + 1));
                    }
                }
            } elseif ($_FILES['file_outros']['error'] === UPLOAD_ERR_OK) {
                uploadArquivo($_FILES['file_outros'], 'outro', $id_solicitacao, 'Documento adicional');
            }
        }
        
        // Registrar log
        $ip = $_SERVER['REMOTE_ADDR'];
        $log_stmt = $pdo->prepare("INSERT INTO logs_sistema (id_solicitacao, acao, descricao, usuario, ip_address) 
                                   VALUES (?, 'cadastro', 'Nova solicitação cadastrada', ?, ?)");
        $log_stmt->execute([$id_solicitacao, $email_responsavel, $ip]);
        
        $pdo->commit();
        
        // Enviar e-mail de confirmação
        enviarEmailConfirmacao($email_responsavel, $protocolo, $nome_evento, $nome_responsavel);
        
        // Redirecionar para página de confirmação
        header("Location: confirmacao.php?protocolo=" . urlencode($protocolo));
        exit();
        
    } catch (Exception $e) {
        $pdo->rollBack();
        error_log("Erro no processamento: " . $e->getMessage());
        header("Location: erro.php?msg=" . urlencode("Erro ao processar solicitação. Tente novamente."));
        exit();
    }
} else {
    header("Location: formulario_evento.html");
    exit();
}

// Função para enviar e-mail de confirmação
function enviarEmailConfirmacao($email, $protocolo, $nome_evento, $nome_responsavel) {
    $to = $email;
    $subject = "Confirmação de Solicitação - Protocolo: $protocolo";
    
    $message = "
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: #0066cc; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; }
            .content { background: #f8f9fa; padding: 20px; border: 1px solid #dee2e6; }
            .protocolo { background: #e9ecef; padding: 15px; text-align: center; font-size: 1.2em; font-weight: bold; margin: 20px 0; }
            .footer { margin-top: 20px; padding-top: 20px; border-top: 1px solid #dee2e6; font-size: 0.9em; color: #666; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>Prefeitura de Juiz de Fora</h2>
                <h3>Secretaria de Mobilidade Urbana</h3>
            </div>
            <div class='content'>
                <h3>Solicitação Recebida com Sucesso!</h3>
                
                <p>Prezado(a) <strong>$nome_responsavel</strong>,</p>
                
                <p>Sua solicitação de autorização para o evento <strong>$nome_evento</strong> foi registrada em nosso sistema.</p>
                
                <div class='protocolo'>
                    Nº PROTOCOLO: $protocolo
                </div>
                
                <p><strong>Próximos passos:</strong></p>
                <ol>
                    <li>Sua solicitação será analisada pela nossa equipe</li>
                    <li>O prazo para análise é de até 10 dias úteis</li>
                    <li>Você receberá uma resposta por e-mail</li>
                    <li>Utilize o número do protocolo para acompanhamento</li>
                </ol>
                
                <p><strong>Dúvidas:</strong></p>
                <p>Telefone: (32) 3690-8400<br>
                E-mail: smu@pjf.mg.gov.br<br>
                Horário: Segunda a Sexta, 8h às 17h</p>
            </div>
            <div class='footer'>
                Esta é uma mensagem automática. Por favor, não responda este e-mail.
            </div>
        </div>
    </body>
    </html>
    ";
    
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= "From: " . EMAIL_FROM_NAME . " <" . EMAIL_FROM . ">\r\n";
    $headers .= "Reply-To: " . EMAIL_FROM . "\r\n";
    
    // Em produção, descomente a linha abaixo
    // mail($to, $subject, $message, $headers);
    
    // Para desenvolvimento, salvar e-mail em arquivo
    if (!file_exists('emails')) {
        mkdir('emails', 0777, true);
    }
    file_put_contents('emails/' . $protocolo . '.html', $message);
}
?>