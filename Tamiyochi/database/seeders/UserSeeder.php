<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Models\Company\CompanyId;
use App\Core\Domain\Models\CompanyPic\CompanyPicId;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User::factory()
        //     ->count(50)
        //     ->create();
    }
}
