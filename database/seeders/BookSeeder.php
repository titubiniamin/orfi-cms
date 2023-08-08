<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Book::create([
            "name" => 'English For Today for Class 9 and 10',
            'subject_id' => '1',
            'book' => 'book/z8U8og2XrLD9ekFXI81Yd4T5os6enbiHmtqBl1sK.pdf'
        ]);
    }
}
