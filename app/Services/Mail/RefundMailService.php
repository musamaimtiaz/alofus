<?php

namespace App\Services\Mail;

use Modules\Refund\Entities\Refund;
use App\Models\{
    User, Vendor, Preference, Currency
};

class RefundMailService extends TechVillageMail
{
    /**
     * Send mail to user
     *
     * @param  object  $request
     * @return array $response
     */
    public function send($request)
    {
        $refundStatus = ['In progress' => 'in-progress-refund-request', 'Declined' => 'decline-refund-request', 'Accepted' => 'accept-refund-request'];
        $email = $this->getTemplate(preference('dflt_lang'), $refundStatus[$request->status]);

        if (! $email['status']) {
            return $email;
        }

        $userInfo = User::where('id', $request->user_id)->first();

        $refund = Refund::find($request->id);
        $product = $refund->getProduct();

        $vendor = Vendor::select('id', 'name', 'phone')->where('email', $request->vendor_email)->first();

        if (! empty($vendor)) {
            // Replacing template variable
            $subject = str_replace('{company_name}', preference('company_name'), $email->subject);

            $data = [
                '{logo}' => $this->logo,
                '{user_name}' => $userInfo->name,
                '{product_image}' => $product->getFeaturedImage('small'),
                '{product_name}' => $product->name,
                '{vendor_name}' => $vendor->name,
                '{product_qty}' => $refund->quantity_sent,
                '{currency_symbol}' => Currency::getDefault()->symbol,
                '{price}' => $request->total,
                '{contact_number}' => $vendor->phone,
                '{product_details_url}' => route('site.productDetails', ['slug' => $product->slug]),
                '{support_mail}' => $request->vendor_email,
                '{company_name}' => preference('company_name'),
            ];

            $message = str_replace(array_keys($data), $data, $email->body);

            return $this->email->sendEmail($userInfo->email, $subject, $message, null, preference('company_name'));
        }
    }
}
