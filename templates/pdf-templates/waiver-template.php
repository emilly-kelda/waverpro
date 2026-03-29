<?php
/**
 * WaverPro PDF Template
 * Used by Gravity PDF to generate signed waivers
 *
 * @package WaverPro
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Get form data
$form_data = $args['form_data'];
$entry = $args['entry'];
$form = $args['form'];

// Get school settings
$school_id = get_option('waverpro_school_id', 'Watersports School');
$primary_color = get_option('waverpro_primary_color', '#0066cc');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12pt;
            line-height: 1.6;
            color: #000;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid <?php echo esc_attr($primary_color); ?>;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .header h1 {
            color: <?php echo esc_attr($primary_color); ?>;
            font-size: 24pt;
            margin: 0;
        }

        .header .subtitle {
            font-size: 14pt;
            color: #666;
            margin-top: 5px;
        }

        .section {
            margin-bottom: 25px;
        }

        .section h2 {
            color: <?php echo esc_attr($primary_color); ?>;
            font-size: 16pt;
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }

        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }

        .info-row {
            display: table-row;
        }

        .info-label {
            display: table-cell;
            font-weight: bold;
            width: 35%;
            padding: 8px;
            background-color: #f5f5f5;
            border: 1px solid #ddd;
        }

        .info-value {
            display: table-cell;
            padding: 8px;
            border: 1px solid #ddd;
        }

        .medical-alert {
            background-color: #fff3cd;
            border: 2px solid #ff9800;
            padding: 15px;
            margin: 20px 0;
        }

        .medical-alert h3 {
            color: #ff6600;
            margin-top: 0;
        }

        .terms-text {
            text-align: justify;
            font-size: 10pt;
            line-height: 1.5;
            margin: 20px 0;
            padding: 15px;
            border: 1px solid #ddd;
            background-color: #fafafa;
        }

        .signature-section {
            margin-top: 40px;
            page-break-inside: avoid;
        }

        .signature-box {
            border: 2px solid #000;
            padding: 15px;
            min-height: 100px;
            margin-bottom: 10px;
        }

        .signature-image {
            max-width: 400px;
            max-height: 100px;
        }

        .signature-info {
            font-size: 9pt;
            color: #666;
            margin-top: 10px;
        }

        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 9pt;
            color: #666;
            text-align: center;
        }

        .lgpd-notice {
            background-color: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 10px;
            margin: 20px 0;
            font-size: 9pt;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <h1>TERMO DE RESPONSABILIDADE</h1>
        <div class="subtitle">ATIVIDADES DE WATERSPORTS</div>
        <div class="subtitle"><?php echo esc_html($school_id); ?></div>
    </div>

    <!-- Student Information -->
    <div class="section">
        <h2>📋 Dados do Participante</h2>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Nome Completo:</div>
                <div class="info-value"><?php echo esc_html($form_data['name'] ?? 'N/A'); ?></div>
            </div>
            <div class="info-row">
                <div class="info-label">E-mail:</div>
                <div class="info-value"><?php echo esc_html($form_data['email'] ?? 'N/A'); ?></div>
            </div>
            <div class="info-row">
                <div class="info-label">WhatsApp:</div>
                <div class="info-value"><?php echo esc_html($form_data['phone'] ?? 'N/A'); ?></div>
            </div>
            <div class="info-row">
                <div class="info-label">Data de Nascimento:</div>
                <div class="info-value"><?php echo esc_html($form_data['date_of_birth'] ?? 'N/A'); ?></div>
            </div>
            <div class="info-row">
                <div class="info-label">CPF/Passaporte:</div>
                <div class="info-value"><?php echo esc_html($form_data['cpf_passport'] ?? 'N/A'); ?></div>
            </div>
        </div>
    </div>

    <!-- Activity Information -->
    <div class="section">
        <h2>🏄 Informações da Atividade</h2>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Modalidade:</div>
                <div class="info-value"><strong><?php echo esc_html(strtoupper($form_data['activity'] ?? 'N/A')); ?></strong></div>
            </div>
            <div class="info-row">
                <div class="info-label">Data da Aula:</div>
                <div class="info-value"><?php echo esc_html($form_data['class_date'] ?? 'N/A'); ?></div>
            </div>
        </div>
    </div>

    <!-- Medical Information -->
    <?php if (!empty($form_data['medical_conditions'])): ?>
    <div class="medical-alert">
        <h3>🚑 ALERTA MÉDICO</h3>
        <p><strong>Condições Médicas:</strong></p>
        <p><?php echo nl2br(esc_html($form_data['medical_conditions'])); ?></p>
    </div>
    <?php endif; ?>

    <!-- Emergency Contact -->
    <div class="section">
        <h2>📞 Contato de Emergência</h2>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Nome:</div>
                <div class="info-value"><?php echo esc_html($form_data['emergency_contact_name'] ?? 'N/A'); ?></div>
            </div>
            <div class="info-row">
                <div class="info-label">Telefone:</div>
                <div class="info-value"><?php echo esc_html($form_data['emergency_contact_phone'] ?? 'N/A'); ?></div>
            </div>
        </div>
    </div>

    <!-- Terms and Conditions -->
    <div class="section">
        <h2>📜 Termos de Responsabilidade</h2>
        <div class="terms-text">
            <p>Eu, <strong><?php echo esc_html($form_data['name'] ?? '___________________'); ?></strong>, declaro que:</p>

            <ol>
                <li>Estou ciente dos riscos inerentes à prática de esportes aquáticos.</li>
                <li>Estou em condições físicas adequadas para participar da atividade.</li>
                <li>Comprometo-me a seguir todas as instruções de segurança fornecidas.</li>
                <li>Isento a escola de qualquer responsabilidade por acidentes decorrentes de negligência própria.</li>
                <li>As informações médicas fornecidas são verdadeiras e completas.</li>
            </ol>

            <p><strong>Declaro estar ciente de que a prática de watersports envolve riscos, incluindo mas não limitado a: afogamento, lesões por colisão, hipotermia, queimaduras solares, e outros riscos típicos de atividades aquáticas.</strong></p>
        </div>
    </div>

    <!-- LGPD Notice -->
    <div class="lgpd-notice">
        <strong>📋 LGPD - Lei Geral de Proteção de Dados:</strong><br>
        Seus dados pessoais serão utilizados exclusivamente para fins de segurança, controle de atividades e contato emergencial, em conformidade com a Lei nº 13.709/2018 (LGPD). Você possui direito de acesso, correção e exclusão de seus dados a qualquer momento.
    </div>

    <!-- Signature Section -->
    <div class="signature-section">
        <h2>✍️ Assinatura Digital</h2>

        <div class="signature-box">
            <?php if (!empty($form_data['signature'])): ?>
                <img src="<?php echo esc_url($form_data['signature']); ?>" class="signature-image" alt="Assinatura">
            <?php else: ?>
                <p style="color: #999; text-align: center; padding: 30px;">Assinatura não disponível</p>
            <?php endif; ?>
        </div>

        <div class="signature-info">
            <strong>Data e Hora:</strong> <?php echo esc_html($form_data['date_created'] ?? date('d/m/Y H:i:s')); ?><br>
            <strong>IP:</strong> <?php echo esc_html($form_data['ip'] ?? 'N/A'); ?><br>
            <strong>Hash de Verificação:</strong> <?php echo esc_html(substr(hash('sha256', serialize($form_data)), 0, 32)); ?>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Documento gerado automaticamente pelo WaverPro System</p>
        <p>Data de emissão: <?php echo date('d/m/Y H:i:s'); ?></p>
        <p>ID do Termo: <?php echo esc_html($entry['id'] ?? 'N/A'); ?></p>
    </div>

</body>
</html>