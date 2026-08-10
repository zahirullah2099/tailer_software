@extends('layouts.app')

@section('title', 'Pending Orders')

@section('content')
    @include('dashboard.orders._table', [
        'pageTitle' => 'Pending Orders',
        'pageDescription' => 'Orders still in progress, not yet delivered.',
    ])
@endsection

@push('scripts')
<script src="{{ asset('js/orders/index.js') }}"></script>
@endpush
