<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 12-10-2021
 */

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Validator;
use Response;

class FilesController extends Controller
{
    /**
     * upload event attachments
     *
     * @param  bool  $save
     * @return json string
     **/
    public function uploadEventAttachments(Request $request, $save = false)
    {
        if (! empty($_FILES['attachment'])) {
            $uploaderId = $request->uploader_id;
            $tempDirectory = 'public/contents/temp';
            if (! file_exists($tempDirectory)) {
                mkdir($tempDirectory, config('app.filePermission'), true);
            }
            $files = $request->attachment;
            if ($_FILES['attachment']['error'] != 0 || ! is_uploaded_file($_FILES['attachment']['tmp_name'])) {
                $this->_returnJSON(false, __('Error in uploading file. Please try again.'));
            }

            $maxFileSize = maxFileSize($_FILES['attachment']['size']);
            if (isset($maxFileSize['status']) && $maxFileSize['status'] == 0) {
                $this->_returnJSON(false, $maxFileSize['message']);
            }

            $validator = Validator::make($request->all(), []);

            $validator->after(function ($validator) use ($request) {
                $files  = $request->file('attachment');
                if (empty($files)) {
                    return true;
                }

                if (checkFileValidation($files->getClientOriginalExtension(), 3) == false) {
                    $validator->errors()->add('upload_File', __('Allowed File Extensions: jpg, jpeg, png'));
                }
            });

            if ($validator->fails()) {
                $this->_returnJSON(false, __('Invalid file type'));
            }

            $attachment = md5(time()) . '_' . $uploaderId . '_' . $_FILES['attachment']['name'];
            $attachment = str_replace(['/', ' '], '_', $attachment);
            $attachmentPath = $tempDirectory . '/' . $attachment;
            if (move_uploaded_file($_FILES['attachment']['tmp_name'], $attachmentPath)) {
                $this->_returnJSON(true, ['message' => __('Uploaded successfully'), 'attachment' => $attachment, 'attachment_type' => getFileIcon($_FILES['attachment']['name']), 'attachment_path' => $attachmentPath, 'attachment_name' => $_FILES['attachment']['name']]);
            }
        }
        $this->_returnJSON(false, __('Error in uploading file. Please try again.'));
    }

    /**
     * delete attachment
     *
     * @return mixed
     */
    public function deleteEventAttachment(Request $request)
    {
        $request->filePath = isset($request->filePath) && ! empty($request->filePath) ? $request->filePath : $request->attachment;
        if ($request->id != 0) {
            if (isset($request->thumbnail) && ! empty($request->thumbnail)) {
                (new File())->unlinkFile($request->thumbnail);
            }

            return (new File())->deleteFiles(null, null, ['ids' => [$request->id]], $request->filePath);
        } else {
            return (new File())->unlinkFile($request->filePath);
        }
    }

    /**
     * @return false|string
     */
    public function isValidFileSize()
    {
        $maxFileSize = maxFileSize($_GET['filesize']);
        if (isset($maxFileSize['status']) && $maxFileSize['status'] == 0) {
            return json_encode($maxFileSize['message']);
        }

        return json_encode(true);
    }

    /**
     * Return JSON Encoded output for ajax call
     *
     * @param  bool  $result
     * @param  mixed  $data
     * @param  bool  $return  if set the json encoded string will be returned
     * @return string
     */
    protected function _returnJSON($result, $data = null, $options = [])
    {
        $options = array_merge(['return' => false, 'render' => false, 'layout' => false], $options);
        if (is_string($data)) {
            $data = ['errorMessage' => $data];
        }
        // render the current action and add to html data key
        if (! empty($options['render'])) {
            if (! empty($options['layout'])) {
                $this->layout = $options['layout'];
            }
            if (empty($options['view'])) {
                $options['view'] = $this->action;
            }
            $data['html'] = $this->render($options['view']);
            if (is_object($data['html'])) {
                if (($options['layout'] == 'paginated-html')) {
                    $data['html'] = json_decode($data['html']->body(), true);
                } else {
                    $data['html'] = $data['html']->body();
                }
            }
        }
        if (! empty($options['sqlLogs'])) {
            $data['_sqlLogs'] = $options['sqlLogs'];
        }
        if ($result !== false) {
            if (! empty($options['return'])) {
                return json_encode(['result' => true, 'serverTime' => date('Y-m-d H:i:s'), 'data' => $data]);
            } else {
                if (! empty($options['jsonResponse'])) {
                    // send josn response without exiting the code
                    $this->autoRender = false;
                    $this->response->body(json_encode(['result' => true, 'serverTime' => date('Y-m-d H:i:s'), 'data' => $data]));

                    return $this->response;
                } else {
                    // @deprecated, should be removed in the future, this is currently default way
                    echo json_encode(['result' => true, 'serverTime' => date('Y-m-d H:i:s'), 'data' => $data]);
                    exit;
                }
            }
        } else {
            $errorMessage = false;
            if (! empty($data['errorMessage'])) {
                $errorMessage = $data['errorMessage'];
            }
            if (! empty($options['return'])) {
                return json_encode(['result' => false, 'serverTime' => date('Y-m-d H:i:s'), 'errorMessage' => $errorMessage, 'data' => $data]);
            } else {
                if (! empty($options['jsonResponse'])) {
                    // send josn response without exiting the code
                    $this->autoRender = false;
                    $this->response->body(json_encode(['result' => false, 'serverTime' => date('Y-m-d H:i:s'), 'errorMessage' => $errorMessage, 'data' => $data]));

                    return $this->response;
                } else {
                    // @deprecated, should be removed in the future, this is currently default way
                    echo json_encode(['result' => false, 'serverTime' => date('Y-m-d H:i:s'), 'errorMessage' => $errorMessage, 'data' => $data]);
                    exit;
                }
            }
        }
    }

    public function downloadAttachment($id)
    {
        return (new File())->downloadAttachment($id);

    }
}
