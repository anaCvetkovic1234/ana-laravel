<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Genre;
use App\Models\Book;

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
        User::truncate();
        Genre::truncate();
        Book::truncate();


        $user = User::factory()->create();

        $genre1 = Genre::create(['name' => 'Comedy', 'slug' => 'comedy']);
        $genre2 = Genre::create(['name' => 'Tragedy', 'slug' => 'tragedy']);
        // $genre2 = Genre::create(['name' => 'Thriller', 'slug' => 'thriller']);

        Book::factory(2)->create([
            'user_id' => $user->id,
            'genre_id' => $genre1->id
        ]);
        Book::factory(2)->create([
            'user_id' => $user->id,
            'genre_id' => $genre2->id
        ]);

    }
}
