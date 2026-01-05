<?php

declare(strict_types=1);

namespace App\classes;

class MedicalValidator
{
    private static array $patterns = [
        'DOCTOR'      => '/^(?<number>\d{5,6})\/(?<year>\d{4})$/',
        'NURSE'       => '/^ENF-(?<number>\d{5,6})\/(?<year>\d{4})$/',
        'TECHNICIAN'  => '/^TL-(?<number>\d{5,6})\/(?<year>\d{4})$/',
        'PHARMACIST'  => '/^FAR-(?<number>\d{5,6})\/(?<year>\d{4})$/',
        'PSYCHOLOGIST' => '/^PSI-(?<number>\d{5,6})\/(?<year>\d{4})$/',
        'DENTIST'     => '/^DENT-(?<number>\d{5,6})\/(?<year>\d{4})$/',
        'RADIOLOGY'   => '/^RAD-(?<number>\d{5,6})\/(?<year>\d{4})$/',
    ];

    /**
     * Valida número de registro para qualquer categoria e ano válido (não futuro).
     */
    public static function isValid(string $registrationNumber): bool
    {
        return self::validateAndCheckYear($registrationNumber) === true;
    }

    /**
     * Retorna a categoria do profissional ou null se inválido.
     */
    public static function getCategory(string $registrationNumber): ?string
    {
        foreach (self::$patterns as $category => $pattern) {
            if (preg_match($pattern, $registrationNumber)) {
                return $category;
            }
        }

        return null;
    }

    /**
     * Valida número para uma categoria específica e ano válido.
     */
    public static function isValidFor(string $registrationNumber, string $category): bool
    {
        $category = strtoupper($category);
        if (!isset(self::$patterns[$category])) {
            return false;
        }

        return self::validateAndCheckYear($registrationNumber, $category) === true;
    }

    /**
     * Lista as categorias suportadas.
     */
    public static function getSupportedCategories(): array
    {
        return array_keys(self::$patterns);
    }

    /**
     * Valida a regex e verifica se o ano não é futuro.
     * Retorna true se ok, ou string com mensagem de erro.
     */
    public static function validateAndCheckYear(string $registrationNumber, ?string $category = null)
    {
        $patterns = $category ?
            [$category => self::$patterns[$category]] :
            self::$patterns;

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $registrationNumber, $matches)) {
                $year = (int)($matches['year'] ?? 0);
                $currentYear = (int)date('Y');

                if ($year > $currentYear) {
                    return sprintf('Invalid year: %d is in the future.', $year);
                }

                return true; // Tudo ok
            }
        }

        return "Invalid format or category.";
    }

    /**
     * Extrai o ano do número de registro, ou null se inválido.
     */
    public static function extractYear(string $registrationNumber): ?int
    {
        foreach (self::$patterns as $pattern) {
            if (preg_match($pattern, $registrationNumber, $matches)) {
                return isset($matches['year']) ? (int)$matches['year'] : null;
            }
        }

        return null;
    }
}