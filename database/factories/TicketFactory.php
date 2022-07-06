<?php

namespace Database\Factories;

use App\Models\Flight;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $flight = Flight::withCount('tickets')
            ->find(
                $this->faker
                    ->randomElement(
                        Flight::pluck('id')->toArray()
                    )
            );

        return [
            'flight_id' => $flight->id,
            'passenger_name' => $this->faker->name,
            'seat' => $flight->tickets_count + 1,
        ];
    }
}
