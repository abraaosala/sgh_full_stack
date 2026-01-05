<?php
namespace App\Middleware;

use core\Middleware;

class DetectApiMiddleware extends Middleware
{
  public function handle(): bool
    {
      
      return true;
    }    
}
