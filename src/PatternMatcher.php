<?php

namespace Axlon\PostalCodeValidation;

class PatternMatcher
{
    /**
     * The matching patterns.
     *
     * @var array
     */
    protected $patterns;

    /**
     * Create a new postal code matcher.
     *
     * @param array $patterns
     * @return void
     */
    public function __construct(array $patterns)
    {
        $this->patterns = $patterns;
    }

    /**
     * Determine if the given postal code(s) are valid for the given country.
     *
     * @param string $countryCode
     * @param string ...$postalCodes
     * @return bool
     */
    public function passes(string $countryCode, string ...$postalCodes): bool
    {
        if (($pattern = $this->patternFor($countryCode)) === null) {
            return true;
        }

        foreach ($postalCodes as $postalCode) {
            if (preg_match($pattern, $postalCode) !== 1) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the matching pattern for the given country.
     *
     * @param string $countryCode
     * @return string|null
     */
    public function patternFor(string $countryCode): ?string
    {
        return $this->patterns[strtoupper($countryCode)] ?? null;
    }

    /**
     * Determine if a matching pattern exists for the given country.
     *
     * @param string $countryCode
     * @return bool
     */
    public function supports(string $countryCode): bool
    {
        return array_key_exists(strtoupper($countryCode), $this->patterns);
    }
}
