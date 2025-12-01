<?php

namespace App\Traits;

trait EnsuresUtf8
{
    /**
     * Helper to ensure string is UTF-8.
     *
     * @param mixed $value
     * @return mixed
     */
    protected function ensureUtf8($value)
    {
        if (is_null($value) || !is_string($value)) {
            return $value;
        }

        // Detect encoding
        $encoding = mb_detect_encoding($value, mb_detect_order(), true);

        if ($encoding && $encoding !== 'UTF-8') {
            $value = mb_convert_encoding($value, 'UTF-8', $encoding);
        } elseif (!$encoding) {
            // If detection fails, assume ISO-8859-1 (common culprit)
            $value = mb_convert_encoding($value, 'UTF-8', 'ISO-8859-1');
        }

        // Final cleanup of any invalid UTF-8 sequences
        // iconv with //IGNORE drops invalid characters
        return iconv('UTF-8', 'UTF-8//IGNORE', $value);
    }
}
