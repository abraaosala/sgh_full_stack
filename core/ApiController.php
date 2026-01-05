<?php

namespace core;


abstract class ApiController
{

   public function __construct()
   {
      //tornar o uma paginas Api
      header(API);
   }


   abstract public function index();
}
