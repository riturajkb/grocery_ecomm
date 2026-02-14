@extends('layouts.app')

@section('content')
    <div style="margin-bottom: 32px; display: flex; justify-content: space-between; align-items: center;">
        <h1>My Addresses</h1>
        <a href="{{ route('account.addresses.create') }}" class="btn btn-primary">+ Add New Address</a>
    </div>

    @if($addresses->isEmpty())
        <div class="card">
            <div class="card-body" style="text-align: center; padding: 60px 20px;">
                <p style="color: #6c757d; font-size: 1.1rem; margin-bottom: 20px;">You haven't added any addresses yet.</p>
                <a href="{{ route('account.addresses.create') }}" class="btn btn-primary">Add Your First Address</a>
            </div>
        </div>
    @else
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 20px;">
            @foreach($addresses as $address)
                <div class="card" style="position: relative;">
                    @if($address->is_default)
                        <div
                            style="position: absolute; top: 12px; right: 12px; background: #28a745; color: white; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">
                            Default
                        </div>
                    @endif

                    <div class="card-body">
                        <h5 style="margin-bottom: 12px; font-weight: 600;">{{ $address->name }}</h5>
                        <p style="margin-bottom: 8px; color: #495057;">{{ $address->phone }}</p>
                        <p style="margin-bottom: 8px; color: #495057; line-height: 1.5;">
                            {{ $address->address }}<br>
                            {{ $address->city }}, {{ $address->state }} - {{ $address->pincode }}
                        </p>

                        <div
                            style="margin-top: 16px; padding-top: 16px; border-top: 1px solid #eee; display: flex; gap: 10px; flex-wrap: wrap;">
                            @if(!$address->is_default)
                                <form action="{{ route('account.addresses.setDefault', $address->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn"
                                        style="background: #f8f9fa; padding: 6px 12px; font-size: 0.875rem;">
                                        Set as Default
                                    </button>
                                </form>
                            @endif

                            <a href="{{ route('account.addresses.edit', $address->id) }}" class="btn"
                                style="background: #f8f9fa; padding: 6px 12px; font-size: 0.875rem;">
                                Edit
                            </a>

                            <form action="{{ route('account.addresses.destroy', $address->id) }}" method="POST"
                                style="display: inline;"
                                onsubmit="return confirm('Are you sure you want to delete this address?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn"
                                    style="background: #f8d7da; color: #721c24; padding: 6px 12px; font-size: 0.875rem;">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection