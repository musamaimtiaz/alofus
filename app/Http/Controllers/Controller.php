<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sabbir Al-Razi <[sabbir.techvill@gmail.com]>
 *
 * @created 20-05-2021
 */

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use DB;
use Session;
use App\Traits\ApiResponse;

class Controller extends BaseController
{
    use ApiResponse;
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public const STATUSES = ['active' => 1, 'inactive' => 0];

    public const CHECK_YES_NO = ['yes' => 1, 'no' => 0];

    protected const ITEM_TYPE = ['product' => 'product', 'service' => 'service'];

    protected const ROWS_PER_PAGE = 20;

    protected const MAX_PER_PAGE = 100;

    /**
     * Pagination
     *
     * @param  array  $options
     * @param  array  $request
     * @return array
     */
    protected function initialize($options = [], $request = null)
    {
        if (! isset($request['rows_per_page']) || empty($request['rows_per_page']) || ! preg_match('/^[1-9]+[0-9]*$/', $request['rows_per_page'])) {
            $options['rows_per_page'] = self::ROWS_PER_PAGE;
        } else {
            $options['rows_per_page'] = $request['rows_per_page'];
        }
        $max = isset($options['max_per_page']) && ! empty($options['max_per_page']) ? $options['max_per_page'] : self::MAX_PER_PAGE;
        $options['rows_per_page'] = $options['rows_per_page'] > $max ? $max : $options['rows_per_page'];

        return $options;
    }

    /**
     * Get All Status Code Texts
     *
     * @param  int  $code
     * @return string
     */
    public function getStatus($code = 444)
    {
        $messages =  [
            200 => __('Ok'),
            400 => __('Bad Request'),
            401 => __('Unauthorized'),
            403 => __('Forbidden'),
            404 => __('Not Found'),
            405 => __('Method Not Allowed'),
            408 => __('Request Timeout'),
            416 => __('Requested Range Not Satisfiable'),
            444 => __('No Response'),
            500 => __('Internal Server Error'),
            503 => __('Be right back'),
        ];
        if (! array_key_exists($code, $messages)) {
            $code = 444;
        }

        return ['code' => $code, 'text' => $messages[$code]];
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray($data = [])
    {
        if (! empty($data)) {
            $array = $data->toArray();

            return [
                'total' => $array['total'],
                'rows_per_page' => $array['per_page'],
                'next_page_url' => $array['next_page_url'],
                'current_page' => $array['current_page'],
                'prev_page_url' => $array['prev_page_url'],
            ];
        }
    }

    /**
     * Check data is exist or not
     *
     * @param  string  $value
     * @param  string  $tableName
     * @param  array  $options
     * @return array
     */
    public function checkExistence($value, $tableName, $options = [])
    {
        $name = $options['columnName'] ?? str_replace('_', ' ', $tableName);
        $options = array_merge(['columnName' => 'id', 'getData' => false], $options);
        $data = ['status' => false, 'code' => 400, 'message' => __(':x does not exist.', ['x' => ucfirst($name)])];

        if (! empty($tableName) && ! empty($value)) {
            $detail = DB::table($tableName)->where($options['columnName'], $value);
            if ($detail->count() > 0) {
                $data['code'] = 200;
                $data['status'] = true;
                $data['message'] = null;
                $data['data'] = ! empty($options['getData']) ? $detail->first() : [];
            } else {
                $data['code'] = 404;
            }
        } elseif ($value == 0) {
            $data['code'] = 404;
        }

        return $data;
    }

    /**
     * @param  $message
     */
    public function setSessionValue($data = [])
    {
        Session::flash($data['status'], $data['message']);
    }

    /**
     * @param  null  $message
     * @return array
     */
    public function messageArray($message = null, $status = null)
    {
        return [
            'status'  => $status,
            'message' => $message,
        ];
    }

    /**
     * Execute an action on the controller.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function callAction($method, $parameters)
    {
        $fullNamespace = get_class($this);
        $filterTag = "{$fullNamespace}@{$method}";

        $filteredResult = apply_filters($filterTag, $method, $parameters);

        if ($filteredResult !== $method) {
            return $filteredResult;
        }

        return parent::callAction($method, $parameters);
    }
}
