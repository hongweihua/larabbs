<?php

use Illuminate\Database\Seeder;
use App\Models\Link;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 生成数据集合
        $links = factory(Link::class)->times(6)->make();

        // 将数据集合转为数组并插入到数据库
        (new Link())->insert($links->toArray());
    }
}