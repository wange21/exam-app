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
        // add teachers
        DB::table('teachers')->insert([
            ['id' => 1000, 'name' => '超级管理员']
        ]);
        // add exams
        $this->call(ExamsSeeder::class);
        // get the latest exam per type
        // student id limited
        $exam0 = DB::table('exams')
            ->where('type', 0)
            ->orderBy('start', 'desc')
            ->first();
        // import accounts limited
        $exam1 = DB::table('exams')
            ->where('type', 1)
            ->orderBy('start', 'desc')
            ->first();
        // public password limited
        $exam2 = DB::table('exams')
            ->where('type', 2)
            ->orderBy('start', 'desc')
            ->first();

        // add users
        $user = DB::table('users')->insertGetId([
            'name' => '何阳',
            'email' => 'herobs@herobs.cn',
            'password' => bcrypt('123456'),
            'student' => '13055415',
            'major' => '网络工程',
        ]);
        $user = DB::table('users')->find($user);
        // add students
        // student id limited
        DB::table('students')->insert([
            [
                'exam' => $exam0->id,
                'student' => $user->student,
                'name' => '',
                'major' => '',
                'password' => null,
                'ip' => '0.0.0.0',
            ]
        ]);
        // import accounts limited
        DB::table('students')->insert([
            [
                'exam' => $exam1->id,
                'student' => '13055415',
                'name' => '何阳',
                'major' => '网络工程',
                'password' => bcrypt('123456'),
                'ip' => '0.0.0.0',
            ]
        ]);
        // public password limited
        DB::table('exams')
            ->where('id', $exam2->id)
            ->update(['password' => '123456']);

        // exam questions
        // true-false questions
        $trueFalse = DB::table('questions')->insertGetId([
            'exam' => $exam2->id,
            'type' => 0,
            'description' => '在 C 语言中，`int` 数据类型占用 4 字节内存。',
            'score' => 10,
            'source' => 0,
            'ref' => 0,
        ]);
        DB::table('questions')
            ->where('id', $trueFalse)
            ->update(['ref' => $trueFalse]);
        // insert answer
        DB::table('standard_true_false')->insert([
            [
                'id' => $trueFalse,
                'answer' => 'true',
            ]
        ]);
        $trueFalse = DB::table('questions')->insertGetId([
            'exam' => $exam2->id,
            'type' => 0,
            'description' => 'PHP 是世界上最好的语言！！',
            'score' => 20,
            'source' => 0,
            'ref' => 0,
        ]);
        DB::table('questions')
            ->where('id', $trueFalse)
            ->update(['ref' => $trueFalse]);
        // insert answer
        DB::table('standard_true_false')->insert([
            [
                'id' => $trueFalse,
                'answer' => 'true',
            ]
        ]);
        // multi-choice questions
        $multiChoice = DB::table('questions')->insertGetId([
            'exam' => $exam2->id,
            'type' => 1,
            'description' => '选出下列选项中的关系型数据库。',
            'score' => 10,
            'source' => 0,
            'ref' => 0,
        ]);
        DB::table('questions')
            ->where('id', $multiChoice)
            ->update(['ref' => $multiChoice]);
        DB::table('question_multi_choice')->insert([
            [
                'id' => $multiChoice,
                'order' => 0,
                'option' => 'MySQL',
            ], [
                'id' => $multiChoice,
                'order' => 1,
                'option' => 'MongoDB',
            ], [
                'id' => $multiChoice,
                'order' => 2,
                'option' => 'PostgreSQL',
            ], [
                'id' => $multiChoice,
                'order' => 3,
                'option' => 'Redis',
            ]
        ]);
        // insert answer
        DB::table('standard_multi_choice')->insert([
            [
                'id' => $multiChoice,
                'answer' => 5,
            ]
        ]);
        $multiChoice = DB::table('questions')->insertGetId([
            'exam' => $exam2->id,
            'type' => 1,
            'description' => '下面哪些选项是 C 语言中的基本数据类型。',
            'score' => 10,
            'source' => 0,
            'ref' => 0,
        ]);
        DB::table('questions')
            ->where('id', $multiChoice)
            ->update(['ref' => $multiChoice]);
        DB::table('question_multi_choice')->insert([
            [
                'id' => $multiChoice,
                'order' => 0,
                'option' => 'int',
            ], [
                'id' => $multiChoice,
                'order' => 1,
                'option' => 'char',
            ], [
                'id' => $multiChoice,
                'order' => 2,
                'option' => 'stack',
            ], [
                'id' => $multiChoice,
                'order' => 3,
                'option' => 'boolean',
            ]
        ]);
        // insert answer
        DB::table('standard_multi_choice')->insert([
            [
                'id' => $multiChoice,
                'answer' => 3,
            ]
        ]);
        // blank-fill questions
        $blankFill = DB::table('questions')->insertGetId([
            'exam' => $exam2->id,
            'type' => 2,
            'description' => '@@ 是 Google 开源的一款 Web 前端 MVVC 框架，目前的最新版本为 @@。',
            'score' => 10,
            'source' => 0,
            'ref' => 0,
        ]);
        DB::table('questions')
            ->where('id', $blankFill)
            ->update(['ref' => $blankFill]);
        DB::table('standard_blank_fill')->insert([
            [
                'id' => $blankFill,
                'order' => 0,
                'answer' => 'Angular',
            ], [
                'id' => $blankFill,
                'order' => 1,
                'answer' => '2|Angular 2',
            ],
        ]);
        // short-answer questions
        DB::table('questions')->insert([
            [
                'exam' => $exam2->id,
                'type' => 3,
                'description' => '请简述什么是软件。',
                'score' => 20,
                'source' => 0,
                'ref' => 0,
            ]
        ]);
        // general questions
        DB::table('questions')->insert([
            [
                'exam' => $exam2->id,
                'type' => 4,
                'description' => '使用你最擅长的语言设计一个[布隆过滤器](https://en.wikipedia.org/wiki/Bloom_filter)。',
                'score' => 50,
                'source' => 0,
                'ref' => 0,
            ]
        ]);
    }
}
