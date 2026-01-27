<?php
// config.php
// Configurações do sistema

// Banco de Dados
define('DB_HOST', 'localhost');
define('DB_NAME', 'eventos_via_publica');
define('DB_USER', 'root');
define('DB_PASS', '');

// Upload
define('UPLOAD_DIR', 'uploads/');
define('MAX_FILE_SIZE', 5242880); // 5MB
define('ALLOWED_FILE_TYPES', ['pdf', 'jpg', 'jpeg', 'png', 'doc', 'docx']);

// E-mail
define('EMAIL_FROM', 'smu@pjf.mg.gov.br');
define('EMAIL_FROM_NAME', 'SMU Juiz de Fora');

// Site
define('SITE_NAME', 'Sistema de Eventos - SMU Juiz de Fora');
define('SITE_URL', 'http://localhost/eventos');

// Segurança
define('SESSION_TIMEOUT', 1800); // 30 minutos

// Timezone
date_default_timezone_set('America/Sao_Paulo');

// Iniciar sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Funções globais
function sanitizar($input) {
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

function formatarData($data, $formato = 'd/m/Y') {
    if (empty($data) || $data == '0000-00-00') return '';
    return date($formato, strtotime($data));
}

function formatarHora($hora) {
    if (empty($hora) || $hora == '00:00:00') return '';
    return date('H:i', strtotime($hora));
}

function formatarMoeda($valor) {
    return 'R$ ' . number_format($valor, 2, ',', '.');
}

function getStatusColor($status) {
    $cores = [
        'pendente' => 'warning',
        'em_analise' => 'info',
        'aprovado' => 'success',
        'rejeitado' => 'danger'
    ];
    return $cores[$status] ?? 'secondary';
}

function getStatusText($status) {
    $textos = [
        'pendente' => 'Pendente',
        'em_analise' => 'Em Análise',
        'aprovado' => 'Aprovado',
        'rejeitado' => 'Rejeitado'
    ];
    return $textos[$status] ?? 'Desconhecido';
}

// Função para gerar protocolo
function gerarProtocolo() {
    $data = date('Ymd');
    $hora = date('His');
    $random = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
    return "PROT-{$data}-{$hora}-{$random}";
}
?>