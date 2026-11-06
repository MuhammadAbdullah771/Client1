<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Ensure only one "IT Services" row exists. Keep the one with smallest id;
     * reassign portfolio_items from duplicates to that one, then delete duplicates.
     */
    public function up(): void
    {
        $ids = DB::table('services')
            ->where('title', 'IT Services')
            ->orderBy('id')
            ->pluck('id');

        if ($ids->count() <= 1) {
            return;
        }

        $keepId = $ids->first();
        $duplicateIds = $ids->slice(1)->values()->all();

        foreach ($duplicateIds as $dupId) {
            DB::table('portfolio_items')->where('service_id', $dupId)->update(['service_id' => $keepId]);
            DB::table('services')->where('id', $dupId)->delete();
        }
    }

    public function down(): void
    {
        // Cannot restore deleted duplicates
    }
};
