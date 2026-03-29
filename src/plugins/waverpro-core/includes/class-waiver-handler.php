<?php
/**
 * Waiver Handler Class
 * Handles all waiver submission and processing logic
 *
 * @package WaverPro
 */

if (!defined('ABSPATH')) {
    exit;
}

class WaverPro_Waiver_Handler {

    /**
     * Process waiver submission from Gravity Forms
     *
     * @param array $entry Gravity Forms entry data
     * @param array $form Gravity Forms form data
     * @return bool Success status
     */
    public function process_submission($entry, $form) {

        // 1. Validate submission
        if (!$this->validate_submission($entry)) {
            error_log('WaverPro: Invalid submission data');
            return false;
        }

        // 2. Create audit trail (LGPD compliance)
        $audit_id = $this->create_audit_trail($entry);

        // 3. Generate PDF waiver
        $pdf_url = $this->generate_pdf($entry);

        // 4. Trigger Google Drive backup
        $this->trigger_google_drive_backup($pdf_url, $entry);

        // 5. Send WhatsApp confirmation
        $this->send_whatsapp_confirmation($entry);

        return true;
    }

    /**
     * Validate submission data
     */
    private function validate_submission($entry) {
        // Check required fields exist
        $required_fields = ['name', 'email', 'phone'];

        foreach ($required_fields as $field) {
            if (empty($entry[$field])) {
                return false;
            }
        }

        // Verify LGPD consent was given
        if (empty($entry['lgpd_consent'])) {
            return false;
        }

        return true;
    }

    /**
     * Create audit trail for LGPD compliance
     */
    private function create_audit_trail($entry) {
        global $wpdb;

        $table_name = $wpdb->prefix . 'waverpro_audit_trail';

        $audit_data = array(
            'entry_id' => $entry['id'],
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'timestamp' => current_time('mysql'),
            'signature_hash' => $this->generate_signature_hash($entry),
            'lgpd_consent' => $entry['lgpd_consent']
        );

        $wpdb->insert($table_name, $audit_data);

        return $wpdb->insert_id;
    }

    /**
     * Generate cryptographic hash of signature for audit trail
     */
    private function generate_signature_hash($entry) {
        $signature_data = $entry['signature'] ?? '';
        return hash('sha256', $signature_data . $entry['id'] . time());
    }

    /**
     * Generate PDF waiver document
     */
    private function generate_pdf($entry) {
        // Integration with Gravity PDF
        // This will be configured via Gravity PDF settings

        // Return PDF URL (Gravity PDF generates this automatically)
        $pdf_url = $this->get_gravity_pdf_url($entry);

        return $pdf_url;
    }

    /**
     * Get Gravity PDF URL
     */
    private function get_gravity_pdf_url($entry) {
        // Gravity PDF creates URLs in this format
        // This is a placeholder - actual implementation depends on Gravity PDF config
        return site_url('/pdf/' . $entry['id'] . '/waiver.pdf');
    }

    /**
     * Trigger Google Drive backup via Zapier webhook
     */
    private function trigger_google_drive_backup($pdf_url, $entry) {
        $webhook_url = get_option('waverpro_google_drive_webhook');

        if (empty($webhook_url)) {
            error_log('WaverPro: Google Drive webhook not configured');
            return false;
        }

        $payload = array(
            'student_name' => $entry['name'],
            'activity_type' => $entry['activity'],
            'sign_date' => current_time('Y-m-d'),
            'pdf_url' => $pdf_url,
            'school_id' => get_option('waverpro_school_id'),
            'trigger' => 'google_drive_backup'
        );

        $response = wp_remote_post($webhook_url, array(
            'body' => json_encode($payload),
            'headers' => array('Content-Type' => 'application/json'),
            'timeout' => 30
        ));

        if (is_wp_error($response)) {
            error_log('WaverPro: Google Drive backup failed - ' . $response->get_error_message());
            return false;
        }

        return true;
    }

    /**
     * Send WhatsApp confirmation message
     */
    private function send_whatsapp_confirmation($entry) {
        $webhook_url = get_option('waverpro_whatsapp_webhook');

        if (empty($webhook_url)) {
            error_log('WaverPro: WhatsApp webhook not configured');
            return false;
        }

        // Get message template in user's language
        $language = $entry['language'] ?? 'pt-BR';
        $message = $this->get_whatsapp_message_template($language, $entry);

        $payload = array(
            'phone' => $entry['phone'],
            'message' => $message,
            'trigger' => 'waiver_signed_confirmation'
        );

        $response = wp_remote_post($webhook_url, array(
            'body' => json_encode($payload),
            'headers' => array('Content-Type' => 'application/json'),
            'timeout' => 30
        ));

        if (is_wp_error($response)) {
            error_log('WaverPro: WhatsApp confirmation failed - ' . $response->get_error_message());
            return false;
        }

        return true;
    }

    /**
     * Get WhatsApp message template
     */
    private function get_whatsapp_message_template($language, $entry) {
        $templates = array(
            'pt-BR' => "✅ Termo assinado com sucesso!\n\n📄 Seu documento foi registrado\n📅 Aula confirmada para {$entry['class_date']}\n🏄‍♂️ Nos vemos na água!",
            'en-US' => "✅ Waiver signed successfully!\n\n📄 Your document has been registered\n📅 Class confirmed for {$entry['class_date']}\n🏄‍♂️ See you on the water!",
            'es-ES' => "✅ Término firmado con éxito!\n\n📄 Su documento ha sido registrado\n📅 Clase confirmada para {$entry['class_date']}\n🏄‍♂️ ¡Nos vemos en el agua!"
        );

        return $templates[$language] ?? $templates['pt-BR'];
    }

    /**
     * Get waiver statistics for dashboard
     */
    public function get_statistics($date_range = 'today') {
        global $wpdb;

        $table_name = $wpdb->prefix . 'gf_entry';

        // Get count of signed waivers
        $stats = array(
            'signed_today' => 0,
            'pending' => 0,
            'medical_alerts' => 0,
            'total_this_month' => 0
        );

        // These queries will be implemented based on Gravity Forms data structure

        return $stats;
    }
}