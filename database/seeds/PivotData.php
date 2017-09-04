<?php

use Illuminate\Database\Seeder;

class PivotData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients = new \App\Clients();
        $client = $clients->find(1);
        $client->comics()->sync([1]);
    }
}
