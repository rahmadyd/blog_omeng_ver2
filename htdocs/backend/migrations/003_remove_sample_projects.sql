-- Migration: remove sample projects inserted by default
DELETE FROM projects WHERE judul IN ('Pan Pan Destination', 'Custom Illustration');

-- Optionally delete associated uploaded images if you want to clean files (uncomment and adjust paths):
-- DELETE FROM projects WHERE gambar = 'panpandestionation.png';

-- Run this migration carefully; it permanently removes rows from `projects` table.
