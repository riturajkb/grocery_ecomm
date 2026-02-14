<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Show the customer profile.
     */
    public function edit()
    {
        return view('account.profile', ['user' => Auth::user()]);
    }

    /**
     * Update the customer profile.
     */
    public function update(Request $request)
    {
        $request->validate([
            'phone' => 'nullable|string|max:20',
        ]);

        $user = Auth::user();
        $user->phone = $request->phone;
        $user->save();

        return redirect()->route('account.profile')->with('success', 'Profile updated successfully.');
    }
}
