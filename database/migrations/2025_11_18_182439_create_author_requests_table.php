<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('author_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained("users")->onDelete("cascade");
            $table->text("sample_text");
            $table->enum("status",["pending", "approved", "rejected"])->default("pending");
            $table->string("note")->nullable();
            $table->timestamps();
        });
    }

};
