<?php

use App\Room;
use App\User;
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
        $room_first = new Room();
        $room_first->name = 'first';
        $room_first->save();

        $room_second = new Room();
        $room_second->name = 'second';
        $room_second->save();

        $first = Room::where('name', 'first')->pluck('id')->first();
        $second  = Room::where('name', 'second')->pluck('id')->first();

        $user = new User();
        $user->name = 'john';
        $user->email = 'john@gmail.com';
        $user->password = bcrypt('123456');
        $user->save();
        $user->rooms()->attach([$first, $second]);

        $user = new User();
        $user->name = 'anna';
        $user->email = 'anna@gmail.com';
        $user->password = bcrypt('987654');
        $user->save();
        $user->rooms()->attach([$first, $second]);

        $user = new User();
        $user->name = 'david';
        $user->email = 'david@gmail.com';
        $user->password = bcrypt('qwerty');
        $user->save();
        $user->rooms()->attach([$first]);
    }
}
