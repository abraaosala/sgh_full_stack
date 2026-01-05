<?php

namespace App\classes;

use App\trait\TemplateView as ViewTrait;

class View
{
   use ViewTrait;

   public static function srender(array $templates, ?array $data=null)
   {
      $sdclass= new static;

      $sdclass->render($templates,  $data);
   }

   public static function scontent(array $templates, ?array $data=null)
   {
      $sdclass= new static;

      $sdclass->content($templates,  $data);
   }
}