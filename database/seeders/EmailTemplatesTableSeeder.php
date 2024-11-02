<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EmailTemplatesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('email_templates')->delete();

        \DB::table('email_templates')->insert([
            0 => [
                'id' => 1,
                'parent_id' => null,
                'name' => 'order',
                'slug' => 'order',
                'subject' => 'Your Invoice # {invoice_reference_no} from {company_name} has been created.',
                'body' => '<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8" />
<meta http-equiv="x-ua-compatible" content="ie=edge" />
<title>3.Invoice</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<style type="text/css">
@media screen {
@font-face {
font-family: "DM Sans";
font-weight: 700;
src: url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriASitCBimCw.woff2) format("woff2");
}

@font-face {
font-family: "DM Sans";
font-weight: 500;
font-style: normal;
src: url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriAWCrCBimCw.woff2) format("woff2");
}

@font-face {
font-family: \'Roboto\';
font-style: normal;
font-weight: 500;
src: url(https://fonts.gstatic.com/s/roboto/v30/KFOlCnqEu92Fr1MmEU9fBBc4.woff2) format(\'woff2\');
unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
}
}

.bodys,
.tables,
td,
.anchor-tag a {
-ms-text-size-adjust: 100%;
-webkit-text-size-adjust: 100%;
}

.tables,
td {
mso-table-rspace: 0pt;
mso-table-lspace: 0pt;
}

.anchor-tag a {
padding: 1px;
margin: 1px;
}

.anchor-tag a[x-apple-data-detectors] {
font-family: inherit !important;
font-size: inherit !important;
font-weight: inherit !important;
line-height: inherit !important;
color: inherit !important;
text-decoration: none !important;
}

.bodys {
width: 100% !important;
height: 100% !important;
padding: 0 !important;
margin: 0 !important;
}

.tables {
border-collapse: collapse !important;
}

.logo-img {
margin: 26px 0px 19px 0px;
padding: 0px;
width: 207.98px;
height: 56px;
}

.actives {
box-sizing: border-box;
text-decoration: none;
-webkit-text-size-adjust: none;
text-align: center;
border-radius: 2px;
-webkit-border-radius: 2px;
-moz-border-radius: 2px;
-khtml-border-radius: 2px;
-o-border-radius: 2px;
-ms-border-radius: 2px;
padding: 10px 31px;
cursor: pointer;
background: #fcca19;
}

.anchor-tag a:focus,
.anchor-tag a:hover {
text-decoration: underline;
text-decoration-color: #fcca19;
}

.anchor-tag a:-webkit-any-link {
color: -webkit-link;
cursor: pointer;
text-decoration: underline;
text-decoration-color: #fcca19;
}

.anchor-tag a:-webkit-any-link {
color: -webkit-link;
cursor: pointer;
text-decoration: none;
text-decoration-color: #fcca19;
}
</style>
</head>

<body class="bodys" style="background-color: #e9ecef">
<div class="preheader"
style="display: none; max-width: 0; max-height: 0; margin: 0px; overflow: hidden; color: #fff; opacity: 0;">
</div>
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px">
<tr>
<td align="center" valign="top" style="padding: 36px 24px"></td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
style="max-width: 640px; margin-top: 100px">
<tr>
<td align="center" bgcolor="#ffffff">
<img class="logo-img" src="{logo}" alt="logo" />
<p style="border-top: 1px solid #dfdfdf; margin: 1px 20px 0px 20px;"></p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
<tr>
<td align="center" bgcolor="#fff">
<p
style="font-family: \'DM Sans\', sans-serif; letter-spacing: 0.255em; text-transform: uppercase; margin: 28px 0px 20px 0px; line-height: 25px; font-size:14px !important; color: rgb(44, 44, 44); font-weight: 500 !important; cursor: default !important;">
Your Order is confirmed</p>
<p
style="margin: 0px; font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 500; font-size: 14px; line-height: 28px; text-align: center; color: #2C2C2C;">
ORDER INVOICE</p>
<p style="margin-top: 5px;font-family: \'DM Sans\', sans-serif;  font-style: normal; font-weight: 700;
font-size: 32px; line-height: 28px; text-align: center; color: #2C2C2C;">{order_number}
</p>
<p style="margin-top: 32px; padding:0px 30px 0px 37px; font-family: \'DM Sans\', sans-serif; text-align: left; font-style: normal; font-weight: 500; font-size: 14px; line-height: 24px; color: #898989;
"><span style="color: #2C2C2C;">Dear {user_name},</span> your order placed on
<a href="{company_url}" style="color:#0060A9 ; text-decoration:underline;">{company_name}</a>
has been
confirmed on <span style="color: #2C2C2C;">{order_confirm_date}.</span> Your order is
being prepared for delivery. To cancel your order or for further information, login to
your account or call us: <span style="color: #2C2C2C;"> {contact_number}.</span></p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
<tr>
<td align="center" bgcolor="#ffffff">
<div style="margin: 29px 20px 0px 37px;">
<p
style="font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 700; font-size: 18px; margin-top: 2px; line-height: 28px; color: #2C2C2C; float: left; text-align: left; padding-top: 4px;">
ORDER DETAILS</p>
<a href="{order_track_url}" aria-pressed="true" class="actives anchor-tag"
style="font-family: \'DM Sans\',sans-serif; font-style: normal; display:flex; font-weight: 700; float:right; font-size: 14px; line-height: 28px; color: #2C2C2C;">
Check Order<img
style="height: 13px; margin-top: 8px; margin-left: 6px; align-items: center; text-align: center; width:13px;"
src="https://i.ibb.co/KbdnGPG/Group-9393.png" alt=""></a>
</div>
<div style="clear: both;"></div>
<div style="margin:14px 20px;">
<table class="tables" id="customers" border="0" cellpadding="0" cellspacing="0"
width="100%" style="text-align: left;">
<tr style="align-items:left;">
<th style="padding-left: 18px;">Items</th>
<th>Seller</th>
<th style="padding-left:18px;">Qty</th>
<th>Price</th>
</tr>
<tr>
{products}
<tr>
<td></td>
<td
style="font-family:\'DM Sans\', sans-serif; border-bottom: 1px solid #DFDFDF; font-style: normal; font-weight: 500; font-size: 14px; line-height: 18px; color: #898989;">
<p style="margin: 1px; padding-top:24px;">Subtotal </p>
<p style="margin: 1px; padding-top:24px;">Shipping </p>
<p style="margin: 1px; padding-top:24px;">Tax </p>
<p style="margin: 1px; padding:16px 0px;">Discount </p>
</td>
<td style="border-bottom: 1px solid #DFDFDF;">
</td>
<td
style="font-family:\'DM Sans\', sans-serif;  border-bottom: 1px solid #DFDFDF; font-style: normal; font-weight: 500; font-size: 14px; line-height: 18px; color: #898989;">
<p style="margin: 0; padding-top:24px; margin-top:1px;">
{currency_symbol}{subtotal}</p>
<p style="margin: 0; padding-top:24px; margin-top:1px;">
{currency_symbol}{shipping_charge}</p>
<p style="margin: 0; padding-top:24px; margin-top:1px;">
{currency_symbol}{tax_charge}</p>
<p style="margin: 0;padding:16px 0px; margin-top:1px;">
{currency_symbol}{discount_amount}</p>
</td>
</tr>
<tr>
<td></td>
<td
style="font-family: \'DM Sans\', sans-serif; font-style: normal;font-weight:500; font-size: 14px;line-height: 18px; padding-top: 16px; color: #2C2C2C;">
Grand Total</td>
<td></td>
<td
style="font-family: \'DM Sans\', sans-serif; font-style:normal; font-weight:500; font-size: 14px;line-height: 18px; padding-top: 16px; color: #2C2C2C;">
{currency_symbol}{grand_total}</td>
</tr>
</table>
{download}
</div>
<div style="margin:30px 20px; background-color: #F3F3F3; border-radius: 4px;">
<div>
<p
style="font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 700; font-size: 18px; line-height: 28px; padding: 20px 14px 11px 14px ; text-align: left; padding-left:14px; margin-right:14px;color: #2C2C2C; margin-top: 1px;">
CUSTOMER DETAILS</p>
<p
style="border-bottom: 1px solid #DFDFDF; margin-left:14px; margin-top:1px; margin-right:14px;">
</p>
</div>
<div style="display:flex;">
<div style="margin-right:50px">
<p
style="font-family:\'DM Sans\', sans-serif; font-style: normal; font-weight: 700; font-size: 16px; line-height: 28px; padding: 20px 14px 0px 14px ; text-align: left; padding-left:14px; margin-right:14px;color: #2C2C2C; margin-top: 1px;">
SHIPPING ADDRESS</p>
<div
style="font-family:\'DM Sans\', sans-serif; font-style: normal; font-weight: 400; font-size: 14px; line-height: 24px;color: #2C2C2C; padding: 5px 0px 43px 14px; text-align: left; width: 200px; margin-top: 1px; width: 200px;">
{shipping_address}
</div>
</div>
<div style="padding-bottom: 24px; margin-left: 20px;">
<p
style="font-family:\'DM Sans\', sans-serif; font-style: normal; font-weight: 700; font-size: 16px; line-height: 28px; padding: 26px 14px 0px 14px ; text-align: left; margin-right:14px;color: #2C2C2C; margin-top: 1px;">
PAYMENT</p>
<p
style="font-family:\'DM Sans\', sans-serif; font-style: normal; font-weight: 400; font-size: 14px; line-height: 24px; color: #2C2C2C; padding: 5px 0px 0px 14px; text-align: left; margin-top: 1px;">
{payment_method}</p>
<p
style="font-family:\'DM Sans\', sans-serif; font-style: normal; font-weight: 700; font-size: 16px; line-height: 28px; padding: 26px 14px 0px 14px ; text-align: left; margin-right:14px;color: #2C2C2C; margin-top: 1px;">
Track Code</p>
<p
style="font-family:\'DM Sans\', sans-serif; font-style: normal; font-weight: 400; font-size: 14px; line-height: 24px; color: #2C2C2C; padding: 5px 0px 0px 14px; text-align: left; margin-top: 1px;">
{track_code}</p>
</div>
</div>
</div>
<div>
<p
style="font-family:\'DM Sans\', sans-serif; font-style: normal; font-weight: 700; font-size: 18px;line-height: 21px; margin-top:1px ;text-align:center; text-transform: uppercase; color: #2C2C2C;">
Keep in touch</p>
</div>
<div
style="margin-top: 1px; font-size: 14px; text-align: center; color: #898989; line-height: 22px; margin: 1px;">
<p style="margin-top:14px"> If you have any queries, concerns or suggestions,</p>
<p style="margin:0px; margin-top:1px"> please email us: <span
style="cursor: pointer; color: #0060A9; text-decoration: underline;">{support_mail}</span>
</p>
</div>
<div style="margin-top: 25px; margin-bottom:14px;">
<a class="anchor-tag"
style="margin-right: 9px; width: 32px; height:32px; display: inline-block;"
href="https://www.facebook.com/"><img src="https://i.ibb.co/fCZXxCC/Group-9380.png"
alt="" /></a>
<a class="anchor-tag"
style="margin-right: 9px; width: 32px; height:32px; display: inline-block;"
href="https://twitter.com/?lang=en"><img src="https://i.ibb.co/ZLgzjS0/twitter.png"
alt="" /></a>
<a class="anchor-tag"
style="margin-right: 9px; width: 32px; height:32px; display: inline-block;"
href="https://www.instagram.com/?hl=en"><img
src="https://i.ibb.co/WKyFkYz/instagramm.png" alt="" /></a>
<a class="anchor-tag"
style="margin-right: 9px; width: 32px; height:32px; display: inline-block;"
href="https://www.whatsapp.com/"><img src="https://i.ibb.co/6R7LWr1/watsapp.png"
alt="" /></a>
<a class="anchor-tag"
style="margin-right: 9px; width: 32px; height:32px; display: inline-block;"
href="https://www.pioneer.eu/"> <img style="margin: -2px;"
src="https://i.ibb.co/wYT6Tmg/pinterest.png" alt="" /></a>
<a class="anchor-tag"
style="margin-right: 9px; width: 32px; height:32px; display: inline-block;"
href="https://www.youtube.com/"><img style="margin: 1px;"
src="https://i.ibb.co/RT7Zns1/youtube.png" alt="" /></a>
</div>
<p style="border-top: 1px solid #dfdfdf; margin: 1px 20px 0px 20px;"></p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500; margin-bottom: 200px;">
<tr>
<td align="center" bgcolor="#ffffff">
<p
style="text-align: center; line-height: 16px; color: #898989; font-size: 12px; margin: 13px 0px;">
&copy; 2022, {company_name}. All rights reserved.</p>
</td>
</tr>
</table>
</td>
</tr>
</table>
</body>

</html>',
                'language_id' => 1,
                'status' => 'Active',
                'variables' => 'logo,order_number,user_name,company_url,order_confirm_date,contact_number,order_track_url,currency_symbol,subtotal,shipping_charge,grand_total,shipping_address,payment_method,support_mail,company_name,tax_charge,discount_amount,track_code,products',
            ],
            1 => [
                'id' => 2,
                'parent_id' => null,
                'name' => 'User',
                'slug' => 'user',
                'subject' => 'Welcome to {company_name} as an user',
                'body' => '<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8" />
<meta http-equiv="x-ua-compatible" content="ie=edge" />
<title>10.NEW COUPON ADDED</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<style type="text/css">
@media screen {
@font-face {
font-family: "DM Sans";
font-weight: 700;
src: url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriASitCBimCw.woff2) format("woff2");
}

@font-face {
font-family: "DM Sans";
font-weight: 500;
font-style: normal;
src: url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriAWCrCBimCw.woff2) format("woff2");
}
}

.bodys,
.tables,
td,
.anchor-tag a {
-ms-text-size-adjust: 100%;
-webkit-text-size-adjust: 100%;
}

.tables,
td {
mso-table-rspace: 0pt;
mso-table-lspace: 0pt;
}

.anchor-tag a {
padding: 1px;
margin: 1px;
}

.anchor-tag a[x-apple-data-detectors] {
font-family: inherit !important;
font-size: inherit !important;
font-weight: inherit !important;
line-height: inherit !important;
color: inherit !important;
text-decoration: none !important;
}

.bodys {
width: 100% !important;
height: 100% !important;
padding: 0 !important;
margin: 0 !important;
}

.tables {
border-collapse: collapse !important;
}

.logo-img {
margin: 26px 0px 19px 0px;
padding: 0px;
width: 207.98px;
height: 56px;
}

.anchor-tag a:focus,
.anchor-tag a:hover {
text-decoration: underline;
text-decoration-color: #fcca19;
}

.anchor-tag a:-webkit-any-link {
color: -webkit-link;
cursor: pointer;
text-decoration: underline;
text-decoration-color: #fcca19;
}

.anchor-tag a:-webkit-any-link {
color: -webkit-link;
cursor: pointer;
text-decoration: none;
text-decoration-color: #fcca19;
}
</style>
</head>

<body class="bodys" style="background-color: #e9ecef">
<div class="preheader"
style="display: none; max-width: 0; max-height: 0; margin: 0px; overflow: hidden; color: #fff; opacity: 0;"></div>
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px">
<tr>
<td align="center" valign="top" style="padding: 36px 24px"></td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
style="max-width: 640px; margin-top: 100px">
<tr>
<td align="center" bgcolor="#ffffff">
<img class="logo-img" src="{logo}" alt="logo" />
<p style="border-top: 1px solid #dfdfdf; margin: 1px 20px 0px 20px;"></p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
<tr>
<td align="center" bgcolor="#fff">
<p style="font-family: \'DM Sans\', sans-serif; letter-spacing: 0.255em; text-transform: uppercase; margin: 26px 0px;
line-height: 25px; font-size: 0.8em !important; color: rgb(44, 44, 44); font-weight: 500 !important;
cursor: default !important;"></p>
<p style="margin: 0px;text-align: center; line-height: 24px; font-size: 16px;
color: #2c2c2c;"> Dear {user_name} </p>
<p style="margin: 0px; color: #898989; font-size: 14px; margin: 3px 50px 31px;
text-align: center; line-height: 24px;">A warm welcome to {company_name} family, please login to the <a
href="{company_url}" style="text-decoration: underline; cursor: pointer; color: #0060a9;">portal</a>
to see the details of your account.</p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
<tr>
<td align="center" bgcolor="#ffffff">
<div>
<p style="font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 700;
font-size: 18px; line-height: 21px; margin-top: 37px; text-align: center;
text-transform: uppercase; color: #2c2c2c;"> Keep in touch</p>
</div>
<div style="font-size: 14px; text-align: center; color: #898989;line-height: 22px; margin: 1px;">
<div style="font-size: 14px; text-align: center; color: #898989;line-height: 22px; margin: 1px;">
<p style="margin-top: 14px">If you have any queries, concerns or suggestions,
</p>
<p style="margin: 0px; margin-top: 1px">please email us:
<span style="text-decoration: underline; cursor: pointer; color: #0060a9;">{support_mail}</span>
</p>
</div>
</div>
<div style="margin-top: 32px; margin-bottom: 31px">
<a class="anchor-tag" style="margin-right: 9px; width: 32px; display: inline-block; "
href="https://www.facebook.com/"><img src="https://i.ibb.co/fCZXxCC/Group-9380.png" alt="" /></a>
<a class="anchor-tag" style="margin-right: 9px; width: 32px; display: inline-block;"
href="https://twitter.com/?lang=en"><img src="https://i.ibb.co/ZLgzjS0/twitter.png" alt="" /></a>
<a class="anchor-tag" style="margin-right: 9px; width: 32px;display: inline-block; "
href="https://www.instagram.com/?hl=en"><img src="https://i.ibb.co/WKyFkYz/instagramm.png"
alt="" /></a>
<a class="anchor-tag" style="margin-right: 9px; width: 32px; display: inline-block; "
href="https://www.whatsapp.com/"><img src="https://i.ibb.co/6R7LWr1/watsapp.png" alt="" /></a>
<a class="anchor-tag" style="margin-right: 9px; width: 32px; display: inline-block;"
href="https://www.pioneer.eu/"><img src="https://i.ibb.co/wYT6Tmg/pinterest.png" alt="" /></a>
<a class="anchor-tag" style="margin-right: 9px; width: 32px; display: inline-block; "
href="https://www.youtube.com/"><img src="https://i.ibb.co/RT7Zns1/youtube.png" alt="" /></a>
</div>
<p style="border-top: 1px solid #dfdfdf;margin: 1px 20px 0px 20px; "></p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500; margin-bottom: 200px; ">
<tr>
<td align="center" bgcolor="#ffffff">
<p style=" text-align: center; line-height: 16px; color: #898989; font-size: 12px; margin: 13px 0px; ">
&copy 2022, {company_name}. All rights reserved.</p>
</td>
</tr>
</table>
</td>
</tr>
</table>
</body>

</html>',
                'language_id' => 1,
                'status' => 'Active',
                'variables' => 'logo,user_name, company_url, company_name,support_mail',
            ],
            2 => [
                'id' => 4,
                'parent_id' => null,
                'name' => 'Email Verification',
                'slug' => 'email-verification',
                'subject' => 'Active user information',
                'body' => '<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta http-equiv="x-ua-compatible" content="ie=edge" />
<title>2.otp</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<style type="text/css">
@media screen {
@font-face {
font-family: "DM Sans";
font-weight: 700;
src:   url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriASitCBimCw.woff2)
format("woff2");
}
@font-face {
font-family: "DM Sans";
font-weight: 500;
font-style: normal;
src: url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriAWCrCBimCw.woff2)
format("woff2");
}
}
.bodys,
.tables,
td,
.anchor-tag a {
-ms-text-size-adjust: 100%;
-webkit-text-size-adjust: 100%;
}
.tables,
td {
mso-table-rspace: 0pt;
mso-table-lspace: 0pt;
}
.anchor-tag a {
padding: 1px;
margin: 1px;
}
.anchor-tag a[x-apple-data-detectors] {
font-family: inherit !important;
font-size: inherit !important;
font-weight: inherit !important;
line-height: inherit !important;
color: inherit !important;
text-decoration: none !important;
}
.bodys {
width: 100% !important;
height: 100% !important;
padding: 0 !important;
margin: 0 !important;
}
.tables {
border-collapse: collapse !important;
}
.logo-img {
margin: 26px 0px 19px 0px;
padding: 0px;
width: 207.98px;
height: 56px;
}
.actives {
box-sizing: border-box;
text-decoration: none;
-webkit-text-size-adjust: none;
text-align: center;
border-radius: 2px;
-webkit-border-radius: 2px;
-moz-border-radius: 2px;
-khtml-border-radius: 2px;
-o-border-radius: 2px;
-ms-border-radius: 2px;
padding: 10px 31px;
cursor: pointer;
background: #fcca19;
}
.anchor-tag a:focus,
.anchor-tag a:hover {
text-decoration: underline;
text-decoration-color: #fcca19;
}
.anchor-tag a:-webkit-any-link {
color: -webkit-link;
cursor: pointer;
text-decoration: underline;
text-decoration-color: #fcca19;
}
.anchor-tag a:-webkit-any-link {
color: -webkit-link;
cursor: pointer;
text-decoration: none;
text-decoration-color: #fcca19;
}
</style>
</head>
<body class="bodys" style="background-color: #e9ecef">
<div class="preheader" style="display: none; max-width: 0; max-height: 0; margin: 0px; overflow: hidden; color: #fff; opacity: 0;"></div>
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td align="center" bgcolor="#e9ecef">
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px">
<tr>
<td align="center" valign="top" style="padding: 36px 24px"></td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px; margin-top: 100px">
<tr>
<td align="center" bgcolor="#ffffff">
<img class="logo-img" src="{logo}" alt="logo" />
<p style="border-top: 1px solid #dfdfdf; margin: 1px 20px 0px 20px;"></p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
<tr>
<td align="center" bgcolor="#fff">
<p style="font-family: \'DM Sans\', sans-serif; letter-spacing: 0.255em; text-transform: uppercase; margin: 26px 0px 20px 0px; line-height: 25px;
font-size:0.80em!important; color: rgb(44, 44, 44); font-weight: 500 !important; cursor: default !important;">account confirmation</p>
<p style="font-family: \'DM Sans\', sans-serif; font-weight: 500 !important; font-style: normal; margin: 0px; color: #2C2C2C; font-size: 14px; margin: 15px 54px 28px; text-align: center; line-height: 24px;"> You’re almost there! Please use the OTP code given or click on the button below to confirm your email address and enjoy exclusive services with us!
</p>
<p style="font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 500; font-size: 14px;line-height: 28px; text-align: center; color: #2C2C2C; margin-bottom: 8px; text-transform: uppercase; {otp_active}">otp code</p>
<p style="font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 700;  font-size: 36px;
line-height: 28px; text-align: center; letter-spacing: 0.375em; color: #2C2C2C; margin-bottom: 15px; {otp_active}">{verification_otp}</p>
<p style="font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 500;font-size: 14px; line-height: 24px; text-align: center; color: #898989; margin-bottom: 32px; text-transform: uppercase; {token_otp_active}">or</p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style=" max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
<tr>
<td align="center" bgcolor="#ffffff">
<div style="{token_active}">
<a href="{verification_url}" aria-pressed="true" class="actives anchor-tag">
<span style="text-decoration: none; color: #2C2C2C;">Confirm Account</span>
</a>
</div>
<div style="font-size: 14px; text-align: center; color: #898989; line-height: 22px; margin: 1px;">
<p style="margin-top: 54px"> If you have any queries, concerns or suggestions,</p>
<p style="margin: 0px; margin-top: 1px"> please email us:
<span style="text-decoration: underline; cursor: pointer; color: #0060a9;">{support_mail}</span>
</p>
</div>
<div style="margin-top: 25px; margin-bottom:14px;">
<a class="anchor-tag "style="margin-right: 9px; width: 32px; height:32px; display: inline-block;" href="https://www.facebook.com/"><img src="https://i.ibb.co/fCZXxCC/Group-9380.png" alt=""/></a>
<a class="anchor-tag "style="margin-right: 9px; width: 32px; height:32px; display: inline-block;" href="https://twitter.com/?lang=en"><img src="https://i.ibb.co/ZLgzjS0/twitter.png" alt=""/></a>
<a class="anchor-tag "style="margin-right: 9px; width: 32px; height:32px; display: inline-block;" href="https://www.instagram.com/?hl=en"><img src="https://i.ibb.co/WKyFkYz/instagramm.png" alt="" /></a>
<a class="anchor-tag "style="margin-right: 9px; width: 32px; height:32px; display: inline-block;" href="https://www.whatsapp.com/"><img src="https://i.ibb.co/6R7LWr1/watsapp.png" alt=""/></a>
<a class="anchor-tag "style="margin-right: 9px; width: 32px; height:32px; display: inline-block;" href="https://www.pioneer.eu/"> <img style="margin: -2px;" src="https://i.ibb.co/wYT6Tmg/pinterest.png" alt="" /></a>
<a class="anchor-tag "style="margin-right: 9px; width: 32px; height:32px; display: inline-block;" href="https://www.youtube.com/"><img style="margin: 1px;" src="https://i.ibb.co/RT7Zns1/youtube.png" alt=""/></a>
</div>
<p style="border-top: 1px solid #dfdfdf; margin: 1px 20px 0px 20px;"></p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table  class="tables" border="0" cellpadding="0" cellspacing="0"  width="100%"style=" max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500; margin-bottom: 200px; ">
<tr>
<td align="center" bgcolor="#ffffff">
<p style="text-align: center; line-height: 16px; color: #898989; font-size: 12px; margin: 13px 0px;" > &copy 2022, {company_name}. All rights reserved.</p>
</td>
</tr>
</table>
</td>
</tr>
</table>
</body>
</html>
',
                'language_id' => 1,
                'status' => 'Active',
                'variables' => 'logo, verification_url, company_name,verification_otp,support_mail,otp_active,token_active,token_otp_active',
            ],
            3 => [
                'id' => 5,
                'parent_id' => null,
                'name' => 'New Password Set',
                'slug' => 'new-password-set',
                'subject' => 'New Password Set',
                'body' => '<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta http-equiv="x-ua-compatible" content="ie=edge" />
<title>1.Password Reset</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<style type="text/css">
@media screen {
@font-face {
font-family: "DM Sans";
font-weight: 700;
src:   url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriASitCBimCw.woff2)
format("woff2");
}
@font-face {
font-family: "DM Sans";
font-weight: 500;
font-style: normal;
src: url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriAWCrCBimCw.woff2)
format("woff2");
}
}
.bodys,
.tables,
td,
.anchor-tag a {
-ms-text-size-adjust: 100%;
-webkit-text-size-adjust: 100%;
}
.tables,
td {
mso-table-rspace: 0pt;
mso-table-lspace: 0pt;
}
.anchor-tag a {
padding: 1px;
margin: 1px;
}
.anchor-tag a[x-apple-data-detectors] {
font-family: inherit !important;
font-size: inherit !important;
font-weight: inherit !important;
line-height: inherit !important;
color: inherit !important;
text-decoration: none !important;
}
.bodys {
width: 100% !important;
height: 100% !important;
padding: 0 !important;
margin: 0 !important;
}
.tables {
border-collapse: collapse !important;
}
.logo-img {
margin: 26px 0px 19px 0px;
padding: 0px;
width: 207.98px;
height: 56px;
}
.actives {
box-sizing: border-box;
text-decoration: none;
-webkit-text-size-adjust: none;
text-align: center;
border-radius: 2px;
-webkit-border-radius: 2px;
-moz-border-radius: 2px;
-khtml-border-radius: 2px;
-o-border-radius: 2px;
-ms-border-radius: 2px;
padding: 10px 31px;
cursor: pointer;
background: #fcca19;
}
.anchor-tag a:focus,
.anchor-tag a:hover {
text-decoration: underline;
text-decoration-color: #fcca19;
}
.anchor-tag a:-webkit-any-link {
color: -webkit-link;
cursor: pointer;
text-decoration: underline;
text-decoration-color: #fcca19;
}
.anchor-tag a:-webkit-any-link {
color: -webkit-link;
cursor: pointer;
text-decoration: none;
text-decoration-color: #fcca19;
}
</style>
</head>
<body class="bodys" style="background-color: #e9ecef">
<div class="preheader" style="display: none; max-width: 0; max-height: 0; margin: 0px; overflow: hidden; color: #fff; opacity: 0;"></div>
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px">
<tr>
<td align="center" valign="top" style="padding: 36px 24px"></td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px; margin-top: 100px">
<tr>
<td align="center" bgcolor="#ffffff">
<img class="logo-img" src="{logo}" alt="logo" />
<p style="border-top: 1px solid #dfdfdf; margin: 1px 20px 0px 20px;"></p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
<tr>
<td align="center" bgcolor="#fff">
<p style="font-family: \'DM Sans\', sans-serif; letter-spacing: 0.255em; text-transform: uppercase; margin: 26px 0px; line-height: 25px;
font-size:0.80em!important; color: rgb(44, 44, 44); font-weight: 500 !important; cursor: default !important;"> Updated Your Password</p>
<p style="margin: 0px; text-align: center; line-height: 24px; font-size: 16px; color: #2c2c2c;" > Dear {user_name}</p>
<p style="margin: 0px; color: #898989; font-size: 14px; margin: 15px 54px 42px; text-align: center; line-height: 24px;"> You have requested to reset the password of your {company_name} account. Your new password has been set. You can check the update going through the portal.
</p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style=" max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
<tr>
<td align="center" bgcolor="#ffffff">

<div>
<p style="color: #2C2C2C;">Credentials:</p>
<p style="margin: 0px; color: #898989; font-size: 14px; text-align: center; line-height: 24px;">
<span style="color: #2c2c2c; padding-right: 2px;">Email:</span>{user_id}
</p>
<p style="margin: 0px; color: #898989; font-size: 14px; text-align: center; line-height: 24px;">
<span style="color: #2c2c2c; padding-right: 2px;">Password:</span>{user_pass}
</p>
</div>

<div style="font-size: 14px; text-align: center; color: #898989; line-height: 22px; margin: 1px;">
<p style="margin-top: 54px"> If you have any queries, concerns or suggestions,</p>
<p style="margin: 0px; margin-top: 1px"> please email us:
<span style="text-decoration: underline; cursor: pointer; color: #0060a9;">{support_mail}</span>
</p>
</div>
<div style=" margin-top: 32px; margin-bottom:31px;">
<a class="anchor-tag" style="margin-right: 9px; width: 32px; display: inline-block;" href="https://www.facebook.com/"><img src="https://i.ibb.co/fCZXxCC/Group-9380.png" alt=""/></a>
<a class="anchor-tag" style="margin-right: 9px; width: 32px; display: inline-block;" href="https://twitter.com/?lang=en"><img src="https://i.ibb.co/ZLgzjS0/twitter.png" alt=""/> </a>
<a class="anchor-tag" style="margin-right: 9px; width: 32px; display: inline-block;" href="https://www.instagram.com/?hl=en"><img src="https://i.ibb.co/WKyFkYz/instagramm.png" alt="" /></a>
<a class="anchor-tag" style="margin-right: 9px; width: 32px; display: inline-block;" href="https://www.whatsapp.com/"><img src="https://i.ibb.co/6R7LWr1/watsapp.png" alt=""/></a>
<a class="anchor-tag" style="margin-right: 9px; width: 32px; display: inline-block;" href="https://www.pioneer.eu/"> <img src="https://i.ibb.co/wYT6Tmg/pinterest.png" alt="" /></a>
<a class="anchor-tag" style="margin-right: 9px; width: 32px; display: inline-block;"  href="https://www.youtube.com/"><img src="https://i.ibb.co/RT7Zns1/youtube.png" alt=""/></a>
</div>
<p style="border-top: 1px solid #dfdfdf; margin: 1px 20px 0px 20px;"></p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"style=" max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500; margin-bottom: 200px; ">
<tr>
<td align="center" bgcolor="#ffffff">
<p style="text-align: center; line-height: 16px; color: #898989; font-size: 12px; margin: 13px 0px;" > &copy 2022, {company_name}. All rights reserved.</p>
</td>
</tr>
</table>
</td>
</tr>
</table>
</body>
</html>
',
                'language_id' => 1,
                'status' => 'Active',
                'variables' => 'user_name, company_url, user_id, user_pass, company_name,logo,support_mail',
            ],
            4 => [
                'id' => 6,
                'parent_id' => null,
                'name' => 'Reset Password',
                'slug' => 'reset-password',
                'subject' => 'Reset Password',
                'body' => '<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8" />
<meta http-equiv="x-ua-compatible" content="ie=edge" />
<title>2.otp</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<style type="text/css">
@media screen {
@font-face {
font-family: "DM Sans";
font-weight: 700;
src: url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriASitCBimCw.woff2) format("woff2");
}

@font-face {
font-family: "DM Sans";
font-weight: 500;
font-style: normal;
src: url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriAWCrCBimCw.woff2) format("woff2");
}
}

.bodys,
.tables,
td,
.anchor-tag a {
-ms-text-size-adjust: 100%;
-webkit-text-size-adjust: 100%;
}

.tables,
td {
mso-table-rspace: 0pt;
mso-table-lspace: 0pt;
}

.anchor-tag a {
padding: 1px;
margin: 1px;
}

.anchor-tag a[x-apple-data-detectors] {
font-family: inherit !important;
font-size: inherit !important;
font-weight: inherit !important;
line-height: inherit !important;
color: inherit !important;
text-decoration: none !important;
}

.bodys {
width: 100% !important;
height: 100% !important;
padding: 0 !important;
margin: 0 !important;
}

.tables {
border-collapse: collapse !important;
}

.logo-img {
margin: 26px 0px 19px 0px;
padding: 0px;
width: 207.98px;
height: 56px;
}

.actives {
box-sizing: border-box;
text-decoration: none;
-webkit-text-size-adjust: none;
text-align: center;
border-radius: 2px;
-webkit-border-radius: 2px;
-moz-border-radius: 2px;
-khtml-border-radius: 2px;
-o-border-radius: 2px;
-ms-border-radius: 2px;
padding: 10px 31px;
cursor: pointer;
background: #fcca19;
}

.anchor-tag a:focus,
.anchor-tag a:hover {
text-decoration: underline;
text-decoration-color: #fcca19;
}

.anchor-tag a:-webkit-any-link {
color: -webkit-link;
cursor: pointer;
text-decoration: underline;
text-decoration-color: #fcca19;
}

.anchor-tag a:-webkit-any-link {
color: -webkit-link;
cursor: pointer;
text-decoration: none;
text-decoration-color: #fcca19;
}
</style>
</head>

<body class="bodys" style="background-color: #e9ecef">
<div class="preheader"
style="display: none; max-width: 0; max-height: 0; margin: 0px; overflow: hidden; color: #fff; opacity: 0;"></div>
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td align="center" bgcolor="#e9ecef">
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px">
<tr>
<td align="center" valign="top" style="padding: 36px 24px"></td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
style="max-width: 640px; margin-top: 100px">
<tr>
<td align="center" bgcolor="#ffffff">
<img class="logo-img" src="{logo}" alt="logo" />
<p style="border-top: 1px solid #dfdfdf; margin: 1px 20px 0px 20px;"></p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
<tr>
<td align="center" bgcolor="#fff">
<p
style="font-family: \'DM Sans\', sans-serif; letter-spacing: 0.255em; text-transform: uppercase; margin: 26px 0px 20px 0px; line-height: 25px;
font-size:0.80em!important; color: rgb(44, 44, 44); font-weight: 500 !important; cursor: default !important;">
PASSWORD RECOVERY</p>
<p style="margin: 0px;text-align: center; line-height: 24px; font-size: 16px; color: #2c2c2c;">Dear
{user_name} </p>
<p
style="font-family: \'DM Sans\', sans-serif; font-weight: 500 !important; font-style: normal; margin: 0px; color: #2C2C2C; font-size: 14px; margin: 15px 54px 28px; text-align: center; line-height: 24px;">
You have requested to reset the password of your Martvill account. If you did not request a password
reset, you can
disregard this email. No changes have been made to your account yet.
</p>
<p
style="font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 500; font-size: 14px;line-height: 28px; text-align: center; color: #2C2C2C; margin-bottom: 8px; text-transform: uppercase; {opt_active}">
otp code</p>
<p
style="font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 700;  font-size: 36px;
line-height: 28px; text-align: center; letter-spacing: 0.375em; color: #2C2C2C; margin-bottom: 15px; {otp_active}">
{verification_otp}</p>
<p
style="font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 500;font-size: 14px; line-height: 24px; text-align: center; color: #898989; margin-bottom: 32px; text-transform: uppercase; {token_otp_active}">
or</p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
style=" max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
<tr>
<td align="center" bgcolor="#ffffff">
<div style="{token_active}">
<a href="{verification_url}" aria-pressed="true" class="actives anchor-tag">
<span style="text-decoration: none; color: #2C2C2C;">Confirm Account</span>
</a>
</div>
<div style="font-size: 14px; text-align: center; color: #898989; line-height: 22px; margin: 1px;">
<p style="margin-top: 54px"> If you have any queries, concerns or suggestions,</p>
<p style="margin: 0px; margin-top: 1px"> please email us:
<span style="text-decoration: underline; cursor: pointer; color: #0060a9;">{support_mail}</span>
</p>
</div>
<div style="margin-top: 25px; margin-bottom:14px;">
<a class="anchor-tag" style="margin-right: 9px; width: 32px; height:32px; display: inline-block;"
href="https://www.facebook.com/"><img src="https://i.ibb.co/fCZXxCC/Group-9380.png" alt="" /></a>
<a class="anchor-tag" style="margin-right: 9px; width: 32px; height:32px; display: inline-block;"
href="https://twitter.com/?lang=en"><img src="https://i.ibb.co/ZLgzjS0/twitter.png" alt="" /></a>
<a class="anchor-tag" style="margin-right: 9px; width: 32px; height:32px; display: inline-block;"
href="https://www.instagram.com/?hl=en"><img src="https://i.ibb.co/WKyFkYz/instagramm.png"
alt="" /></a>
<a class="anchor-tag" style="margin-right: 9px; width: 32px; height:32px; display: inline-block;"
href="https://www.whatsapp.com/"><img src="https://i.ibb.co/6R7LWr1/watsapp.png" alt="" /></a>
<a class="anchor-tag" style="margin-right: 9px; width: 32px; height:32px; display: inline-block;"
href="https://www.pioneer.eu/"> <img style="margin: -2px;"
src="https://i.ibb.co/wYT6Tmg/pinterest.png" alt="" /></a>
<a class="anchor-tag" style="margin-right: 9px; width: 32px; height:32px; display: inline-block;"
href="https://www.youtube.com/"><img style="margin: 1px;" src="https://i.ibb.co/RT7Zns1/youtube.png"
alt="" /></a>
</div>
<p style="border-top: 1px solid #dfdfdf; margin: 1px 20px 0px 20px;"></p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
style=" max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500; margin-bottom: 200px; ">
<tr>
<td align="center" bgcolor="#ffffff">
<p style="text-align: center; line-height: 16px; color: #898989; font-size: 12px; margin: 13px 0px;">
&copy 2022, {company_name}. All rights reserved.</p>
</td>
</tr>
</table>
</td>
</tr>
</table>
</body>

</html>',
                'language_id' => 1,
                'status' => 'Active',
                'variables' => 'logo, verification_url, company_name,verification_otp,support_mail,user_name,otp_active,token_otp_active,token_active',
            ],
            5 => [
                'id' => 7,
                'parent_id' => null,
                'name' => 'Accept refund request',
                'slug' => 'accept-refund-request',
                'subject' => 'Accept refund request',
                'body' => '<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta http-equiv="x-ua-compatible" content="ie=edge" />
<title>7.Refund request accepted</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<style type="text/css">
@media screen {
@font-face {
font-family: "DM Sans";
font-weight: 700;
src: url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriASitCBimCw.woff2)
format("woff2");
}
@font-face {
font-family: "DM Sans";
font-weight: 500;
font-style: normal;
src: url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriAWCrCBimCw.woff2)
format("woff2");
}
}
.bodys,
.tables,
td,
.anchor-tag a {
-ms-text-size-adjust: 100%;
-webkit-text-size-adjust: 100%;
}
.tables,
td {
mso-table-rspace: 0pt;
mso-table-lspace: 0pt;
}
.anchor-tag a {
padding: 1px;
margin: 1px;
}
.anchor-tag a[x-apple-data-detectors] {
font-family: inherit !important;
font-size: inherit !important;
font-weight: inherit !important;
line-height: inherit !important;
color: inherit !important;
text-decoration: none !important;
}
.bodys {
width: 100% !important;
height: 100% !important;
padding: 0 !important;
margin: 0 !important;
}
.tables {
border-collapse: collapse !important;
}
.logo-img {
margin: 26px 0px 19px 0px;
padding: 0px;
width: 207.98px;
height: 56px;
}
.actives {
box-sizing: border-box;
text-decoration: none;
-webkit-text-size-adjust: none;
text-align: center;
border-radius: 2px;
-webkit-border-radius: 2px;
-moz-border-radius: 2px;
-khtml-border-radius: 2px;
-o-border-radius: 2px;
-ms-border-radius: 2px;
padding: 10px 31px;
cursor: pointer;
background: #fcca19;
}
.anchor-tag a:focus,
.anchor-tag a:hover {
text-decoration: underline;
text-decoration-color: #fcca19;
}
.anchor-tag a:-webkit-any-link {
color: -webkit-link;
cursor: pointer;
text-decoration: underline;
text-decoration-color: #fcca19;
}
.anchor-tag a:-webkit-any-link {
color: -webkit-link;
cursor: pointer;
text-decoration: none;
text-decoration-color: #fcca19;
}
</style>
</head>
<body class="bodys" style="background-color: #e9ecef">
<div class="preheader" style="display: none; max-width: 0; max-height: 0; margin: 0px; overflow: hidden; color: #fff; opacity: 0;"></div>
<table  class="tables" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td align="center" bgcolor="#e9ecef">
<table  class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px">
<tr>
<td align="center" valign="top" style="padding: 36px 24px"></td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table  class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px; margin-top: 100px">
<tr>
<td align="center" bgcolor="#ffffff">
<img class="logo-img" src="{logo}" alt="logo"/>
<p style="border-top: 1px solid #dfdfdf; margin: 1px 20px 0px 20px;"></p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table  class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
<tr>
<td align="center" bgcolor="#fff">
<p style="font-family: \'DM Sans\', sans-serif; letter-spacing: 0.255em; text-transform: uppercase; margin: 26px 0px; line-height: 25px; font-size: 0.8em !important; color: rgb(44, 44, 44); font-weight: 500 !important; cursor: default !important;">Refund request accepted </p>
<p style="margin: 0px;text-align: center; line-height: 24px; font-size: 16px; color: #2c2c2c;">Dear {user_name} </p>
<p style="color: #898989; font-size: 14px; margin: 3px 0px 0px; text-align: center; line-height: 24px;">Your request for the refund of the product below is complete. </p>
<p style="color: #898989; font-size: 14px; margin: 2px 0px 27px; text-align: center; line-height: 24px;">Thank you for your patience.</p>
<div style="margin-bottom: 19px">
<img style="padding: 21px; width: 56px; height: 56px; background-color: #f1f1f1; border-radius: 4px;"src="{product_image}" alt=""/> </div>
<p style="font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 500; font-size: 16px; line-height: 21px; text-align: center; color: #2c2c2c;">{product_name}</p>
<div style="display: inline-flex; text-align: center; margin-top: 8px; margin-bottom: 46px;">
<p style="font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 500; font-size: 12px; line-height: 28px; color: #898989; text-align: center;">{vendor_name}</p>
<p style="font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 500; font-size: 12px; line-height: 28px; color: #898989; text-align: center; margin-left: 32px;">Qty: {product_qty}</p>
<p style="font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 500; font-size: 12px; line-height: 28px; color: #898989; text-align: center; margin-left: 32px;">{currency_symbol}{price}</p>
</div>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
<tr>
<td align="center" bgcolor="#ffffff">
<div>
<a href="{product_details_url}" aria-pressed="true" class="actives anchor-tag">
<span style="text-decoration: none; color: #2c2c2c">Check Details</span
><img style=" height: 13px; margin-left: 6px; align-items: center; text-align: center; width: 13px;" src="https://i.ibb.co/KbdnGPG/Group-9393.png" alt=""/> </a>
</div>
<p style="font-family: \'DM Sans\', sans-serif; margin: 44px 0px 0px ; font-style: normal; font-weight: 500; font-size: 14px; line-height: 24px; text-align: center; color: #898989;"> For further information, login to your account or call us: </p>
<span style="color:#2c2c2c ; margin: 0px 0px 25px ; font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 500; font-size: 14px; line-height: 24px; text-align:center;"> {contact_number}.</span>
<div>
<p style=" font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 700;
font-size: 18px; line-height: 21px; margin-top: 57px; text-align: center;
text-transform: uppercase; color: #2c2c2c;"> Keep in touch</p>
</div>
<div style="font-size: 14px; text-align: center; color: #898989;line-height: 22px; margin: 3px;">
<p style="font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 500;font-size: 14px;
line-height: 24px; text-align: center; color: #898989; margin: 14px 44px 25px;
">Your request for a refund has been accepted. Please give us <span style="color: #2c2c2c ;margin: 0px 4px">2-4 days</span>
to send you your refund.  For further information, login to your account or call us: <span style="color:#2c2c2c; margin:0px 4px">{contact_number}</span> .
</p>
<p style="margin: 0px; margin-top: 1px">please email us:
<span style="text-decoration: underline; cursor: pointer; color: #0060a9;">{support_mail}</span></p>
</div>
<div style="margin-top: 32px; margin-bottom: 31px">
<a class="anchor-tag" style=" margin-right: 9px; width: 32px; display: inline-block; " href="https://www.facebook.com/"><img src="https://i.ibb.co/fCZXxCC/Group-9380.png" alt="" /></a>
<a class="anchor-tag" style=" margin-right: 9px; width: 32px; display: inline-block;" href="https://twitter.com/?lang=en"><img src="https://i.ibb.co/ZLgzjS0/twitter.png" alt="" /></a>
<a class="anchor-tag" style=" margin-right: 9px; width: 32px;display: inline-block; " href="https://www.instagram.com/?hl=en"><img src="https://i.ibb.co/WKyFkYz/instagramm.png" alt=""
/></a>
<a class="anchor-tag" style=" margin-right: 9px; width: 32px; display: inline-block; " href="https://www.whatsapp.com/"><img src="https://i.ibb.co/6R7LWr1/watsapp.png" alt="" /></a>
<a class="anchor-tag" style=" margin-right: 9px; width: 32px; display: inline-block;" href="https://www.pioneer.eu/" ><img src="https://i.ibb.co/wYT6Tmg/pinterest.png" alt=""/></a>
<a class="anchor-tag" style=" margin-right: 9px; width: 32px; display: inline-block; " href="https://www.youtube.com/"><img src="https://i.ibb.co/RT7Zns1/youtube.png" alt=""/></a>
</div>
<p style="border-top: 1px solid #dfdfdf;margin: 1px 20px 0px 20px; " ></p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style=" max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500; margin-bottom: 200px; ">
<tr>
<td align="center" bgcolor="#ffffff">
<p style=" text-align: center; line-height: 16px; color: #898989; font-size: 12px; margin: 13px 0px; " > &copy 2022, {company_name}. All rights reserved.</p>
</td>
</tr>
</table>
</td>
</tr>
</table>
</body>
</html>
',
                'language_id' => 1,
                'status' => 'Active',
                'variables' => 'logo,user_name,product_image,product_name,vendor_name,product_qty,currency_symbol,price,contact_number,product_details_url,support_mail,company_name',
            ],
            6 => [
                'id' => 8,
                'parent_id' => null,
                'name' => 'Decline refund request',
                'slug' => 'decline-refund-request',
                'subject' => 'Decline refund request',
                'body' => '<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta http-equiv="x-ua-compatible" content="ie=edge" />
<title>8.refund complete</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<style type="text/css">
@media screen {
@font-face {
font-family: "DM Sans";
font-weight: 700;
src: url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriASitCBimCw.woff2)
format("woff2");
}
@font-face {
font-family: "DM Sans";
font-weight: 500;
font-style: normal;
src: url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriAWCrCBimCw.woff2)
format("woff2");
}
}
.bodys,
.tables,
td,
.anchor-tag a {
-ms-text-size-adjust: 100%;
-webkit-text-size-adjust: 100%;
}
.tables,
td {
mso-table-rspace: 0pt;
mso-table-lspace: 0pt;
}
.anchor-tag a {
padding: 1px;
margin: 1px;
}
.anchor-tag a[x-apple-data-detectors] {
font-family: inherit !important;
font-size: inherit !important;
font-weight: inherit !important;
line-height: inherit !important;
color: inherit !important;
text-decoration: none !important;
}
.bodys {
width: 100% !important;
height: 100% !important;
padding: 0 !important;
margin: 0 !important;
}
.tables {
border-collapse: collapse !important;
}
.logo-img {
margin: 26px 0px 19px 0px;
padding: 0px;
width: 207.98px;
height: 56px;
}
.actives {
box-sizing: border-box;
text-decoration: none;
-webkit-text-size-adjust: none;
text-align: center;
border-radius: 2px;
-webkit-border-radius: 2px;
-moz-border-radius: 2px;
-khtml-border-radius: 2px;
-o-border-radius: 2px;
-ms-border-radius: 2px;
padding: 10px 31px;
cursor: pointer;
background: #fcca19;
}
.anchor-tag a:focus,
.anchor-tag a:hover {
text-decoration: underline;
text-decoration-color: #fcca19;
}
.anchor-tag a:-webkit-any-link {
color: -webkit-link;
cursor: pointer;
text-decoration: underline;
text-decoration-color: #fcca19;
}
.anchor-tag a:-webkit-any-link {
color: -webkit-link;
cursor: pointer;
text-decoration: none;
text-decoration-color: #fcca19;
}
</style>
</head>
<body class="bodys" style="background-color: #e9ecef">
<div class="preheader" style="display: none; max-width: 0; max-height: 0; margin: 0px; overflow: hidden; color: #fff; opacity: 0;"></div>
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px">
<tr>
<td align="center" valign="top" style="padding: 36px 24px"></td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px; margin-top: 100px">
<tr>
<td align="center" bgcolor="#ffffff">
<img class="logo-img" src="{logo}" alt="logo"/>
<p style="border-top: 1px solid #dfdfdf; margin: 1px 20px 0px 20px;"></p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
<tr>
<td align="center" bgcolor="#fff">
<p style="font-family: \'DM Sans\', sans-serif; letter-spacing: 0.255em; text-transform: uppercase; margin: 26px 0px; line-height: 25px; font-size: 0.8em !important; color: rgb(44, 44, 44); font-weight: 500 !important; cursor: default !important;">Refund reject</p>
<p style="margin: 0px;text-align: center; line-height: 24px; font-size: 16px; color: #2c2c2c;">Dear {user_name} </p>
<p  style="color: #898989; font-size: 14px; text-align: center;  margin: 7px 0px 0px ; line-height: 24px;">Your request for the refund of the product below is rejected.</p>
<p  style="color: #898989; font-size: 14px; text-align: center; margin: 2px 0px 29px ; line-height: 24px;">Thank you for your patience.</p>
<div style="margin-bottom: 20px">
<img style="padding: 21px; width: 56px; height: 56px; background-color: #f1f1f1; border-radius: 4px;"src="{product_image}" alt=""/> </div>
<p style="font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 500; font-size: 16px; line-height: 21px; text-align: center; color: #2c2c2c;">{product_name}</p>
<div style="display: inline-flex; text-align: center; margin-top: 8px; margin-bottom: 45px;">
<p style="font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 500; font-size: 12px; line-height: 28px; color: #898989; text-align: center;">{vendor_name}</p>
<p style="font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 500; font-size: 12px; line-height: 28px; color: #898989; text-align: center; margin-left: 32px;">Qty: {product_qty}</p>
<p style="font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 500; font-size: 12px; line-height: 28px; color: #898989; text-align: center; margin-left: 32px;">{currency_symbol}{price}</p>
</div>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
<tr>
<td align="center" bgcolor="#ffffff">
<div>
<a href="{product_details_url}" aria-pressed="true" class="actives anchor-tag">
<span style="text-decoration: none; color: #2c2c2c"
>Check Details</span
><img style=" height: 13px; margin-left: 6px; align-items: center; text-align: center; width: 13px;" src="https://i.ibb.co/KbdnGPG/Group-9393.png" alt=""/> </a>
</div>
<p style="font-family: \'DM Sans\', sans-serif; margin: 44px 0px 0px ; font-style: normal; font-weight: 500; font-size: 14px; line-height: 24px; text-align: center; color: #898989;"> For further information, login to your account or call us: </p>
<span style="color:#2c2c2c ; margin: 0px 0px 25px ; font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 500; font-size: 14px; line-height: 24px; text-align:center;"> {contact_number}.</span>
<div>
<p style="font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 700; font-size: 18px; line-height: 21px; margin-top: 52px; text-align: center; text-transform: uppercase; color: #2c2c2c;"> Keep in touch</p>
</div>
<div style=" font-size: 14px; text-align: center; color: #898989;line-height: 22px; margin: 1px;">
<p style="margin-top: 12px">If you have any queries, concerns or suggestions,
</p>
<p style="margin: 0px; margin-top: 1px">please email us:
<span style="text-decoration: underline; cursor: pointer; color: #0060a9;">{support_mail}</span></p>
</div>
<div style="margin-top: 32px; margin-bottom: 31px">
<a class="anchor-tag" style=" margin-right: 9px; width: 32px; display: inline-block; " href="https://www.facebook.com/"><img src="https://i.ibb.co/fCZXxCC/Group-9380.png" alt="" /></a>
<a class="anchor-tag" style=" margin-right: 9px; width: 32px; display: inline-block;" href="https://twitter.com/?lang=en"><img src="https://i.ibb.co/ZLgzjS0/twitter.png" alt="" /></a>
<a class="anchor-tag" style=" margin-right: 9px; width: 32px;display: inline-block; " href="https://www.instagram.com/?hl=en"><img src="https://i.ibb.co/WKyFkYz/instagramm.png" alt=""
/></a>
<a class="anchor-tag" style=" margin-right: 9px; width: 32px; display: inline-block; " href="https://www.whatsapp.com/"><img src="https://i.ibb.co/6R7LWr1/watsapp.png" alt="" /></a>
<a class="anchor-tag" style=" margin-right: 9px; width: 32px; display: inline-block;" href="https://www.pioneer.eu/" ><img src="https://i.ibb.co/wYT6Tmg/pinterest.png" alt=""/></a>
<a class="anchor-tag" style=" margin-right: 9px; width: 32px; display: inline-block; " href="https://www.youtube.com/"><img src="https://i.ibb.co/RT7Zns1/youtube.png" alt=""/></a>
</div>
<p style="border-top: 1px solid #dfdfdf;margin: 1px 20px 0px 20px; " ></p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style=" max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500; margin-bottom: 200px; ">
<tr>
<td align="center" bgcolor="#ffffff">
<p style=" text-align: center; line-height: 16px; color: #898989; font-size: 12px; margin: 13px 0px; " > &copy 2022, {company_name}. All rights reserved.</p>
</td>
</tr>
</table>
</td>
</tr>
</table>
</body>
</html>
',
                'language_id' => 1,
                'status' => 'Active',
                'variables' => 'logo,company_name, user_name, product_name,product_qty,product_image,support_mail,price,currancy_symbol,product_details_url,contact_number',
            ],
            7 => [
                'id' => 9,
                'parent_id' => null,
                'name' => 'In Progress refund request',
                'slug' => 'in-progress-refund-request',
                'subject' => 'In-progress refund request',
                'body' => '<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta http-equiv="x-ua-compatible" content="ie=edge" />
<title>8.refund in progress</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<style type="text/css">
@media screen {
@font-face {
font-family: "DM Sans";
font-weight: 700;
src: url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriASitCBimCw.woff2)
format("woff2");
}
@font-face {
font-family: "DM Sans";
font-weight: 500;
font-style: normal;
src: url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriAWCrCBimCw.woff2)
format("woff2");
}
}
.bodys,
.tables,
td,
.anchor-tag a {
-ms-text-size-adjust: 100%;
-webkit-text-size-adjust: 100%;
}
.tables,
td {
mso-table-rspace: 0pt;
mso-table-lspace: 0pt;
}
.anchor-tag a {
padding: 1px;
margin: 1px;
}
.anchor-tag a[x-apple-data-detectors] {
font-family: inherit !important;
font-size: inherit !important;
font-weight: inherit !important;
line-height: inherit !important;
color: inherit !important;
text-decoration: none !important;
}
.bodys {
width: 100% !important;
height: 100% !important;
padding: 0 !important;
margin: 0 !important;
}
.tables {
border-collapse: collapse !important;
}
.logo-img {
margin: 26px 0px 19px 0px;
padding: 0px;
width: 207.98px;
height: 56px;
}
.actives {
box-sizing: border-box;
text-decoration: none;
-webkit-text-size-adjust: none;
text-align: center;
border-radius: 2px;
-webkit-border-radius: 2px;
-moz-border-radius: 2px;
-khtml-border-radius: 2px;
-o-border-radius: 2px;
-ms-border-radius: 2px;
padding: 10px 31px;
cursor: pointer;
background: #fcca19;
}
.anchor-tag a:focus,
.anchor-tag a:hover {
text-decoration: underline;
text-decoration-color: #fcca19;
}
.anchor-tag a:-webkit-any-link {
color: -webkit-link;
cursor: pointer;
text-decoration: underline;
text-decoration-color: #fcca19;
}
.anchor-tag a:-webkit-any-link {
color: -webkit-link;
cursor: pointer;
text-decoration: none;
text-decoration-color: #fcca19;
}
</style>
</head>
<body class="bodys" style="background-color: #e9ecef">
<div class="preheader" style="display: none; max-width: 0; max-height: 0; margin: 0px; overflow: hidden; color: #fff; opacity: 0;"></div>
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px">
<tr>
<td align="center" valign="top" style="padding: 36px 24px"></td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px; margin-top: 100px">
<tr>
<td align="center" bgcolor="#ffffff">
<img class="logo-img" src="{logo}" alt="logo"/>
<p style="border-top: 1px solid #dfdfdf; margin: 1px 20px 0px 20px;"></p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
<tr>
<td align="center" bgcolor="#fff">
<p style="font-family: \'DM Sans\', sans-serif; letter-spacing: 0.255em; text-transform: uppercase; margin: 26px 0px; line-height: 25px; font-size: 0.8em !important; color: rgb(44, 44, 44); font-weight: 500 !important; cursor: default !important;">Refund in progress</p>
<p style="margin: 0px;text-align: center; line-height: 24px; font-size: 16px; color: #2c2c2c;">Dear {user_name} </p>
<p  style="color: #898989; font-size: 14px; text-align: center;  margin: 7px 0px 0px ; line-height: 24px;">Your request for the refund of the product below is in progress.</p>
<p  style="color: #898989; font-size: 14px; text-align: center; margin: 2px 0px 29px ; line-height: 24px;">Thank you for your patience.</p>
<div style="margin-bottom: 20px">
<img style="padding: 21px; width: 56px; height: 56px; background-color: #f1f1f1; border-radius: 4px;"src="{product_image}" alt=""/> </div>
<p style="font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 500; font-size: 16px; line-height: 21px; text-align: center; color: #2c2c2c;">{product_name}</p>
<div style="display: inline-flex; text-align: center; margin-top: 8px; margin-bottom: 45px;">
<p style="font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 500; font-size: 12px; line-height: 28px; color: #898989; text-align: center;">{vendor_name}</p>
<p style="font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 500; font-size: 12px; line-height: 28px; color: #898989; text-align: center; margin-left: 32px;">Qty: {product_qty}</p>
<p style="font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 500; font-size: 12px; line-height: 28px; color: #898989; text-align: center; margin-left: 32px;">{currency_symbol}{price}</p>
</div>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
<tr>
<td align="center" bgcolor="#ffffff">
<div>
<a href="{product_details_url}" aria-pressed="true" class="actives anchor-tag">
<span style="text-decoration: none; color: #2c2c2c"
>Check Details</span
><img style=" height: 13px; margin-left: 6px; align-items: center; text-align: center; width: 13px;" src="https://i.ibb.co/KbdnGPG/Group-9393.png" alt=""/> </a>
</div>
<p style="font-family: \'DM Sans\', sans-serif; margin: 44px 0px 0px ; font-style: normal; font-weight: 500; font-size: 14px; line-height: 24px; text-align: center; color: #898989;"> For further information, login to your account or call us: </p>
<span style="color:#2c2c2c ; margin: 0px 0px 25px ; font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 500; font-size: 14px; line-height: 24px; text-align:center;"> {contact_number}.</span>
<div>
<p style="font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 700; font-size: 18px; line-height: 21px; margin-top: 52px; text-align: center; text-transform: uppercase; color: #2c2c2c;"> Keep in touch</p>
</div>
<div style=" font-size: 14px; text-align: center; color: #898989;line-height: 22px; margin: 1px;">
<p style="margin-top: 12px">If you have any queries, concerns or suggestions,
</p>
<p style="margin: 0px; margin-top: 1px">please email us:
<span style="text-decoration: underline; cursor: pointer; color: #0060a9;">{support_mail}</span></p>
</div>
<div style="margin-top: 32px; margin-bottom: 31px">
<a class="anchor-tag" style=" margin-right: 9px; width: 32px; display: inline-block; " href="https://www.facebook.com/"><img src="https://i.ibb.co/fCZXxCC/Group-9380.png" alt="" /></a>
<a class="anchor-tag" style=" margin-right: 9px; width: 32px; display: inline-block;" href="https://twitter.com/?lang=en"><img src="https://i.ibb.co/ZLgzjS0/twitter.png" alt="" /></a>
<a class="anchor-tag" style=" margin-right: 9px; width: 32px;display: inline-block; " href="https://www.instagram.com/?hl=en"><img src="https://i.ibb.co/WKyFkYz/instagramm.png" alt=""
/></a>
<a class="anchor-tag" style=" margin-right: 9px; width: 32px; display: inline-block; " href="https://www.whatsapp.com/"><img src="https://i.ibb.co/6R7LWr1/watsapp.png" alt="" /></a>
<a class="anchor-tag" style=" margin-right: 9px; width: 32px; display: inline-block;" href="https://www.pioneer.eu/" ><img src="https://i.ibb.co/wYT6Tmg/pinterest.png" alt=""/></a>
<a class="anchor-tag" style=" margin-right: 9px; width: 32px; display: inline-block; " href="https://www.youtube.com/"><img src="https://i.ibb.co/RT7Zns1/youtube.png" alt=""/></a>
</div>
<p style="border-top: 1px solid #dfdfdf;margin: 1px 20px 0px 20px; " ></p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style=" max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500; margin-bottom: 200px; ">
<tr>
<td align="center" bgcolor="#ffffff">
<p style=" text-align: center; line-height: 16px; color: #898989; font-size: 12px; margin: 13px 0px; " > &copy 2022, {company_name}. All rights reserved.</p>
</td>
</tr>
</table>
</td>
</tr>
</table>
</body>
</html>
',
                'language_id' => 1,
                'status' => 'Active',
                'variables' => 'logo,user_name,product_image,product_name,vendor_name,product_qty,currency_symbol,price,product_details_url,contact_number,support_mail,company_name',
            ],
            8 => [
                'id' => 10,
                'parent_id' => null,
                'name' => 'Subscriber',
                'slug' => 'subscriber',
                'subject' => 'Subscription for newsletter',
                'body' => '<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta http-equiv="x-ua-compatible" content="ie=edge" />
<title>4.Voucher</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<style type="text/css">
@media screen {
@font-face {
font-family: "DM Sans";
font-weight: 700;
src:   url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriASitCBimCw.woff2)
format("woff2");
}
@font-face {
font-family: "DM Sans";
font-weight: 500;
font-style: normal;
src: url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriAWCrCBimCw.woff2)
format("woff2");
}
@font-face {
font-family: \'DM Sans\';
font-style: normal;
font-weight: 400;
src: url(https://fonts.gstatic.com/s/dmsans/v11/rP2Hp2ywxg089UriCZOIHQ.woff2) format(\'woff2\');
}
}
.bodys,
.tables,
td,
.anchor-tag a {
-ms-text-size-adjust: 100%;
-webkit-text-size-adjust: 100%;
}
.tables,
td {
mso-table-rspace: 0pt;
mso-table-lspace: 0pt;
}
.anchor-tag a {
padding: 1px;
margin: 1px;
}
.anchor-tag a[x-apple-data-detectors] {
font-family: inherit !important;
font-size: inherit !important;
font-weight: inherit !important;
line-height: inherit !important;
color: inherit !important;
text-decoration: none !important;
}
.bodys {
width: 100% !important;
height: 100% !important;
padding: 0 !important;
margin: 0 !important;
}
.tables {
border-collapse: collapse !important;
}
.logo-img {
margin: 26px 0px 19px 0px;
padding: 0px;
width: 207.98px;
height: 56px;
}
.actives {
box-sizing: border-box;
text-decoration: none;
-webkit-text-size-adjust: none;
text-align: center;
border-radius: 2px;
-webkit-border-radius: 2px;
-moz-border-radius: 2px;
-khtml-border-radius: 2px;
-o-border-radius: 2px;
-ms-border-radius: 2px;
padding: 10px 31px;
cursor: pointer;
background: #fcca19;
}
.anchor-tag a:focus,
.anchor-tag a:hover {
text-decoration: underline;
text-decoration-color: #fcca19;
}
.anchor-tag a:-webkit-any-link {
color: -webkit-link;
cursor: pointer;
text-decoration: underline;
text-decoration-color: #fcca19;
}
.anchor-tag a:-webkit-any-link {
color: -webkit-link;
cursor: pointer;
text-decoration: none;
text-decoration-color: #fcca19;
}
.unsubscribe:hover {
color: #fff;
}
</style>
</head>
<body class="bodys" style="background-color: #e9ecef">
<div class="preheader" style="display: none; max-width: 0; max-height: 0; margin: 0px; overflow: hidden; color: #fff; opacity: 0;"></div>
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px">
<tr>
<td align="center" valign="top" style="padding: 36px 24px"></td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px; margin-top: 100px">
<tr>
<td align="center" bgcolor="#2c2c2c">
<img class="logo-img" src="{logo}" alt="logo" />
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
<tr>

</tr>
<tr>
<td align="center" bgcolor="#ffffff">
<p style="font-family: \'DM Sans\', sans-serif;font-style: normal;font-weight: 400;font-size: 15px;line-height: 25px;text-align: center; color: #2C2C2C; margin: 40px 72px 44px;">You’ve been added to our mailing list and will now be among the first to hear about new arrivals, big events and special offers.</p>
<div style="margin-bottom: 58px;">
<a href="{home_url}" aria-pressed="true" class="actives anchor-tag">
<span style="text-decoration: none; color: #2C2C2C;">Shop Now</span>
</a>
</div>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style=" max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
<tr>
<td align="center" bgcolor="#2c2c2c">
<div style="font-size: 14px; text-align: center; color: #ffffff; line-height: 22px; margin: 1px;">
<p style="margin-top: 30px"> If you have any queries, concerns or suggestions,</p>
<p style="margin: 0px; margin-top: 1px"> please email us:
<span style="text-decoration: underline; cursor: pointer; color: #FCCA19;">{support_mail}</span>
</p>
</div>
<div style=" margin-top: 32px;">
<a class="anchor-tag" style="margin-right: 9px; width: 32px; display: inline-block;" href="https://www.facebook.com/"><img src="https://i.ibb.co/9T1qkwM/white-facebook.png" alt=""/></a>
<a class="anchor-tag" style="margin-right: 9px; width: 32px; display: inline-block;" href="https://twitter.com/?lang=en"><img src="https://i.ibb.co/ZhPHPhp/white-twitter.png" alt=""/> </a>
<a class="anchor-tag" style="margin-right: 9px; width: 32px; display: inline-block;" href="https://www.instagram.com/?hl=en"><img src="https://i.ibb.co/Hnx1Cww/white-instagram.png" alt="" /></a>
<a class="anchor-tag" style="margin-right: 9px; width: 32px; display: inline-block;" href="https://www.whatsapp.com/"><img src="https://i.ibb.co/X7Fhw6Q/white-whatsapp.png" alt=""/></a>
<a class="anchor-tag" style="margin-right: 9px; width: 32px; display: inline-block;" href="https://www.pioneer.eu/"> <img style="margin: -2px;" src="https://i.ibb.co/KwXSt44/white-pinterest.png" alt="" /></a>
<a class="anchor-tag" style="margin-right: 9px; width: 32px; display: inline-block;"  href="https://www.youtube.com/"><img src="https://i.ibb.co/s9gY8Mt/white-youtube.png" alt=""/></a>
</div>
<div style=" margin-bottom:31px;">
<a href="{unsubscribe}" class="unsubscribe" style="margin-right: 9px; display: inline-block; margin-top: 10px;" >Unsubscribe</a>
</div>
<p style="border-top: 1px solid #464646; margin: 1px 20px 0px 20px;"></p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"style=" max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500; margin-bottom: 200px; ">
<tr>
<td align="center" bgcolor="#2c2c2c">
<p style="text-align: center; line-height: 16px; color: #898989; font-size: 12px; margin: 13px 0px;" > &copy 2022, {company_name}. All rights reserved.</p>
</td>
</tr>
</table>
</td>
</tr>
</table>
</body>
</html>
',
                'language_id' => 1,
                'status' => 'Active',
                'variables' => 'logo,company_name,supprot_mail, home_url,unsubscribe',
            ],
            9 => [
                'id' => 11,
                'parent_id' => null,
                'name' => 'Vendor Invoice',
                'slug' => 'vendor-invoice',
                'subject' => 'An Invoice # {invoice_reference_no} from {company_name} has been created.',
                'body' => '<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8" />
<meta http-equiv="x-ua-compatible" content="ie=edge" />
<title>3.Invoice</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<style type="text/css">
@media screen {
@font-face {
font-family: "DM Sans";
font-weight: 700;
src: url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriASitCBimCw.woff2) format("woff2");
}

@font-face {
font-family: "DM Sans";
font-weight: 500;
font-style: normal;
src: url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriAWCrCBimCw.woff2) format("woff2");
}

@font-face {
font-family: \'Roboto\';
font-style: normal;
font-weight: 500;
src: url(https://fonts.gstatic.com/s/roboto/v30/KFOlCnqEu92Fr1MmEU9fBBc4.woff2) format(\'woff2\');
unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
}
}

.bodys,
.tables,
td,
.anchor-tag a {
-ms-text-size-adjust: 100%;
-webkit-text-size-adjust: 100%;
}

.tables,
td {
mso-table-rspace: 0pt;
mso-table-lspace: 0pt;
}

.anchor-tag a {
padding: 1px;
margin: 1px;
}

.anchor-tag a[x-apple-data-detectors] {
font-family: inherit !important;
font-size: inherit !important;
font-weight: inherit !important;
line-height: inherit !important;
color: inherit !important;
text-decoration: none !important;
}

.bodys {
width: 100% !important;
height: 100% !important;
padding: 0 !important;
margin: 0 !important;
}

.tables {
border-collapse: collapse !important;
}

.logo-img {
margin: 26px 0px 19px 0px;
padding: 0px;
width: 207.98px;
height: 56px;
}

.actives {
box-sizing: border-box;
text-decoration: none;
-webkit-text-size-adjust: none;
text-align: center;
border-radius: 2px;
-webkit-border-radius: 2px;
-moz-border-radius: 2px;
-khtml-border-radius: 2px;
-o-border-radius: 2px;
-ms-border-radius: 2px;
padding: 10px 31px;
cursor: pointer;
background: #fcca19;
}

.anchor-tag a:focus,
.anchor-tag a:hover {
text-decoration: underline;
text-decoration-color: #fcca19;
}

.anchor-tag a:-webkit-any-link {
color: -webkit-link;
cursor: pointer;
text-decoration: underline;
text-decoration-color: #fcca19;
}

.anchor-tag a:-webkit-any-link {
color: -webkit-link;
cursor: pointer;
text-decoration: none;
text-decoration-color: #fcca19;
}
</style>
</head>

<body class="bodys" style="background-color: #e9ecef">
<div class="preheader"
style="display: none; max-width: 0; max-height: 0; margin: 0px; overflow: hidden; color: #fff; opacity: 0;">
</div>
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px">
<tr>
<td align="center" valign="top" style="padding: 36px 24px"></td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
style="max-width: 640px; margin-top: 100px">
<tr>
<td align="center" bgcolor="#ffffff">
<img class="logo-img" src="{logo}" alt="logo" />
<p style=" border-top: 1px solid #dfdfdf; margin: 1px 20px 0px 20px;"></p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
style=" max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
<tr>
<td align="center" bgcolor="#fff">
<p
style="font-family: \'DM Sans\', sans-serif; letter-spacing: 0.255em; text-transform: uppercase; margin: 28px 0px 20px 0px; line-height: 25px; font-size:14px !important; color: rgb(44, 44, 44); font-weight: 500 !important; cursor: default !important;">
Your Order is confirmed</p>
<p
style=" margin: 0px; font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 500; font-size: 14px; line-height: 28px; text-align: center; color: #2C2C2C;">
ORDER INVOICE</p>
<p style=" margin-top: 5px;font-family: \'DM Sans\', sans-serif;  font-style: normal; font-weight: 700;
font-size: 32px; line-height: 28px; text-align: center; color: #2C2C2C;">{order_number}
</p>
<p style="margin-top: 32px; padding:0px 30px 0px 37px; font-family: \'DM Sans\', sans-serif; text-align: left; font-style: normal; font-weight: 500; font-size: 14px; line-height: 24px; color: #898989;
"><span style=" color: #2C2C2C;">Dear {user_name},</span> your order placed on <span
style="color:#0060A9 ; text-decoration:underline; ">{company_url}</span> has been
confirmed on <span style=" color: #2C2C2C;">{order_confirm_date}.</span> Your order is
being prepared for delivery. To cancel your order or for further information, login to
your account or call us: <span style=" color: #2C2C2C;"> {contact_number}.</span></p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
style=" max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
<tr>
<td align="center" bgcolor="#ffffff">
<div style="margin: 29px 20px 0px 37px;">
<p
style="font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 700; font-size: 18px; margin-top: 2px; line-height: 28px; color: #2C2C2C; float: left; text-align: left; padding-top: 4px;">
ORDER DETAILS</p>
<a href="{order_details_url}" aria-pressed="true" class="actives anchor-tag"
style=" font-family: \'DM Sans\',sans-serif; font-style: normal; display:flex; font-weight: 700; float:right; font-size: 14px; line-height: 28px; color: #2C2C2C;">
Check Order<img
style="height: 13px; margin-top: 8px; margin-left: 6px; align-items: center; text-align: center; width:13px;"
src="https://i.ibb.co/KbdnGPG/Group-9393.png" alt=""></a>
</div>
<div style="clear: both;"></div>
<div style="margin:14px 20px;">
<table class="tables" id="customers" border="0" cellpadding="0" cellspacing="0"
width="100%" style="text-align: left;">
<tr style="align-items:left;">
<th style="padding-left: 18px;">Items</th>
<th>Seller</th>
<th style="padding-left:18px;">Qty</th>
<th>Price</th>
</tr>
<tr>
<td style="border-bottom: 1px solid #DFDFDF; width: 300px;">
<img style="width: 21px; height: 21px; padding: 10.5px; background-color: #F1F1F1; border-radius: 2px; margin-left: 18px; margin-top: 24px; margin-bottom: 24px;float:left"
src="{product_image}" alt="">
<div style="float:left; width: 220px; padding-bottom: 24px;">
<p
style="font-family:\'DM Sans\', sans-serif; font-style: normal; font-weight: 500; font-size: 14px; margin-left: 12px; line-height: 20px; color: #2C2C2C; margin-top: 27px;">
{product_name}</p>
<p
style="font-family: \'Roboto\', sans-serif; font-style: normal;font-weight: 500; font-size: 11px;line-height: 13px; color: #898989; margin-left: 12px; margin-top: 4px;">
{attributes}</p>
</div>
<div style="clear: both;"></div>
</td>
<td
style="font-family:\'DM Sans\', sans-serif; border-bottom: 1px solid #DFDFDF;font-style: normal; font-weight: 500; font-size: 11px; width: 100px; padding-top: 5px; line-height: 16px; color: #2C2C2C;">
{vendor_name}</td>
<td
style="font-family:\'DM Sans\', sans-serif; border-bottom: 1px solid #DFDFDF; font-style: normal; padding-left: 24px; font-weight: 500; font-size: 14px; line-height: 18px; text-align: left;  margin-left: 10px; color: #2C2C2C; padding-top: 4px;">
{product_qty}</td>
<td
style=" font-family:\'DM Sans\', sans-serif;  border-bottom: 1px solid #DFDFDF; font-style: normal; margin-left: 10px;  padding-top: 4px; font-weight: 500;font-size: 14px;line-height: 18px;color: #2C2C2C;">
{currency_symbol}{product_price}</td>
</tr>
<tr>
<td></td>
<td
style="font-family:\'DM Sans\', sans-serif; border-bottom: 1px solid #DFDFDF; font-style: normal; font-weight: 500; font-size: 14px; line-height: 18px; color: #898989;">
<p style="margin: 1px; padding-top:24px;">Subtotal </p>
<p style="margin: 1px;padding:16px 0px;">Shipping </p>
</td>
<td style="border-bottom: 1px solid #DFDFDF;">
</td>
<td
style="font-family:\'DM Sans\', sans-serif;  border-bottom: 1px solid #DFDFDF; font-style: normal; font-weight: 500; font-size: 14px; line-height: 18px; color: #898989;">
<p style="margin: 0; padding-top:24px; margin-top:1px;">
{currency_symbol}{subtotal}</p>
<p style="margin: 0;padding:16px 0px; margin-top:1px;">
{currency_symbol}{shipping_charge}</p>
</td>
</tr>
<tr>
<td></td>
<td
style="font-family: \'DM Sans\', sans-serif; font-style: normal;font-weight:500; font-size: 14px;line-height: 18px; padding-top: 16px; color: #2C2C2C;">
Grand Total</td>
<td></td>
<td
style="font-family: \'DM Sans\', sans-serif; font-style:normal; font-weight:500; font-size: 14px;line-height: 18px; padding-top: 16px; color: #2C2C2C;">
{currency_symbol}{grand_total}</td>
</tr>
</table>
</div>
<div style="margin:30px 20px; background-color: #F3F3F3; border-radius: 4px;">
<div>
<p
style="font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 700; font-size: 18px; line-height: 28px; padding: 20px 14px 11px 14px ; text-align: left; padding-left:14px; margin-right:14px;color: #2C2C2C; margin-top: 1px;">
CUSTOMER DETAILS</p>
<p
style="border-bottom: 1px solid #DFDFDF; margin-left:14px; margin-top:1px; margin-right:14px;">
</p>
</div>
<div style="display:flex;">
<div style="margin-right:50px">
<p
style="font-family:\'DM Sans\', sans-serif; font-style: normal; font-weight: 700; font-size: 16px; line-height: 28px; padding: 20px 14px 0px 14px ; text-align: left; padding-left:14px; margin-right:14px;color: #2C2C2C; margin-top: 1px;">
SHIPPING ADDRESS</p>
<p
style="font-family:\'DM Sans\', sans-serif; font-style: normal; font-weight: 400; font-size: 14px; line-height: 24px;color: #2C2C2C; padding: 5px 0px 43px 14px; text-align: left; width: 200px; margin-top: 1px; width: 200px;">
{shipping_address}
</p>
</div>
<div style="padding-bottom: 24px; margin-left: 20px;">
<p
style="font-family:\'DM Sans\', sans-serif; font-style: normal; font-weight: 700; font-size: 16px; line-height: 28px; padding: 20px 14px 0px 14px ; text-align: left; padding-left:14px; margin-right:14px;color:#2C2C2C; margin-top: 1px;">
ESTIMATED DELIVERY TIME</p>
<p
style="font-family:\'DM Sans\', sans-serif; font-style: normal; font-weight: 400; font-size: 14px; line-height: 24px; color: #2C2C2C; padding: 5px 0px 0px 14px; text-align: left; margin-top: 1px;">
{estimated_delivery_time} Office Days</p>
<p
style="font-family:\'DM Sans\', sans-serif; font-style: normal; font-weight: 700; font-size: 16px; line-height: 28px; padding: 26px 14px 0px 14px ; text-align: left; margin-right:14px;color: #2C2C2C; margin-top: 1px;">
PAYMENT</p>
<p
style="font-family:\'DM Sans\', sans-serif; font-style: normal; font-weight: 400; font-size: 14px; line-height: 24px; color: #2C2C2C; padding: 5px 0px 0px 14px; text-align: left; margin-top: 1px;">
{payment_method}</p>
</div>
</div>
</div>
<div>
<p
style="font-family:\'DM Sans\', sans-serif; font-style: normal; font-weight: 700; font-size: 18px;line-height: 21px; margin-top:1px ;text-align:center; text-transform: uppercase; color: #2C2C2C;">
Keep in touch</p>
</div>
<div
style="margin-top: 1px; font-size: 14px; text-align: center; color: #898989; line-height: 22px; margin: 1px;">
<p style="margin-top:14px"> If you have any queries, concerns or suggestions,</p>
<p style="margin:0px; margin-top:1px"> please email us: <span
style="cursor: pointer; color: #0060A9; text-decoration: underline;">{support_mail}</span>
</p>
</div>
<div style="margin-top: 25px; margin-bottom:14px;">
<a class="anchor-tag"
style="margin-right: 9px; width: 32px; height:32px; display: inline-block;"
href="https://www.facebook.com/"><img src="https://i.ibb.co/fCZXxCC/Group-9380.png"
alt="" /></a>
<a class="anchor-tag"
style="margin-right: 9px; width: 32px; height:32px; display: inline-block;"
href="https://twitter.com/?lang=en"><img src="https://i.ibb.co/ZLgzjS0/twitter.png"
alt="" /></a>
<a class="anchor-tag"
style="margin-right: 9px; width: 32px; height:32px; display: inline-block;"
href="https://www.instagram.com/?hl=en"><img
src="https://i.ibb.co/WKyFkYz/instagramm.png" alt="" /></a>
<a class="anchor-tag"
style="margin-right: 9px; width: 32px; height:32px; display: inline-block;"
href="https://www.whatsapp.com/"><img src="https://i.ibb.co/6R7LWr1/watsapp.png"
alt="" /></a>
<a class="anchor-tag"
style="margin-right: 9px; width: 32px; height:32px; display: inline-block;"
href="https://www.pioneer.eu/"> <img style="margin: -2px;"
src="https://i.ibb.co/wYT6Tmg/pinterest.png" alt="" /></a>
<a class="anchor-tag"
style="margin-right: 9px; width: 32px; height:32px; display: inline-block;"
href="https://www.youtube.com/"><img style="margin: 1px;"
src="https://i.ibb.co/RT7Zns1/youtube.png" alt="" /></a>
</div>
<p style="border-top: 1px solid #dfdfdf; margin: 1px 20px 0px 20px;"></p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500; margin-bottom: 200px;">
<tr>
<td align="center" bgcolor="#ffffff">
<p
style="text-align: center; line-height: 16px; color: #898989; font-size: 12px; margin: 13px 0px;">
&copy 2022, {company_name}. All rights reserved.</p>
</td>
</tr>
</table>
</td>
</tr>
</table>
</body>

</html>',
                'language_id' => 1,
                'status' => 'Active',
                'variables' => 'logo,order_number,user_name,company_url,order_confirm_date,contact_number,order_details_url,product_image,product_name,attributes,vendor_name,vendor_name,currency_symbol,product_price,subtotal,shipping_charge,grand_total,shipping_address,estimated_delivery_time,payment_method,support_mail,company_name',
            ],
            10 => [
                'id' => 13,
                'parent_id' => null,
                'name' => 'Ticket Department',
                'slug' => 'ticket-department',
                'subject' => '{ticket_subject} #Ticket ID: {ticket_no}',
                'body' => '<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta http-equiv="x-ua-compatible" content="ie=edge" />
<title>Ticket-template-design</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<style type="text/css">
@media screen {
@font-face {
font-family: "DM Sans";
font-weight: 700;
src:   url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriASitCBimCw.woff2)
format("woff2");
}
@font-face {
font-family: "DM Sans";
font-weight: 500;
font-style: normal;
src: url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriAWCrCBimCw.woff2)
format("woff2");
}
}
.bodys,
.tables,
td,
.anchor-tag a {
-ms-text-size-adjust: 100%;
-webkit-text-size-adjust: 100%;
}
.tables,
td {
mso-table-rspace: 0pt;
mso-table-lspace: 0pt;
}
.anchor-tag a {
padding: 1px;
margin: 1px;
}
.anchor-tag a[x-apple-data-detectors] {
font-family: inherit !important;
font-size: inherit !important;
font-weight: inherit !important;
line-height: inherit !important;
color: inherit !important;
text-decoration: none !important;
}
.bodys {
width: 100% !important;
height: 100% !important;
padding: 0 !important;
margin: 0 !important;
}
.tables {
border-collapse: collapse !important;
}
.logo-img {
margin: 26px 0px 19px 0px;
padding: 0px;
width: 207.98px;
height: 56px;
}
.actives {
box-sizing: border-box;
text-decoration: none;
-webkit-text-size-adjust: none;
text-align: center;
border-radius: 2px;
-webkit-border-radius: 2px;
-moz-border-radius: 2px;
-khtml-border-radius: 2px;
-o-border-radius: 2px;
-ms-border-radius: 2px;
padding: 10px 38px;
cursor: pointer;
background: #fcca19;
}
.anchor-tag a:focus,
.anchor-tag a:hover {
text-decoration: underline;
text-decoration-color: #fcca19;
}
.anchor-tag a:-webkit-any-link {
color: -webkit-link;
cursor: pointer;
text-decoration: underline;
text-decoration-color: #fcca19;
}
.anchor-tag a:-webkit-any-link {
color: -webkit-link;
cursor: pointer;
text-decoration: none;
text-decoration-color: #fcca19;
}
</style>
</head>
<body class="bodys" style="background-color: #e9ecef">
<div class="preheader" style="display: none; max-width: 0; max-height: 0; margin: 0px; overflow: hidden; color: #fff; opacity: 0;"></div>
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px">
<tr>
<td align="center" valign="top" style="padding: 36px 24px"></td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px; margin-top: 100px">
<tr>
<td align="center" bgcolor="#ffffff">
<img class="logo-img" src="{logo}" alt="logo" />
<p style="border-top: 1px solid #dfdfdf; margin: 1px 20px 0px 20px;"></p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
<tr>
<td align="center" bgcolor="#fff">
<p style="font-family: \'DM Sans\', sans-serif; letter-spacing: 0.255em; text-transform: uppercase; margin: 26px 0px; line-height: 25px;
font-size:0.80em!important; color: rgb(44, 44, 44); font-weight: 500 !important; cursor: default !important;">Ticket Module</p>
<p style="margin: 0px; text-align: center; line-height: 24px; font-size: 16px; color: #2c2c2c;" > Hello {member_name}</p>
<p style="margin: 0px; color: #898989; font-size: 14px; margin: 7px 54px 0px; text-align: center; line-height: 24px;">A new support ticket has been assigned.
</p>
<div style="background-color: #F3F3F3; border-radius:4px ; margin: 25px 78px">
<p style="font-family: \'DM Sans\', sans-serif; font-style: italic; font-weight: 500; font-size: 13px; line-height: 24px;text-align: center; color: #2C2C2C; padding: 24px 26px;">‘{ticket_message}’</p>
</div>
<div style="margin: 20px 78px 58px; background: #FFFFFF; border: 1px solid #DFDFDF; border-radius: 4px; display: flex;padding: 16px;">
<div style=" margin-right:60px; text-align: left;">
<p style="font-family: \'DM Sans\', sans-serif;font-style: normal; font-weight: 500; font-size: 13px;line-height: 17px; color:#898989; word-break: break-all;"><span style="color: #2c2c2c; padding-right: 2px;">Ticket ID:</span>{ticket_no}</p>
<p style="font-family: \'DM Sans\', sans-serif;font-style: normal; font-weight: 500; font-size: 13px;line-height: 17px; color:#898989; word-break: break-all;"><span style="color: #2c2c2c; padding-right: 2px;">Project Name:</span>{project_name}</p>
</div>
<div class=" text-align: left;">
<p style="font-family: \'DM Sans\', sans-serif;font-style: normal; font-weight: 500; font-size: 13px;line-height: 17px; color:#898989; text-align: left; word-break: break-all;"><span style="color: #2c2c2c; padding-right: 2px;">Subject:</span>{ticket_subject}</p>
<p style="font-family: \'DM Sans\', sans-serif;font-style: normal;  text-align: left; font-weight: 500; margin-bottom: 0px; font-size: 13px; line-height: 17px; color:#898989; word-break: break-all;"><span style="color: #2c2c2c; padding-right: 2px;">Status:</span>{ticket_status}</p>
</div>
</div>

</td>

</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style=" max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
<tr>
<td align="center" bgcolor="#ffffff">
<div>
<a href="{details}" aria-pressed="true" class="actives anchor-tag">
<span style="text-decoration: none; color: #2C2C2C;">View Tickets</span>
</a>
</div>
<p style="font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 500; font-size: 13px; line-height: 17px; text-align: center; color: #2C2C2C; margin-top: 62px;">Thank You,</p>
<p style="font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 500;padding-top: 2px; font-size: 13px;line-height: 17px; text-align: center;color: #898989;margin:0; margin-top: 12px; margin-bottom: 20px;">{customer_name}</p>
<p style="border-top: 1px solid #dfdfdf; margin: 1px 20px 0px 20px;"></p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"style=" max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500; margin-bottom: 200px; ">
<tr>
<td align="center" bgcolor="#ffffff">
<p style="text-align: center; line-height: 16px; color: #898989; font-size: 12px; margin: 13px 0px;" > &copy 2022, {company_name}. All rights reserved.</p>
</td>
</tr>
</table>
</td>
</tr>
</table>
</body>
</html>
',
                'language_id' => 1,
                'status' => 'Active',
                'variables' => 'ticket_subject,ticket_no,customer_name,ticket_message,company_name,details,ticket_status,logo',
            ],
            11 => [
                'id' => 14,
                'parent_id' => null,
                'name' => 'Ticket Vendor',
                'slug' => 'ticket-vendor',
                'subject' => '{ticket_subject} #Ticket ID: {ticket_no}',
                'body' => '<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta http-equiv="x-ua-compatible" content="ie=edge" />
<title>Ticket-template-design</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<style type="text/css">
@media screen {
@font-face {
font-family: "DM Sans";
font-weight: 700;
src:   url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriASitCBimCw.woff2)
format("woff2");
}
@font-face {
font-family: "DM Sans";
font-weight: 500;
font-style: normal;
src: url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriAWCrCBimCw.woff2)
format("woff2");
}
}
.bodys,
.tables,
td,
.anchor-tag a {
-ms-text-size-adjust: 100%;
-webkit-text-size-adjust: 100%;
}
.tables,
td {
mso-table-rspace: 0pt;
mso-table-lspace: 0pt;
}
.anchor-tag a {
padding: 1px;
margin: 1px;
}
.anchor-tag a[x-apple-data-detectors] {
font-family: inherit !important;
font-size: inherit !important;
font-weight: inherit !important;
line-height: inherit !important;
color: inherit !important;
text-decoration: none !important;
}
.bodys {
width: 100% !important;
height: 100% !important;
padding: 0 !important;
margin: 0 !important;
}
.tables {
border-collapse: collapse !important;
}
.logo-img {
margin: 26px 0px 19px 0px;
padding: 0px;
width: 207.98px;
height: 56px;
}
.actives {
box-sizing: border-box;
text-decoration: none;
-webkit-text-size-adjust: none;
text-align: center;
border-radius: 2px;
-webkit-border-radius: 2px;
-moz-border-radius: 2px;
-khtml-border-radius: 2px;
-o-border-radius: 2px;
-ms-border-radius: 2px;
padding: 10px 38px;
cursor: pointer;
background: #fcca19;
}
.anchor-tag a:focus,
.anchor-tag a:hover {
text-decoration: underline;
text-decoration-color: #fcca19;
}
.anchor-tag a:-webkit-any-link {
color: -webkit-link;
cursor: pointer;
text-decoration: underline;
text-decoration-color: #fcca19;
}
.anchor-tag a:-webkit-any-link {
color: -webkit-link;
cursor: pointer;
text-decoration: none;
text-decoration-color: #fcca19;
}
</style>
</head>
<body class="bodys" style="background-color: #e9ecef">
<div class="preheader" style="display: none; max-width: 0; max-height: 0; margin: 0px; overflow: hidden; color: #fff; opacity: 0;"></div>
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px">
<tr>
<td align="center" valign="top" style="padding: 36px 24px"></td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px; margin-top: 100px">
<tr>
<td align="center" bgcolor="#ffffff">
<img class="logo-img" src="{logo}" alt="logo" />
<p style="border-top: 1px solid #dfdfdf; margin: 1px 20px 0px 20px;"></p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
<tr>
<td align="center" bgcolor="#fff">
<p style="font-family: \'DM Sans\', sans-serif; letter-spacing: 0.255em; text-transform: uppercase; margin: 26px 0px; line-height: 25px;
font-size:0.80em!important; color: rgb(44, 44, 44); font-weight: 500 !important; cursor: default !important;">Ticket Module</p>
<p style="margin: 0px; text-align: center; line-height: 24px; font-size: 16px; color: #2c2c2c;" > Hello {assignee_name}</p>
<p style="margin: 0px; color: #898989; font-size: 14px; margin: 7px 54px 0px; text-align: center; line-height: 24px;">A new support ticket has been assigned to you.
</p>
<div style="background-color: #F3F3F3; border-radius:4px ; margin: 25px 78px">
<p style="font-family: \'DM Sans\', sans-serif; font-style: italic; font-weight: 500; font-size: 13px; line-height: 24px;text-align: center; color: #2C2C2C; padding: 24px 26px;">‘{ticket_message}’</p>
</div>
<div style="margin: 20px 78px 58px; background: #FFFFFF; border: 1px solid #DFDFDF; border-radius: 4px; display: flex;padding: 16px;">
<div style=" margin-right:60px; text-align: left;">
<p style="font-family: \'DM Sans\', sans-serif;font-style: normal; font-weight: 500; font-size: 13px;line-height: 17px; color:#898989; word-break: break-all;"><span style="color: #2c2c2c; padding-right: 2px;">Ticket ID:</span>{ticket_no}</p>
<p style="font-family: \'DM Sans\', sans-serif;font-style: normal; font-weight: 500; font-size: 13px;line-height: 17px; color:#898989; word-break: break-all;margin-bottom: 0px;"><span style="color: #2c2c2c; padding-right: 2px;">Status:</span>{ticket_status}</p>
</div>
<div class=" text-align: left;">
<p style="font-family: \'DM Sans\', sans-serif;font-style: normal; font-weight: 500; font-size: 13px;line-height: 17px; color:#898989; text-align: left; word-break: break-all;"><span style="color: #2c2c2c; padding-right: 2px;">Customer ID:</span>{customer_id}</p>
<p style="font-family: \'DM Sans\', sans-serif;font-style: normal;  text-align: left; font-weight: 500; margin-bottom: 0px; font-size: 13px; line-height: 17px; color:#898989; word-break: break-all;"><span style="color: #2c2c2c; padding-right: 2px;">Subject:</span>{ticket_subject}</p>
</div>
</div>

</td>

</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style=" max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
<tr>
<td align="center" bgcolor="#ffffff">
<div>
<a href="{details}" aria-pressed="true" class="actives anchor-tag">
<span style="text-decoration: none; color: #2C2C2C;">View Tickets</span>
</a>
</div>
<p style="font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 500; font-size: 13px; line-height: 17px; text-align: center; color: #2C2C2C; margin-top: 62px;">Thank You,</p>
<p style="font-family: \'DM Sans\', sans-serif; font-style: normal; margin:0; font-weight: 500; font-size: 13px;line-height: 17px; text-align: center;color: #898989;">{assigned_by_whom}</p>
<p style="font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 500;padding-top: 2px; font-size: 13px;line-height: 17px; text-align: center;color: #898989;margin:0; margin-top: 12px; margin-bottom: 20px;">{company_name}</p>
<p style="border-top: 1px solid #dfdfdf; margin: 1px 20px 0px 20px;"></p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"style=" max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500; margin-bottom: 200px; ">
<tr>
<td align="center" bgcolor="#ffffff">
<p style="text-align: center; line-height: 16px; color: #898989; font-size: 12px; margin: 13px 0px;" > &copy 2022, {company_name}. All rights reserved.</p>
</td>
</tr>
</table>
</td>
</tr>
</table>
</body>
</html>
',
                'language_id' => 1,
                'status' => 'Active',
                'variables' => 'company_name, email, company_url, ticket_message, ticket_subject, ticket_status,ticket_no,assignee_name,assigned_by_whom,logo',
            ],
            12 => [
                'id' => 15,
                'parent_id' => null,
                'name' => 'Ticket Assignee',
                'slug' => 'ticket-assignee',
                'subject' => '{ticket_subject} #Ticket ID: {ticket_no}',
                'body' => '<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8" />
<meta http-equiv="x-ua-compatible" content="ie=edge" />
<title>Ticket-template-design</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<style type="text/css">
@media screen {
@font-face {
font-family: "DM Sans";
font-weight: 700;
src: url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriASitCBimCw.woff2) format("woff2");
}

@font-face {
font-family: "DM Sans";
font-weight: 500;
font-style: normal;
src: url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriAWCrCBimCw.woff2) format("woff2");
}
}

.bodys,
.tables,
td,
.anchor-tag a {
-ms-text-size-adjust: 100%;
-webkit-text-size-adjust: 100%;
}

.tables,
td {
mso-table-rspace: 0pt;
mso-table-lspace: 0pt;
}

.anchor-tag a {
padding: 1px;
margin: 1px;
}

.anchor-tag a[x-apple-data-detectors] {
font-family: inherit !important;
font-size: inherit !important;
font-weight: inherit !important;
line-height: inherit !important;
color: inherit !important;
text-decoration: none !important;
}

.bodys {
width: 100% !important;
height: 100% !important;
padding: 0 !important;
margin: 0 !important;
}

.tables {
border-collapse: collapse !important;
}

.logo-img {
margin: 26px 0px 19px 0px;
padding: 0px;
width: 207.98px;
height: 56px;
}

.actives {
box-sizing: border-box;
text-decoration: none;
-webkit-text-size-adjust: none;
text-align: center;
border-radius: 2px;
-webkit-border-radius: 2px;
-moz-border-radius: 2px;
-khtml-border-radius: 2px;
-o-border-radius: 2px;
-ms-border-radius: 2px;
padding: 10px 38px;
cursor: pointer;
background: #fcca19;
}

.anchor-tag a:focus,
.anchor-tag a:hover {
text-decoration: underline;
text-decoration-color: #fcca19;
}

.anchor-tag a:-webkit-any-link {
color: -webkit-link;
cursor: pointer;
text-decoration: underline;
text-decoration-color: #fcca19;
}

.anchor-tag a:-webkit-any-link {
color: -webkit-link;
cursor: pointer;
text-decoration: none;
text-decoration-color: #fcca19;
}
</style>
</head>

<body class="bodys" style="background-color: #e9ecef">
<div class="preheader"
style="display: none; max-width: 0; max-height: 0; margin: 0px; overflow: hidden; color: #fff; opacity: 0;">
</div>
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px">
<tr>
<td align="center" valign="top" style="padding: 36px 24px"></td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
style="max-width: 640px; margin-top: 100px">
<tr>
<td align="center" bgcolor="#ffffff">
<img class="logo-img" src="{logo}" alt="logo" />
<p style="border-top: 1px solid #dfdfdf; margin: 1px 20px 0px 20px;"></p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
<tr>
<td align="center" bgcolor="#fff">
<p style="font-family: \'DM Sans\', sans-serif; letter-spacing: 0.255em; text-transform: uppercase; margin: 26px 0px; line-height: 25px;
font-size:0.80em!important; color: rgb(44, 44, 44); font-weight: 500 !important; cursor: default !important;">Ticket
Module</p>
<p
style="margin: 0px; text-align: center; line-height: 24px; font-size: 16px; color: #2c2c2c;">
Hello {assignee_name}</p>
<p
style="margin: 0px; color: #898989; font-size: 14px; margin: 7px 54px 0px; text-align: center; line-height: 24px;">
A new support ticket has been assigned to you.
</p>
<div style="background-color: #F3F3F3; border-radius:4px ; margin: 25px 78px">
<p
style="font-family: \'DM Sans\', sans-serif; font-style: italic; font-weight: 500; font-size: 13px; line-height: 24px;text-align: center; color: #2C2C2C; padding: 24px 26px;">
‘{ticket_message}’</p>
</div>
<div
style="margin: 20px 78px 58px; background: #FFFFFF; border: 1px solid #DFDFDF; border-radius: 4px; display: flex;padding: 16px;">
<div style=" margin-right:60px; text-align: left;">
<p
style="font-family: \'DM Sans\', sans-serif;font-style: normal; font-weight: 500; font-size: 13px;line-height: 17px; color:#898989; word-break: break-all;">
<span style="color: #2c2c2c; padding-right: 2px;">Ticket ID:</span>{ticket_no}
</p>
<p
style="font-family: \'DM Sans\', sans-serif;font-style: normal; font-weight: 500; font-size: 13px;line-height: 17px; color:#898989; word-break: break-all;margin-bottom: 0px;">
<span style="color: #2c2c2c; padding-right: 2px;">Status:</span>{ticket_status}
</p>
</div>
<div class=" text-align: left;">
<p
style="font-family: \'DM Sans\', sans-serif;font-style: normal; font-weight: 500; font-size: 13px;line-height: 17px; color:#898989; text-align: left; word-break: break-all;">
<span style="color: #2c2c2c; padding-right: 2px;">Customer
ID:</span>{customer_id}
</p>
<p
style="font-family: \'DM Sans\', sans-serif;font-style: normal;  text-align: left; font-weight: 500; margin-bottom: 0px; font-size: 13px; line-height: 17px; color:#898989; word-break: break-all;">
<span
style="color: #2c2c2c; padding-right: 2px;">Subject:</span>{ticket_subject}
</p>
</div>
</div>

</td>

</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
style=" max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
<tr>
<td align="center" bgcolor="#ffffff">
<div>
<a href="{details}" aria-pressed="true" class="actives anchor-tag">
<span style="text-decoration: none; color: #2C2C2C;">View Tickets</span>
</a>
</div>
<p
style="font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 500; font-size: 13px; line-height: 17px; text-align: center; color: #2C2C2C; margin-top: 62px;">
Thank You,</p>
<p
style="font-family: \'DM Sans\', sans-serif; font-style: normal; margin:0; font-weight: 500; font-size: 13px;line-height: 17px; text-align: center;color: #898989;">
{assigned_by_whom}</p>
<p
style="font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 500;padding-top: 2px; font-size: 13px;line-height: 17px; text-align: center;color: #898989;margin:0; margin-top: 12px; margin-bottom: 20px;">
{company_name}</p>
<p style="border-top: 1px solid #dfdfdf; margin: 1px 20px 0px 20px;"></p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
style=" max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500; margin-bottom: 200px; ">
<tr>
<td align="center" bgcolor="#ffffff">
<p
style="text-align: center; line-height: 16px; color: #898989; font-size: 12px; margin: 13px 0px;">
&copy 2022, {company_name}. All rights reserved.</p>
</td>
</tr>
</table>
</td>
</tr>
</table>
</body>

</html>',
                'language_id' => 1,
                'status' => 'Active',
                'variables' => 'ticket_subject,ticket_no,customer_name,ticket_message,company_name,details,ticket_status,logo,project_name,logo',
            ],
            13 => [
                'id' => 16,
                'parent_id' => null,
                'name' => 'Admin accepted seller request',
                'slug' => 'admin-accepted-seller-request',
                'subject' => 'Seller request accepted',
                'body' => '<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8" />
<meta http-equiv="x-ua-compatible" content="ie=edge" />
<title>10.NEW COUPON ADDED</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<style type="text/css">
@media screen {
@font-face {
font-family: "DM Sans";
font-weight: 700;
src: url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriASitCBimCw.woff2) format("woff2");
}

@font-face {
font-family: "DM Sans";
font-weight: 500;
font-style: normal;
src: url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriAWCrCBimCw.woff2) format("woff2");
}
}

.bodys,
.tables,
td,
.anchor-tag a {
-ms-text-size-adjust: 100%;
-webkit-text-size-adjust: 100%;
}

.tables,
td {
mso-table-rspace: 0pt;
mso-table-lspace: 0pt;
}

.anchor-tag a {
padding: 1px;
margin: 1px;
}

.anchor-tag a[x-apple-data-detectors] {
font-family: inherit !important;
font-size: inherit !important;
font-weight: inherit !important;
line-height: inherit !important;
color: inherit !important;
text-decoration: none !important;
}

.bodys {
width: 100% !important;
height: 100% !important;
padding: 0 !important;
margin: 0 !important;
}

.tables {
border-collapse: collapse !important;
}

.logo-img {
margin: 26px 0px 19px 0px;
padding: 0px;
width: 207.98px;
height: 56px;
}

.anchor-tag a:focus,
.anchor-tag a:hover {
text-decoration: underline;
text-decoration-color: #fcca19;
}

.anchor-tag a:-webkit-any-link {
color: -webkit-link;
cursor: pointer;
text-decoration: underline;
text-decoration-color: #fcca19;
}

.anchor-tag a:-webkit-any-link {
color: -webkit-link;
cursor: pointer;
text-decoration: none;
text-decoration-color: #fcca19;
}
</style>
</head>

<body class="bodys" style="background-color: #e9ecef">
<div class="preheader"
style="display: none; max-width: 0; max-height: 0; margin: 0px; overflow: hidden; color: #fff; opacity: 0;"></div>
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px">
<tr>
<td align="center" valign="top" style="padding: 36px 24px"></td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
style="max-width: 640px; margin-top: 100px">
<tr>
<td align="center" bgcolor="#ffffff">
<img class="logo-img" src="{logo}" alt="logo" />
<p style="border-top: 1px solid #dfdfdf; margin: 1px 20px 0px 20px;"></p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
<tr>
<td align="center" bgcolor="#fff">
<p style="font-family: \'DM Sans\', sans-serif; letter-spacing: 0.255em; text-transform: uppercase; margin: 26px 0px;
line-height: 25px; font-size: 0.8em !important; color: rgb(44, 44, 44); font-weight: 500 !important;
cursor: default !important;"></p>
<p style="margin: 0px;text-align: center; line-height: 24px; font-size: 16px;
color: #2c2c2c;"> Dear {user_name} </p>
<p style=" margin: 0px; color: #898989; font-size: 14px; margin: 3px 50px 31px;
text-align: center; line-height: 24px;">Your status has been changed by the admin of {company_name},
please login to the <a href="{company_url}"
style="text-decoration: underline; cursor: pointer; color: #0060a9;">portal</a> to see the details of
your
account.</p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
<tr>
<td align="center" bgcolor="#ffffff">
<div>
<p style=" font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 700;
font-size: 18px; line-height: 21px; margin-top: 37px; text-align: center;
text-transform: uppercase; color: #2c2c2c;"> Keep in touch</p>
</div>
<div style=" font-size: 14px; text-align: center; color: #898989;line-height: 22px; margin: 1px;">
<div style=" font-size: 14px; text-align: center; color: #898989;line-height: 22px; margin: 1px;">
<p style="margin-top: 14px">If you have any queries, concerns or suggestions,
</p>
<p style="margin: 0px; margin-top: 1px">please email us:
<span style="text-decoration: underline; cursor: pointer; color: #0060a9;">{support_mail}</span>
</p>
</div>
</div>
<div style="margin-top: 32px; margin-bottom: 31px">
<a class="anchor-tag" style=" margin-right: 9px; width: 32px; display: inline-block; "
href="https://www.facebook.com/"><img src="https://i.ibb.co/fCZXxCC/Group-9380.png" alt="" /></a>
<a class="anchor-tag" style=" margin-right: 9px; width: 32px; display: inline-block;"
href="https://twitter.com/?lang=en"><img src="https://i.ibb.co/ZLgzjS0/twitter.png" alt="" /></a>
<a class="anchor-tag" style=" margin-right: 9px; width: 32px;display: inline-block; "
href="https://www.instagram.com/?hl=en"><img src="https://i.ibb.co/WKyFkYz/instagramm.png"
alt="" /></a>
<a class="anchor-tag" style=" margin-right: 9px; width: 32px; display: inline-block; "
href="https://www.whatsapp.com/"><img src="https://i.ibb.co/6R7LWr1/watsapp.png" alt="" /></a>
<a class="anchor-tag" style=" margin-right: 9px; width: 32px; display: inline-block;"
href="https://www.pioneer.eu/"><img src="https://i.ibb.co/wYT6Tmg/pinterest.png" alt="" /></a>
<a class="anchor-tag" style=" margin-right: 9px; width: 32px; display: inline-block; "
href="https://www.youtube.com/"><img src="https://i.ibb.co/RT7Zns1/youtube.png" alt="" /></a>
</div>
<p style="border-top: 1px solid #dfdfdf;margin: 1px 20px 0px 20px; "></p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
style=" max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500; margin-bottom: 200px; ">
<tr>
<td align="center" bgcolor="#ffffff">
<p style=" text-align: center; line-height: 16px; color: #898989; font-size: 12px; margin: 13px 0px; ">
&copy 2022, {company_name}. All rights reserved.</p>
</td>
</tr>
</table>
</td>
</tr>
</table>
</body>

</html>',
                'language_id' => 1,
                'status' => 'Active',
                'variables' => 'logo,company_url,user_name,company_name,support_mail',
            ],
            14 => [
                'id' => 17,
                'parent_id' => null,
                'name' => 'Seller request for admin',
                'slug' => 'seller-request-for-admin',
                'subject' => 'Seller request for admin',
                'body' => '<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8" />
<meta http-equiv="x-ua-compatible" content="ie=edge" />
<title>10.NEW COUPON ADDED</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<style type="text/css">
@media screen {
@font-face {
font-family: "DM Sans";
font-weight: 700;
src: url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriASitCBimCw.woff2) format("woff2");
}

@font-face {
font-family: "DM Sans";
font-weight: 500;
font-style: normal;
src: url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriAWCrCBimCw.woff2) format("woff2");
}
}

.bodys,
.tables,
td,
.anchor-tag a {
-ms-text-size-adjust: 100%;
-webkit-text-size-adjust: 100%;
}

.tables,
td {
mso-table-rspace: 0pt;
mso-table-lspace: 0pt;
}

.anchor-tag a {
padding: 1px;
margin: 1px;
}

.anchor-tag a[x-apple-data-detectors] {
font-family: inherit !important;
font-size: inherit !important;
font-weight: inherit !important;
line-height: inherit !important;
color: inherit !important;
text-decoration: none !important;
}

.bodys {
width: 100% !important;
height: 100% !important;
padding: 0 !important;
margin: 0 !important;
}

.tables {
border-collapse: collapse !important;
}

.logo-img {
margin: 26px 0px 19px 0px;
padding: 0px;
width: 207.98px;
height: 56px;
}

.anchor-tag a:focus,
.anchor-tag a:hover {
text-decoration: underline;
text-decoration-color: #fcca19;
}

.anchor-tag a:-webkit-any-link {
color: -webkit-link;
cursor: pointer;
text-decoration: underline;
text-decoration-color: #fcca19;
}

.anchor-tag a:-webkit-any-link {
color: -webkit-link;
cursor: pointer;
text-decoration: none;
text-decoration-color: #fcca19;
}
</style>
</head>

<body class="bodys" style="background-color: #e9ecef">
<div class="preheader"
style="display: none; max-width: 0; max-height: 0; margin: 0px; overflow: hidden; color: #fff; opacity: 0;">
</div>
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px">
<tr>
<td align="center" valign="top" style="padding: 36px 24px"></td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
style="max-width: 640px; margin-top: 100px">
<tr>
<td align="center" bgcolor="#ffffff">
<img class="logo-img" src="{logo}" alt="logo" />
<p style="border-top: 1px solid #dfdfdf; margin: 1px 20px 0px 20px;"></p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
<tr>
<td align="center" bgcolor="#fff">
<p style="font-family: \'DM Sans\', sans-serif; letter-spacing: 0.255em; text-transform: uppercase; margin: 26px 0px;
line-height: 25px; font-size: 0.8em !important; color: rgb(44, 44, 44); font-weight: 500 !important;
cursor: default !important;"></p>
<p style="margin: 0px;text-align: center; line-height: 24px; font-size: 16px;
color: #2c2c2c;"> Dear {user_name} </p>
<p style=" margin: 0px; color: #898989; font-size: 14px; margin: 3px 50px 31px;
text-align: center; line-height: 24px;">A seller has requested to join {company_name} family. Please change the status of that seller.</p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
<tr>
<td align="center" bgcolor="#ffffff">
<div>
<p style=" font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 700;
font-size: 18px; line-height: 21px; margin-top: 37px; text-align: center;
text-transform: uppercase; color: #2c2c2c;"> Keep in touch</p>
</div>
<div
style=" font-size: 14px; text-align: center; color: #898989;line-height: 22px; margin: 1px;">
<div
style=" font-size: 14px; text-align: center; color: #898989;line-height: 22px; margin: 1px;">
<p style="margin-top: 14px">If you have any queries, concerns or suggestions,
</p>
<p style="margin: 0px; margin-top: 1px">please email us:
<span
style="text-decoration: underline; cursor: pointer; color: #0060a9;">{support_mail}</span>
</p>
</div>
</div>
<div style="margin-top: 32px; margin-bottom: 31px">
<a class="anchor-tag" style=" margin-right: 9px; width: 32px; display: inline-block; "
href="https://www.facebook.com/"><img src="https://i.ibb.co/fCZXxCC/Group-9380.png"
alt="" /></a>
<a class="anchor-tag" style=" margin-right: 9px; width: 32px; display: inline-block;"
href="https://twitter.com/?lang=en"><img src="https://i.ibb.co/ZLgzjS0/twitter.png"
alt="" /></a>
<a class="anchor-tag" style=" margin-right: 9px; width: 32px;display: inline-block; "
href="https://www.instagram.com/?hl=en"><img
src="https://i.ibb.co/WKyFkYz/instagramm.png" alt="" /></a>
<a class="anchor-tag" style=" margin-right: 9px; width: 32px; display: inline-block; "
href="https://www.whatsapp.com/"><img src="https://i.ibb.co/6R7LWr1/watsapp.png"
alt="" /></a>
<a class="anchor-tag" style=" margin-right: 9px; width: 32px; display: inline-block;"
href="https://www.pioneer.eu/"><img src="https://i.ibb.co/wYT6Tmg/pinterest.png"
alt="" /></a>
<a class="anchor-tag" style=" margin-right: 9px; width: 32px; display: inline-block; "
href="https://www.youtube.com/"><img src="https://i.ibb.co/RT7Zns1/youtube.png"
alt="" /></a>
</div>
<p style="border-top: 1px solid #dfdfdf;margin: 1px 20px 0px 20px; "></p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
style=" max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500; margin-bottom: 200px; ">
<tr>
<td align="center" bgcolor="#ffffff">
<p
style=" text-align: center; line-height: 16px; color: #898989; font-size: 12px; margin: 13px 0px; ">
&copy 2022, {company_name}. All rights reserved.</p>
</td>
</tr>
</table>
</td>
</tr>
</table>
</body>

</html>',
                'language_id' => 1,
                'status' => 'Active',
                'variables' => 'user_name,company_name,support_mail,logo',
            ],
            15 => [
                'id' => 18,
                'parent_id' => null,
                'name' => 'Admin change seller status',
                'slug' => 'admin-change-seller-status',
                'subject' => 'Admin change your status',
                'body' => '<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8" />
<meta http-equiv="x-ua-compatible" content="ie=edge" />
<title>10.NEW COUPON ADDED</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<style type="text/css">
@media screen {
@font-face {
font-family: "DM Sans";
font-weight: 700;
src: url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriASitCBimCw.woff2) format("woff2");
}

@font-face {
font-family: "DM Sans";
font-weight: 500;
font-style: normal;
src: url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriAWCrCBimCw.woff2) format("woff2");
}
}

.bodys,
.tables,
td,
.anchor-tag a {
-ms-text-size-adjust: 100%;
-webkit-text-size-adjust: 100%;
}

.tables,
td {
mso-table-rspace: 0pt;
mso-table-lspace: 0pt;
}

.anchor-tag a {
padding: 1px;
margin: 1px;
}

.anchor-tag a[x-apple-data-detectors] {
font-family: inherit !important;
font-size: inherit !important;
font-weight: inherit !important;
line-height: inherit !important;
color: inherit !important;
text-decoration: none !important;
}

.bodys {
width: 100% !important;
height: 100% !important;
padding: 0 !important;
margin: 0 !important;
}

.tables {
border-collapse: collapse !important;
}

.logo-img {
margin: 26px 0px 19px 0px;
padding: 0px;
width: 207.98px;
height: 56px;
}

.anchor-tag a:focus,
.anchor-tag a:hover {
text-decoration: underline;
text-decoration-color: #fcca19;
}

.anchor-tag a:-webkit-any-link {
color: -webkit-link;
cursor: pointer;
text-decoration: underline;
text-decoration-color: #fcca19;
}

.anchor-tag a:-webkit-any-link {
color: -webkit-link;
cursor: pointer;
text-decoration: none;
text-decoration-color: #fcca19;
}
</style>
</head>

<body class="bodys" style="background-color: #e9ecef">
<div class="preheader"
style="display: none; max-width: 0; max-height: 0; margin: 0px; overflow: hidden; color: #fff; opacity: 0;"></div>
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px">
<tr>
<td align="center" valign="top" style="padding: 36px 24px"></td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
style="max-width: 640px; margin-top: 100px">
<tr>
<td align="center" bgcolor="#ffffff">
<img class="logo-img" src="{logo}" alt="logo" />
<p style="border-top: 1px solid #dfdfdf; margin: 1px 20px 0px 20px;"></p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
<tr>
<td align="center" bgcolor="#fff">
<p style="font-family: \'DM Sans\', sans-serif; letter-spacing: 0.255em; text-transform: uppercase; margin: 26px 0px;
line-height: 25px; font-size: 0.8em !important; color: rgb(44, 44, 44); font-weight: 500 !important;
cursor: default !important;"></p>
<p style="margin: 0px;text-align: center; line-height: 24px; font-size: 16px;
color: #2c2c2c;"> Dear {user_name} </p>
<p style=" margin: 0px; color: #898989; font-size: 14px; margin: 3px 50px 31px;
text-align: center; line-height: 24px;">Your account has been deactivated. Please contact our administrator.</p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
<tr>
<td align="center" bgcolor="#ffffff">
<div>
<p style=" font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 700;
font-size: 18px; line-height: 21px; margin-top: 37px; text-align: center;
text-transform: uppercase; color: #2c2c2c;"> Keep in touch</p>
</div>
<div style=" font-size: 14px; text-align: center; color: #898989;line-height: 22px; margin: 1px;">
<div style=" font-size: 14px; text-align: center; color: #898989;line-height: 22px; margin: 1px;">
<p style="margin-top: 14px">If you have any queries, concerns or suggestions,
</p>
<p style="margin: 0px; margin-top: 1px">please email us:
<span style="text-decoration: underline; cursor: pointer; color: #0060a9;">{support_mail}</span>
</p>
</div>
</div>
<div style="margin-top: 32px; margin-bottom: 31px">
<a class="anchor-tag" style=" margin-right: 9px; width: 32px; display: inline-block; "
href="https://www.facebook.com/"><img src="https://i.ibb.co/fCZXxCC/Group-9380.png" alt="" /></a>
<a class="anchor-tag" style=" margin-right: 9px; width: 32px; display: inline-block;"
href="https://twitter.com/?lang=en"><img src="https://i.ibb.co/ZLgzjS0/twitter.png" alt="" /></a>
<a class="anchor-tag" style=" margin-right: 9px; width: 32px;display: inline-block; "
href="https://www.instagram.com/?hl=en"><img src="https://i.ibb.co/WKyFkYz/instagramm.png"
alt="" /></a>
<a class="anchor-tag" style=" margin-right: 9px; width: 32px; display: inline-block; "
href="https://www.whatsapp.com/"><img src="https://i.ibb.co/6R7LWr1/watsapp.png" alt="" /></a>
<a class="anchor-tag" style=" margin-right: 9px; width: 32px; display: inline-block;"
href="https://www.pioneer.eu/"><img src="https://i.ibb.co/wYT6Tmg/pinterest.png" alt="" /></a>
<a class="anchor-tag" style=" margin-right: 9px; width: 32px; display: inline-block; "
href="https://www.youtube.com/"><img src="https://i.ibb.co/RT7Zns1/youtube.png" alt="" /></a>
</div>
<p style="border-top: 1px solid #dfdfdf;margin: 1px 20px 0px 20px; "></p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
style=" max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500; margin-bottom: 200px; ">
<tr>
<td align="center" bgcolor="#ffffff">
<p style=" text-align: center; line-height: 16px; color: #898989; font-size: 12px; margin: 13px 0px; ">
&copy 2022, {company_name}. All rights reserved.</p>
</td>
</tr>
</table>
</td>
</tr>
</table>
</body>

</html>',
                'language_id' => 1,
                'status' => 'Active',
                'variables' => 'logo,user_name,support_mail,company_name',
            ],
            16 => [
                'id' => 19,
                'parent_id' => null,
                'name' => 'Popup Mail',
                'slug' => 'popup-mail',
                'subject' => 'Popup Mail',
                'body' => '<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8" />
<meta http-equiv="x-ua-compatible" content="ie=edge" />
<title>10.NEW COUPON ADDED</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<style type="text/css">
@media screen {
@font-face {
font-family: "DM Sans";
font-weight: 700;
src: url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriASitCBimCw.woff2) format("woff2");
}

@font-face {
font-family: "DM Sans";
font-weight: 500;
font-style: normal;
src: url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriAWCrCBimCw.woff2) format("woff2");
}
}

.bodys,
.tables,
td,
.anchor-tag a {
-ms-text-size-adjust: 100%;
-webkit-text-size-adjust: 100%;
}

.tables,
td {
mso-table-rspace: 0pt;
mso-table-lspace: 0pt;
}

.anchor-tag a {
padding: 1px;
margin: 1px;
}

.anchor-tag a[x-apple-data-detectors] {
font-family: inherit !important;
font-size: inherit !important;
font-weight: inherit !important;
line-height: inherit !important;
color: inherit !important;
text-decoration: none !important;
}

.bodys {
width: 100% !important;
height: 100% !important;
padding: 0 !important;
margin: 0 !important;
}

.tables {
border-collapse: collapse !important;
}

.logo-img {
margin: 26px 0px 19px 0px;
padding: 0px;
width: 207.98px;
height: 56px;
}

.anchor-tag a:focus,
.anchor-tag a:hover {
text-decoration: underline;
text-decoration-color: #fcca19;
}

.anchor-tag a:-webkit-any-link {
color: -webkit-link;
cursor: pointer;
text-decoration: underline;
text-decoration-color: #fcca19;
}

.anchor-tag a:-webkit-any-link {
color: -webkit-link;
cursor: pointer;
text-decoration: none;
text-decoration-color: #fcca19;
}
</style>
</head>

<body class="bodys" style="background-color: #e9ecef">
<div class="preheader"
style="display: none; max-width: 0; max-height: 0; margin: 0px; overflow: hidden; color: #fff; opacity: 0;"></div>
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px">
<tr>
<td align="center" valign="top" style="padding: 36px 24px"></td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
style="max-width: 640px; margin-top: 100px">
<tr>
<td align="center" bgcolor="#ffffff">
<img class="logo-img" src="{logo}" alt="logo" />
<p style="border-top: 1px solid #dfdfdf; margin: 1px 20px 0px 20px;"></p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
<tr>
<td align="center" bgcolor="#fff">
<p style="font-family: \'DM Sans\', sans-serif; letter-spacing: 0.255em; text-transform: uppercase; margin: 26px 0px;
line-height: 25px; font-size: 0.8em !important; color: rgb(44, 44, 44); font-weight: 500 !important;
cursor: default !important;"></p>
<p style=" margin: 0px; color: #898989; font-size: 14px; margin: 3px 50px 31px;
text-align: center; line-height: 24px;">{mail_content}</p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
<tr>
<td align="center" bgcolor="#ffffff">
<div>
<p style=" font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 700;
font-size: 18px; line-height: 21px; margin-top: 37px; text-align: center;
text-transform: uppercase; color: #2c2c2c;"> Keep in touch</p>
</div>
<div style=" font-size: 14px; text-align: center; color: #898989;line-height: 22px; margin: 1px;">
<div style=" font-size: 14px; text-align: center; color: #898989;line-height: 22px; margin: 1px;">
<p style="margin-top: 14px">If you have any queries, concerns or suggestions,
</p>
<p style="margin: 0px; margin-top: 1px">please email us:
<span style="text-decoration: underline; cursor: pointer; color: #0060a9;">{support_mail}</span>
</p>
</div>
</div>
<div style="margin-top: 32px; margin-bottom: 31px">
<a class="anchor-tag" style=" margin-right: 9px; width: 32px; display: inline-block; "
href="https://www.facebook.com/"><img src="https://i.ibb.co/fCZXxCC/Group-9380.png" alt="" /></a>
<a class="anchor-tag" style=" margin-right: 9px; width: 32px; display: inline-block;"
href="https://twitter.com/?lang=en"><img src="https://i.ibb.co/ZLgzjS0/twitter.png" alt="" /></a>
<a class="anchor-tag" style=" margin-right: 9px; width: 32px;display: inline-block; "
href="https://www.instagram.com/?hl=en"><img src="https://i.ibb.co/WKyFkYz/instagramm.png"
alt="" /></a>
<a class="anchor-tag" style=" margin-right: 9px; width: 32px; display: inline-block; "
href="https://www.whatsapp.com/"><img src="https://i.ibb.co/6R7LWr1/watsapp.png" alt="" /></a>
<a class="anchor-tag" style=" margin-right: 9px; width: 32px; display: inline-block;"
href="https://www.pioneer.eu/"><img src="https://i.ibb.co/wYT6Tmg/pinterest.png" alt="" /></a>
<a class="anchor-tag" style=" margin-right: 9px; width: 32px; display: inline-block; "
href="https://www.youtube.com/"><img src="https://i.ibb.co/RT7Zns1/youtube.png" alt="" /></a>
</div>
<p style="border-top: 1px solid #dfdfdf;margin: 1px 20px 0px 20px; "></p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
style=" max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500; margin-bottom: 200px; ">
<tr>
<td align="center" bgcolor="#ffffff">
<p style=" text-align: center; line-height: 16px; color: #898989; font-size: 12px; margin: 13px 0px; ">
&copy 2022, {company_name}. All rights reserved.</p>
</td>
</tr>
</table>
</td>
</tr>
</table>
</body>

</html>',
                'language_id' => 1,
                'status' => 'Active',
                'variables' => 'logo,support_mail,company_name, mail_content',
            ],
            17 => [
                'id' => 20,
                'parent_id' => null,
                'name' => 'ticket reply',
                'slug' => 'ticket-reply',
                'subject' => 'Ticket reply',
                'body' => '<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta http-equiv="x-ua-compatible" content="ie=edge" />
<title>Ticket-template-design</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<style type="text/css">
@media screen {
@font-face {
font-family: "DM Sans";
font-weight: 700;
src:   url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriASitCBimCw.woff2)
format("woff2");
}
@font-face {
font-family: "DM Sans";
font-weight: 500;
font-style: normal;
src: url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriAWCrCBimCw.woff2)
format("woff2");
}
}
.bodys,
.tables,
td,
.anchor-tag a {
-ms-text-size-adjust: 100%;
-webkit-text-size-adjust: 100%;
}
.tables,
td {
mso-table-rspace: 0pt;
mso-table-lspace: 0pt;
}
.anchor-tag a {
padding: 1px;
margin: 1px;
}
.anchor-tag a[x-apple-data-detectors] {
font-family: inherit !important;
font-size: inherit !important;
font-weight: inherit !important;
line-height: inherit !important;
color: inherit !important;
text-decoration: none !important;
}
.bodys {
width: 100% !important;
height: 100% !important;
padding: 0 !important;
margin: 0 !important;
}
.tables {
border-collapse: collapse !important;
}
.logo-img {
margin: 26px 0px 19px 0px;
padding: 0px;
width: 207.98px;
height: 56px;
}
.actives {
box-sizing: border-box;
text-decoration: none;
-webkit-text-size-adjust: none;
text-align: center;
border-radius: 2px;
-webkit-border-radius: 2px;
-moz-border-radius: 2px;
-khtml-border-radius: 2px;
-o-border-radius: 2px;
-ms-border-radius: 2px;
padding: 10px 38px;
cursor: pointer;
background: #fcca19;
}
.anchor-tag a:focus,
.anchor-tag a:hover {
text-decoration: underline;
text-decoration-color: #fcca19;
}
.anchor-tag a:-webkit-any-link {
color: -webkit-link;
cursor: pointer;
text-decoration: underline;
text-decoration-color: #fcca19;
}
.anchor-tag a:-webkit-any-link {
color: -webkit-link;
cursor: pointer;
text-decoration: none;
text-decoration-color: #fcca19;
}
</style>
</head>
<body class="bodys" style="background-color: #e9ecef">
<div class="preheader" style="display: none; max-width: 0; max-height: 0; margin: 0px; overflow: hidden; color: #fff; opacity: 0;"></div>
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px">
<tr>
<td align="center" valign="top" style="padding: 36px 24px"></td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px; margin-top: 100px">
<tr>
<td align="center" bgcolor="#ffffff">
<img class="logo-img" src="{logo}" alt="logo" />
<p style="border-top: 1px solid #dfdfdf; margin: 1px 20px 0px 20px;"></p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
<tr>
<td align="center" bgcolor="#fff">
<p style="font-family: \'DM Sans\', sans-serif; letter-spacing: 0.255em; text-transform: uppercase; margin: 26px 0px; line-height: 25px;
font-size:0.80em!important; color: rgb(44, 44, 44); font-weight: 500 !important; cursor: default !important;">Ticket Module</p>
<p style="margin: 0px; text-align: center; line-height: 24px; font-size: 16px; color: #2c2c2c;" > Hello {name}</p>
<p style="margin: 0px; color: #898989; font-size: 14px; margin: 7px 54px 0px; text-align: center; line-height: 24px;">You have a reply from the {team_member} of {company_name}.
</p>
<div style="background-color: #F3F3F3; border-radius:4px ; margin: 25px 78px">
<p style="font-family: \'DM Sans\', sans-serif; font-style: italic; font-weight: 500; font-size: 13px; line-height: 24px;text-align: center; color: #2C2C2C; padding: 24px 26px;">‘{ticket_message}’</p>
</div>
<div style="margin: 20px 78px 58px; background: #FFFFFF; border: 1px solid #DFDFDF; border-radius: 4px; display: flex;padding: 16px;">
<div style=" margin-right:60px; text-align: left;">
<p style="font-family: \'DM Sans\', sans-serif;font-style: normal; font-weight: 500; font-size: 13px;line-height: 17px; color:#898989; word-break: break-all;"><span style="color: #2c2c2c; padding-right: 2px;">Ticket ID:</span>{ticket_no}</p>
<p style="font-family: \'DM Sans\', sans-serif;font-style: normal;  text-align: left; font-weight: 500; margin-bottom: 0px; font-size: 13px; line-height: 17px; color:#898989; word-break: break-all;"><span style="color: #2c2c2c; padding-right: 2px;">Subject:</span>{ticket_subject}</p>
</div>
<div class=" text-align: left;">
<p style="font-family: \'DM Sans\', sans-serif;font-style: normal; font-weight: 500; font-size: 13px;line-height: 17px; color:#898989; word-break: break-all;margin-bottom: 0px;"><span style="color: #2c2c2c; padding-right: 2px;">Status:</span>{ticket_status}</p>
</div>
</div>

</td>

</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style=" max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
<tr>
<td align="center" bgcolor="#ffffff">
<div>
<a href="{details}" aria-pressed="true" class="actives anchor-tag">
<span style="text-decoration: none; color: #2C2C2C;">View Tickets</span>
</a>
</div>
<p style="font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 500; font-size: 13px; line-height: 17px; text-align: center; color: #2C2C2C; margin-top: 46px; margin-bottom:12px">Thank You,</p>
<p style="font-family: \'DM Sans\', sans-serif; font-style: normal; margin:0; font-weight: 500; font-size: 13px;line-height: 17px; text-align: center;color: #898989;">{team_member}</p>
<p style="font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 500;font-size: 13px;line-height: 17px; text-align: center;color: #898989;margin:0; margin-top: 7px; margin-bottom: 20px;">{company_name}</p>
<p style="border-top: 1px solid #dfdfdf; margin: 1px 20px 0px 20px;"></p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"style=" max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500; margin-bottom: 200px; ">
<tr>
<td align="center" bgcolor="#ffffff">
<p style="text-align: center; line-height: 16px; color: #898989; font-size: 12px; margin: 13px 0px;" > &copy 2022, {company_name}. All rights reserved.</p>
</td>
</tr>
</table>
</td>
</tr>
</table>
</body>
</html>
',
                'language_id' => 1,
                'status' => 'Active',
                'variables' => 'ticket_subject, ticket_no, customer_name, name, ticket_message, ticket_status, details, company_name',
            ],
            18 => [
                'id' => 21,
                'parent_id' => null,
                'name' => 'Low Stock Threshold',
                'slug' => 'low-stock-threshold',
                'subject' => 'Low Stock Threshold Remembered',
                'body' => '<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8" />
<meta http-equiv="x-ua-compatible" content="ie=edge" />
<title>10.NEW COUPON ADDED</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<style type="text/css">
@media screen {
@font-face {
font-family: "DM Sans";
font-weight: 700;
src: url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriASitCBimCw.woff2) format("woff2");
}

@font-face {
font-family: "DM Sans";
font-weight: 500;
font-style: normal;
src: url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriAWCrCBimCw.woff2) format("woff2");
}
}

.bodys,
.tables,
td,
.anchor-tag a {
-ms-text-size-adjust: 100%;
-webkit-text-size-adjust: 100%;
}

.tables,
td {
mso-table-rspace: 0pt;
mso-table-lspace: 0pt;
}

.anchor-tag a {
padding: 1px;
margin: 1px;
}

.anchor-tag a[x-apple-data-detectors] {
font-family: inherit !important;
font-size: inherit !important;
font-weight: inherit !important;
line-height: inherit !important;
color: inherit !important;
text-decoration: none !important;
}

.bodys {
width: 100% !important;
height: 100% !important;
padding: 0 !important;
margin: 0 !important;
}

.tables {
border-collapse: collapse !important;
}

.logo-img {
margin: 26px 0px 19px 0px;
padding: 0px;
width: 207.98px;
height: 56px;
}

.anchor-tag a:focus,
.anchor-tag a:hover {
text-decoration: underline;
text-decoration-color: #fcca19;
}

.anchor-tag a:-webkit-any-link {
color: -webkit-link;
cursor: pointer;
text-decoration: underline;
text-decoration-color: #fcca19;
}

.anchor-tag a:-webkit-any-link {
color: -webkit-link;
cursor: pointer;
text-decoration: none;
text-decoration-color: #fcca19;
}
</style>
</head>

<body class="bodys" style="background-color: #e9ecef">
<div class="preheader"
style="display: none; max-width: 0; max-height: 0; margin: 0px; overflow: hidden; color: #fff; opacity: 0;"></div>
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px">
<tr>
<td align="center" valign="top" style="padding: 36px 24px"></td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
style="max-width: 640px; margin-top: 100px">
<tr>
<td align="center" bgcolor="#ffffff">
<img class="logo-img" src="{logo}" alt="logo" />
<p style="border-top: 1px solid #dfdfdf; margin: 1px 20px 0px 20px;"></p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
<tr>
<td align="center" bgcolor="#fff">
<p style="font-family: \'DM Sans\', sans-serif; letter-spacing: 0.255em; text-transform: uppercase; margin: 26px 0px;
line-height: 25px; font-size: 0.8em !important; color: rgb(44, 44, 44); font-weight: 500 !important;
cursor: default !important;"></p>
<p style="margin: 0px;text-align: center; line-height: 24px; font-size: 16px;
color: #2c2c2c;"> Hi {user_name} </p>
<p style=" margin: 0px; color: #898989; font-size: 14px; margin: 3px 50px 31px;
text-align: center; line-height: 24px;">Below products has reached the low stock threshold value <br>
{product_list}
<br>Please add stock to this products</p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
<tr>
<td align="center" bgcolor="#ffffff">
<div>
<p style=" font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 700;
font-size: 18px; line-height: 21px; margin-top: 37px; text-align: center;
text-transform: uppercase; color: #2c2c2c;"> Keep in touch</p>
</div>
<div style=" font-size: 14px; text-align: center; color: #898989;line-height: 22px; margin: 1px;">
<div style=" font-size: 14px; text-align: center; color: #898989;line-height: 22px; margin: 1px;">
<p style="margin-top: 14px">If you have any queries, concerns or suggestions,
</p>
<p style="margin: 0px; margin-top: 1px">please email us:
<span style="text-decoration: underline; cursor: pointer; color: #0060a9;">{support_mail}</span>
</p>
</div>
</div>
<div style="margin-top: 32px; margin-bottom: 31px">
<a class="anchor-tag" style=" margin-right: 9px; width: 32px; display: inline-block; "
href="https://www.facebook.com/"><img src="https://i.ibb.co/fCZXxCC/Group-9380.png" alt="" /></a>
<a class="anchor-tag" style=" margin-right: 9px; width: 32px; display: inline-block;"
href="https://twitter.com/?lang=en"><img src="https://i.ibb.co/ZLgzjS0/twitter.png" alt="" /></a>
<a class="anchor-tag" style=" margin-right: 9px; width: 32px;display: inline-block; "
href="https://www.instagram.com/?hl=en"><img src="https://i.ibb.co/WKyFkYz/instagramm.png"
alt="" /></a>
<a class="anchor-tag" style=" margin-right: 9px; width: 32px; display: inline-block; "
href="https://www.whatsapp.com/"><img src="https://i.ibb.co/6R7LWr1/watsapp.png" alt="" /></a>
<a class="anchor-tag" style=" margin-right: 9px; width: 32px; display: inline-block;"
href="https://www.pioneer.eu/"><img src="https://i.ibb.co/wYT6Tmg/pinterest.png" alt="" /></a>
<a class="anchor-tag" style=" margin-right: 9px; width: 32px; display: inline-block; "
href="https://www.youtube.com/"><img src="https://i.ibb.co/RT7Zns1/youtube.png" alt="" /></a>
</div>
<p style="border-top: 1px solid #dfdfdf;margin: 1px 20px 0px 20px; "></p>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td align="center" bgcolor="#e9ecef">
<table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
style=" max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500; margin-bottom: 200px; ">
<tr>
<td align="center" bgcolor="#ffffff">
<p style=" text-align: center; line-height: 16px; color: #898989; font-size: 12px; margin: 13px 0px; ">
&copy 2022, {company_name}. All rights reserved.</p>
</td>
</tr>
</table>
</td>
</tr>
</table>
</body>

</html>',
                'language_id' => 1,
                'status' => 'Active',
                'variables' => 'logo,user_name, company_url, company_name,support_mail, product_list,',
            ],
        ]);

    }
}
