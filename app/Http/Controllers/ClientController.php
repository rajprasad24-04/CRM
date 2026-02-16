<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ClientController extends Controller
{
    /**
     * Show the form to create a new client.
     */
    public function create()
    {
        $relationshipManagers = $this->relationshipManagers();

        return view('create', compact('relationshipManagers'));
    }

    /**
     * Display a list of clients with search and filter functionality.
     */
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));
        $familyFilter = $request->input('familyFilter', '0');
        
        // Individual column filters
        $familyCodeFilter = trim($request->input('family_code', ''));
        $clientCodeFilter = trim($request->input('client_code', '')); // ✅ New filter
        $familyHeadFilter = trim($request->input('family_head', ''));
        $clientNameFilter = trim($request->input('client_name', ''));
        $mobileFilter = trim($request->input('mobile', ''));
        $emailFilter = trim($request->input('email', ''));
        $rmFilter = trim($request->input('rm', ''));
        $partnerFilter = trim($request->input('partner', ''));
        $missingField = $request->input('missing', '');

        $clients = Client::query();

        if (!$this->isAdmin()) {
            $clients->where('rm_user_id', Auth::id());
        }

        // Global search (searches across multiple fields) - Case insensitive
        if (!empty($search)) {
            $clients->where(function ($query) use ($search) {
                $searchLower = strtolower($search);
                $query->whereRaw('LOWER(client_name) like ?', ["%$searchLower%"])
                      ->orWhereRaw('LOWER(family_code) like ?', ["%$searchLower%"])
                      ->orWhereRaw('LOWER(client_code) like ?', ["%$searchLower%"]) // ✅ Added to global search
                      ->orWhereRaw('LOWER(family_head) like ?', ["%$searchLower%"])
                      ->orWhereRaw('LOWER(primary_mobile_number) like ?', ["%$searchLower%"])
                      ->orWhereRaw('LOWER(primary_email_number) like ?', ["%$searchLower%"]);
            });
        }

        // Individual column filters - Case insensitive
        if (!empty($familyCodeFilter)) {
            $familyCodeLower = strtolower($familyCodeFilter);
            $clients->whereRaw('LOWER(family_code) like ?', ["%$familyCodeLower%"]);
        }

        // ✅ Client code filter
        if (!empty($clientCodeFilter)) {
            $clientCodeLower = strtolower($clientCodeFilter);
            $clients->whereRaw('LOWER(client_code) like ?', ["%$clientCodeLower%"]);
        }

        if (!empty($familyHeadFilter)) {
            $familyHeadLower = strtolower($familyHeadFilter);
            $clients->whereRaw('LOWER(family_head) like ?', ["%$familyHeadLower%"]);
        }

        if (!empty($clientNameFilter)) {
            $clientNameLower = strtolower($clientNameFilter);
            $clients->whereRaw('LOWER(client_name) like ?', ["%$clientNameLower%"]);
        }

        if (!empty($mobileFilter)) {
            $mobileLower = strtolower($mobileFilter);
            $clients->whereRaw('LOWER(primary_mobile_number) like ?', ["%$mobileLower%"]);
        }

        if (!empty($emailFilter)) {
            $emailLower = strtolower($emailFilter);
            $clients->whereRaw('LOWER(primary_email_number) like ?', ["%$emailLower%"]);
        }

        if (!empty($rmFilter)) {
            $rmLower = strtolower($rmFilter);
            $clients->whereRaw('LOWER(rm) like ?', ["%$rmLower%"]);
        }

        if (!empty($partnerFilter)) {
            $partnerLower = strtolower($partnerFilter);
            $clients->whereRaw('LOWER(partner) like ?', ["%$partnerLower%"]);
        }

        // Missing field filter
        $missingMap = [
            'pan' => 'pan_card_number',
            'dob' => 'dob',
            'address' => 'address',
            'mobile' => 'primary_mobile_number',
            'email' => 'primary_email_number',
            'rm' => 'rm_user_id',
            'partner' => 'partner',
        ];

        if (!empty($missingField) && array_key_exists($missingField, $missingMap)) {
            $column = $missingMap[$missingField];
            $clients->where(function ($query) use ($column) {
                $query->whereNull($column)->orWhere($column, '');
            });
        }

        // Family head filter
        if ($familyFilter === '1') {
            $clients->whereColumn('family_head', 'client_name');
        }

        if ($request->input('export') === 'csv') {
            $exportScope = $request->input('scope', 'filtered');
            $exportQuery = $exportScope === 'all' ? Client::query() : clone $clients;

            if (!$this->isAdmin()) {
                $exportQuery->where('rm_user_id', Auth::id());
            }

            return $this->exportCsv($exportQuery);
        }

        $clients = $clients->paginate(15)->withQueryString();

        return view('index', compact(
            'clients', 
            'search', 
            'familyFilter',
            'familyCodeFilter',
            'clientCodeFilter', // ✅ Pass to view
            'familyHeadFilter',
            'clientNameFilter',
            'mobileFilter',
            'emailFilter',
            'rmFilter',
            'partnerFilter',
            'missingField'
        ));
    }

    /**
     * Show details of a single client.
     */
    public function show($id)
    {
        $client = $this->findAuthorizedClient($id);
        $familyMembersQuery = Client::query()->where('family_code', $client->family_code);

        if (!$this->isAdmin()) {
            $familyMembersQuery->where('rm_user_id', Auth::id());
        }

        $familyMembers = $familyMembersQuery
            ->orderByRaw('LOWER(client_name) ASC')
            ->get();

        return view('show', compact('client', 'familyMembers'));
    }

    /**
     * Show the edit form for a client.
     */
    public function edit($id)
    {
        $client = $this->findAuthorizedClient($id);
        $relationshipManagers = $this->relationshipManagers();

        return view('edit', compact('client', 'relationshipManagers'));
    }

    /**
     * Update client details.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'account_type'          => 'nullable',
            'family_code'           => 'nullable',
            'client_code'           => 'nullable|string|max:255', // ✅ Optional validation
            'family_head'           => 'nullable',
            'client_name'           => 'nullable',
            'abbr'                  => 'nullable',
            'gender'                => 'nullable',
            'pan_card_number'       => 'required|unique:clients,pan_card_number,' . $id,
            'dob'                   => 'nullable|date',
            'primary_mobile_number' => 'nullable|numeric',
            'primary_email_number'  => 'nullable|email',
            'address'               => 'nullable',
            'city'                  => 'nullable',
            'state'                 => 'nullable',
            'zip_code'              => 'nullable|numeric',
            'rm_user_id'            => 'nullable|exists:users,id',
        ]);

        $client = $this->findAuthorizedClient($id);
        $payload = $request->all();
        $rmUser = $this->resolveRelationshipManager($request->input('rm_user_id'));
        $payload['rm_user_id'] = $rmUser?->id;
        $payload['rm'] = $rmUser?->name;

        $client->update($payload);

        return redirect()->route('clients.index')->with('success', 'Client updated successfully!');
    }

    /**
     * Delete a client.
     */
    public function destroy($id)
    {
        $client = $this->findAuthorizedClient($id);
        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Client deleted successfully!');
    }

    /**
     * Store a new client in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'account_type'          => 'nullable',
            'family_code'           => 'nullable',
            'client_code'           => 'nullable|string|max:255', // ✅ Optional validation
            'family_head'           => 'nullable',
            'client_name'           => 'nullable',
            'abbr'                  => 'nullable',
            'gender'                => 'nullable',
            'pan_card_number'       => 'required|unique:clients',
            'dob'                   => 'nullable|date',
            'primary_mobile_number' => 'nullable|numeric',
            'primary_email_number'  => 'nullable|email',
            'address'               => 'nullable',
            'city'                  => 'nullable',
            'state'                 => 'nullable',
            'zip_code'              => 'nullable|numeric',
            'rm_user_id'            => 'nullable|exists:users,id',
        ]);

        $payload = $request->all();
        $rmUser = $this->resolveRelationshipManager($request->input('rm_user_id'));
        $payload['rm_user_id'] = $rmUser?->id;
        $payload['rm'] = $rmUser?->name;

        Client::create($payload);

        return redirect()->route('clients.index')->with('success', 'Client added successfully!');
    }

    private function isAdmin(): bool
    {
        return Auth::user()?->hasRole('admin') ?? false;
    }

    private function relationshipManagers()
    {
        if ($this->isAdmin()) {
            return User::orderBy('name')->get();
        }

        return User::where('id', Auth::id())->get();
    }

    private function resolveRelationshipManager($rmUserId): ?User
    {
        if (!$this->isAdmin()) {
            return Auth::user();
        }

        if (empty($rmUserId)) {
            return null;
        }

        return User::find($rmUserId);
    }

    private function findAuthorizedClient($id): Client
    {
        $query = Client::query();

        if (!$this->isAdmin()) {
            $query->where('rm_user_id', Auth::id());
        }

        return $query->findOrFail($id);
    }

    private function exportCsv($query): StreamedResponse
    {
        $filename = 'clients_' . now()->format('Ymd_His') . '.csv';
        $columns = Schema::getColumnListing((new Client())->getTable());

        return response()->streamDownload(function () use ($query, $columns) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $columns);

            $query->orderBy('id')->chunk(500, function ($clients) use ($handle, $columns) {
                foreach ($clients as $client) {
                    fputcsv($handle, array_map(
                        static fn ($column) => $client->{$column},
                        $columns
                    ));
                }
            });

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }
}
