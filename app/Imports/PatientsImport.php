<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Log;

class PatientsImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
         try {
             Log::info('Processing row: ', $row);
        return new User([
            'first_name'    => $row['first_name'],
            'email'         => $row['email'],
            'mobile'        => $row['mobile'],
            'gender'        => $row['gender'],
            'date_of_birth' => $row['date_of_birth'],
            'user_type'     => 'user',
            'civil_id'      => $row['civil_id'],
            'department_id' => $row['departments_id'],
            'employee_id'   => $row['employee_id'],
            'pme_month'     => $row['pme_month'],
            'pme_year'      => $row['pme_year'],
        ]);
       } catch (\Exception $e) {
        \Log::error('Import failed for row: ' . json_encode($row) . ' with error: ' . $e->getMessage());
        return null; // or throw an exception to stop the import
       }
    }
    public function rules(): array
    {
        return [
            '*.first_name' => ['required', 'string'],
            '*.email' => ['required', 'email'],
            '*.mobile' => ['required', 'string'],
            '*.gender' => ['required', 'string'],
            '*.date_of_birth' => ['required', 'date'],
            '*.civil_id' => ['required', 'string'],
            '*.departments_id' => ['required', 'integer'],
            '*.employee_id' => ['required', 'string'],
            '*.pme_month' => ['required', 'string'],
            '*.pme_year' => ['required', 'integer'],
        ];
    }
}
