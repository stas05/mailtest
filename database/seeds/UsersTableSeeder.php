<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userStatus = factory(App\Status::class, 'user')->create();

        factory(App\User::class, 'admin', 1)->create()->each(function ($user) use ($userStatus)
        {
           $user->roles()->save(factory(App\Role::class, 'admin')->make());
           $user->status_id = $userStatus->id;
           $user->save();

        });

        factory(App\User::class, 'guest', 10)->create();

        $userRole = factory(App\Role::class, 'user')->create();
        factory(App\User::class, 'user', 2)->create()->each(function ($user) use ($userRole, $userStatus)
        {
            $user->roles()->attach($userRole);
            $user->status_id = $userStatus->id;
            $user->save();
        });

        DB::table('statuses')->insert([
            'name' => 'invited',
        ]);
        DB::table('statuses')->insert([
            'name' => 'blocked',
        ]);
        DB::table('statuses')->insert([
            'name' => 'removed',
        ]);
    }
}
