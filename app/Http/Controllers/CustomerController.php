<?php

namespace App\Http\Controllers;

use App\Actions\Customer\CreateCustomerWithMeasurementAction;
use App\Actions\Customer\DeleteCustomerAction;
use App\Actions\Customer\UpdateCustomerAction;
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Models\Customer;
use App\Repository\Interfaces\CustomerInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function __construct(
        private readonly CustomerInterface $customers,
    ) {}

    public function index(): View
    {
        $customers = $this->customers->all();

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

    public function edit(Customer $customer): JsonResponse
    {
        return response()->json([
            'customer' => $customer,
        ]);
    }

    public function update(UpdateCustomerRequest $request, Customer $customer, UpdateCustomerAction $action): JsonResponse
    {
        $customer = $action->execute($customer, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Customer updated successfully.',
            'customer' => $customer,
        ]);
    }

    public function destroy(Customer $customer, DeleteCustomerAction $action): JsonResponse
    {
        $action->execute($customer);

        return response()->json([
            'success' => true,
            'message' => 'Customer deleted successfully.',
        ]);
    }
}
