<?php

namespace App\helpers;

class ViewHelper
{
    /**
     * Chamar o Front End.
     */
    public static function asset(string|array $filename, bool $ui = false): array|string
    {
        if (is_array($filename)) {
            return array_map(self::asset(...), $filename);
        }
        
        if ($ui) {
            return root() . dirname(ASSETS) . '/ui/assets/' . $filename;
        }
        
        return root() . ASSETS . $filename;
    }

    public static function assetLink(string|array $filename, $ui = false): iterable|string
    {
        if (is_array($filename)) {
            return array_map(self::assetLink(...), $filename);
        }
        
        $dirname = $ui ? ASSETS . 'ui/' . $filename : ASSETS . $filename;
        return sprintf("<link rel='stylesheet' href='%s'>", $dirname);
    }

    public static function assetJs(iterable|string $filename, bool $ui = false): string|iterable
    {
        if (is_array($filename)) {
            return array_map(self::assetJs(...), $filename);
        }
        
        $dirname = $ui ? ASSETS . 'ui/' . $filename : ASSETS . $filename;
        return sprintf("<script src='%s'></script>", $dirname);
    }

    public static function view(string $filename, bool $include = true)
    {
        $base = VIEW;
        $view = $base . $filename;
        if (!$include) {
            return $view;
        }
        
        include_once $view;
        return null;
    }

    public static function reviewMaxLenContent(string $content, int $max = 100)
    {
        if (strlen($content) > $max) {
            return substr($content, 0, $max) . " <i class='bi bi-three-dots'></i>";
        }
        
        return $content;
    }

    public static function divAlert($content, $type)
    {
        return sprintf("<div class='alert alert-%s text-center' role='alert'>%s</div>", $type, $content);
    }
}
