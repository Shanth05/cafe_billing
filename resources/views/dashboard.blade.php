<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <p>{{ __("You're logged in!") }}</p>

                    @php
                        $role = auth()->user()->getRoleNames()->first();
                    @endphp

                    @if($role)
                        <p class="mt-4">
                            {{ __("You're logged in as") }}
                            <strong class="text-green-600">{{ ucfirst($role) }}</strong>!
                        </p>

                        @if($role === 'admin')
                            <p>Welcome Admin! Here you can manage users, settings, and reports.</p>
                            <!-- Admin dashboard content here -->

                        @elseif($role === 'manager')
                            <p>Welcome Manager! Here you can monitor sales, manage orders and staff.</p>
                            <!-- Manager dashboard content here -->

                        @elseif($role === 'cashier')
                            <p>Welcome Cashier! Here you can process bills and manage daily transactions.</p>
                            <!-- Cashier dashboard content here -->

                        @else
                            <p>Your role dashboard is under construction.</p>
                        @endif

                    @else
                        <p class="mt-4 text-red-600">
                            {{ __("You're logged in but no role has been assigned.") }}
                        </p>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
