<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // teachers
        DB::table('teachers')->insert([
            ['id' => 1000, 'name' => '超级管理员']
        ]);
        // exams
        $this->call(ExamsSeeder::class);
    }
}
