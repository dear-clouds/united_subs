<?php

namespace RSSAutopilot;

/**
 * Class ValidateForm
 * @package RSSAutopilot
 */
class ValidateForm {

    /**
     * Validation rules
     * @var array
     */
    private $fields = array();

    /**
     * Form data
     * @var array
     */
    private $data = array();

    /**
     * Default error messages
     * @var array
     */
    private $messages = array();

    /**
     * Available validators
     * @var array
     */
    private $validators = array(
        'required'
    );

    /**
     * Form class constructor, set default messages
     */
    public function __construct()
    {
        $this->messages = array(
            'required' => __( '%s is a required field', 'rss-autopilot' )
        );
    }

    /**
     * Add field to validate
     * @param $name
     * @param $label
     * @param array $validationRules
     */
    public function addField($name, $label, $validationRules=array())
    {
        $this->fields[$name] = array(
            'label' => $label,
            'rules' => $validationRules
        );
    }

    /**
     * Clear validation rules
     */
    public function clear()
    {
        $this->fields = array();
    }

    /**
     * Set form data
     * @param array $data
     */
    public function setData($data=array())
    {
        $this->data = $data;
    }

    /**
     * Validate form
     * @return array with errors
     */
    public function validate()
    {
        $errors = array();
        foreach ($this->fields as $field => $data)
        {
            foreach ($data['rules'] as $rule)
            {
                if (is_array($rule)) {
                    $validator = $rule[0];
                    $message = $rule[1];
                } else {
                    $validator = $rule;
                    $message = $this->messages[$rule];
                }

                $error = $this->validateField($field, $data['label'], $validator, $message);
                if ($error !== true) {
                    $errors[$field] = $error;
                }
            }
        }
        return $errors;
    }

    /**
     * Check if form is valid
     * @return bool
     */
    public function isValid()
    {
        $errors = $this->validate();
        if (count($errors)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Validate single field
     * @param string $field
     * @param string $label
     * @param string $rule
     * @param string $message
     * @return bool|string
     */
    public function validateField($field, $label, $rule, $message)
    {
        // If it isn't a valid rule - display wp error
        if (!in_array($rule, $this->validators)) {
            wp_die(__( 'Invalid validation rule', 'rss-autopilot' ));
        }

        $method = 'validate'.ucfirst($rule);
        // Check if field is valid
        if ($this->$method($field) === true) {
            return true;
        } else {
            return $this->putName($label, $message);
        }
    }

    /**
     * Put name into message string
     * @param string $label
     * @param string $message
     * @return string result message
     */
    private function putName($label, $message)
    {
        return str_replace('%s', $label, $message);
    }

    /**
     * Validate required field
     * @param string $field
     * @return bool
     */
    private function validateRequired($field)
    {
        if (isset($this->data[$field]) && $this->data[$field]) {
            return true;
        } else {
            return false;
        }
    }
}