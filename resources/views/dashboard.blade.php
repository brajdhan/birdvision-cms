<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard & Analytics') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- Total Customers -->
                    <div class="bg-blue-500 text-white p-4 rounded-md">
                        <h3 class="text-lg">Total Customers</h3>
                        <p class="text-3xl">{{ $totalCustomers }}</p>
                    </div>

                    <!-- Total Sales Value -->
                    <div class="bg-green-500 text-white p-4 rounded-md">
                        <h3 class="text-lg">Total Sales Value</h3>
                        <p class="text-3xl">Rs {{ number_format($totalSalesValue, 2) }}</p>
                    </div>

                    <!-- Date Range Filter -->
                    <div class="p-4">
                        <form method="GET" action="{{ route('dashboard') }}">
                            <label for="start_date" class="block">Start Date</label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $startDate ?? '') }}" class="border p-2 rounded-md" />

                            <label for="end_date" class="block mt-2">End Date</label>
                            <input type="date" name="end_date" id="end_date"     value="{{ old('end_date', $endDate ?? '') }}" class="border p-2 rounded-md" />

                            <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-md">Filter</button>
                        </form>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Monthly Sales Trends (Line Chart) -->
                    <div class="bg-white shadow-lg rounded-lg border p-4">
                        <h2 class="text-lg font-semibold mb-4">Monthly Sales Trends</h2>
                        <canvas id="monthlySalesChart"></canvas>
                    </div>
                
                    <!-- Top 5 Customers (Bar Chart) -->
                    <div class="bg-white shadow-lg rounded-lg border p-4">
                        <h2 class="text-lg font-semibold mb-4">Top 5 Customers</h2>
                        <canvas id="topCustomersChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')

        <script>
            const monthlySalesData = @json($monthlySales);
            const topCustomersData = @json($topCustomers);

            // Monthly Sales Line Chart
            const ctx1 = document.getElementById('monthlySalesChart').getContext('2d');
            new Chart(ctx1, {
                type: 'line',
                data: {
                    labels: monthlySalesData.map(item => `${item.month}`),
                    datasets: [{
                        label: 'Sales Value',
                        data: monthlySalesData.map(item => item.total_sales),
                        borderColor: '#34D399',
                        borderWidth: 2,
                        fill: false,
                    }]
                }
            });

            // Top Customers Bar Chart
            const ctx2 = document.getElementById('topCustomersChart').getContext('2d');
            new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: topCustomersData.map(item => item.customer.name),
                    datasets: [{
                        label: 'Sales Value',
                        data: topCustomersData.map(item => item.total_sales),
                        backgroundColor: '#3B82F6',
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    @endsection
</x-app-layout>
