<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsCollectionInMongoDb extends Migration
{
    protected $connection = 'mongodb';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection($this->connection)->dropIfExists('posts');

        Schema::connection($this->connection)
            ->create('posts', function (Blueprint $collection) {
                $collection->index('title');
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
            ->table('posts', function (Blueprint $collection)
            {
                $collection->drop();
            });
    }
}
