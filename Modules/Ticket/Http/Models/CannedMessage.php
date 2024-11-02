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

class CannedMessage extends Model
{
    /**
     * @return CannedMessage[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getAll()
    {
        return parent::all();
    }

    /**
     * @param  array  $data
     * @return mixed
     */
    protected function messageValidation($data = [])
    {
        $validator = Validator::make($data, [
            'title'   => 'required|max:150',
            'message' => 'required',
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
    public function updateMessage($id, $data = [])
    {
        $cannedMsg = parent::where('id', $id);
        if ($cannedMsg->exists()) {
            $cannedMsg->update($data);

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
        $cannedMsg = parent::where('id', $id);
        if ($cannedMsg->exists()) {
            $cannedMsg->delete();

            return true;
        }

        return false;
    }

    public function search($request)
    {
        $data              = [];
        $data['status_no'] = 0;
        $data['message']   = __('No Canned Message Found');
        $data['canned']    = [];
        $title             = $request;
        $return_arr        = [];
        $cannedMsg         = CannedMessage::where('title', 'LIKE', '%' . $title . '%')->take(10)->get();
        if (! $cannedMsg->isEmpty()) {
            $data['status_no'] = 1;
            $data['message']   = __('Canned Message Found');
            $i                 = 0;
            foreach ($cannedMsg as $key => $value) {
                $return_arr[$i]['id']          = $value->id;
                $return_arr[$i]['data']        = $value->message;
                $return_arr[$i]['filter_data'] = strlen($value->title) < 50 ? strip_tags($value->title) : substr(strip_tags($value->title), 0, 50) . '...';
                $i++;
            }
            $data['canned'] = $return_arr;
        }
        echo json_encode($data);
        exit;
    }
}
