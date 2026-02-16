<?php

namespace App\Imports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class ClientsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Client([
            'account_type'            => $row['account_type'] ?? null,
            'family_code'             => $row['family_code'] ?? null,
            'client_code'             => $row['client_code'] ?? null, // ✅ Added
            'family_head'             => $row['family_head'] ?? null,
            'abbr'                    => $row['abbr'] ?? null,
            'client_name'             => $row['client_name'] ?? null,
            'gender'                  => $row['gender'] ?? null,
            'pan_card_number'         => $row['pan_card_number'] ?? null,

            // ✅ Convert Excel numeric dates into proper format
            'dob'        => $this->transformDate($row['dob']),
            'doa'        => $this->transformDate($row['doa']),
            'date_of_join' => $this->transformDate($row['date_of_join']),
            'close_date' => $this->transformDate($row['close_date']),

            'category'                => $row['category'] ?? null,
            'rm'                      => $row['rm'] ?? null,
            'partner'                 => $row['partner'] ?? null,
            'primary_mobile_number'   => $row['primary_mobile_number'] ?? null,
            'primary_email_number'    => $row['primary_email_number'] ?? null,
            'secondary_mobile_number' => $row['secondary_mobile_number'] ?? null,
            'secondary_email_number'  => $row['secondary_email_number'] ?? null,
            'address'                 => $row['address'] ?? null,
            'city'                    => $row['city'] ?? null,
            'state'                   => $row['state'] ?? null,
            'zip_code'                => $row['zip_code'] ?? null,
            'referred_by'             => $row['referred_by'] ?? null,
            'tax_status'              => $row['tax_status'] ?? null,
            'notes'                   => $row['notes'] ?? null,
        ]);
    }

    private function transformDate($value)
    {
        try {
            if (is_numeric($value)) {
                // Excel serial number to PHP date
                return ExcelDate::excelToDateTimeObject($value)->format('Y-m-d');
            }
            if (!empty($value)) {
                return date('Y-m-d', strtotime($value));
            }
        } catch (\Exception $e) {
            return null;
        }
        return null;
    }
}