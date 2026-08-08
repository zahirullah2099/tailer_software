<?php

namespace App\Http\Controllers;

use App\Actions\Customer\CreateCustomerWithMeasurementAction;
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Repository\Interfaces\CustomerInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function __construct(
        private readonly CustomerInterface $customers,
    ) {}

    public function index(Request $request): View
    {
        $customers = $this->customers->paginateWithSearch(
            search: $request->string('search')->toString() ?: null,
        );

        return view('dashboard.customers.index', compact('customers'));
    }

    public function create(): View
    {
        return view('dashboard.customers.create');
    }

    public function store(StoreCustomerRequest $request, CreateCustomerWithMeasurementAction $action): JsonResponse
    {
        $customer = $action->execute($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Customer added successfully.',
            'redirect_url' => route('customers.show', $customer->id),
        ]);
    }

    public function show(int $customer): View
    {
        $customer = $this->customers->findWithMeasurements($customer);

        return view('dashboard.customers.show', compact('customer'));
    }
}
