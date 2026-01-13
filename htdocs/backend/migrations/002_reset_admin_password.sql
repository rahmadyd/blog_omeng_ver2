-- Migration: ensure admin user exists and set known password
-- WARNING: Run only on your development or with caution on production.

-- Insert admin if missing (id will auto-increment)
INSERT IGNORE INTO admins (username, password) VALUES
('omeng.gembul', '$2y$10$.1cpPgT0FtdkzvFnjcOgG.Clu27LgRuU8a9allonnnaD0MmtsBddq');

-- Ensure id=1 exists; optionally update the first admin row's username+password
UPDATE admins
SET username = 'omeng.gembul', password = '$2y$10$.1cpPgT0FtdkzvFnjcOgG.Clu27LgRuU8a9allonnnaD0MmtsBddq'
WHERE id = 1;

-- If you prefer to update by username instead, uncomment and use this:
-- UPDATE admins SET password = '$2y$10$.1cpPgT0FtdkzvFnjcOgG.Clu27LgRuU8a9allonnnaD0MmtsBddq' WHERE username = 'omeng.gembul';

-- Notes:
-- Password above is a bcrypt hash for: omengcreations.gembul@#.$
-- After running this migration you should be able to login with username: omeng.gembul and password: omengcreations.gembul@#.$
