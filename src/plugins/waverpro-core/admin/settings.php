<?php
/**
 * WaverPro Settings Page
 *
 * @package WaverPro
 */

if (!defined('ABSPATH')) {
    exit;
}

// Save settings if form submitted
if (isset($_POST['waverpro_save_settings'])) {
    check_admin_referer('waverpro_settings');

    update_option('waverpro_school_id', sanitize_text_field($_POST['school_id']));
    update_option('waverpro_google_drive_webhook', esc_url_raw($_POST['google_drive_webhook']));
    update_option('waverpro_whatsapp_webhook', esc_url_raw($_POST['whatsapp_webhook']));
    update_option('waverpro_primary_color', sanitize_hex_color($_POST['primary_color']));

    echo '<div class="notice notice-success"><p>' . esc_html__('Configurações salvas com sucesso!', 'waverpro') . '</p></div>';
}

// Get current settings
$school_id = get_option('waverpro_school_id', '');
$gdrive_webhook = get_option('waverpro_google_drive_webhook', '');
$whatsapp_webhook = get_option('waverpro_whatsapp_webhook', '');
$primary_color = get_option('waverpro_primary_color', '#0066cc');
?>

<div class="wrap">
    <h1><?php echo esc_html__('Configurações WaverPro', 'waverpro'); ?></h1>

    <form method="post" action="">
        <?php wp_nonce_field('waverpro_settings'); ?>

        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="school_id"><?php echo esc_html__('ID da Escola', 'waverpro'); ?></label>
                </th>
                <td>
                    <input type="text"
                           id="school_id"
                           name="school_id"
                           value="<?php echo esc_attr($school_id); ?>"
                           class="regular-text">
                    <p class="description">
                        <?php echo esc_html__('Identificador único da escola (usado para organização no Google Drive)', 'waverpro'); ?>
                    </p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="google_drive_webhook"><?php echo esc_html__('Google Drive Webhook URL', 'waverpro'); ?></label>
                </th>
                <td>
                    <input type="url"
                           id="google_drive_webhook"
                           name="google_drive_webhook"
                           value="<?php echo esc_url($gdrive_webhook); ?>"
                           class="regular-text">
                    <p class="description">
                        <?php echo esc_html__('URL do webhook Zapier/Make.com para backup no Google Drive', 'waverpro'); ?>
                    </p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="whatsapp_webhook"><?php echo esc_html__('WhatsApp Webhook URL', 'waverpro'); ?></label>
                </th>
                <td>
                    <input type="url"
                           id="whatsapp_webhook"
                           name="whatsapp_webhook"
                           value="<?php echo esc_url($whatsapp_webhook); ?>"
                           class="regular-text">
                    <p class="description">
                        <?php echo esc_html__('URL do webhook Zapier/Make.com para envio de mensagens WhatsApp', 'waverpro'); ?>
                    </p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="primary_color"><?php echo esc_html__('Cor Primária da Escola', 'waverpro'); ?></label>
                </th>
                <td>
                    <input type="color"
                           id="primary_color"
                           name="primary_color"
                           value="<?php echo esc_attr($primary_color); ?>">
                    <p class="description">
                        <?php echo esc_html__('Cor usada nos formulários e PDFs', 'waverpro'); ?>
                    </p>
                </td>
            </tr>
        </table>

        <?php submit_button(__('Salvar Configurações', 'waverpro'), 'primary', 'waverpro_save_settings'); ?>
    </form>

    <hr>

    <h2><?php echo esc_html__('Guia de Configuração', 'waverpro'); ?></h2>

    <div class="card">
        <h3>📋 Passo 1: Configurar Google Drive</h3>
        <ol>
            <li>Acesse <a href="https://zapier.com" target="_blank">Zapier</a> ou <a href="https://make.com" target="_blank">Make.com</a></li>
            <li>Crie um novo Zap/Scenario</li>
            <li>Trigger: Webhooks (Catch Hook)</li>
            <li>Action: Google Drive (Upload File)</li>
            <li>Cole a URL do webhook acima</li>
        </ol>
    </div>

    <div class="card">
        <h3>📱 Passo 2: Configurar WhatsApp</h3>
        <ol>
            <li>Crie conta em <a href="https://360dialog.com" target="_blank">360Dialog</a> ou <a href="https://twilio.com" target="_blank">Twilio</a></li>
            <li>Configure WhatsApp Business API</li>
            <li>No Zapier/Make, crie Action: Send WhatsApp Message</li>
            <li>Cole a URL do webhook acima</li>
        </ol>
    </div>
</div>