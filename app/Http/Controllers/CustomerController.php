<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Http\Resources\CustomerCollection;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CustomerController extends Controller
{
    public function index(Request $request): Response
    {
        $customers = Customer::all();

        return response(new CustomerCollection($customers), 200);
    }

    public function store(CustomerStoreRequest $request): Response
    {
        $customer = Customer::create($request->validated());

        return response(new CustomerResource($customer), 201);
    }

    public function show(Request $request, Customer $customer): Response
    {
        return response(new CustomerResource($customer), 200);
    }

    public function update(CustomerUpdateRequest $request, Customer $customer): Response
    {
        $customer->update($request->validated());

        return response(new CustomerResource($customer), 200);
    }

    public function destroy(Request $request, Customer $customer): Response
    {
        $customer->delete();

        return response()->noContent();
    }
}
