<?php

    namespace Core;

    class Validation
    {
        private $errors = array();

        public function validate($name, $value, $rules){

            if(in_array('required', $rules)){
                $value = trim($value);
                if(empty($value)){
                    $this->errors[$name] = "Обязательное для заполнения поле";
                    return;
                }
            }

            if(in_array('email', $rules)){
                $value = trim($value);
                if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
                    $this->errors[$name] = "Неправильный формат email";
                    return;
                }
            }

        }

        public function getErrors(){
            return $this->errors;
        }
    }