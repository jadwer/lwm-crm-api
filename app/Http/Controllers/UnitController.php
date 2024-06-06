<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitStoreRequest;
use App\Http\Requests\UnitUpdateRequest;
use App\Http\Resources\UnitCollection;
use App\Http\Resources\UnitResource;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UnitController extends Controller
{
    public function index(Request $request): Response
    {
        $units = Unit::all();

        return response(new UnitCollection($units));
    }

    public function store(UnitStoreRequest $request): Response
    {
        $unit = Unit::create($request->validated());

        return response(new UnitResource($unit),201);
    }

    public function show(Request $request, Unit $unit): Response
    {
        return response(new UnitResource($unit));
    }

    public function update(UnitUpdateRequest $request, Unit $unit): Response
    {
        $unit->update($request->validated());

        return response(new UnitResource($unit));
    }

    public function destroy(Request $request, Unit $unit): Response
    {
        $unit->delete();

        return response()->noContent();
    }
}
