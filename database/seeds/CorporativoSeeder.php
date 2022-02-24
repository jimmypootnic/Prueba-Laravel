<?php

use App\Models\tw_corporativos;
use Illuminate\Database\Seeder;

class CorporativoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(tw_corporativos::class, 10)->create();
    }
}
