<?php
/**
 * WaverPro Admin Dashboard
 *
 * @package WaverPro
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get today's statistics
$handler = new WaverPro_Waiver_Handler();
$stats = $handler->get_statistics('today');
?>

<div class="wrap waverpro-dashboard">
    <h1><?php echo esc_html__('WaverPro Dashboard', 'waverpro'); ?></h1>

    <!-- Statistics Cards -->
    <div class="waverpro-stats-grid">
        <div class="waverpro-stat-card">
            <div class="stat-icon">✅</div>
            <div class="stat-content">
                <h3><?php echo esc_html($stats['signed_today']); ?></h3>
                <p><?php echo esc_html__('Check-ins Concluídos Hoje', 'waverpro'); ?></p>
            </div>
        </div>

        <div class="waverpro-stat-card pending">
            <div class="stat-icon">⏰</div>
            <div class="stat-content">
                <h3><?php echo esc_html($stats['pending']); ?></h3>
                <p><?php echo esc_html__('Termos Pendentes', 'waverpro'); ?></p>
            </div>
        </div>

        <div class="waverpro-stat-card medical">
            <div class="stat-icon">🚑</div>
            <div class="stat-content">
                <h3><?php echo esc_html($stats['medical_alerts']); ?></h3>
                <p><?php echo esc_html__('Alertas Médicos', 'waverpro'); ?></p>
            </div>
        </div>

        <div class="waverpro-stat-card">
            <div class="stat-icon">🆕</div>
            <div class="stat-content">
                <h3><?php echo esc_html($stats['total_this_month']); ?></h3>
                <p><?php echo esc_html__('Total Este Mês', 'waverpro'); ?></p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="waverpro-quick-actions">
        <h2><?php echo esc_html__('Ações Rápidas', 'waverpro'); ?></h2>
        <div class="action-buttons">
            <a href="<?php echo admin_url('admin.php?page=gf_entries'); ?>" class="button button-primary">
                📋 <?php echo esc_html__('Ver Todos os Termos', 'waverpro'); ?>
            </a>
            <a href="<?php echo admin_url('admin.php?page=waverpro-settings'); ?>" class="button">
                ⚙️ <?php echo esc_html__('Configurações', 'waverpro'); ?>
            </a>
            <a href="<?php echo admin_url('admin.php?page=waverpro-bulk'); ?>" class="button">
                📤 <?php echo esc_html__('Envio em Massa', 'waverpro'); ?>
            </a>
        </div>
    </div>

    <!-- Recent Waivers -->
    <div class="waverpro-recent-waivers">
        <h2><?php echo esc_html__('Termos Recentes', 'waverpro'); ?></h2>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th><?php echo esc_html__('Aluno', 'waverpro'); ?></th>
                    <th><?php echo esc_html__('Atividade', 'waverpro'); ?></th>
                    <th><?php echo esc_html__('Data da Aula', 'waverpro'); ?></th>
                    <th><?php echo esc_html__('Status', 'waverpro'); ?></th>
                    <th><?php echo esc_html__('Ações', 'waverpro'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Get recent entries from Gravity Forms
                // This will be populated with actual data
                ?>
                <tr>
                    <td colspan="5" class="no-items">
                        <?php echo esc_html__('Nenhum termo encontrado. Configure o Gravity Forms para começar.', 'waverpro'); ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- System Status -->
    <div class="waverpro-system-status">
        <h2><?php echo esc_html__('Status do Sistema', 'waverpro'); ?></h2>
        <table class="form-table">
            <tr>
                <th><?php echo esc_html__('Gravity Forms', 'waverpro'); ?></th>
                <td>
                    <?php
                    $gf_active = class_exists('GFForms');
                    echo $gf_active
                        ? '<span class="dashicons dashicons-yes-alt" style="color: green;"></span> Ativo'
                        : '<span class="dashicons dashicons-warning" style="color: red;"></span> Não instalado';
                    ?>
                </td>
            </tr>
            <tr>
                <th><?php echo esc_html__('Google Drive Webhook', 'waverpro'); ?></th>
                <td>
                    <?php
                    $gdrive_configured = !empty(get_option('waverpro_google_drive_webhook'));
                    echo $gdrive_configured
                        ? '<span class="dashicons dashicons-yes-alt" style="color: green;"></span> Configurado'
                        : '<span class="dashicons dashicons-warning" style="color: orange;"></span> Não configurado';
                    ?>
                </td>
            </tr>
            <tr>
                <th><?php echo esc_html__('WhatsApp Webhook', 'waverpro'); ?></th>
                <td>
                    <?php
                    $whatsapp_configured = !empty(get_option('waverpro_whatsapp_webhook'));
                    echo $whatsapp_configured
                        ? '<span class="dashicons dashicons-yes-alt" style="color: green;"></span> Configurado'
                        : '<span class="dashicons dashicons-warning" style="color: orange;"></span> Não configurado';
                    ?>
                </td>
            </tr>
        </table>
    </div>
</div>

<style>
.waverpro-dashboard {
    background: #fff;
    padding: 20px;
}

.waverpro-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin: 30px 0;
}

.waverpro-stat-card {
    background: #fff;
    border: 2px solid #000;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
}

.waverpro-stat-card.pending {
    border-color: #ff9800;
}

.waverpro-stat-card.medical {
    border-color: #f44336;
}

.stat-icon {
    font-size: 40px;
}

.stat-content h3 {
    font-size: 32px;
    margin: 0;
    font-weight: bold;
}

.stat-content p {
    margin: 5px 0 0 0;
    color: #666;
}

.waverpro-quick-actions {
    margin: 30px 0;
    padding: 20px;
    border: 2px solid #000;
}

.action-buttons {
    display: flex;
    gap: 10px;
    margin-top: 15px;
}

.waverpro-recent-waivers,
.waverpro-system-status {
    margin: 30px 0;
    padding: 20px;
    border: 2px solid #000;
}

.waverpro-system-status .form-table th {
    width: 200px;
}
</style>