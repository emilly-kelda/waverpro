<?php
/**
 * Gravity Forms Integration
 * Hooks into Gravity Forms submission process
 *
 * @package WaverPro
 */

if (!defined('ABSPATH')) {
    exit;
}

class WaverPro_Gravity_Forms_Integration {

    /**
     * Initialize hooks
     */
    public function __construct() {
        // Hook into Gravity Forms after submission
        add_action('gform_after_submission', array($this, 'process_waiver_submission'), 10, 2);

        // Add custom fields to forms
        add_filter('gform_add_field_buttons', array($this, 'add_custom_field_buttons'));

        // Modify form output
        add_filter('gform_pre_render', array($this, 'populate_activity_types'));
    }

    /**
     * Process waiver submission after form is submitted
     *
     * @param array $entry Gravity Forms entry
     * @param array $form Gravity Forms form
     */
    public function process_waiver_submission($entry, $form) {

        // Check if this is a waiver form (you can tag forms with CSS class 'waverpro-waiver')
        if (!$this->is_waiver_form($form)) {
            return;
        }

        // Log submission
        error_log('WaverPro: Processing waiver submission for entry ID: ' . $entry['id']);

        // Get form data
        $waiver_data = $this->extract_waiver_data($entry, $form);

        // Process with WaverPro handler
        $handler = new WaverPro_Waiver_Handler();
        $result = $handler->process_submission($waiver_data, $form);

        if ($result) {
            error_log('WaverPro: Successfully processed waiver for ' . $waiver_data['name']);
        } else {
            error_log('WaverPro: Failed to process waiver for entry ID: ' . $entry['id']);
        }
    }

    /**
     * Check if form is a waiver form
     */
    private function is_waiver_form($form) {
        // Check if form has 'waverpro-waiver' CSS class
        if (isset($form['cssClass']) && strpos($form['cssClass'], 'waverpro-waiver') !== false) {
            return true;
        }

        // Or check if form title contains 'waiver' or 'termo'
        if (isset($form['title'])) {
            $title_lower = strtolower($form['title']);
            if (strpos($title_lower, 'waiver') !== false || strpos($title_lower, 'termo') !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Extract waiver data from Gravity Forms entry
     */
    private function extract_waiver_data($entry, $form) {

        $data = array();

        // Map common field labels to data
        foreach ($form['fields'] as $field) {
            $field_id = $field->id;
            $field_label = strtolower($field->label);
            $field_value = isset($entry[$field_id]) ? $entry[$field_id] : '';

            // Name
            if (strpos($field_label, 'name') !== false || strpos($field_label, 'nome') !== false) {
                $data['name'] = $field_value;
            }

            // Email
            if ($field->type == 'email' || strpos($field_label, 'email') !== false) {
                $data['email'] = $field_value;
            }

            // Phone
            if ($field->type == 'phone' || strpos($field_label, 'phone') !== false || strpos($field_label, 'telefone') !== false || strpos($field_label, 'whatsapp') !== false) {
                $data['phone'] = $field_value;
            }

            // Activity
            if (strpos($field_label, 'activity') !== false || strpos($field_label, 'atividade') !== false || strpos($field_label, 'modalidade') !== false) {
                $data['activity'] = $field_value;
            }

            // Date of Birth
            if (strpos($field_label, 'birth') !== false || strpos($field_label, 'nascimento') !== false) {
                $data['date_of_birth'] = $field_value;
            }

            // CPF/Passport
            if (strpos($field_label, 'cpf') !== false || strpos($field_label, 'passport') !== false || strpos($field_label, 'passaporte') !== false) {
                $data['cpf_passport'] = $field_value;
            }

            // Medical conditions
            if (strpos($field_label, 'medical') !== false || strpos($field_label, 'médic') !== false || strpos($field_label, 'health') !== false || strpos($field_label, 'saúde') !== false) {
                $data['medical_conditions'] = $field_value;
            }

            // Emergency contact name
            if (strpos($field_label, 'emergency') !== false && strpos($field_label, 'name') !== false) {
                $data['emergency_contact_name'] = $field_value;
            }

            // Emergency contact phone
            if (strpos($field_label, 'emergency') !== false && (strpos($field_label, 'phone') !== false || strpos($field_label, 'telefone') !== false)) {
                $data['emergency_contact_phone'] = $field_value;
            }

            // LGPD Consent
            if (strpos($field_label, 'lgpd') !== false || strpos($field_label, 'consent') !== false) {
                $data['lgpd_consent'] = !empty($field_value);
            }

            // Signature
            if ($field->type == 'signature') {
                $data['signature'] = $field_value;
            }

            // Language
            if (strpos($field_label, 'language') !== false || strpos($field_label, 'idioma') !== false) {
                $data['language'] = $field_value;
            }

            // Class date
            if (strpos($field_label, 'class date') !== false || strpos($field_label, 'data da aula') !== false) {
                $data['class_date'] = $field_value;
            }
        }

        // Add entry metadata
        $data['id'] = $entry['id'];
        $data['form_id'] = $entry['form_id'];
        $data['date_created'] = $entry['date_created'];
        $data['ip'] = $entry['ip'];
        $data['user_agent'] = $entry['user_agent'];

        return $data;
    }

    /**
     * Populate activity types dropdown
     */
    public function populate_activity_types($form) {

        // Find activity field and populate options
        foreach ($form['fields'] as &$field) {
            $field_label = strtolower($field->label);

            if (strpos($field_label, 'activity') !== false || strpos($field_label, 'atividade') !== false) {

                // Set choices
                $field->choices = array(
                    array('text' => 'Kitesurf', 'value' => 'kitesurf'),
                    array('text' => 'Windsurf', 'value' => 'windsurf'),
                    array('text' => 'Wing Foil', 'value' => 'wing_foil'),
                    array('text' => 'Surf', 'value' => 'surf'),
                    array('text' => 'SUP', 'value' => 'sup'),
                );
            }
        }

        return $form;
    }

    /**
     * Get waiver form template (JSON export format)
     */
    public static function get_form_template() {
        return array(
            'title' => 'Termo de Responsabilidade - Watersports',
            'description' => 'Por favor, preencha todos os campos para participar das atividades.',
            'cssClass' => 'waverpro-waiver',
            'fields' => array(
                array(
                    'type' => 'text',
                    'label' => 'Nome Completo',
                    'isRequired' => true
                ),
                array(
                    'type' => 'email',
                    'label' => 'E-mail',
                    'isRequired' => true
                ),
                array(
                    'type' => 'phone',
                    'label' => 'WhatsApp',
                    'isRequired' => true
                ),
                array(
                    'type' => 'date',
                    'label' => 'Data de Nascimento',
                    'isRequired' => true
                ),
                array(
                    'type' => 'text',
                    'label' => 'CPF ou Passaporte',
                    'isRequired' => true
                ),
                array(
                    'type' => 'select',
                    'label' => 'Atividade',
                    'isRequired' => true,
                    'choices' => array('Kitesurf', 'Windsurf', 'Wing Foil', 'Surf', 'SUP')
                ),
                array(
                    'type' => 'date',
                    'label' => 'Data da Aula',
                    'isRequired' => true
                ),
                array(
                    'type' => 'textarea',
                    'label' => 'Condições Médicas / Alergias',
                    'description' => 'Informe qualquer condição médica relevante',
                    'isRequired' => false
                ),
                array(
                    'type' => 'text',
                    'label' => 'Contato de Emergência (Nome)',
                    'isRequired' => true
                ),
                array(
                    'type' => 'phone',
                    'label' => 'Contato de Emergência (Telefone)',
                    'isRequired' => true
                ),
                array(
                    'type' => 'checkbox',
                    'label' => 'LGPD - Consentimento',
                    'choices' => array(
                        WaverPro_LGPD_Compliance::get_consent_text('pt-BR')
                    ),
                    'isRequired' => true
                ),
                array(
                    'type' => 'signature',
                    'label' => 'Assinatura Digital',
                    'isRequired' => true
                )
            )
        );
    }
}

// Initialize integration
new WaverPro_Gravity_Forms_Integration();