<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::rename('tag_recipe', 'recipe_tag');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('recipe_tag', 'tag_recipe');
    }
};
