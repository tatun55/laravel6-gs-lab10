<?php

use Illuminate\Database\Seeder;

class AddBooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Book::class, 10)->create([
            'user_id' => 1,
            'item_img' => 'https://dummyimage.com/300x300/cccccc/ffffff&text=ダミー画像',
        ]);
    }
}
