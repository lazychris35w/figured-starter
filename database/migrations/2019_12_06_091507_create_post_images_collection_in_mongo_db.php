<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostImagesCollectionInMongoDb extends Migration
{
    protected $connection = 'mongodb';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection($this->connection)->dropIfExists('post_images');

        Schema::connection($this->connection)
            ->create('post_images', function (Blueprint $collection) {
                $collection->index('post_image_path');
                // $collection->unique('id');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection($this->connection)
            ->table('post_images', function (Blueprint $collection)
            {
                $collection->drop();
            });
    }
}
