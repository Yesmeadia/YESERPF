<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    public function run(): void
    {
        $states = [
            ['name' => 'Jammu & Kashmir', 'code' => 'JK'],
            ['name' => 'Rajasthan',        'code' => 'RJ'],
            ['name' => 'West Bengal',      'code' => 'WB'],
            ['name' => 'Bihar',            'code' => 'BR'],
            ['name' => 'Maharashtra',      'code' => 'MH'],
            ['name' => 'Andhra Pradesh',   'code' => 'AP'],
            ['name' => 'Karnataka',        'code' => 'KA'],
            ['name' => 'Kerala',           'code' => 'KL'],
        ];

        foreach ($states as $state) {
            State::updateOrCreate(['code' => $state['code']], $state);
        }
    }
}
