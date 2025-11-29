@extends('layouts.app')

@section('title', 'Edit Supplier')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded-xl shadow-lg animate-fade-in">

    <h1 class="text-3xl font-bold mb-4">Edit Supplier</h1>

    <form action="{{ route('restaurants.suppliers.update', [$restaurant, $supplier]) }}"
          method="POST" class="space-y-6">

        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label class="block font-semibold mb-1">Supplier Name *</label>
                <input type="text" name="name"
                       value="{{ old('name', $supplier->name) }}"
                       required class="w-full border rounded-lg px-3 py-2">
            </div>

            <div>
                <label class="block font-semibold mb-1">Company Name</label>
                <input type="text" name="company_name"
                       value="{{ old('company_name', $supplier->company_name) }}"
                       class="w-full border rounded-lg px-3 py-2">
            </div>

            <div>
                <label class="block font-semibold mb-1">Contact Person</label>
                <input type="text" name="contact_person"
                       value="{{ old('contact_person', $supplier->contact_person) }}"
                       class="w-full border rounded-lg px-3 py-2">
            </div>

            <div>
                <label class="block font-semibold mb-1">Phone</label>
                <input type="text" name="phone"
                       value="{{ old('phone', $supplier->phone) }}"
                       class="w-full border rounded-lg px-3 py-2">
            </div>

            <div>
                <label class="block font-semibold mb-1">Email</label>
                <input type="email" name="email"
                       value="{{ old('email', $supplier->email) }}"
                       class="w-full border rounded-lg px-3 py-2">
            </div>

            <div class="md:col-span-2">
                <label class="block font-semibold mb-1">Address</label>
                <textarea name="address"
                          class="w-full border rounded-lg px-3 py-2">{{ old('address', $supplier->address) }}</textarea>
            </div>

            <div class="md:col-span-2 mt-2">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_active" value="1"
                           {{ $supplier->is_active ? 'checked' : '' }}>
                    <span class="ml-2">Active Supplier</span>
                </label>
            </div>

        </div>

        <button type="submit"
                class="px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold">
            Update Supplier
        </button>

        <a href="{{ route('restaurants.suppliers.index', $restaurant) }}"
           class="px-6 py-3 bg-gray-200 rounded-lg font-semibold ml-2">
            Cancel
        </a>

    </form>
</div>
@endsection
