@extends('layouts.app')

@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    <div class="card">
        <div class="card-body">
            <h2 style="margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px;">My Profile</h2>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('account.profile.update') }}">
                @csrf

                <div style="margin-bottom: 15px;">
                    <label for="name" style="display: block; margin-bottom: 5px; font-weight: bold;">Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" readonly disabled 
                        style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; background-color: #e9ecef;">
                    <small style="color: #6c757d; display: block; margin-top: 5px;">Name cannot be changed.</small>
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="email" style="display: block; margin-bottom: 5px; font-weight: bold;">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" readonly disabled 
                        style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; background-color: #e9ecef;">
                    <small style="color: #6c757d; display: block; margin-top: 5px;">Email cannot be changed.</small>
                </div>

                <div style="margin-bottom: 20px;">
                    <label for="phone" style="display: block; margin-bottom: 5px; font-weight: bold;">Phone Number</label>
                    <input id="phone" type="text" name="phone" value="{{ old('phone', $user->phone) }}" 
                        style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;" autofocus>
                    @error('phone')
                        <div style="color: #dc3545; font-size: 0.875em; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Profile</button>
            </form>
        </div>
    </div>
</div>
@endsection