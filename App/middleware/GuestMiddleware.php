<?php

namespace App\Middleware;

use core\Middleware;

class GuestMiddleware extends Middleware
{
  public function handle(): bool
  {
    if (session()->has()) {
      redirect();
    }
    
    return true;
  }
}