<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Organization;
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
        $account = Account::create(['name' => 'Acme Corporation']);

        User::factory()->create([
            'account_id' => $account->id,
            'first_name' => 'Abdessamad',
            'last_name' => 'BENNOUF',
            'email' => 'abdessamad@bennouf.es',
            'owner' => true,
        ]);

        User::factory(5)->create(['account_id' => $account->id]);

        $organizations = Organization::factory(50)
        ->create(['account_id' => $account->id]);

        Contact::factory(50)
        ->create(['account_id' => $account->id])
        ->each(function ($contact) use ($organizations) {
            $contact->update(['organization_id' => $organizations->random()->id]);
        });
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
