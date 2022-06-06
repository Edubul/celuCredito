<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Celulares;
use App\Models\Contact;
use App\Models\Gastos;
use App\Models\Organization;
use App\Models\User;
use App\Models\Marcas;
use App\Models\Reportes;
use App\Models\Ventas;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $account = Account::create(['name' => 'Celu Credito - Colombia']);

        User::factory()->create([
            'account_id' => $account->id,
            'first_name' => 'Oscar',
            'last_name' => 'Celu-creditos',
            'email' => 'admin@celucreditos.com',
            'password' => '123456',
            'owner' => true,
        ]);

        // User::factory(5)->create(['account_id' => $account->id]);

        // $organizations = Organization::factory(100)
        //     ->create(['account_id' => $account->id]);

        // Contact::factory(100)
        //     ->create(['account_id' => $account->id])
        //     ->each(function ($contact) use ($organizations) {
        //         $contact->update(['organization_id' => $organizations->random()->id]);
        //     });

        Marcas::factory(10)->create();

        // Celulares::factory(20)->create()->each(function ($celular) {
        //     $celular->update([
        //         'marca_id' => Marcas::inRandomOrder()->first()->id,
        //     ]);
        // });

        // Reportes::factory(10)->create()->each(function ($reporte) {
        //     $reporte->update([
        //         'user_id' => User::inRandomOrder()->first()->id,
        //     ]);
        // });

        // Ventas::factory(10)->create()->each(function ($venta) {
        //     $venta->update([
        //         'id_celular' => Celulares::inRandomOrder()->first()->id,
        //     ]);
        // });

        // Gastos::factory(10)->create()->each(function ($gasto) {
        //     $gasto->update([
        //         'user_id' => User::inRandomOrder()->first()->id,
        //     ]);
        // });
    }
}
