<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Sale') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Display validation errors if any -->
                    @if ($errors->any())
                        <div class="bg-red-500 text-white p-4 rounded-md mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Create Sale Form -->
                    <form method="POST" action="{{ route('sales.store') }}">
                        @csrf

                        <!-- Customer Dropdown -->
                        <div class="mb-4">
                            <label for="customer_id" class="block text-sm font-medium text-gray-700">Customer</label>
                            <select name="customer_id" id="customer_id"
                                class="select2 border border-gray-300 p-2 rounded-md w-full" required>
                                <option value="">Select a customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}"
                                        {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Product Name -->
                        <div class="mb-4">
                            <label for="product_name" class="block text-gray-700">Product Name</label>
                            <input type="text" name="product_name" id="product_name"
                                value="{{ old('product_name') }}" class="border border-gray-300 p-2 rounded-md w-full"
                                {{-- required --}} />
                        </div>

                        <!-- Amount -->
                        <div class="mb-4">
                            <label for="amount" class="block text-gray-700">Amount</label>
                            <input type="text" name="amount" id="amount" value="{{ old('amount') }}"
                                class="border border-gray-300 p-2 rounded-md w-full" {{-- required --}} />
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit"
                                class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
                                Create Sale
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                new TomSelect('.select2', {
                    create: false, // Disable adding new items
                    sortField: {
                        field: "text",
                        direction: "asc"
                    }, // Sort options alphabetically
                    placeholder: "Select a customer",
                });
            });
        </script>
    @endsection
</x-app-layout>
