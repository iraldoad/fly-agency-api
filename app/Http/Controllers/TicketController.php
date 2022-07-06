<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response|ResponseFactory
    {
        $query = Ticket::query();

        request()->collect(['flight_id', 'seat'])
            ->each(function ($value, $field) use ($query) {
                $query->where($field, $value);
            });

        request()->whenHas('passenger_name', function ($value) use ($query) {
            $query->where(
                DB::raw('lower(passenger_name)'),
                'like',
                '%' . strtolower($value) . '%'
            );
        });

        return jsend_success([
            'tickets' => $query->customPaginate()
                ->get(),
            'total' => $query->count(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket): Response|ResponseFactory
    {
        $ticket->load('flight');

        return jsend_success(compact('ticket'));
    }
}
