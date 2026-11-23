<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('DROP VIEW IF EXISTS vw_daftar_ng_reject');

        $sql = <<<'SQL'
CREATE VIEW vw_daftar_ng_reject AS
SELECT
    'WM' AS source_module,
    fg.id AS fg_id,
    h.id AS header_id,
    fg.status,
    fg.lot_number,
    h.nomor_inspeksi,
    h.tanggal,
    h.shift,
    p.pro_id AS pro_number,
    COALESCE(m.mesin_id, '-') AS kode_mesin,
    COALESCE(p.description, '-') AS product_description,
    fg.qty,
    fg.weight,
    CASE WHEN fg.weight IS NULL THEN NULL ELSE ROUND(fg.qty * fg.weight, 2) END AS total_weight,
    COALESCE(NULLIF(det.description, ''), '-') AS detail_inspeksi_1,
    COALESCE(NULLIF(det.description2, ''), '-') AS detail_inspeksi_2,
    COALESCE(u.name, '-') AS inspector,
    fg.created_at
FROM inspeksi_wm_fgs fg
JOIN inspeksi_wms h ON h.id = fg.inspeksi_wm_id
LEFT JOIN pros p ON p.id = h.pro_id
LEFT JOIN mesins m ON m.id = h.mesin_id
LEFT JOIN users u ON u.id = fg.user_id
LEFT JOIN (
    SELECT d1.inspeksi_wm_fg_id, d1.description, d1.description2
    FROM inspeksi_wm_fg_details d1
    INNER JOIN (
        SELECT inspeksi_wm_fg_id, MIN(id) AS min_id
        FROM inspeksi_wm_fg_details
        GROUP BY inspeksi_wm_fg_id
    ) dm ON dm.min_id = d1.id
) det ON det.inspeksi_wm_fg_id = fg.id
WHERE fg.status IN ('NG', 'REJECT') AND fg.lot_number IS NOT NULL

UNION ALL

SELECT
    'Fencing' AS source_module,
    fg.id AS fg_id,
    h.id AS header_id,
    fg.status,
    fg.lot_number,
    h.nomor_inspeksi,
    h.tanggal,
    h.shift,
    p.pro_id AS pro_number,
    COALESCE(m.mesin_id, '-') AS kode_mesin,
    COALESCE(p.description, '-') AS product_description,
    fg.qty,
    fg.weight,
    CASE WHEN fg.weight IS NULL THEN NULL ELSE ROUND(fg.qty * fg.weight, 2) END AS total_weight,
    COALESCE(NULLIF(det.description, ''), '-') AS detail_inspeksi_1,
    COALESCE(NULLIF(det.description2, ''), '-') AS detail_inspeksi_2,
    COALESCE(u.name, '-') AS inspector,
    fg.created_at
FROM inspeksi_fencing_fgs fg
JOIN inspeksi_fencings h ON h.id = fg.inspeksi_fencing_id
LEFT JOIN pros p ON p.id = h.pro_id
LEFT JOIN mesins m ON m.id = h.mesin_id
LEFT JOIN users u ON u.id = fg.user_id
LEFT JOIN (
    SELECT d1.inspeksi_fencing_fg_id, d1.description, d1.description2
    FROM inspeksi_fencing_fg_details d1
    INNER JOIN (
        SELECT inspeksi_fencing_fg_id, MIN(id) AS min_id
        FROM inspeksi_fencing_fg_details
        GROUP BY inspeksi_fencing_fg_id
    ) dm ON dm.min_id = d1.id
) det ON det.inspeksi_fencing_fg_id = fg.id
WHERE fg.status IN ('NG', 'REJECT') AND fg.lot_number IS NOT NULL

UNION ALL

SELECT
    'CTCL' AS source_module,
    fg.id AS fg_id,
    h.id AS header_id,
    fg.status,
    fg.lot_number,
    h.nomor_inspeksi,
    h.tanggal,
    h.shift,
    p.pro_id AS pro_number,
    COALESCE(m.mesin_id, '-') AS kode_mesin,
    COALESCE(p.description, '-') AS product_description,
    fg.qty,
    fg.weight,
    CASE WHEN fg.weight IS NULL THEN NULL ELSE ROUND(fg.qty * fg.weight, 2) END AS total_weight,
    COALESCE(NULLIF(det.description, ''), '-') AS detail_inspeksi_1,
    COALESCE(NULLIF(det.description2, ''), '-') AS detail_inspeksi_2,
    COALESCE(u.name, '-') AS inspector,
    fg.created_at
FROM inspeksi_ct_fgs fg
JOIN inspeksi_cts h ON h.id = fg.inspeksi_ct_id
LEFT JOIN pros p ON p.id = h.pro_id
LEFT JOIN mesins m ON m.id = h.mesin_id
LEFT JOIN users u ON u.id = fg.user_id
LEFT JOIN (
    SELECT d1.inspeksi_ct_fg_id, d1.description, d1.description2
    FROM inspeksi_ct_fg_details d1
    INNER JOIN (
        SELECT inspeksi_ct_fg_id, MIN(id) AS min_id
        FROM inspeksi_ct_fg_details
        GROUP BY inspeksi_ct_fg_id
    ) dm ON dm.min_id = d1.id
) det ON det.inspeksi_ct_fg_id = fg.id
WHERE fg.status IN ('NG', 'REJECT') AND fg.lot_number IS NOT NULL

UNION ALL

SELECT
    'Chainlink' AS source_module,
    fg.id AS fg_id,
    h.id AS header_id,
    fg.status,
    fg.lot_number,
    h.nomor_inspeksi,
    h.tanggal,
    h.shift,
    p.pro_id AS pro_number,
    COALESCE(m.mesin_id, '-') AS kode_mesin,
    COALESCE(p.description, '-') AS product_description,
    fg.qty,
    fg.weight,
    CASE WHEN fg.weight IS NULL THEN NULL ELSE ROUND(fg.qty * fg.weight, 2) END AS total_weight,
    COALESCE(NULLIF(det.description, ''), '-') AS detail_inspeksi_1,
    COALESCE(NULLIF(det.description2, ''), '-') AS detail_inspeksi_2,
    COALESCE(u.name, '-') AS inspector,
    fg.created_at
FROM inspeksi_chainlink_fgs fg
JOIN inspeksi_chainlinks h ON h.id = fg.inspeksi_chainlink_id
LEFT JOIN pros p ON p.id = h.pro_id
LEFT JOIN mesins m ON m.id = h.mesin_id
LEFT JOIN users u ON u.id = fg.user_id
LEFT JOIN (
    SELECT d1.inspeksi_chainlink_fg_id, d1.description, d1.description2
    FROM inspeksi_chainlink_fg_details d1
    INNER JOIN (
        SELECT inspeksi_chainlink_fg_id, MIN(id) AS min_id
        FROM inspeksi_chainlink_fg_details
        GROUP BY inspeksi_chainlink_fg_id
    ) dm ON dm.min_id = d1.id
) det ON det.inspeksi_chainlink_fg_id = fg.id
WHERE fg.status IN ('NG', 'REJECT') AND fg.lot_number IS NOT NULL

UNION ALL

SELECT
    'Kawat Duri' AS source_module,
    fg.id AS fg_id,
    h.id AS header_id,
    fg.status,
    fg.lot_number,
    h.nomor_inspeksi,
    h.tanggal,
    h.shift,
    p.pro_id AS pro_number,
    COALESCE(m.mesin_id, '-') AS kode_mesin,
    COALESCE(p.description, '-') AS product_description,
    fg.qty,
    fg.weight,
    CASE WHEN fg.weight IS NULL THEN NULL ELSE ROUND(fg.qty * fg.weight, 2) END AS total_weight,
    COALESCE(NULLIF(det.description, ''), '-') AS detail_inspeksi_1,
    COALESCE(NULLIF(det.description2, ''), '-') AS detail_inspeksi_2,
    COALESCE(u.name, '-') AS inspector,
    fg.created_at
FROM inspeksi_kawat_duri_fgs fg
JOIN inspeksi_kawat_duris h ON h.id = fg.inspeksi_kawat_duri_id
LEFT JOIN pros p ON p.id = h.pro_id
LEFT JOIN mesins m ON m.id = h.mesin_id
LEFT JOIN users u ON u.id = fg.user_id
LEFT JOIN (
    SELECT d1.inspeksi_kawat_duri_fg_id, d1.description, d1.description2
    FROM inspeksi_kd_fg_details d1
    INNER JOIN (
        SELECT inspeksi_kawat_duri_fg_id, MIN(id) AS min_id
        FROM inspeksi_kd_fg_details
        GROUP BY inspeksi_kawat_duri_fg_id
    ) dm ON dm.min_id = d1.id
) det ON det.inspeksi_kawat_duri_fg_id = fg.id
WHERE fg.status IN ('NG', 'REJECT') AND fg.lot_number IS NOT NULL

UNION ALL

SELECT
    'Razor Packing' AS source_module,
    fg.id AS fg_id,
    h.id AS header_id,
    fg.status,
    fg.lot_number,
    h.nomor_inspeksi,
    h.tanggal,
    h.shift,
    p.pro_id AS pro_number,
    '-' AS kode_mesin,
    COALESCE(p.description, '-') AS product_description,
    fg.qty,
    fg.weight,
    CASE WHEN fg.weight IS NULL THEN NULL ELSE ROUND(fg.qty * fg.weight, 2) END AS total_weight,
    COALESCE(NULLIF(det.description, ''), '-') AS detail_inspeksi_1,
    COALESCE(NULLIF(det.description2, ''), '-') AS detail_inspeksi_2,
    COALESCE(u.name, '-') AS inspector,
    fg.created_at
FROM inspeksi_razorpacking_fgs fg
JOIN inspeksi_razorpackings h ON h.id = fg.inspeksi_razorpacking_id
LEFT JOIN pros p ON p.id = h.pro_id
LEFT JOIN users u ON u.id = fg.user_id
LEFT JOIN (
    SELECT d1.inspeksi_razorpacking_fg_id, d1.description, d1.description2
    FROM inspeksi_razorpacking_fg_details d1
    INNER JOIN (
        SELECT inspeksi_razorpacking_fg_id, MIN(id) AS min_id
        FROM inspeksi_razorpacking_fg_details
        GROUP BY inspeksi_razorpacking_fg_id
    ) dm ON dm.min_id = d1.id
) det ON det.inspeksi_razorpacking_fg_id = fg.id
WHERE fg.status IN ('NG', 'REJECT') AND fg.lot_number IS NOT NULL

UNION ALL

SELECT
    'Gabion Packing' AS source_module,
    fg.id AS fg_id,
    h.id AS header_id,
    fg.status,
    fg.lot_number,
    h.nomor_inspeksi,
    h.tanggal,
    h.shift,
    p.pro_id AS pro_number,
    '-' AS kode_mesin,
    COALESCE(p.description, '-') AS product_description,
    fg.qty,
    fg.weight,
    CASE WHEN fg.weight IS NULL THEN NULL ELSE ROUND(fg.qty * fg.weight, 2) END AS total_weight,
    COALESCE(NULLIF(det.description, ''), '-') AS detail_inspeksi_1,
    COALESCE(NULLIF(det.description2, ''), '-') AS detail_inspeksi_2,
    COALESCE(u.name, '-') AS inspector,
    fg.created_at
FROM inspeksi_gabionpacking_fgs fg
JOIN inspeksi_gabionpackings h ON h.id = fg.inspeksi_gabionpacking_id
LEFT JOIN pros p ON p.id = h.pro_id
LEFT JOIN users u ON u.id = fg.user_id
LEFT JOIN (
    SELECT d1.inspeksi_gabionpacking_fg_id, d1.description, d1.description2
    FROM inspeksi_gabionpacking_fg_details d1
    INNER JOIN (
        SELECT inspeksi_gabionpacking_fg_id, MIN(id) AS min_id
        FROM inspeksi_gabionpacking_fg_details
        GROUP BY inspeksi_gabionpacking_fg_id
    ) dm ON dm.min_id = d1.id
) det ON det.inspeksi_gabionpacking_fg_id = fg.id
WHERE fg.status IN ('NG', 'REJECT') AND fg.lot_number IS NOT NULL

UNION ALL

SELECT
    'Gabion Anyam' AS source_module,
    fg.id AS fg_id,
    h.id AS header_id,
    fg.status,
    fg.lot_number,
    h.nomor_inspeksi,
    h.tanggal,
    h.shift,
    p.pro_id AS pro_number,
    COALESCE(m.mesin_id, '-') AS kode_mesin,
    COALESCE(p.description, '-') AS product_description,
    fg.qty,
    fg.weight,
    CASE WHEN fg.weight IS NULL THEN NULL ELSE ROUND(fg.qty * fg.weight, 2) END AS total_weight,
    COALESCE(NULLIF(det.description, ''), '-') AS detail_inspeksi_1,
    COALESCE(NULLIF(det.description2, ''), '-') AS detail_inspeksi_2,
    COALESCE(u.name, '-') AS inspector,
    fg.created_at
FROM inspeksi_gabionanyam_fgs fg
JOIN inspeksi_gabionanyams h ON h.id = fg.inspeksi_gabionanyam_id
LEFT JOIN pros p ON p.id = h.pro_id
LEFT JOIN mesins m ON m.id = h.mesin_id
LEFT JOIN users u ON u.id = fg.user_id
LEFT JOIN (
    SELECT d1.inspeksi_gabionanyam_fg_id, d1.description, d1.description2
    FROM inspeksi_gabionanyam_fg_details d1
    INNER JOIN (
        SELECT inspeksi_gabionanyam_fg_id, MIN(id) AS min_id
        FROM inspeksi_gabionanyam_fg_details
        GROUP BY inspeksi_gabionanyam_fg_id
    ) dm ON dm.min_id = d1.id
) det ON det.inspeksi_gabionanyam_fg_id = fg.id
WHERE fg.status IN ('NG', 'REJECT') AND fg.lot_number IS NOT NULL

UNION ALL

SELECT
    'Shearing' AS source_module,
    fg.id AS fg_id,
    h.id AS header_id,
    fg.status,
    fg.lot_number,
    h.nomor_inspeksi,
    h.tanggal,
    h.shift,
    p.pro_id AS pro_number,
    COALESCE(m.mesin_id, '-') AS kode_mesin,
    COALESCE(p.description, '-') AS product_description,
    fg.qty,
    fg.weight,
    CASE WHEN fg.weight IS NULL THEN NULL ELSE ROUND(fg.qty * fg.weight, 2) END AS total_weight,
    COALESCE(NULLIF(det.description, ''), '-') AS detail_inspeksi_1,
    COALESCE(NULLIF(det.description2, ''), '-') AS detail_inspeksi_2,
    COALESCE(u.name, '-') AS inspector,
    fg.created_at
FROM inspeksi_shearing_fgs fg
JOIN inspeksi_shearings h ON h.id = fg.inspeksi_shearing_id
LEFT JOIN pros p ON p.id = h.pro_id
LEFT JOIN mesins m ON m.id = h.mesin_id
LEFT JOIN users u ON u.id = fg.user_id
LEFT JOIN (
    SELECT d1.inspeksi_shearing_fg_id, d1.description, d1.description2
    FROM inspeksi_shearing_fg_details d1
    INNER JOIN (
        SELECT inspeksi_shearing_fg_id, MIN(id) AS min_id
        FROM inspeksi_shearing_fg_details
        GROUP BY inspeksi_shearing_fg_id
    ) dm ON dm.min_id = d1.id
) det ON det.inspeksi_shearing_fg_id = fg.id
WHERE fg.status IN ('NG', 'REJECT') AND fg.lot_number IS NOT NULL
SQL;

        DB::statement($sql);
    }

    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS vw_daftar_ng_reject');
    }
};
