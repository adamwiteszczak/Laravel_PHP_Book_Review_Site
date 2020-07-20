<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGenresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genres', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('link');
        });

        $genres = array(
            'Fantasy',
            'Adventure',
            'Romance',
            'Contemporary',
            'Dystopian',
            'Mystery',
            'Horror',
            'Thriller',
            'Paranormal',
            'Science-Fiction',
            'Memoir',
            'Cooking',
            'Art',
            'Self-Help',
            'Development',
            'Motivational',
            'Health',
            'History',
            'Travel',
            'Guide How to',
            'Families and Relationships',
            'Humor',
            'Childrens',
            'Western'
        );

        foreach ($genres as $genre) {
            DB::table('genres')->insert(array(
                'name' => $genre,
                'link' => strtolower(str_replace(' ', '-', $genre))
            ));
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('genres');
    }
}
