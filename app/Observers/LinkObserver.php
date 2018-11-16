<?php
/**
 * Created by PhpStorm.
 * User: whhong
 * Date: 2018/11/16
 * Time: 17:26
 */
namespace App\Observers;
use App\Models\Link;
use Cache;

class LinkObserver
{
    public function saved(Link $link)
    {
        Cache::forget($link->cache_key);
    }
}