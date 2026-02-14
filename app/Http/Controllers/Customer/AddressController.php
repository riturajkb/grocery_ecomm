<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    /**
     * Display all addresses for the customer.
     */
    public function index()
    {
        $addresses = Auth::user()->addresses()->get();
        return view('account.addresses.index', compact('addresses'));
    }

    /**
     * Show the form for creating a new address.
     */
    public function create()
    {
        return view('account.addresses.create');
    }

    /**
     * Store a newly created address.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'pincode' => 'required|string|max:10',
        ]);

        $address = Auth::user()->addresses()->create($request->all());

        // If this is the first address or is_default is checked, make it default
        if ($request->has('is_default') || Auth::user()->addresses()->count() == 1) {
            // Remove default from all other addresses
            Auth::user()->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
            $address->is_default = true;
            $address->save();
        }

        return redirect()->route('account.addresses')->with('success', 'Address added successfully.');
    }

    /**
     * Show the form for editing an address.
     */
    public function edit($id)
    {
        $address = Auth::user()->addresses()->findOrFail($id);
        return view('account.addresses.edit', compact('address'));
    }

    /**
     * Update the specified address.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'pincode' => 'required|string|max:10',
        ]);

        $address = Auth::user()->addresses()->findOrFail($id);
        $address->update($request->all());

        if ($request->has('is_default')) {
            Auth::user()->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
            $address->is_default = true;
            $address->save();
        }

        return redirect()->route('account.addresses')->with('success', 'Address updated successfully.');
    }

    /**
     * Remove the specified address.
     */
    public function destroy($id)
    {
        $address = Auth::user()->addresses()->findOrFail($id);

        // If this was the default address, make another one default
        if ($address->is_default) {
            $newDefault = Auth::user()->addresses()->where('id', '!=', $id)->first();
            if ($newDefault) {
                $newDefault->is_default = true;
                $newDefault->save();
            }
        }

        $address->delete();

        return redirect()->route('account.addresses')->with('success', 'Address deleted successfully.');
    }

    /**
     * Set an address as default.
     */
    public function setDefault($id)
    {
        $address = Auth::user()->addresses()->findOrFail($id);

        // Remove default from all addresses
        Auth::user()->addresses()->update(['is_default' => false]);

        // Set this address as default
        $address->is_default = true;
        $address->save();

        return redirect()->route('account.addresses')->with('success', 'Default address updated.');
    }
}
