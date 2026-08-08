<?php

namespace App\Http\Controllers;

use App\Actions\Customer\CreateCustomerWithMeasurementAction;
use App\DataTables\CustomerDataTable;
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Repository\Interfaces\CustomerInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

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
            'redirect_url' => route('dashboard.customers.show', $customer->id),
        ]);
    }

    public function show(int $customer): View
    {
        $customer = $this->customers->findWithMeasurements($customer);

        return view('dashboard.customers.show', compact('customer'));
    }
}
