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
            value="250"
            icon="users"
            color="blue" />

        <x-dashboard.card
            title="Total Orders"
            value="145"
            icon="clipboard-list"
            color="green" />

        <x-dashboard.card
            title="Pending Orders"
            value="12"
            icon="clock"
            color="yellow" />

        <x-dashboard.card
            title="Completed Orders"
            value="133"
            icon="circle-check"
            color="emerald" />

        <x-dashboard.card
            title="Revenue"
            value="Rs. 250,000"
            icon="sack-dollar"
            color="purple" />

        <x-dashboard.card
            title="Today's Orders"
            value="18"
            icon="calendar-day"
            color="red" />

    </div>

</div>

@endsection