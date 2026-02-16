<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Password;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientPasswordController extends Controller
{
    // Show all passwords for a client
    public function index($clientId)
    {
        // Find the client and load associated passwords
        $client = $this->findAuthorizedClient($clientId)->load('passwords');

        // Pass client and passwords to the view
        return view('client_passwords.index', [
            'client' => $client,
            'passwords' => $client->passwords
        ]);
    }

    // Show form to create a new password for the client
    public function create($clientId)
    {
        $client = $this->findAuthorizedClient($clientId);
        return view('client_passwords.create', compact('client'));
    }

    // Store a newly created password in the database
    public function store(Request $request, $clientId)
    {
        $request->validate([
            'title' => 'required|string',
            'user_id' => 'required|string',
            'password' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $client = $this->findAuthorizedClient($clientId);

        // Store the encrypted password
        $client->passwords()->create([
            'title' => $request->title,
            'user_id' => $request->user_id,
            'password' => $request->password, // Encrypting password
            'notes' => $request->notes,
        ]);

        return redirect()->route('client_passwords.index', $clientId)
            ->with('success', 'Password added successfully.');
    }

    // Show form to edit an existing password
    public function edit($clientId, $passwordId)
    {
        $client = $this->findAuthorizedClient($clientId);
        $password = $client->passwords()->findOrFail($passwordId);

        return view('client_passwords.edit', compact('client', 'password'));
    }

    // Update an existing password
    public function update(Request $request, $clientId, $passwordId)
    {
        $request->validate([
            'title' => 'required|string',
            'user_id' => 'required|string',
            'password' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $client = $this->findAuthorizedClient($clientId);
        $password = $client->passwords()->findOrFail($passwordId);

        // Update password only if a new one is provided
        $passwordData = [
            'title' => $request->title,
            'user_id' => $request->user_id,
            'notes' => $request->notes,
        ];
        if ($request->filled('password')) {
            $passwordData['password'] = $request->password; // Encrypting new password
        }

        $password->update($passwordData);

        return redirect()->route('client_passwords.index', $clientId)
            ->with('success', 'Password updated successfully.');
    }

    // Delete a password
    public function destroy($clientId, $passwordId)
    {
        $client = $this->findAuthorizedClient($clientId);
        $password = $client->passwords()->findOrFail($passwordId);
        $password->delete();

        return redirect()->route('client_passwords.index', $clientId)
            ->with('success', 'Password deleted successfully.');
    }

    // Reveal a password for copy (no plaintext in HTML)
    public function reveal($clientId, $passwordId)
    {
        $client = $this->findAuthorizedClient($clientId);
        $password = $client->passwords()->findOrFail($passwordId);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'password_reveal',
            'auditable_type' => Password::class,
            'auditable_id' => $password->id,
            'old_values' => null,
            'new_values' => [
                'client_id' => $client->id,
            ],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return response()
            ->json(['password' => $password->password])
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
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
