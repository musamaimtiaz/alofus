<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Soumik Datta <soumik.techvill@gmail.com>
 *
 * @created 17-09-2022
 */

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class ActivityLogService
{
    protected $request = null;

    /**
     * Log Name
     *
     * @var string|null
     */
    protected $logName = null;

    /**
     * Log Description
     *
     * @var string
     */
    protected $description = 'Not Provided';

    /**
     * Causer Model
     *
     * @var Model|null
     */
    protected $causerModel = null;

    /**
     * Subject Model
     *
     * @var Model|null
     */
    protected $subjectModel = null;

    /**
     * Properties data to store in the log
     *
     * @param  array|null  $properties
     */
    protected $properties = null;

    /**
     * Define constructor
     */
    public function __construct()
    {
        $this->request = Request::instance();
    }

    /**
     * Log login activities
     *
     * @return void
     */
    public function userLogin(?string $status = null, ?string $message = null)
    {
        $causerTypeArray = ['Incorrect', 'Deleted', 'Pending', 'Inactive'];
        $this->logName = 'USER LOGIN';
        $this->properties['status'] = $status;
        $this->setRequestProperties();

        if (in_array($message, $causerTypeArray)) {
            $this->causerModel = User::where('email', $this->request->email)->first();
            $this->description = $message . ' user';
        } else {
            $this->description = $message;
        }

        $this->storeActivity();
    }

    /**
     * Log logout activities
     *
     * @return void
     */
    public function userLogout(?string $status, ?string $message, User $causerModel)
    {
        $this->logName = 'USER LOGOUT';
        $this->properties['status'] = $status;
        $this->setRequestProperties();
        $this->description = $message;
        $this->causerModel = $causerModel;

        $this->storeActivity();
    }

    /**
     * Set url, method, ip address and user agent as properties
     *
     * @return void
     */
    public function setRequestProperties()
    {
        $this->properties['url'] = Request::fullUrl();
        $this->properties['method'] = Request::method();
        $this->properties['ip_address'] = Request::ip();
        $this->properties['user_agent'] = Request::header('user-agent');

        $UAP = new UserAgentParserService();
        $parsedUA = $UAP->parse($this->properties['user_agent']);

        $this->properties['browser'] = $parsedUA['browser'];
        $this->properties['browser_version'] = $parsedUA['version'];
        $this->properties['platform'] = $parsedUA['platform'];
    }

    /**
     * Store activity using package helper function
     *
     * @return void
     */
    public function storeActivity()
    {
        $activity = activity($this->logName);

        if ($this->properties != null) {
            $activity->withProperties($this->properties);
        }
        if ($this->causerModel != null) {
            $activity->causedBy($this->causerModel);
        }
        if ($this->subjectModel != null) {
            $activity->performedOn($this->subjectModel);
        }

        $activity->log($this->description);                 //finally saves the activity
    }
}
