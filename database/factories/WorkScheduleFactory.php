<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WorkScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 2),
            'activity' => $this->faker->sentence(3),
            'target' => $this->faker->sentence(3),
            'report' => $this->faker->sentence(3),
            'status' => $this->faker->randomElement(['Belum Selesai', 'Proses', 'Selesai', 'Tidak Selesai']),
            'approval' => $this->faker->randomElement(['Tertunda', 'Disetujui', 'Ditolak']),
            'note' => $this->faker->sentence(3),
            'dates' => $this->faker->date(),
            'due_date' => $this->faker->date(),
            'start' => $this->faker->time(),
            'end' => $this->faker->time(),
        ];
    }
}
