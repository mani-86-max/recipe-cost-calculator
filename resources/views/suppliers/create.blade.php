@extends('layouts.app')

@section('title', 'Add New Supplier')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded-xl shadow-lg animate-fade-in">

    <h1 class="text-3xl font-bold mb-4">Add New Supplier</h1>

    <form action="{{ route('restaurants.suppliers.store', $restaurant) }}" method="POST" class="space-y-6">
        @csrf

        <!-- Basic Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label class="block font-semibold mb-1">Supplier Name *</label>
                <input type="text" name="name" required
                       class="w-full border rounded-lg px-3 py-2" >
            </div>

            <div>
                <label class="block font-semibold mb-1">Company Name</label>
                <input type="text" name="company_name"
                       class="w-full border rounded-lg px-3 py-2">
            </div>

            <div>
                <label class="block font-semibold mb-1">Contact Person</label>
                <input type="text" name="contact_person"
                       class="w-full border rounded-lg px-3 py-2">
            </div>

            <div>
                <label class="block font-semibold mb-1">Phone</label>
                <input type="text" name="phone"
                       class="w-full border rounded-lg px-3 py-2">
            </div>

            <div>
                <label class="block font-semibold mb-1">Email</label>
                <input type="email" name="email"
                       class="w-full border rounded-lg px-3 py-2">
            </div>

            <div class="md:col-span-2">
                <label class="block font-semibold mb-1">Address</label>
                <textarea name="address"
                          class="w-full border rounded-lg px-3 py-2"></textarea>
            </div>

            <div class="md:col-span-2 mt-2">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_active" value="1" checked>
                    <span class="ml-2">Active Supplier</span>
                </label>
            </div>
        </div>

        <button type="submit"
                class="px-6 py-3 bg-purple-600 text-white rounded-lg font-semibold">
            Save Supplier
        </button>
    </form>

</div>
@endsection
