<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $comics = new \App\Comics();
        $comics->insert([
            'title' => 'Scooby-Doo',
            'number' => '82',
            'id' => '1',
            'barcode' => '619412981208211',
            'notes' => 'a comic'
        ]);
        $comics->insert([
            'title' => 'foo to the bar',
            'number' => '666',
            'barcode' => '666666666666666',
            'deleted_at' => DB::raw('CURRENT_TIMESTAMP'),
            'notes' => 'a deleted comic'
        ]);
        $clients = new \App\Clients();
        $clients->insert([
            'name' => 'Patrick Moon',
            'barcode' => '00000001',
            'email' => 'patrickmoon@gmail.com',
            'phone' => '6016704',
            'other' => 'aim:2290697'
        ]);
        $clients->insert([
            'name' => 'Delete Test',
            'barcode' => '00000666',
            'email' => 'foo@bar.com',
            'phone' => '6666666',
            'other' => 'whatever',
            'deleted_at' => DB::raw('CURRENT_TIMESTAMP')
        ]);
        
        $groups = new \App\Groups();
        $groups->insert([
            'barcode' => '20000001',
            'title' => 'scooby doo',
        ]);
        $groups->insert([
            'barcode' => '20000666',
            'title' => 'foo a bar',
            'deleted_at' => DB::raw('CURRENT_TIMESTAMP')
        ]);
    }
}
