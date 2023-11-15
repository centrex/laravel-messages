<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->integer('thread_id')->unsigned()->index();
            $table->morphs('creator');
            $table->text('body');
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
