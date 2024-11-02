<?php
/**
 * @author tehcvillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 17-06-2021
 */

namespace Modules\Ticket\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Validator;

class CannedLink extends Model
{
    /**
     * @return CannedLink[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getAll()
    {
        return parent::all();
    }

    /**
     * @param  array  $data
     * @return mixed
     */
    protected function linkaVlidation($data = [])
    {
        $validator = Validator::make($data, [
            'title'   => 'required|max:150',
            'link' => 'required|max:255',
        ]);

        return $validator;
    }

    /**
     * @param  array  $data
     * @return null
     */
    public function store($data = [])
    {
        $id = parent::insertGetId($data) ?? null;
        if (! empty($id)) {
            return true;
        }

        return false;
    }

    /**
     * @param  array  $data
     * @return bool
     */
    public function updateLink($id, $data = [])
    {
        $cannedLink = parent::where('id', $id);
        if ($cannedLink->exists()) {
            $cannedLink->update($data);

            return true;
        }

        return false;
    }

    /**
     * @param  array  $data
     * @return bool|null
     */
    public function remove($id)
    {
        $cannedLink = parent::where('id', $id);
        if ($cannedLink->exists()) {
            $cannedLink->delete();

            return true;
        }

        return false;
    }

    public function search($request)
    {
        $data              = [];
        $data['status_no'] = 0;
        $data['message']   = __('No Canned Link Found');
        $data['canned']    = [];
        $title             = $request;
        $return_arr        = [];
        $cannedLink         = CannedLink::where('title', 'LIKE', '%' . $title . '%')->take(10)->get();
        if (! $cannedLink->isEmpty()) {
            $data['status_no'] = 1;
            $data['message']   = __('Canned Link Found');
            $i                 = 0;
            foreach ($cannedLink as $key => $value) {
                $return_arr[$i]['id']          = $value->id;
                $return_arr[$i]['data']        = strip_tags($value->link);
                $return_arr[$i]['filter_data'] = strlen($value->title) < 41 ? strip_tags($value->title) : substr(strip_tags($value->title), 0, 40) . '...';
                $i++;
            }
            $data['canned'] = $return_arr;
        }
        echo json_encode($data);
        exit;
    }
}
