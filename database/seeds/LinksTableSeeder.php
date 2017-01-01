<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'link_title' => '百度度',
                'link_url' => 'http:www.baidu.com',
                'link_desc' => '这就是百度',
                'link_order' => 3
            ],
            [
                'link_title' => 'laravel',
                'link_url' => 'https://laravel.com',
                'link_desc' => 'laravel',
                'link_order' => 1
            ],
            [
                'link_title' => 'yii2',
                'link_url' => 'http://www.yiichina.com/m',
                'link_desc' => 'yii2',
                'link_order' => 2
            ],
        ];
        DB::table('links')->insert($data);
    }
}
