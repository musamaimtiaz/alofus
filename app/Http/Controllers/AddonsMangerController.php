<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 19-01-2022
 */

namespace App\Http\Controllers;

class AddonsMangerController extends Controller
{
    /**
     * All orders
     *
     * @return mixed
     */
    public function index()
    {
        return view('admin.addons.index');
    }
}
