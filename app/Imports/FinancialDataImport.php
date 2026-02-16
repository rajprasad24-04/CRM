<?php

namespace App\Imports;

use App\Models\Client;
use App\Models\FinancialData;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FinancialDataImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Find client by unique identifier (like client_name or id)
        $client = Client::where('client_name', $row['client_name'])->first();

        if (!$client) {
            return null; // Skip if client not found
        }

        // Check if already exists
        if ($client->financialData()->exists()) {
            return null; // Skip if financial data already exists
        }

        return new FinancialData([
            'life'       => $row['life'] ?? null,
            'health'     => $row['health'] ?? null,
            'pa'         => $row['pa'] ?? null,
            'critical'   => $row['critical'] ?? null,
            'motor'      => $row['motor'] ?? null,
            'general'    => $row['general'] ?? null,
            'fd'         => $row['fd'] ?? null,
            'mf'         => $row['mf'] ?? null,
            'pms'        => $row['pms'] ?? null,
            'income_tax' => $row['income_tax'] ?? null,
            'gst'        => $row['gst'] ?? null,
            'tds'        => $row['tds'] ?? null,
            'pt'         => $row['pt'] ?? null,
            'vat'        => $row['vat'] ?? null,
            'roc'        => $row['roc'] ?? null,
            'cma'        => $row['cma'] ?? null,
            'accounting' => $row['accounting'] ?? null,
            'others'     => $row['others'] ?? null,
            'client_id'  => $client->id,
        ]);
    }
}
