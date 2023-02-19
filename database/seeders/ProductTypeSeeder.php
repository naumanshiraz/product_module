<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['name' => 'Item'],
            ['name' => 'Service'],
        ];

        collect($types)->each(function ($type) {
            ProductType::create($type);
        });
    }
}
