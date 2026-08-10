@extends('layouts.app')

@section('title', 'Completed Orders')

@section('content')
    @include('dashboard.orders._table', [
        'pageTitle' => 'Completed Orders',
        'pageDescription' => 'Orders that have been delivered.',
    ])
@endsection

@push('scripts')
<script src="{{ asset('js/orders/index.js') }}"></script>
@endpush
