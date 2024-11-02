<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 17-08-2021
 */

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request = [])
    {
        $pictureURL  = url('public/dist/img/default-image.png');
        $pictureName = 'default-image.png';
        if (isset($this->avatarFile->file_name) && ! empty($this->avatarFile->file_name) && file_exists('public/uploads/vendor/' . $this->avatarFile->file_name)) {
            $pictureURL  = url('public/uploads/vendor/' . $this->avatarFile->file_name);
            $pictureName = $this->avatarFile->file_name;
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'formal_name' => $this->formal_name,
            'status' => $this->status,
            'website' => $this->website,
            'created_at' => $this->format_created_at,
            'picture_name' => $pictureName,
            'picture_url' => $pictureURL,
        ];
    }
}
