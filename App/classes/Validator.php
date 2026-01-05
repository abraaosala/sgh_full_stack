<?php

namespace App\classes;

class Validator
{
    private $errors = [];
    
    private $validations = [];

    public function __construct(private array $data)
    {
    }

    // Adiciona cada validação à fila de execuções
    public function Roles($key, $method, $errorMessage, $params = [])
    {
        $this->validations[] = [
            'key' => $key,
            'method' => $method,
            'errorMessage' => $errorMessage,
            'params' => $params
        ];
        return $this;
    }

    // Método para executar todas as validações e retornar true ou false
    public function validation()
    {
        foreach ($this->validations as $validation) {
            $key = $validation['key'];
            $method = $validation['method'];
            $errorMessage = $validation['errorMessage'];
            $params = $validation['params'];

            // Verifica se a chave existe no array de dados
            if (!isset($this->data[$key])) {
                $this->addError($key, sprintf('O campo %s não existe.', $key));
                continue;
            }

            $value = $this->data[$key];

            // Verifica se o método de validação existe
            if (method_exists($this, $method)) {
                array_unshift($params, $value); // Adiciona o valor no início dos parâmetros
                if (!call_user_func_array([$this, $method], $params)) {
                    $this->addError($key, $errorMessage);
                }
            } else {
                throw new \Exception(sprintf("Método de validação '%s' não encontrado.", $method));
            }
        }

        // Retorna true se não houver erros, false se houver
        return empty($this->errors);
    }

    // Adiciona erro à chave correspondente, permitindo múltiplas mensagens
    private function addError($key, $message)
    {
        if (!isset($this->errors[$key])) {
            $this->errors[$key] = [];
        }
        
        $this->errors[$key][] = $message; // Adiciona a nova mensagem ao array
    }

    // Métodos de validação
    private function required($value)
    {
        return !empty($value);
    }

    private function email($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    private function bI($value)
    {
        //Padrão
        $pattern = '/^\d{9}[A-z]{2}0\d{2}$/i';
        if (preg_match($pattern, (string) $value)) {
            return true;
        } else {
            return false;
        }
    }
    
    private function minLength($value, $min)
    {
        return strlen((string) $value) >= $min;
    }

    private function maxLength($value, $max)
    {
        return strlen((string) $value) <= $max;
    }

    private function numeric($value)
    {
        return is_numeric($value);
    }

    private function integer($value)
    {
        return filter_var($value, FILTER_VALIDATE_INT) !== false;
    }

    private function decimal($value)
    {
        return filter_var($value, FILTER_VALIDATE_FLOAT) !== false;
    }

    private function between($value, $min, $max)
    {
        return $value >= $min && $value <= $max;
    }

    private function url($value)
    {
        return filter_var($value, FILTER_VALIDATE_URL) !== false;
    }

    private function date($value, $format = 'Y-m-d')
    {
        $d = \DateTime::createFromFormat($format, $value);
        return $d && $d->format($format) === $value;
    }

    private function alpha($value)
    {
        return ctype_alpha((string) $value);
    }

    private function alphaNumeric($value)
    {
        return ctype_alnum((string) $value);
    }

    private function alphaNumericSpace($value)
    {
        return preg_match('/^[a-zA-Z0-9\s]+$/', (string) $value);
    }

    private function ip($value)
    {
        return filter_var($value, FILTER_VALIDATE_IP) !== false;
    }

    private function ipv4($value)
    {
        return filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false;
    }

    private function ipv6($value)
    {
        return filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false;
    }

    private function phone($value)
    {
        return preg_match('/^\+?[0-9\s\-\(\)]+$/', (string) $value);
    }

    private function regex($value, $pattern)
    {
        return preg_match($pattern, (string) $value);
    }

     private function compare($value, $confirm)
    {
        return $value === $confirm;
    }


    // Retorna o array de erros
    public function getErrors()
    {
        return $this->errors;
    }
}

/* 
// Exemplo de uso

// Array de dados para validar
$data = [
    'email' => 'user@example.com',
    'idade' => 17,
    'website' => 'invalid-url',
];

// Criando instância do Validator passando o array de dados
$validator = new Validator($data);

$validator
    ->Roles('email', 'required', 'O campo Email é obrigatório.')
    ->Roles('email', 'email', 'O email informado não é válido.')
    ->Roles('idade', 'numeric', 'A idade deve ser numérica.')
    ->Roles('idade', 'between', 'A idade deve estar entre 18 e 60 anos.', [18, 60])
    ->Roles('website', 'url', 'O website informado não é uma URL válida.')
    ->Roles('idade', 'minLength', 'A idade deve ter pelo menos 2 caracteres.', [2]); // Exemplo de erro adicional

// Chamando o método validation
if ($validator->validation()) {
    echo "Validação bem-sucedida!";
} else {
    print_r($validator->getErrors());
}
 */