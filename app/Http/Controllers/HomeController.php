<?php

namespace App\Http\Controllers;

use App\Models\Donation;
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

        return view('dashboard', compact('popularDonations'));
    }
}
