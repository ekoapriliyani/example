<?php

namespace App\Support;

class LaporanFormatter
{
    /**
     * Gabungkan nilai satu kolom dari banyak baris data child menjadi satu teks.
     *
     * Nilai null atau string kosong dilewati agar tidak menyisipkan koma kosong.
     * Contoh: "K1, K2, K3"
     *
     * @param  iterable  $rows  Koleksi model/array (mis. relasi hasMany).
     * @param  string  $field  Nama kolom/atribut yang diambil.
     */
    public static function joinValues(iterable $rows, string $field, string $separator = ', '): string
    {
        $values = [];

        foreach ($rows as $row) {
            $value = is_array($row) ? ($row[$field] ?? null) : ($row->{$field} ?? null);

            if ($value === null || $value === '') {
                continue;
            }

            $values[] = (string) $value;
        }

        return implode($separator, $values);
    }
}
