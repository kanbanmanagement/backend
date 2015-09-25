<?php

namespace Slimvc;

/**
* Validator class
*/
class Validator
{
    private $errors = [];
    private $config = [];
    private $data = [];
    private $valid = true;
    private $model;

    public function __construct($model, $data, $config)
    {
        $this->data = $data;
        $this->config = $config;
        $this->model = $model;
    }

    public function config($model, $data, $config)
    {
        $this->data = $data;
        $this->config = $config;
        $this->model = $model;
    }

    public function validate()
    {
        $this->valid = true;
        $this->errors = [];

        foreach ($this->config as $field => $rules) {
            $fieldName = "";

            foreach ($rules as $ruleName => $ruleValue) {
                switch ($ruleName) {
                    case 'name':
                        $fieldName = $ruleValue;
                    case 'required':
                        if ($ruleValue === true && strlen($this->data[$field]) == 0) {
                            $this->errors[] = 'Pole ' . $fieldName . " jest wymagane.";
                        }
                        break;
                    case 'min_length':
                        if (strlen($this->data[$field]) < $ruleValue) {
                            $this->errors[] = 'Pole ' . $fieldName .
                                ' powinno mieć co najmniej ' . $ruleValue . ' znaków.';
                        }
                        break;
                    case 'max_length':
                        if (strlen($this->data[$field]) > $ruleValue) {
                            $this->errors[] = 'Pole' . $fieldName .
                                ' może mieć nie więcej niż ' . $ruleValue . ' znaków.';
                        }
                        break;
                    case 'unique':
                        if (count($this->model->get($field, array($field => $this->data[$field]))) > 0) {
                            $this->errors[] = 'Dane z pola ' . $fieldName . " są już w bazie danych.";
                        }
                        break;
                    case 'matches':
                        if ($this->data[$field] != $this->data[$ruleValue]) {
                            $this->errors[] = 'Pole ' . $fieldName .
                                ' nie jest równe polu ' . strtolower($this->config[$ruleValue]['name']) . '.';
                        }
                        break;
                    case 'regex':
                        if (!preg_match($ruleValue, $this->data[$field])) {
                            $this->errors[] = 'Pole ' . $fieldName . " zawiera niedozwolone znaki.";
                        }
                        break;
                    case 'valid_email':
                        if (filter_var($this->data[$field], FILTER_VALIDATE_EMAIL) === false) {
                            $this->errors[] = 'Pole ' . $fieldName . " zawiera niepoprawny adres e-mail.";
                        }
                        break;
                }
            }
        }

        if (count($this->errors) > 0) {
            $this->valid = false;
        }

        return $this;
    }

    public function isValid()
    {
        return $this->valid;
    }

    public function errors()
    {
        return $this->errors;
    }
}
