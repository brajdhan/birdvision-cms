<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Customers') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="bg-green-500 text-white p-4 rounded-md mb-4" id="msg_alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <!-- Flex container for search box and button -->
                    <div class="flex justify-between items-center mb-4">

                        <div>


                            <!-- "Create" Button on the left -->
                            <a href="{{ route('customers.create') }}"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                Create Customer
                            </a>
                            {{-- Import/Export --}}
                            @if (auth()->check() && auth()->user()->role === 'admin')
                                <a href="{{ route('customers.export-import') }}"
                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                    Export/Import</a>
                            @endif

                            <!-- "Recycle Bin" link -->
                            @if (auth()->check() && auth()->user()->role === 'admin')
                                <a href="{{ route('customers.recycleBin') }}"
                                    class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800">
                                    Recycle Bin
                                </a>
                            @endif

                        </div>


                        <!-- Search Form on the right -->
                        <form method="GET" action="{{ route('customers.index') }}"
                            class="flex items-center space-x-2">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..."
                                class="border border-gray-300 p-2 rounded-md" />
                            <button type="submit"
                                class="bg-blue-500 text-white p-2 rounded-md ml-2 hover:bg-blue-600">Search</button>
                        </form>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider bg-gray-400 hover:bg-gray-600">
                                        Name
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider bg-gray-400 hover:bg-gray-600">
                                        Email
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider bg-gray-400 hover:bg-gray-600">
                                        Phone
                                    </th>
                                    @if (auth()->check() && auth()->user()->role === 'admin')
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider bg-gray-400 hover:bg-gray-600">
                                        Actions
                                    </th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $item)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $item->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $item->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $item->phone }}</td>
                                            @if (auth()->check() && auth()->user()->role === 'admin')
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center space-x-2">
                                                <!-- Edit Link -->
                                                <a href="{{ route('customers.edit', $item->id) }}"
                                                    class="text-blue-600 hover:text-blue-900">Edit</a>
                                                <span>|</span>
                                                <!-- Delete Form -->
                                                <form id="delete-form-{{ $item->id }}"
                                                    action="{{ route('customers.destroy', $item->id) }}" method="POST"
                                                    class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a class="text-red-600 hover:text-red-900"
                                                        href="javascript:void(0);"
                                                        onclick="submitDeleteForm('{{ $item->id }}')">Delete</a>
                                                </form>
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $customers->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
