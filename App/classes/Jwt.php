<?php
namespace app\classes;

class Jwt {

    private static $secretKey = JWT_KEY;

      // Defina sua chave secreta aqui
    private static $algorithm = 'HS256';  // Algoritmo padrão: HMAC SHA256

    // Codifica os dados em Base64Url
    private static function base64UrlEncode($data) {
        return rtrim(strtr(base64_encode((string) $data), '+/', '-_'), '=');
    }

    // Decodifica os dados em Base64Url
    private static function base64UrlDecode($data) {
        $remainder = strlen((string) $data) % 4;
        if ($remainder !== 0) {
            $padlen = 4 - $remainder;
            $data .= str_repeat('=', $padlen);
        }
        
        return base64_decode(strtr($data, '-_', '+/'));
    }

    // Cria a assinatura do JWT
    private static function sign($header, $payload) {
        $encodedHeader = self::base64UrlEncode(json_encode($header));
        $encodedPayload = self::base64UrlEncode(json_encode($payload));
        $data = $encodedHeader . '.' . $encodedPayload;
        
        return self::base64UrlEncode(hash_hmac('sha256', $data, (string) self::$secretKey, true));
    }

    // Gera o JWT
    public static function encode($payload) {
        $header = [
            'alg' => self::$algorithm,
            'typ' => 'JWT'
        ];

        // Codificar o cabeçalho e o corpo
        $encodedHeader = self::base64UrlEncode(json_encode($header));
        $encodedPayload = self::base64UrlEncode(json_encode($payload));

        // Criar a assinatura
        $signature = self::sign($header, $payload);

        // Retornar o JWT completo
        return $encodedHeader . '.' . $encodedPayload . '.' . $signature;
    }

    // Decodifica um JWT e retorna o payload
    public static function decode($jwt) {
        [$encodedHeader, $encodedPayload, $encodedSignature] = explode('.', (string) $jwt);

        // Decodificar o payload
        $payload = json_decode((string) self::base64UrlDecode($encodedPayload), true);

        // Retornar o payload
        return $payload;
    }

    // Verifica se o JWT é válido
    public static function verify($jwt) {
        [$encodedHeader, $encodedPayload, $encodedSignature] = explode('.', (string) $jwt);

        // Recriar a assinatura com o header e payload
        $data = $encodedHeader . '.' . $encodedPayload;
        $expectedSignature = self::base64UrlEncode(hash_hmac('sha256', $data, (string) self::$secretKey, true));

        // Comparar as assinaturas
        return hash_equals($expectedSignature, $encodedSignature);
    }

    // Valida o JWT, incluindo verificações extras (ex: expiração)
    public static function validate($jwt) {
        if (!self::verify($jwt)) {
            return false;
        }

        // Decodificar o JWT
        $payload = self::decode($jwt);

        // Verificar a expiração (exp)
        if (isset($payload['exp']) && $payload['exp'] < time()) {
            return false;  // Token expirado
        }

        return true;  // Token válido
    }

}

