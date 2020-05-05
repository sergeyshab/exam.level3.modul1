<?php

class Session {

	
// записывает сообщение в сессию

    public static function put($name, $value) {
                                                
        return $_SESSION[$name] = $value;       
    }

// проверяет существует ли сессия

    public static function exists($name) {
        return (isset($_SESSION[$name])) ? true : false;
    }

// удаляет сессию

    public static function delete($name) {
        if(self::exists($name)) {
            unset($_SESSION[$name]);
        }
    }

// получает значение из сессии

    public static function get($name) {
        return $_SESSION[$name];
    }

// записывает сообщение в сессию, либо выводит flash сообщение

    public static function flash($name, $string = '') {
                                                        

        if(self::exists($name) && self::get($name) !== '') { 
            $session = self::get($name);                     
            self::delete($name);                             
            return $session;                                 
        } else {
            self::put($name, $string); 
                                       
        }
    }
}
