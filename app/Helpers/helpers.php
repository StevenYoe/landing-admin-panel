<?php
// This file contains helper functions for the application.

// getSortArrow returns an arrow symbol (↑ or ↓) based on the current sort column and order.
// Usage: Display a visual indicator for sorting direction in table headers.
if (!function_exists('getSortArrow')) {
    function getSortArrow($currentSort, $column, $sortOrder) {
        // If the current sort column is not the same as the given column, return an empty string (no arrow)
        if ($currentSort !== $column) return '';
        // Return '↑' for ascending order, '↓' for descending order
        return $sortOrder === 'asc' ? '↑' : '↓';
    }
}