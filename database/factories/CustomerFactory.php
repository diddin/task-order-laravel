<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $odps = ['ODP KASAKATA', 'ODP MARGAHAYU', 'ODP SUKAMAJU', 'ODP MELATI'];
        $ports = range(1, 32);
        $closures = [
            ['K48 T3 C2', 'K96 T4 C9'],
            ['K12 T1 C1', 'K34 T2 C3'],
            ['K22 T2 C5', 'K88 T1 C8'],
            ['K11 T3 C4', 'K99 T5 C7'],
        ];
        $locations = ['SPBU', 'DEPAN PELANGGAN', 'BELAKANG TOKO', 'SAMPING SEKOLAH'];
        $clusters = ['BWA', 'SAST', 'CDA', 'BDA', 'SEOA', 'NEA'];

        $category = $this->faker->randomElement(['akses', 'backbone']);
        $cluster = $this->faker->randomElement($clusters);

        $odp = $this->faker->randomElement($odps);
        $port = $this->faker->randomElement($ports);
        [$closure1_from, $closure1_to] = $this->faker->randomElement($closures);
        [$closure2_from, $closure2_to] = $this->faker->randomElement($closures);
        $closure_location = $this->faker->randomElement($locations);
        $customerInfo = $this->faker->numerify('202########') . ' - ' . strtoupper($this->faker->company);
        $customerInfo = preg_replace('/^[ \t]+/m', '', $customerInfo);

        $technicalData = <<<TEXT
            $customerInfo

            $odp
            PORT $port

            CLOSURE ODP
            $closure1_from><$closure1_to

            CLOSURE $closure_location
            $closure2_from><$closure2_to
        TEXT;

        return [
            'category' => $category,
            'name' => $category === 'akses' ? $this->faker->company() : 'PT LINTASARTA',
            'contact_person' => $category === 'akses' ? $this->faker->name() : 'Tim NOC Lintasarta',
            'address' => $category === 'akses'
                ? $this->faker->address()
                : 'Menara Thamrin, Lantai 12, Jl. M.H. Thamrin Kav.3, Jakarta 10250',
            'network_number' => $category === 'akses'
                ? Str::upper(Str::random(8))
                : 'BB-' . Str::upper(Str::random(6)),
            'pic' => $category === 'akses'
                ? $this->faker->phoneNumber()
                : '08561114052',
            'technical_data' => $category === 'akses'
                ? $technicalData
                : <<<DATA
                    PT LINTASARTA
                    ODP BACKBONE
                    PORT 1
                    CLOSURE 01><02
                    Lokasi: Central Node
                DATA,
            'cluster' => $cluster,
        ];
    }

    /**
     * State untuk kategori akses
     */
    public function akses()
    {
        $clusters = ['BWA', 'SAST', 'CDA', 'BDA', 'SEOA', 'NEA'];

        return $this->state(function (array $attributes) use ($clusters) {
            return [
                'category' => 'akses',
                'name' => $this->faker->company(),
                'contact_person' => $this->faker->name(),
                'address' => $this->faker->address(),
                'network_number' => Str::upper(Str::random(8)),
                'pic' => $this->faker->phoneNumber(),
                'cluster' => $this->faker->randomElement($clusters),
            ];
        });
    }

    /**
     * State untuk kategori backbone
     */
    public function backbone()
    {
        return $this->state(function (array $attributes) {
            return [
                'category' => 'backbone',
                'name' => 'PT LINTASARTA',
                'contact_person' => 'Tim NOC Lintasarta',
                'address' => 'Menara Thamrin, Lantai 12, Jl. M.H. Thamrin Kav.3, Jakarta 10250',
                'network_number' => '-',//'BB-' . Str::upper(Str::random(6)),
                'pic' => '08561114052',
                'technical_data' => <<<DATA
                    PT LINTASARTA
                    ODP BACKBONE
                    PORT 1
                    CLOSURE 01><02
                    Lokasi: Central Node
                DATA,
                'cluster' => 'BDA',
            ];
        });
    }

    // public function akses()
    // {
    //     return $this->state(fn () => ['category' => 'akses']);
    // }

    // public function backbone()
    // {
    //     return $this->state(fn () => ['category' => 'backbone']);
    // }
}
