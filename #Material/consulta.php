<?php
// Start session to access $_SESSION variables (like patient_id)
session_start();

// Enable error reporting for development (remove/adjust for production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include Composer's autoloader for Dompdf
require_once __DIR__ . '/../vendor/autoload.php'; // Adjust path if necessary

use Dompdf\Dompdf;
use Dompdf\Options;

header('Content-Type: application/json'); // Set header for JSON response

// --- Configuration ---
// Database connection details (replace with your actual credentials)
$dbHost = 'localhost';
$dbName = 'sgh_db'; // Your database name
$dbUser = 'root';
$dbPass = '';

// Path where generated PDFs will be temporarily stored on the server
$pdfStoragePath = __DIR__ . '/../public/pdfs/'; // Adjust path as per your project structure

// Ensure the PDF storage directory exists
if (!is_dir($pdfStoragePath)) {
    mkdir($pdfStoragePath, 0777, true); // Create with read/write permissions
}

// --- Database Connection ---
try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Erro de conexão com o banco de dados: ' . $e->getMessage()]);
    exit();
}

// --- Authentication and Authorization ---
// Check if the user (patient) is logged in
if (!isset($_SESSION['patient_id'])) { // Assuming 'patient_id' is stored in session after login
    http_response_code(401); // Unauthorized
    echo json_encode(['success' => false, 'error' => 'Paciente não autenticado.']);
    exit();
}

$patientId = $_SESSION['patient_id'];

// Get the consultation ID from the client-side request
$input = file_get_contents('php://input');
$data = json_decode($input, true);

$consultationId = $data['consultationId'] ?? null;

if (!$consultationId) {
    http_response_code(400); // Bad Request
    echo json_encode(['success' => false, 'error' => 'ID da consulta não fornecido.']);
    exit();
}

// --- Fetch Consultation and Patient Data ---
try {
    // 1. Fetch consultation details
    $stmt = $pdo->prepare("
        SELECT 
            c.id, c.data, c.hora, c.estado, c.notas, c.clinica,
            m.nome AS medico_nome, m.especialidade AS medico_especialidade,
            p.nome AS paciente_nome, p.data_nascimento AS paciente_data_nascimento, p.nif AS paciente_nif
        FROM consultas c
        JOIN medicos m ON c.medico_id = m.id
        JOIN pacientes p ON c.paciente_id = p.id
        WHERE c.id = :consultation_id AND c.paciente_id = :patient_id
    ");
    $stmt->execute([':consultation_id' => $consultationId, ':patient_id' => $patientId]);
    $consultation = $stmt->fetch();

    if (!$consultation) {
        http_response_code(404); // Not Found or Forbidden
        echo json_encode(['success' => false, 'error' => 'Consulta não encontrada ou não pertence a este paciente.']);
        exit();
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Erro ao buscar dados da consulta: ' . $e->getMessage()]);
    exit();
}

// --- Normalize Status (if needed, as done in JS) ---
function normalizeStatusBackend($raw)
{
    $s = strtolower(trim($raw ?? ''));
    $map = [
        'realizado' => 'Concluída',
        'confirmado' => 'Agendada',
        'confirmada' => 'Agendada',
        'agendado' => 'Agendada',
        'cancelado' => 'Cancelada',
        'cancelada' => 'Cancelada',
        'faltou' => 'Faltou'
    ];
    return $map[$s] ?? ucfirst($s); // Default to capitalized if not mapped
}

$consultation['estado_formatado'] = normalizeStatusBackend($consultation['estado']);


// --- Generate HTML for PDF ---
// Format dates for display
$consultationDate = (new DateTime($consultation['data']))->format('d/m/Y');
$patientBirthDate = (new DateTime($consultation['paciente_data_nascimento']))->format('d/m/Y');

$html = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ficha de Consulta - ID ' . $consultation['id'] . '</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; line-height: 1.6; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { font-size: 24px; color: #0056b3; }
        .section { margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        .section h2 { font-size: 18px; color: #333; margin-bottom: 10px; }
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .data-table th, .data-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .data-table th { background-color: #f2f2f2; font-weight: bold; width: 30%; }
        .notes { border: 1px solid #ddd; padding: 10px; background-color: #f9f9f9; min-height: 80px; }
        .footer { text-align: center; margin-top: 30px; font-size: 10px; color: #777; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Ficha de Consulta</h1>
        <p>Sistema de Gestão Hospitalar</p>
    </div>

    <div class="section">
        <h2>Dados do Paciente</h2>
        <table class="data-table">
            <tr><th>Nome</th><td>' . htmlspecialchars($consultation['paciente_nome']) . '</td></tr>
            <tr><th>NIF</th><td>' . htmlspecialchars($consultation['paciente_nif']) . '</td></tr>
            <tr><th>Data de Nascimento</th><td>' . htmlspecialchars($patientBirthDate) . '</td></tr>
        </table>
    </div>

    <div class="section">
        <h2>Dados da Consulta</h2>
        <table class="data-table">
            <tr><th>ID da Consulta</th><td>' . htmlspecialchars($consultation['id']) . '</td></tr>
            <tr><th>Data</th><td>' . htmlspecialchars($consultationDate) . '</td></tr>
            <tr><th>Hora</th><td>' . htmlspecialchars($consultation['hora']) . '</td></tr>
            <tr><th>Médico</th><td>' . htmlspecialchars($consultation['medico_nome']) . '</td></tr>
            <tr><th>Especialidade</th><td>' . htmlspecialchars($consultation['medico_especialidade']) . '</td></tr>
            <tr><th>Clínica</th><td>' . htmlspecialchars($consultation['clinica']) . '</td></tr>
            <tr><th>Estado</th><td>' . htmlspecialchars($consultation['estado_formatado']) . '</td></tr>
        </table>
    </div>

    <div class="section">
        <h2>Notas da Consulta</h2>
        <div class="notes">' . nl2br(htmlspecialchars($consultation['notas'] ?? 'N/A')) . '</div>
    </div>

    <div class="footer">
        Gerado em ' . date('d/m/Y H:i:s') . '
    </div>
</body>
</html>';


// --- Dompdf Configuration and Generation ---
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);
// If you have issues with Portuguese characters, try setting a font that supports them.
// For example, 'DejaVu Sans' is often used as it's bundled with Dompdf and supports a wide range of Unicode characters.
// Make sure your HTML `font-family` matches this if you're experiencing problems.
// $options->set('defaultFont', 'DejaVu Sans'); // Set default font if needed

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);

// (Optional) Set paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// --- Save and Serve PDF ---
$fileName = "ficha_consulta_" . $consultation['id'] . "_paciente_" . $patientId . "_" . date('YmdHis') . ".pdf";
$filePath = $pdfStoragePath . $fileName;
$publicFileUrl = '/public/pdfs/' . $fileName; // Public URL relative to your web root

// Save the generated PDF to the server
file_put_contents($filePath, $dompdf->output());

// Return success response to the client
http_response_code(200);
echo json_encode([
    'success' => true,
    'message' => 'Ficha gerada com sucesso!',
    'consultationId' => $consultationId,
    'patientId' => $patientId,
    'fileUrl' => $publicFileUrl // Send the URL for the client to open
]);

exit();
