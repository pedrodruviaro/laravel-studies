<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            [
                'user_id'  => 1,
                'title'    => 'Post 1 (admin)',
                'content'  => 'Content of post 1',
                'created_at' => Carbon::now()
            ],
            [
                'user_id'  => 1,
                'title'    => 'Post 2 (admin)',
                'content'  => 'Content of post 2',
                'created_at' => Carbon::now()
            ],
            [
                'user_id'  => 1,
                'title'    => 'Post 3 (admin)',
                'content'  => 'Content of post 3',
                'created_at' => Carbon::now()
            ],
            [
                'user_id'  => 2,
                'title'    => 'Post 3',
                'content'  => 'Content of post 3',
                'created_at' => Carbon::now()
            ],
            [
                'user_id'  => 2,
                'title'    => 'Post 4',
                'content'  => 'Content of post 4',
                'created_at' => Carbon::now()
            ],
        ];

        DB::table('posts')->insert($posts);
    }
}
