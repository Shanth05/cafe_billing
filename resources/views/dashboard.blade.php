@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">

            @php
                $role = auth()->user()->getRoleNames()->first() ?? 'No Role';
            @endphp

            @if($role)
                <p>
                    You're logged in as <strong class="text-success">{{ ucfirst($role) }}</strong>!
                </p>

                @switch($role)
                    @case('admin')
                        <p>Welcome Admin! Here you can manage users, settings, and reports.</p>
                        @break

                    @case('manager')
                        <p>Welcome Manager! Here you can monitor sales, manage orders and staff.</p>
                        @break

                    @case('cashier')
                        <p>Welcome Cashier! Here you can process bills and manage daily transactions.</p>
                        @break

                    @default
                        <p>Your role dashboard is under construction.</p>
                @endswitch
            @else
                <p class="text-danger">You're logged in but no role has been assigned.</p>
            @endif
        </div>
    </div>
</div>
@endsection
