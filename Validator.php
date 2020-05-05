<?php


class Validator {

    private $passed = false, $erorrs = [], $db = null;
	
// создаёт соединение с  базой

    public function __construct() {
        $this->db = Database::getInstance();
    }

// проверяет валидационные данные

    public function check($source, $items = [], $user_id = null) {

        foreach ($items as $item => $rules) { 
                                              
            foreach ($rules as $rule => $rule_value) { 
                                                       

              $value = $source[$item]; 

              if($rule == 'required' && empty($value)) {

                  $this->addError(" введите {$item}");
              } else if(!empty($value)) {
                  switch ($rule) {

                      case 'min':
                          if(strlen($value) < $rule_value) {
                              $this->addError("{$item} должен быть минимум {$rule_value} символа");
                      }
                      break;

                      case 'max':
                          if (strlen($value) > $rule_value) {
                             $this->addError("{$item} должен быть максимум {$rule_value} символа");
                      }
                      break;

                      case 'matches':
                          if($value != $source[$rule_value]) {
                              $this->addError("{$rule_value} должен совпадать с {$item}");
                          }
                          break;

                      case 'unique':
                          $check = $this->db->get($rule_value, [$item, '=', $value]);
						  
                          if($check->count()) {
                              $this->addError("{$item} уже существует");
                          }
                          break;

                      case 'email':
                          if(!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                              $this->addError("не правильный формат {$item}");
                          }
                          break;

                      case 'equal':
                          $User = new User;
                          $User->data()->password;

                          if(!password_verify($value, $User->data()->password)) {
                              $this->addError("не правильный текущий {$item}");
                          }
                          break;

                  }
              }

            }
        }

        if(empty($this->erorrs)) {
            $this->passed = true;
        }

        return $this;

    }

// добавляет сообщение об ошибке

    public function addError($error) {
        //echo $error;
        $this->erorrs[] = $error;
    }

// возвращает массив ошибок

    public function errors() {
        return $this->erorrs;
    }

// возвращает результат валидации

    public function passed() {
        return $this->passed;
    }
}