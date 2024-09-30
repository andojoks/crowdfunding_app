<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\UserDonation;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DonationController extends Controller
{
    /**
     * Display a listing of open donation causes.
     * Route: causes.index
     * 
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        // Get all open donations, sorted by last updated time, with pagination
        $donations = Donation::where('status', 'open')->orderBy('updated_at', 'desc')->paginate(12);

        // Get the most recent 4 donations with their users
        $recentDonations = UserDonation::with('user:id,name')
            ->select('user_id', 'donation_id', 'amount', 'created_at')
            ->groupBy('user_id', 'donation_id', 'amount', 'created_at')
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        return view('causes.list_causes', compact('donations', 'recentDonations'));
    }

    /**
     * Display the details of a specific donation cause.
     * Route: causes.view_cause
     * 
     * @return \Illuminate\View\View
     */
    public function show($id): View
    {
        // Fetch donation with its creator
        $donation = Donation::with('user')->find($id);

        if (!$donation) {
            // Show 404 page if donation not found
            return view('404_not_found');
        }

        // Fetch recent donors for this donation, summing up and grouping their donations
        $recentDonors = User::withSum([
            'userDonations' => function ($query) use ($id) {
                $query->where('donation_id', $id);  // Filter by the current donation
            }
        ], 'amount')
            ->withMax([
                'userDonations' => function ($query) use ($id) {
                    $query->where('donation_id', $id);
                }
            ], 'created_at')
            ->whereHas('userDonations', function ($query) use ($id) {
                $query->where('donation_id', $id);  // Ensure users have donated to this cause
            })
            ->orderBy('user_donations_max_created_at', 'desc')
            ->limit(4)
            ->get();

        return view('causes.view_cause', compact('donation', 'recentDonors'));
    }

    /**
     * Display the user's own donation causes.
     * Route: causes.my
     * 
     * @return \Illuminate\View\View
     */
    public function myCauses(): View
    {
        // Get donations created by the authenticated user
        $donations = Donation::where('user_id', auth()->id())->orderBy('updated_at', 'desc')->paginate(12);

        // Get the recent donations for the logged-in user
        $recentDonations = UserDonation::with('user:id,name')
            ->where('user_id', auth()->id())
            ->select('user_id', 'donation_id', 'amount', 'created_at')
            ->groupBy('user_id', 'donation_id', 'amount', 'created_at')
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        return view('causes.my_causes', compact('donations', 'recentDonations'));
    }

    /**
     * Show the form to create a new donation cause.
     * Route: cause.add
     * 
     * @return \Illuminate\View\View
     */
    public function addCause(): View
    {
        $isEditing = false;  // Set editing to false since it's a new cause
        return view('causes.cause_form', compact('isEditing'));
    }

    /**
     * Show the form to edit an existing donation cause.
     * Route: cause.edit
     * 
     * @return \Illuminate\View\View
     */
    public function editCause($donation_id): View
    {
        $donation = Donation::find($donation_id);

        if (!$donation) {
            // Show 404 page if donation not found
            return view('404_not_found');
        }

        $isEditing = true;  // Set editing to true
        return view('causes.cause_form', compact('donation', 'isEditing'));
    }

    /**
     * Store a new donation cause.
     * Route: cause.store
     */
    public function store(Request $request)
    {
        // Validate the form input
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'target_amount' => 'required|numeric|min:1',
            'due_date' => 'required|date_format:Y-m-d\TH:i',  // Match the datetime-local input format
        ]);

        // Create a new donation record
        $donation = Donation::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'target_amount' => $validated['target_amount'],
            'due_date' => $validated['due_date'],
            'details' => $request->get('details'),  // Optional field
        ]);

        return redirect()->route('causes.view_cause', ['id' => $donation->id]);
    }

    /**
     * Update an existing donation cause.
     * Route: cause.update
     * 
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View
     */
    public function update(Request $request, $donation_id): RedirectResponse|View
    {
        // Validate the form input
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'target_amount' => 'required|numeric|min:1',
        ]);

        $donation = Donation::find($donation_id);

        if (!$donation) {
            // Show 404 page if donation not found
            return view('404_not_found');
        }

        // Update the donation record
        $donation->update($validated);

        return redirect()->route('causes.view_cause', ['id' => $donation->id]);
    }

    /**
     * Handle the donation process for a specific cause.
     * Route: cause.donate
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function donate(Request $request, $donation_id): RedirectResponse
    {
        // Validate the donation amount
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $donation = Donation::find($donation_id);

        if (!$donation) {
            return redirect()->route('causes.view_cause', ['id' => $donation_id])
                ->with('error', 'Donation could not be found. Please try again later.');
        }

        if ($donation->status == 'completed') {
            return redirect()->route('causes.view_cause', ['id' => $donation_id])
                ->with('message', 'The target amount for this donation has already been reached.');
        }

        // Create a user donation record
        UserDonation::create([
            'user_id' => auth()->id(),
            'donation_id' => $donation->id,
            'amount' => $validated['amount'],
        ]);

        // Check if the donation target has been reached
        if ($donation->amount_received >= $donation->target_amount) {
            $donation->update(['status' => 'completed']);
        }

        return redirect()->route('causes.view_cause', ['id' => $donation_id])
            ->with('message', 'Thank you for your donation!');
    }
}
