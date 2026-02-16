<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\FinancialData;
use App\Models\Notice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $clientQuery = Client::query();
        if (!Auth::user()?->hasRole('admin')) {
            $clientQuery->where('rm_user_id', Auth::id());
        }

        $tclients = (clone $clientQuery)->count();

        // Account type statistics
        $activeClients = (clone $clientQuery)->where('account_type', 'Active Account')->count();
        $inactiveClients = (clone $clientQuery)->where('account_type', 'Inactive Account')->count();
        $contactLeads = (clone $clientQuery)->where('account_type', 'Contact/Lead')->count();
        $unknownClients = (clone $clientQuery)->where('account_type', 'Unknown')->count();

        $financialQuery = FinancialData::query();
        if (!Auth::user()?->hasRole('admin')) {
            $financialQuery->whereHas('client', function ($query) {
                $query->where('rm_user_id', Auth::id());
            });
        }

        $totalInsurance = (clone $financialQuery)->sum('life')
            + (clone $financialQuery)->sum('health')
            + (clone $financialQuery)->sum('pa')
            + (clone $financialQuery)->sum('critical')
            + (clone $financialQuery)->sum('motor')
            + (clone $financialQuery)->sum('general');

        $totalInvestments = (clone $financialQuery)->sum('fd')
            + (clone $financialQuery)->sum('mf')
            + (clone $financialQuery)->sum('pms');

        $totalTax = (clone $financialQuery)->sum('income_tax')
            + (clone $financialQuery)->sum('gst')
            + (clone $financialQuery)->sum('tds')
            + (clone $financialQuery)->sum('pt')
            + (clone $financialQuery)->sum('vat')
            + (clone $financialQuery)->sum('roc')
            + (clone $financialQuery)->sum('cma');

        $totalOthers = (clone $financialQuery)->sum('accounting')
            + (clone $financialQuery)->sum('others');

        $totalAmount = $totalInsurance + $totalInvestments + $totalTax + $totalOthers;

        // Year-wise client additions based on date_of_join
        $clientsByYear = (clone $clientQuery)->select(
                DB::raw('YEAR(date_of_join) as year'),
                DB::raw('COUNT(*) as count')
            )
            ->whereNotNull('date_of_join')
            ->where('date_of_join', '!=', '')
            ->groupBy('year')
            ->orderBy('year', 'ASC')
            ->get();

        // Prepare data for chart
        $years = $clientsByYear->pluck('year')->toArray();
        $clientCounts = $clientsByYear->pluck('count')->toArray();

        // Month-wise data for current year
        $currentYear = date('Y');
        $clientsByMonth = (clone $clientQuery)->select(
                DB::raw('MONTH(date_of_join) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereYear('date_of_join', $currentYear)
            ->whereNotNull('date_of_join')
            ->where('date_of_join', '!=', '')
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->get();

        // Prepare monthly data (fill in missing months with 0)
        $monthlyData = array_fill(1, 12, 0);
        foreach ($clientsByMonth as $data) {
            $monthlyData[$data->month] = $data->count;
        }

        $missingFields = [
            'pan' => 'PAN missing',
            'dob' => 'DOB missing',
            'address' => 'Address missing',
            'mobile' => 'Mobile missing',
            'email' => 'Email missing',
            'rm' => 'RM not assigned',
            'partner' => 'Partner missing',
        ];

        $missingCounts = [];
        foreach ($missingFields as $key => $label) {
            $column = match ($key) {
                'pan' => 'pan_card_number',
                'dob' => 'dob',
                'address' => 'address',
                'mobile' => 'primary_mobile_number',
                'email' => 'primary_email_number',
                'rm' => 'rm_user_id',
                'partner' => 'partner',
            };

            $missingCounts[$key] = (clone $clientQuery)->where(function ($query) use ($column) {
                $query->whereNull($column)->orWhere($column, '');
            })->count();
        }

        $notices = Notice::query()
            ->where('is_active', true)
            ->withCount('likes')
            ->orderByDesc('created_at')
            ->limit(3)
            ->get();

        return view('dashboard', compact(
            'tclients',
            'activeClients',
            'inactiveClients',
            'contactLeads',
            'unknownClients',
            'totalInsurance',
            'totalInvestments',
            'totalTax',
            'totalOthers',
            'totalAmount',
            'years',
            'clientCounts',
            'monthlyData',
            'currentYear',
            'missingFields',
            'missingCounts',
            'notices'
        ));
    }
}
