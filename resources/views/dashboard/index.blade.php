@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="space-y-6">

    <div>

        <h1 class="text-3xl font-bold">
            Dashboard
        </h1>

        <p class="text-gray-500">
            Welcome back, {{ auth()->user()->name }} 👋
        </p>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

        <x-dashboard.card
            title="Total Customers"
            value="{{ number_format($stats['total_customers']) }}"
            icon="users"
            color="blue" />

        <x-dashboard.card
            title="Total Orders"
            value="{{ number_format($stats['total_orders']) }}"
            icon="clipboard-list"
            color="green" />

        <x-dashboard.card
            title="Pending Orders"
            value="{{ number_format($stats['pending_orders']) }}"
            icon="clock"
            color="yellow" />

        <x-dashboard.card
            title="Completed Orders"
            value="{{ number_format($stats['completed_orders']) }}"
            icon="circle-check"
            color="emerald" />

        <x-dashboard.card
            title="Revenue"
            value="Rs. {{ number_format($stats['revenue']) }}"
            icon="sack-dollar"
            color="purple" />

        <x-dashboard.card
            title="Today's Orders"
            value="{{ number_format($stats['todays_orders']) }}"
            icon="calendar-day"
            color="red" />

    </div>

</div>

@endsection