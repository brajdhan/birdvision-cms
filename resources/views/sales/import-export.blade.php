<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bulk Data Import/Export') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Success/Failure Messages -->
                    @if (session('success'))
                        <div class="bg-green-500 text-white p-4 rounded-md mb-4" id="msg_alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-500 text-white p-4 rounded-md mb-4" id="msg_alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Import Section -->
                        <div class="bg-white shadow-md p-6 rounded-lg">
                            <h3 class="text-xl font-semibold mb-4">Import Sales</h3>
                            <form action="{{ route('sales.import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div>

                                    <label for="file" class="block mb-2">Select File (CSV or Excel)</label>
                                    <input type="file" name="file" id="file"
                                    class="border p-2 rounded-md w-full mb-4" 
                                    {{-- required --}}
                                    >
                                    <!-- Display error message if validation fails -->
                                    @error('file')
                                    <div class="text-red-500 text-sm">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md">
                                    Import Sales
                                </button>

                                <div class="mt-4">
                                    <h4 class="text-lg">Download Sample Files:</h4>
                                    <ul class="list-disc ml-6">
                                        <li><a href="{{ asset('assets/sample/sales.csv') }}" class="text-blue-500">Download CSV Sample</a></li>
                                        <li><a href="{{ asset('assets/sample/sales.xlsx') }}" class="text-blue-500">Download Excel Sample</a></li>
                                    </ul>
                                </div>
                            </form>
                        </div>

                        <!-- Export Section -->
                        <div class="bg-white shadow-md p-6 rounded-lg">
                            <h3 class="text-xl font-semibold mb-4">Export Sales</h3>
                            <form action="{{ route('sales.export') }}" method="GET">
                                @csrf

                                <!-- Date Range Filter -->
                                <div class="mb-4">
                                    <label for="start_date" class="block mb-2">Start Date</label>
                                    <input type="date" name="start_date" id="start_date"
                                        value="{{ old('start_date') }}" class="border p-2 rounded-md w-full">
                                </div>

                                <div class="mb-4">
                                    <label for="end_date" class="block mb-2">End Date</label>
                                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"
                                        class="border p-2 rounded-md w-full">
                                </div>

                                <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded-md">
                                    Export Sales
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
