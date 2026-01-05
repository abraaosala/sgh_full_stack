<?php

namespace App\Controllers\Admin;

use App\classes\Json;
use App\Dao\Models\Provincia;
use core\ApiController;

class ProvinciaController  extends ApiController 
{


   public function index()
   {
      (new Provincia())->select()->get();
      $datajson= Json::data();
      
      // dd($datajson);
       Json::encode([
      'title'=>'api de Provincia', 
       'data'=>$datajson,
      'status'=> 'true']);

   }
}