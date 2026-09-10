<?php

namespace Database\Seeders;

use App\Models\Desa;
use App\Models\Kecamatan;
use Illuminate\Database\Seeder;

class UpdateKewilayahanCountsSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Kecamatan::all() as $k) {
            $desaCount = $k->desas()->count();
            $k->jumlah_desa = $desaCount > 0 ? $desaCount : ((($k->id * 7) % 6) + 7);
            $k->jumlah_rw = (($k->id * 13) % 45) + 38;
            $k->jumlah_rt = (($k->id * 37) % 320) + 180;
            $k->save();
        }

        foreach (Desa::all() as $d) {
            $d->jumlah_rw = (($d->id * 3) % 8) + 4;
            $d->jumlah_rt = $d->jumlah_rw * 5;
            $d->save();
        }
    }
}
