<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\FinancialData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinancialDataController extends Controller
{
    // Show all financial data for a client

    public function index(Request $request)
    {
        // Getting the search term from the query string
        $search = $request->input('search', '');

        // Fetch clients with pagination, search, and optional filters
        $clients = Client::with('financialData')
            ->where('client_name', 'LIKE', '%' . $search . '%');

        if (!Auth::user()?->hasRole('admin')) {
            $clients->where('rm_user_id', Auth::id());
        }

        $clients = $clients->paginate(15);  // Adjust the number for items per page

        return view('client_financial_data.index', compact('clients', 'search'));
    }


    // Show form to create new financial data for the client
    public function create($clientId)
    {
        // Find the client by ID
        $client = $this->findAuthorizedClient($clientId);

        // Check if financial data already exists for this client
        $existingFinancialData = $client->financialData()->first();

        if ($existingFinancialData) {
            // Redirect to the existing financial data page if data already exists
            return redirect()->route('client_financial_data.index', $clientId)
                ->with('error', 'This client already has financial data.');
        }

        // Pass client data to the view for creating new data
        return view('client_financial_data.create', compact('client'));
    }

    // Store newly created financial data in the database
    public function store(Request $request, $clientId)
    {
        // Validate incoming data
        $request->validate([
            'life' => 'nullable|numeric',
            'health' => 'nullable|numeric',
            'pa' => 'nullable|numeric',
            'critical' => 'nullable|numeric',
            'motor' => 'nullable|numeric',
            'general' => 'nullable|numeric',
            'fd' => 'nullable|numeric',
            'mf' => 'nullable|numeric',
            'pms' => 'nullable|numeric',
            'income_tax' => 'nullable|numeric',
            'gst' => 'nullable|numeric',
            'accounting' => 'nullable|numeric',
            'others' => 'nullable|numeric',
            'tds' => 'nullable|numeric',
            'pt' => 'nullable|numeric',
            'vat' => 'nullable|numeric',
            'roc' => 'nullable|numeric',
            'cma' => 'nullable|numeric',
        ]);

        // Find the client by ID
        $client = $this->findAuthorizedClient($clientId);

        // Check if the client already has financial data
        $existingFinancialData = $client->financialData()->first();

        if ($existingFinancialData) {
            // If data exists, redirect with an error message
            return redirect()->route('client_financial_data.index', $clientId)
                ->with('error', 'This client already has financial data.');
        }

        // Store the financial data
        $client->financialData()->create($request->all());

        // Redirect to the financial data index page with a success message
        return redirect()->route('client_financial_data.index', $clientId)
            ->with('success', 'Financial data added successfully.');
    }

    // Show form to edit existing financial data
    public function edit($clientId)
    {
        // Find the client by ID
        $client = $this->findAuthorizedClient($clientId);

        // Check if the client has existing financial data
        $financialData = $client->financialData()->first();

        if (!$financialData) {
            // If no data exists, redirect with an error message
            return redirect()->route('client_financial_data.create', $clientId)
                ->with('error', 'No financial data exists for this client to edit.');
        }

        // Pass client and financial data to the view for editing
        return view('client_financial_data.edit', compact('client', 'financialData'));
    }

    // Update existing financial data
    public function update(Request $request, $clientId)
    {
        // Validate incoming data
        $request->validate([
            'life' => 'nullable|numeric',
            'health' => 'nullable|numeric',
            'pa' => 'nullable|numeric',
            'critical' => 'nullable|numeric',
            'motor' => 'nullable|numeric',
            'general' => 'nullable|numeric',
            'fd' => 'nullable|numeric',
            'mf' => 'nullable|numeric',
            'pms' => 'nullable|numeric',
            'income_tax' => 'nullable|numeric',
            'gst' => 'nullable|numeric',
            'accounting' => 'nullable|numeric',
            'others' => 'nullable|numeric',
            'tds' => 'nullable|numeric',
            'pt' => 'nullable|numeric',
            'vat' => 'nullable|numeric',
            'roc' => 'nullable|numeric',
            'cma' => 'nullable|numeric',
        ]);

        // Find the client by ID
        $client = $this->findAuthorizedClient($clientId);

        // Check if financial data exists for this client
        $financialData = $client->financialData()->first();

        if (!$financialData) {
            // If no data exists, redirect with an error message
            return redirect()->route('client_financial_data.create', $clientId)
                ->with('error', 'No financial data found for this client to update.');
        }

        // Update the financial data
        $financialData->update($request->all());

        // Redirect to the financial data index page with a success message
        return redirect()->route('client_financial_data.index', $clientId)
            ->with('success', 'Financial data updated successfully.');
    }

    // Delete financial data
    public function destroy($clientId)
    {
        // Find the client by ID
        $client = $this->findAuthorizedClient($clientId);

        // Check if financial data exists for this client
        $financialData = $client->financialData()->first();

        if (!$financialData) {
            // If no data exists, redirect with an error message
            return redirect()->route('client_financial_data.index', $clientId)
                ->with('error', 'No financial data found to delete.');
        }

        // Delete the financial data
        $financialData->delete();

        // Redirect to the financial data index page with a success message
        return redirect()->route('client_financial_data.index', $clientId)
            ->with('success', 'Financial data deleted successfully.');
    }

    private function findAuthorizedClient($clientId): Client
    {
        $query = Client::query();

        if (!Auth::user()?->hasRole('admin')) {
            $query->where('rm_user_id', Auth::id());
        }

        return $query->findOrFail($clientId);
    }
}
