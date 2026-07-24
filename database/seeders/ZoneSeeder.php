<?php

namespace Database\Seeders;

use App\Models\State;
use App\Models\Zone;
use Illuminate\Database\Seeder;

class ZoneSeeder extends Seeder
{
    public function run(): void
    {
        $zonesData = [
            // Jammu & Kashmir zones
            'JK' => [
                ['name' => 'Poonch',     'code' => 'JK-PNC'],
                ['name' => 'Mandi',      'code' => 'JK-MND'],
                ['name' => 'Surankote',  'code' => 'JK-SRK'],
                ['name' => 'Mendar',     'code' => 'JK-MNR'],
                ['name' => 'Rajouri',    'code' => 'JK-RJR'],
                ['name' => 'Srinagar',   'code' => 'JK-SXR'],
                ['name' => 'Jammu',      'code' => 'JK-JAM'],
                ['name' => 'Doda',       'code' => 'JK-DOD'],
            ],
            // Rajasthan zones
            'RJ' => [
                ['name' => 'Rajasthan',  'code' => 'RJ-RAJ'],
            ],
            // West Bengal — North East zone
            'WB' => [
                ['name' => 'North East', 'code' => 'WB-NE'],
            ],
            // Bihar — North East zone
            'BR' => [
                ['name' => 'North East', 'code' => 'BR-NE'],
            ],
            // Maharashtra zones
            'MH' => [
                ['name' => 'Maharashtra', 'code' => 'MH-MAH'],
            ],
            // Andhra Pradesh — South zone
            'AP' => [
                ['name' => 'South', 'code' => 'AP-STH'],
            ],
            // Karnataka — South zone
            'KA' => [
                ['name' => 'South', 'code' => 'KA-STH'],
            ],
            // Kerala — South zone
            'KL' => [
                ['name' => 'South', 'code' => 'KL-STH'],
            ],
        ];

        foreach ($zonesData as $stateCode => $zones) {
            $state = State::where('code', $stateCode)->first();
            if ($state) {
                foreach ($zones as $zone) {
                    Zone::updateOrCreate(
                        ['state_id' => $state->id, 'code' => $zone['code']],
                        ['name' => $zone['name']]
                    );
                }
            }
        }
    }
}
