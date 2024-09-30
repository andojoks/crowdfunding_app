<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\UserDonation;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the homepage with top 3 popular donations.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        // Fetch the top 3 popular donations where the status is 'open'
        $popularDonations = Donation::where('status', 'open')  // Only fetch donations with status 'open'
            ->withCount('userDonations')                      // Count the number of user donations for each donation
            ->orderBy('user_donations_count', 'desc')         // Sort donations by the number of user donations (most popular first)
            ->limit(3)                                        // Limit the result to the top 3 donations
            ->get();                                          // Retrieve the donations as a collection

        // Get the most recent 4 donations with their users
        $recentDonations = UserDonation::with('user:id,name')
            ->select('user_id', 'donation_id', 'amount', 'created_at')
            ->groupBy('user_id', 'donation_id', 'amount', 'created_at')
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        return view('dashboard', compact('popularDonations', 'recentDonations'));
    }
}
