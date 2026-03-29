<?php
/**
 * LGPD Compliance Class
 * Handles Brazilian data protection law compliance
 *
 * @package WaverPro
 */

if (!defined('ABSPATH')) {
    exit;
}

class WaverPro_LGPD_Compliance {

    /**
     * Get LGPD consent text in specified language
     *
     * @param string $language Language code (pt-BR, en-US, etc.)
     * @return string Consent text
     */
    public static function get_consent_text($language = 'pt-BR') {
        $texts = array(
            'pt-BR' => 'Autorizo o tratamento dos meus dados pessoais conforme a LGPD (Lei nº 13.709/2018) para fins de emissão de termo de responsabilidade, controle de segurança e comunicação sobre atividades da escola.',

            'en-US' => 'I authorize the processing of my personal data in accordance with LGPD (Law No. 13.709/2018) for waiver issuance, safety control, and school activity communications.',

            'es-ES' => 'Autorizo el tratamiento de mis datos personales de acuerdo con LGPD (Ley N° 13.709/2018) para emisión de términos de responsabilidad, control de seguridad y comunicaciones sobre actividades de la escuela.',

            'fr-FR' => 'J\'autorise le traitement de mes données personnelles conformément à la LGPD (Loi n° 13.709/2018) pour l\'émission de décharge, le contrôle de sécurité et les communications sur les activités de l\'école.'
        );

        return isset($texts[$language]) ? $texts[$language] : $texts['pt-BR'];
    }

    /**
     * Create database table for audit trail
     */
    public static function create_audit_table() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'waverpro_audit_trail';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            entry_id bigint(20) NOT NULL,
            ip_address varchar(100) NOT NULL,
            user_agent text NOT NULL,
            timestamp datetime NOT NULL,
            signature_hash varchar(255) NOT NULL,
            lgpd_consent tinyint(1) NOT NULL,
            PRIMARY KEY (id),
            KEY entry_id (entry_id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    /**
     * Log data access for LGPD compliance
     */
    public function log_data_access($user_id, $action, $entry_id) {
        global $wpdb;

        $table_name = $wpdb->prefix . 'waverpro_data_access_log';

        $wpdb->insert(
            $table_name,
            array(
                'user_id' => $user_id,
                'action' => $action,
                'entry_id' => $entry_id,
                'ip_address' => $_SERVER['REMOTE_ADDR'],
                'timestamp' => current_time('mysql')
            )
        );
    }

    /**
     * Get data retention period (LGPD recommends 5 years for liability documents)
     */
    public static function get_retention_period() {
        return 5 * YEAR_IN_SECONDS;
    }

    /**
     * Generate privacy policy content
     */
    public static function get_privacy_policy_content() {
        return '
        <h2>Política de Privacidade - WaverPro</h2>

        <h3>1. Dados Coletados</h3>
        <p>Coletamos os seguintes dados pessoais:</p>
        <ul>
            <li>Nome completo</li>
            <li>Data de nascimento</li>
            <li>CPF/Passaporte</li>
            <li>E-mail e telefone</li>
            <li>Endereço</li>
            <li>Condições médicas relevantes</li>
            <li>Contato de emergência</li>
        </ul>

        <h3>2. Finalidade do Tratamento</h3>
        <p>Seus dados são utilizados para:</p>
        <ul>
            <li>Emissão de termo de responsabilidade</li>
            <li>Controle de segurança durante atividades</li>
            <li>Comunicação sobre aulas e eventos</li>
            <li>Atendimento emergencial se necessário</li>
        </ul>

        <h3>3. Armazenamento e Segurança</h3>
        <p>Seus dados são armazenados de forma segura e criptografada, com backup automático em Google Drive.</p>

        <h3>4. Seus Direitos (LGPD)</h3>
        <p>Você tem direito a:</p>
        <ul>
            <li>Acessar seus dados</li>
            <li>Corrigir dados incorretos</li>
            <li>Solicitar exclusão de dados</li>
            <li>Revogar consentimento</li>
        </ul>

        <h3>5. Contato</h3>
        <p>Para exercer seus direitos ou esclarecer dúvidas: [email da escola]</p>
        ';
    }
}