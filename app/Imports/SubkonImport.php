<?php

namespace App\Imports;

use App\Models\Subkon;
use Maatwebsite\Excel\Concerns\ToModel;

class SubkonImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Subkon([
            'subkon_id' => $row['subkon_id'], 
            'name'      => $row['name'],
        ]);
    }
}
