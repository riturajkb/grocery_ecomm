@extends('layouts.app')

@section('content')
    <div style="max-width: 600px; margin: 0 auto;">
        <div style="margin-bottom: 24px;">
            <h1>Add New Address</h1>
            <a href="{{ route('account.addresses') }}" style="color: #007bff; text-decoration: none;">← Back to
                Addresses</a>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('account.addresses.store') }}">
                    @csrf

                    <div style="margin-bottom: 15px;">
                        <label for="name" style="display: block; margin-bottom: 5px; font-weight: bold;">Full Name *</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                        @error('name')
                            <div style="color: #dc3545; font-size: 0.875em; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label for="phone" style="display: block; margin-bottom: 5px; font-weight: bold;">Phone Number
                            *</label>
                        <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                        @error('phone')
                            <div style="color: #dc3545; font-size: 0.875em; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label for="address" style="display: block; margin-bottom: 5px; font-weight: bold;">Address
                            *</label>
                        <textarea id="address" name="address" rows="3" required
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">{{ old('address') }}</textarea>
                        @error('address')
                            <div style="color: #dc3545; font-size: 0.875em; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label for="city" style="display: block; margin-bottom: 5px; font-weight: bold;">City *</label>
                        <input id="city" type="text" name="city" value="{{ old('city') }}" required
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                        @error('city')
                            <div style="color: #dc3545; font-size: 0.875em; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label for="state" style="display: block; margin-bottom: 5px; font-weight: bold;">State *</label>
                        <input id="state" type="text" name="state" value="{{ old('state') }}" required
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                        @error('state')
                            <div style="color: #dc3545; font-size: 0.875em; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label for="pincode" style="display: block; margin-bottom: 5px; font-weight: bold;">Pincode
                            *</label>
                        <input id="pincode" type="text" name="pincode" value="{{ old('pincode') }}" required
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                        @error('pincode')
                            <div style="color: #dc3545; font-size: 0.875em; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: flex; align-items: center; cursor: pointer;">
                            <input type="checkbox" name="is_default" value="1" {{ old('is_default') ? 'checked' : '' }}
                                style="margin-right: 8px; width: 18px; height: 18px;">
                            <span>Set as default address</span>
                        </label>
                    </div>

                    <div style="display: flex; gap: 10px;">
                        <button type="submit" class="btn btn-primary">Save Address</button>
                        <a href="{{ route('account.addresses') }}" class="btn"
                            style="background: #f8f9fa;">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection