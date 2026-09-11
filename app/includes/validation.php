<?php
// app/includes/validation.php

function is_valid_email($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validates a phone number.
 *
 * Rules:
 * - Allows spaces, dashes, dots, and parentheses in input.
 * - Supports international format with + (E.164-style).
 * - Accepts 7 to 15 digits after normalization.
 */
function is_valid_phone(string $phone): bool
{
    $phone = trim($phone);

    if ($phone === '') {
        return false;
    }

    // Keep only digits and optional leading +
    $normalized = preg_replace('/[^\d+]/', '', $phone);

    // Only one + allowed, and only at the start
    if (substr_count($normalized, '+') > 1) {
        return false;
    }

    if (strpos($normalized, '+') > 0) {
        return false;
    }

    // Remove leading + for digit count check
    $digits = ltrim($normalized, '+');

    if (!ctype_digit($digits)) {
        return false;
    }

    $len = strlen($digits);
    return $len >= 7 && $len <= 15;
}
