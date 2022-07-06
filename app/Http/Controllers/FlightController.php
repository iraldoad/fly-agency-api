<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Contracts\Routing\ResponseFactory;
use Symfony\Component\HttpFoundation\Response;

class FlightController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response|ResponseFactory
    {
        $query = Flight::query();

        request()->collect(['number', 'date', 'passengers'])
            ->each(function ($value, $field) use ($query) {
                $query->where($field, $value);
            });

        return jsend_success([
            'flights' => $query->customPaginate()
                ->get(),
            'total' => $query->count(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Flight $flight): Response|ResponseFactory
    {
        return jsend_success(compact('flight'));
    }
}
