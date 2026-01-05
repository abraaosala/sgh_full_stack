<?php

namespace App\library;

class Token
{
    public function __construct(private array $data)
    {
    }

    public  function generate():string{
        $header= $this->header();
        $payload= $this->payload();
        $assign= $this->assign();

        return sprintf('%s.%s.%s ', $header, $payload, $assign);

    }

    private function header():string{
        $header=[
            'alg'=> 'HS256',
            'type'=> 'JWT'
        ];

        //converter
        $encode = encode_json_base24($header);

        return $encode;
    }


    public function payload():string
    {
        $payload= [];
        $data= $this->data;
        unset($data['exp']);
        $payload['exp'] = $this->getduration(); 
        $payload['data_expiracao'] = date('Y-m-d H:i:s', $payload['exp']); 
        //iterar data e atribuir payload
        foreach ($data as $key => $value) {
            $payload[$key]= $value;
        }

        return encode_json_base24($payload);
    }

    public function assign():string
    {
        $header= $this->header();
        $payload= $this->payload();

           //assinatura 
        //    $assignature= hash_hmac('sha256',"{$header}.{$payload}", TOKEN_KEY, true);
           $assignature= hash_hmac('sha256',sprintf('%s.%s', $header, $payload), TOKEN_KEY, true);

           return base64_encode($assignature);

    }

     private function getduration()
    {
    if (isset($this->data['exp'])) {
        $exp = time()+ $this->data['exp'];

        //unset($this->data['exp']);
    }        

    return $exp;
    }

    public function explore()
    {
        return explode('.',$this->generate());
    }
    




}
