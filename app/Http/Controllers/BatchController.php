<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 29-12-2022
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BatchController extends Controller
{
    /**
     * Response
     *
     * @var array
     */
    protected $response = [
        'status' => 'failed',
        'message' => 'Something went wrong, please try again.',
    ];

    /**
     * Delete batch data
     *
     * @return array $response
     */
    public function destroy(Request $request)
    {
        if (config('martvill.is_demo')) {
            $this->response['message'] = __('This is a demo version. You can\'t delete anything.');

            return $this->getResponse();
        }

        if (! $this->isValid($request)) {
            return $this->getResponse();
        }

        try {

            do_action('before_batch_delete');

            $model = new $request->namespace();
            $model->whereIn($request->column, $request->records)->delete();

            $model->forgetCache();

            do_action('after_batch_delete');

            $this->response['status'] = 'success';
            $this->response['message'] = __('Batch :x has been successfully deleted.', ['x' => $this->getModelName($request->namespace)]);

            return $this->getResponse();
        } catch (\Exception $e) {
            $this->response['message'] = $e->getMessage();

            return $this->getResponse();
        }
    }

    /**
     * Get response
     *
     * @return array
     */
    protected function getResponse()
    {
        return apply_filters('batch_delete_response', $this->response);
    }

    /**
     * Check validity
     *
     * @param  Request  $request
     * @return bool
     */
    private function isValid($request)
    {
        $validate = ! Validator::make($request->all(), [
            'records' => 'required',
            'namespace' => 'required',
            'column' => 'required',
        ])->fails();

        return $validate && class_exists($request->namespace);
    }

    /**
     * Get model name
     *
     * @param  string  $namespace
     * @return string
     */
    private function getModelName($namespace)
    {
        $modelName = explode('\\', $namespace);

        return end($modelName);
    }
}
