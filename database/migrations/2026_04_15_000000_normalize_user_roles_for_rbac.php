<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('users')->where('role', 'owner')->update(['role' => 'pet_owner']);

        DB::table('users')->whereIn('role', ['vet', 'staff'])->update(['role' => 'admin']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('users')->where('role', 'pet_owner')->update(['role' => 'owner']);
    }
};
