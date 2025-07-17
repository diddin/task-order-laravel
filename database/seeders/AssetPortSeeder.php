<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\AssetPort;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssetPortSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua asset
        $assets = Asset::all();

        foreach ($assets as $asset) {
            // Pilih jumlah port secara acak dari pilihan yang diizinkan
            $jumlahPort = collect([12, 24, 44, 48, 96])->random();

            // Simpan semua port yang dibuat untuk keperluan jumper reference
            $createdPorts = [];

            for ($i = 1; $i <= $jumlahPort; $i++) {
                $port = AssetPort::create([
                    'asset_id' => $asset->id,
                    'port' => "PORT $i",
                    'jumper_id' => null, // Set sementara null
                ]);

                $createdPorts[] = $port;
            }

            // Tambahkan jumper_id secara acak (tidak semua)
            foreach ($createdPorts as $port) {
                if (fake()->boolean(30)) { // 30% kemungkinan di-jumper
                    // Ambil port lain sebagai jumper target (selain dirinya)
                    $jumper = collect($createdPorts)
                        ->reject(fn($p) => $p->id === $port->id)
                        ->random();

                    $port->update(['jumper_id' => $jumper->id]);
                }
            }
        }
    }
}
