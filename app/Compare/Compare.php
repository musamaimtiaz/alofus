<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 11-01-2022
 */

namespace App\Compare;

use Cache;
use Auth;

class Compare
{
    /**
     * add compare data
     *
     * @return bool|void
     */
    public static function add($productId)
    {
        $compare = self::getCompareData();

        if (! $compare) {
            $compare[] = $productId;
            self::save($compare);

            return true;
        } elseif (! in_array($productId, $compare)) {
            $compare[] = $productId;
            self::save($compare);

            return true;
        }
    }

    /**
     * save compare data
     *
     * @return void
     */
    public static function save($compare)
    {
        if (! empty(self::userId())) {
            Cache::put(config('cache.prefix') . '.compare.' . self::userId(), $compare, 30 * 86400);
        } else {
            Cache::put(config('cache.prefix') . '.compare.' . getUniqueAddress(), $compare, 30 * 86400);
        }
    }

    /**
     * getCompare data
     *
     * @return mixed
     */
    public static function getCompareData()
    {
        return ! empty(self::userId()) ? Cache::get(config('cache.prefix') . '.compare.' . self::userId()) : Cache::get(config('cache.prefix') . '.compare.' . getUniqueAddress());
    }

    /**
     * compare data in collection method
     *
     * @return CompareCollection
     */
    public static function compareCollection($userId = null)
    {
        if ($userId != null && $userId != 0) {
            return new CompareCollection(Cache::get(config('cache.prefix') . '.compare.' . $userId));
        }

        return ! empty(self::userId()) ? new CompareCollection(Cache::get(config('cache.prefix') . '.compare.' . self::userId())) : new CompareCollection(Cache::get(config('cache.prefix') . '.compare.' . getUniqueAddress()));
    }

    /**
     * total CompareData
     *
     * @return int
     */
    public static function totalProduct()
    {
        $compare = self::compareCollection();

        return $compare->count();
    }

    /**
     * compare data destroy
     *
     * @return bool
     */
    public static function destroy($id, $action = 'single')
    {
        if ($action == 'single') {
            $compare = self::getCompareData();
            $index = array_search($id, $compare);
            unset($compare[$index]);
            self::save($compare);
        } else {
            ! empty(self::userId()) ? Cache::forget(config('cache.prefix') . '.compare.' . self::userId()) : Cache::forget(config('cache.prefix') . '.compare.' . getUniqueAddress());
        }

        return true;
    }

    /**
     * compare data transfer local to user
     *
     * @return void
     */
    public static function compareDataTransfer()
    {
        if (! empty(self::userId()) && empty(Cache::get(config('cache.prefix') . '.compare.' . self::userId()))) {

            if (! empty(Cache::get(config('cache.prefix') . '.compare.' . getUniqueAddress()))) {
                Cache::put(config('cache.prefix') . '.compare.' . self::userId(), Cache::get(config('cache.prefix') . '.compare.' . getUniqueAddress()), 30 * 86400);
            }

        } elseif (! empty(self::userId()) && ! empty(Cache::get(config('cache.prefix') . '.compare.' . self::userId())) && ! empty(Cache::get(config('cache.prefix') . '.compare.' . getUniqueAddress()))) {
            $userCompareList = Cache::get(config('cache.prefix') . '.compare.' . self::userId());

            foreach (Cache::get(config('cache.prefix') . '.compare.' . getUniqueAddress()) as $local) {
                if (! in_array($local, $userCompareList)) {
                    self::add($local);
                }
            }

            Cache::forget(config('cache.prefix') . '.compare.' . getUniqueAddress());
            Cache::put(config('cache.prefix') . '.compare.' . getUniqueAddress(), Cache::get(config('cache.prefix') . '.compare.' . self::userId()), 30 * 86400);
        }
    }

    /**
     * get user id
     *
     * @return null| int $userId
     */
    public static function userId()
    {
        $userId = null;

        if (isset(Auth::user()->id)) {
            $userId = Auth::user()->id;
        } elseif (isset(auth()->guard('api')->user()->id)) {
            $userId = auth()->guard('api')->user()->id;
        }

        return $userId;
    }
}
