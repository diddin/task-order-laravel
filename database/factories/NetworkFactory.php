<?php

namespace Database\Factories;

use App\Models\Network;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Network>
 */
class NetworkFactory extends Factory
{
    protected $model = Network::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // access
        $types = ['FO', 'Wireless', 'VSAT'];
        $services = ['B2B', 'Retail', 'Dedicated', 'Shared'];
        $locations = ['Curug', 'Citereup', 'Cibinong', 'Bogor Kota', 'Depok', 'Bekasi'];
        $descriptions = ['via POP A', 'through Node X', 'melewati Hub B', 'melalui BTS C', null, null]; // null untuk kadang tanpa tambahan

        $access = 'Akses: ' .
            $this->faker->randomElement($types) . ' ' .
            $this->faker->randomElement($services) . ' to ' .
            $this->faker->randomElement($locations);

        // Tambahan opsional, Kalau Anda ingin selalu ada deskripsi tambahan, cukup hapus null dari array $descriptions:
        $extra = $this->faker->randomElement($descriptions);
        if ($extra) {
            $access .= ' ' . $extra;
        }

        // Komponen data_core
        $odps = ['ODP KASAKATA', 'ODP MARGAHAYU', 'ODP SUKAMAJU', 'ODP MELATI'];
        $ports = range(1, 32);
        $closures = [
            ['K48 T3 C2', 'K96 T4 C9'],
            ['K12 T1 C1', 'K34 T2 C3'],
            ['K22 T2 C5', 'K88 T1 C8'],
            ['K11 T3 C4', 'K99 T5 C7'],
        ];
        $locations = ['SPBU', 'DEPAN PELANGGAN', 'BELAKANG TOKO', 'SAMPING SEKOLAH'];

        // Random pick
        $odp = $this->faker->randomElement($odps);
        $port = $this->faker->randomElement($ports);
        [$closure1_from, $closure1_to] = $this->faker->randomElement($closures);
        [$closure2_from, $closure2_to] = $this->faker->randomElement($closures);
        $closure_location = $this->faker->randomElement($locations);
        $customerInfo = $this->faker->numerify('202########') . ' - ' . strtoupper($this->faker->company);
        $customerInfo = preg_replace('/^[ \t]+/m', '', $customerInfo);

        return [
            'network_number' => $this->faker->ipv4,
            'detail' => $this->faker->sentence,
            'access' => $access,
            'data_core' => <<<TEXT
                $customerInfo

                $odp
                PORT $port

                CLOSURE ODP
                $closure1_from><$closure1_to

                CLOSURE $closure_location
                $closure2_from><$closure2_to
                TEXT,
            'customer_id' => Customer::inRandomOrder()->first()?->id ?? Customer::factory(),
        ];

        // Anda bisa memperluas variasi ODP, closure, atau locations agar output makin beragam.
        // Format tetap dijaga agar masih bisa diparsing / dibaca jika diperlukan di aplikasi.
    }
}
