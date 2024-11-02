<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 26-01-2023
 */

namespace App\Services\Export;

use Illuminate\Http\Request;

abstract class ExportService
{
    protected $response;

    private $extension = '.csv';

    protected $request;

    protected $csvColumn = [];

    protected $csvData = [];

    /***
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        ini_set('max_execution_time', 600);
    }

    /**
     * load csv file
     */
    public function loadCsv($file = 'file'): array
    {
        $fileName = $file . $this->extension;

        $headers = [
            'Content-type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $columns = $this->csvColumn;
        $data = collect($this->getResource());

        $callback = function () use ($data, $columns) {
            $file = fopen('php://output', 'w');
            fwrite($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($file, $columns);

            foreach ($data as $values) {
                foreach ($columns as $column) {
                    $row[$column]  = $values[$column] ?? null;
                }

                fputcsv($file, $row);
            }

            fclose($file);
        };

        return ['callback' => $callback, 'headers' => $headers];
    }

    /**
     * export process
     *
     * @return false
     */
    public function process()
    {
        return $this->exportSteps();
    }

    /**
     * Set error message
     *
     * @param  string  $message
     * @param  bool  $translated  false
     * @return void
     */
    public function setError($message, $translated = false)
    {
        if (! $translated) {
            $message = __($message);
        }
        $this->error = $message;
    }

    /**
     * get error
     *
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|string|null
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Set response data
     *
     * @param  mixed  $response
     * @return void
     */
    protected function setResponse($response)
    {
        $this->response = $response;
    }

    /**
     * Returns processed step output
     *
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * set resource
     *
     * @return void
     */
    public function setResource($data)
    {
        $this->csvData = $data;
    }

    /**
     * get resource
     *
     * @return array|mixed
     */
    public function getResource()
    {
        return $this->csvData;
    }
}
