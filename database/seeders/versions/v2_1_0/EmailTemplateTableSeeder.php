<?php

namespace Database\Seeders\versions\v2_1_0;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;

class EmailTemplateTableSeeder extends Seeder
{
    /**
     * Update the SMS body of an email template with the given slug.
     *
     * @param  string  $slug
     * @param  string  $data
     */
    private function updateTemplate($slug, $data): void
    {
        $template = EmailTemplate::where('slug', $slug);

        if ($template->exists()) {
            $template->update(['sms_body' => $data]);
        }
    }

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $data = 'ORDER CONFIRMATION

Order #: {order_number}

Dear {user_name}, your order with {company_name} is confirmed on {order_confirm_date}. Preparing for delivery. Log in or call {contact_number} for help.

ORDER DETAILS
{products}

Total: {currency_symbol}{grand_total}
{download}

SHIPPING: {shipping_address}

PAYMENT: {payment_method}

Track Code: {track_code}';

        $this->updateTemplate('order', $data);

        $data = 'Welcome to {company_name}!

Login to view your account details.

KEEP IN TOUCH

For questions or suggestions, email us: {support_mail}

© 2024, {company_name}. All rights reserved.';

        $this->updateTemplate('user', $data);

        $data = 'ACCOUNT CONFIRMATION

Use OTP code {verification_otp} or visit {verification_url} to verify your email and enjoy exclusive services with us!

Confirm Account

For assistance, email us: {support_mail}

© 2024, {company_name}. All rights reserved.';

        $this->updateTemplate('email-verification', $data);

        $data = 'PASSWORD UPDATED

Dear {user_name},

Your {company_name} account password has been reset.

Credentials:
Email: {user_id}
Password: {user_pass}

For help, email: {support_mail}

© 2024, {company_name}. All rights reserved.';

        $this->updateTemplate('new-password-set', $data);

        $data = 'PASSWORD RECOVERY

Dear {user_name},

If you did not request a password reset, you can disregard this message. No changes have been made to your Martvill account.

Use OTP code: {verification_otp} to confirm your password recovery.

Confirm Account

For assistance, email us: {support_mail}

© 2024, {company_name}. All rights reserved.';

        $this->updateTemplate('reset-password', $data);

        $data = 'REFUND ACCEPTED

Dear {user_name},

Your product refund request is complete.

Product: {product_name}
Vendor: {vendor_name}
Qty: {product_qty}
Price: {currency_symbol}{price}

Details: Check Account

Refund process may take 2-4 days. For assistance, login or call: {contact_number}.

For inquiries, email: {support_mail}

© 2024, {company_name}. All rights reserved.';

        $this->updateTemplate('accept-refund-request', $data);

        $data = 'REFUND REJECTED

Dear {user_name},

Your product refund request is rejected.

Product: {product_name}
Vendor: {vendor_name}
Qty: {product_qty}
Price: {currency_symbol}{price}

Details: Check Account

For further information, login or call: {contact_number}.

For inquiries, email: {support_mail}

© 2024, {company_name}. All rights reserved.';

        $this->updateTemplate('decline-refund-request', $data);

        $data = 'REFUND IN PROGRESS

Dear {user_name},

Your product refund request is in progress.

Product: {product_name}
Vendor: {vendor_name}
Qty: {product_qty}
Price: {currency_symbol}{price}

Details: Check Account

For further information, login or call: {contact_number}.

For inquiries, email: {support_mail}

© 2024, {company_name}. All rights reserved.';

        $this->updateTemplate('in-progress-refund-request', $data);

        $data = 'Welcome to our mailing list! 🎉 Be the first to know about new arrivals, events, and special offers.

Shop Now: {shop_link}

For assistance, email: {support_mail}

To unsubscribe, click: {unsubscribe_link}

© 2024, {company_name}. All rights reserved.';

        $this->updateTemplate('subscriber', $data);

        $data = 'ORDER CONFIRMED

Order #: {order_number}

Dear {user_name}, your {company_name} order is confirmed on {order_confirm_date}. Preparing for delivery.

Items: {product_name} - {vendor_name} - Qty: {product_qty} - {currency_symbol}{product_price}
Total: {currency_symbol}{grand_total}

Delivery: {estimated_delivery_time} Days

For help, login or call: {contact_number}.

Inquiries: {support_mail}

© 2024, {company_name}. All rights reserved.';

        $this->updateTemplate('vendor-invoice', $data);

        $data = "TICKET ALERT

Hello {member_name},

New support ticket assigned.
'{ticket_message}'

ID: {ticket_no}
Project: {project_name}
Subject: {ticket_subject}
Status: {ticket_status}

View Tickets: {tickets_link}

© 2024, {company_name}. All rights reserved.";

        $this->updateTemplate('ticket-department', $data);

        $data = "TICKET ALERT

Hello {assignee_name},

New support ticket assigned.
'{ticket_message}'

ID: {ticket_no}
Status: {ticket_status}
Customer ID: {customer_id}
Subject: {ticket_subject}

View Tickets: {tickets_link}

{company_name}

© 2024, {company_name}. All rights reserved.";

        $this->updateTemplate('ticket-vendor', $data);

        $data = "TICKET ALERT

Hello {assignee_name},

New support ticket assigned.
'{ticket_message}'

ID: {ticket_no}
Status: {ticket_status}
Customer ID: {customer_id}
Subject: {ticket_subject}

View Tickets: {tickets_link}

{company_name}

© 2024, {company_name}. All rights reserved.";

        $this->updateTemplate('ticket-assignee', $data);

        $data = 'STATUS UPDATE

Dear {user_name},

Your status at {company_name} has changed. Login to your account for details.

KEEP IN TOUCH

For assistance, email: {support_mail}

© 2024, {company_name}. All rights reserved.';

        $this->updateTemplate('admin-accepted-seller-request', $data);

        $data = 'SELLER REQUEST

Dear {user_name},

A seller wants to join {company_name}. Review and update their status.

KEEP IN TOUCH

For assistance, email: {support_mail}

© 2024, {company_name}. All rights reserved.';

        $this->updateTemplate('seller-request-for-admin', $data);

        $data = 'ACCOUNT DEACTIVATED

Dear {user_name},

Your account at {company_name} has been deactivated. Contact our administrator for assistance.

KEEP IN TOUCH

For inquiries, email: {support_mail}

© 2024, {company_name}. All rights reserved.';

        $this->updateTemplate('admin-change-seller-status', $data);

        $data = '{mail_content}

KEEP IN TOUCH

For assistance, email: {support_mail}

© 2024, {company_name}. All rights reserved.';

        $this->updateTemplate('popup-mail', $data);

        $data = "TICKET REPLY

Hello {name},

Reply from {team_member} at {company_name}.
'{ticket_message}'

ID: {ticket_no}
Subject: {ticket_subject}
Status: {ticket_status}

View Tickets: {tickets_link}

{company_name}

© 2024, {company_name}. All rights reserved.";

        $this->updateTemplate('ticket-reply', $data);

        $data = 'LOW STOCK ALERT

Hi {user_name},

Products below threshold:
{product_list}

Please add stock.

KEEP IN TOUCH

For assistance, email: {support_mail}

© 2024, {company_name}. All rights reserved.';

        $this->updateTemplate('low-stock-threshold', $data);
    }
}
