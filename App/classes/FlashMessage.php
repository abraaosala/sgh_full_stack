<?php

namespace App\classes;

class FlashMessage
{
    // Define uma nova mensagem flash
    public static function set($key, $message, $type = 'success')
    {
          if (is_array($message)) {

            if (count($message) === 1) {
                $message = $message[0];
            } else {
                $messages = '';
                foreach ($message as $msg) {
                    $messages .= $msg . ' <br>';
                }
                
                $message = $messages;
            }
        }
          
        // self::init();
        $_SESSION['flash_messages'][$key] = [
            'message' => $message,
            'type' => $type
        ];
    }

    // Recupera e remove a mensagem flash
    public static function get($key)
    {
        if (isset($_SESSION['flash_messages'][$key])) {
            $flash = $_SESSION['flash_messages'][$key];
            unset($_SESSION['flash_messages'][$key]); // Remove após ser acessada
            return $flash;
        }
        
        return null;
    }

    // Checa se existe uma mensagem flash
    public static function has($key)
    {
        // self::init();
        return isset($_SESSION['flash_messages'][$key]);
    }

    // Exibe a mensagem flash formatada
    public static function display($key)
    {
        if (self::has($key)) {
            $flash = self::get($key);
            $message = $flash['message'];
            $type = $flash['type'];

            // Aqui, podemos personalizar o HTML para mostrar a mensagem
            return "<div class='alert alert-{$type} alert-dismissible fade show text-center'>{$message}
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
        
        return '';
    }

    public static function message($key)
    {
        if (self::has($key)) {
            $flash = self::get($key);
            $message = $flash['message'];
            $type = $flash['type'];

            // Aqui, podemos personalizar o HTML para mostrar a mensagem
            return sprintf("<span class='flash-message  text-%s'>%s</span>", $type, $message);
        }
        
        return '';
    }
}
