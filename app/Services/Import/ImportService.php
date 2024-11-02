<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Md Abdur Rahaman Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 19-11-2022
 */

namespace App\Services\Import;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

abstract class ImportService
{
    protected $request;

    protected $response;

    protected $error;

    protected $path;

    protected $fieldMap = [];

    protected $fillables = [];

    protected $headers;

    protected $batchLimit = 10;

    protected $formats = 'csv';

    public function __construct(Request $request)
    {
        $this->request = $request;
        ini_set('max_execution_time', 600);
    }

    /**
     * Stats processing
     */
    public function process()
    {
        if (! $this->request->has('step')) {
            $this->setError('Step is not defined.');

            return false;
        }

        $method = 'importerStep' . $this->request->step;

        if (! method_exists($this, $method)) {
            $this->setError('Invalid step access.');

            return false;
        }

        return $this->$method();
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
     * Get error message
     *
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Add the file path
     *
     * @param  string  $path
     * @return self
     */
    public function addFilePath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get the file path
     *
     * @return string|null
     */
    public function getFilePath()
    {
        return $this->path ?? null;
    }

    /**
     * Get delimeter
     *
     * @return string|null
     */
    public function getDelimiter()
    {
        return $this->getSession('delimeter');
    }

    /**
     * Set delimeter in session
     *
     * @param  string  $delimeter
     * @return void
     */
    public function setDelimeter($delimeter)
    {
        $this->setSession('delimeter', $delimeter);
    }

    /**
     * Checks if the file has been loaded
     *
     * @return bool
     */
    public function isFileLoaded()
    {
        return ! is_null($this->getFilePath())
            && file_exists($this->getFilePath());
    }

    /**
     * Provided the data/column header
     *
     * @return array
     */
    public function getDataHeaders()
    {
        if (! $this->isFileLoaded()) {
            return [];
        }

        if ($this->headers) {
            return $this->headers;
        }

        $data = $this->readFile(1);

        return $data[0] ?? [];
    }

    /**
     * Stores file in system
     *
     * @return self|false
     */
    public function loadFile($fileInputName = 'csv')
    {
        if ($this->isFileLoaded()) {
            return $this;
        }

        $validator = Validator::make($this->request->all(), [
            $fileInputName => 'required|mimes:txt,' . $this->formats,
            'delimeter' => 'max:1',
        ]);

        if ($validator->errors()->has('delimeter')) {
            $this->setError(__('The delimeter must be a single character.'));

            return false;
        }

        if ($validator->fails() || $this->formats != $this->request->csv->getClientOriginalExtension()) {
            $this->setError(__('Attachment required with file type :x.', ['x' => $this->formats]));

            return false;
        }

        $file = $this->request->file($fileInputName);

        $name = $file->store('imports', ['disk' => 'public-folder']);

        $path = public_path('uploads' . DIRECTORY_SEPARATOR . $name);

        $this->setDelimeter($this->request->delimeter ?? ',');

        $this->addFilePath($path);

        return $this;
    }

    /**
     * Load file from session
     *
     * @param  string  $fileInputName
     * @return bool|self
     */
    public function loadSessionFile($fileInputName)
    {
        $file = $this->getSession($fileInputName);

        if (! $file) {
            $this->setError('File not found.');

            return false;
        }

        $this->addFilePath($file);

        return $this;
    }

    /**
     * Check if the request contains specific file
     *
     * @param  string  $name  File input name
     * @return bool
     */
    public function requestHasFIle($name)
    {
        return $this->request->hasFile($name);
    }

    public function readFile($line = -1, $offset = 0)
    {

        if (! $this->isFileLoaded()) {
            return false;
        }

        $file = $this->getFilePath();

        $data = [];

        $this->fileHandler = fopen($file, 'r');

        while ($offset-- > 0) {
            fgetcsv($this->fileHandler, 0, $this->getDelimiter());
        }

        $index = 0;

        while (! feof($this->fileHandler)) {

            $streamArray = fgetcsv($this->fileHandler, 0, $this->getDelimiter());

            if (! is_array($streamArray) == 0 && count($streamArray) == 0 || $streamArray == false) {
                continue;
            }

            $data[] = $streamArray;

            if ($line != -1 && ++$index == $line) {
                break;
            }
        }

        fclose($this->fileHandler);

        return $data;
    }

    /**
     * Returns file body rows
     *
     * @return array
     */
    public function getDataBody()
    {
        return $this->readFile(-1, 1);
    }

    /**
     * Set session value
     *
     * @param  string|array  $name
     * @param mixed
     * @return void
     */
    protected function setSession($name, $value)
    {
        if (is_array($name)) {
            session($name);
        }
        session([$name => $value]);
    }

    /**
     * Forget request session value
     *
     * @param  string  $name
     * @return void
     */
    protected function forgetSession($name)
    {
        $this->request->session()->forget($name);
    }

    /**
     * Get data from session
     *
     * @param  string  $name
     * @return mixed
     */
    protected function getSession($name)
    {
        return $this->request->session()->get($name);
    }

    /**
     * Get file name to session
     *
     * @param  string  $type  Type of the item which is being imported
     * @return void
     */
    protected function getFileFromSession($type = 'product')
    {
        return $this->getSession($type . '-file');
    }

    /**
     * Set file name to session
     *
     * @param  string  $file  File name with full path
     * @param  string  $type  Type of the item which is being imported
     * @return void
     */
    protected function setFileToSession($file, $type = 'product')
    {
        $this->setSession($type . '-file', $file);
    }

    protected function readFirstColumn()
    {
        $exampleData = $this->readFile(2);

        array_shift($exampleData);

        if (empty($exampleData)) {
            $this->setError(__('Your CSV file is empty.'));

            return false;
        }

        return $exampleData[0];
    }

    public function getBatchLimit()
    {
        return $this->batchLimit;
    }

    public function setBatchLimit($limit)
    {
        $this->batchLimit = $limit;
    }

    /**
     * Return map columns with data source file header index
     *
     * @return array|bool
     */
    protected function getColumns()
    {
        $mappings = $this->mergeColumns($this->request->get('to'), $this->request->get('from'));

        if (is_null($mappings) || is_array($mappings) && count($mappings) == 0) {
            $this->setError('Invalid column mapping.');

            return false;
        }

        return $mappings;
    }

    protected function mergeColumns($toArray, $fromArray)
    {
        $array = [];
        $index = 0;
        array_map(function ($from, $to) use (&$array, &$index) {
            if (! is_null($from)) {
                $array[$from] = $index;
            }
            $index++;
        }, $toArray, $fromArray);

        return $array;
    }

    /**
     * Imports the data
     *
     * @param  array  $columns
     * @param  string  $callback
     * @return void
     */
    protected function processImportableData($columns, $callback)
    {
        $reader = new ReaderGenerator($this->getFilePath());

        $bodyData = [];

        $counter = 0;
        $parentProduct = 0;

        $userType = auth()->user()->role()->type;

        if (isActive('Subscription') && $userType == 'vendor') {
            $subscription = subscription('getUserSubscription');

            if (! $subscription) {
                return $this->$callback($bodyData);
            }

            $limit = subscription('featureLimitRemaining', $subscription->id, 'product');
        }

        foreach ($reader->getRow($this->getDelimiter()) as $key => $row) {
            if ($key == 0) {
                continue;
            }

            $formattedData = $this->assignDataToColumns($columns, $row);

            if ($formattedData) {
                $bodyData[] = $formattedData;
                $counter++;

                if ($formattedData['parent_id'] == '') {
                    $parentProduct++;
                }
            }

            if ($userType == 'vendor' && $parentProduct == $limit) {
                break;
            }

            if ($counter == $this->getBatchLimit()) {
                $this->$callback($bodyData);
                unset($bodyData);
                $bodyData = [];
                $counter = 0;
            }
        }

        $this->$callback($bodyData);
    }

    /**
     * Process fetched to into column => data associative array
     *
     * @param  array  $columns  [] Default
     * @param  array  $rowData
     * @return array|bool
     */
    protected function assignDataToColumns($columns, $rowData)
    {
        if (! is_array($rowData)) {
            return false;
        }

        foreach ($columns as $name => $index) {
            $columns[$name] = $rowData[$index] ?? null;
        }

        return $columns;
    }

    /**
     * Apply all the filters available for the importer class
     *
     * @param  array  $data  Array of item data
     * @param  string  $initiator  Callback function for preparing the initial data
     * @param  string  $destination  Last callback to be executed after all the filter methods
     * @return array
     */
    protected function applyFilters($data, $initiator = null, $destination = null)
    {
        $methods = get_class_methods($this);

        $filterMethods = array_filter($methods, function ($method) {
            return str_starts_with($method, 'filter');
        });

        if ($destination) {
            array_push($filterMethods, $destination);
        }

        $response = array_map(function ($row) use ($filterMethods, $initiator) {
            return array_reduce($filterMethods, $this->tunnelFilter(), $initiator ? $this->$initiator($row) : $row);
        }, $data);

        return $response;
    }

    /**
     * Tunnel through given callbacks
     *
     * @return Closure
     */
    protected function tunnelFilter()
    {
        return function ($data, $callback) {
            return $this->$callback($data);
        };
    }
}
