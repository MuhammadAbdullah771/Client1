<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $developerHero = 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=1600&q=80';
        DB::table('services')
            ->where('title', 'IT Services')
            ->update(['image' => $developerHero, 'updated_at' => now()]);
    }

    public function down(): void
    {
        $previous = 'https://lh3.googleusercontent.com/aida-public/AB6AXuB16YosuDjtnlrkk2LdSvOh0JM0wbw1FzYvs3mw2JDjVdZ-p-bYgs0k8vWOFoY44SgpTrynBFhFzoTfpYJIlhCYwSW4PAjWwPUN1BQyvBQpu6kq8vTJzytrJCLzG6yFvtouXigD6-FCRPEKuTOchs6sH94gm1PBCpYiY_cyl2MbX2s3ftLcEfv5LmiAryP7vBaDmN392DwRkaXZzja43G2ttaInqhGK94XkgOvLBgcH3Xmz3KIKmD0H8zMSg5YNEKc-BUwV-kmNoPk';
        DB::table('services')
            ->where('title', 'IT Services')
            ->update(['image' => $previous, 'updated_at' => now()]);
    }
};
