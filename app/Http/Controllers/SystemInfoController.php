<?php

namespace App\Http\Controllers;

use App\Lib\PhpInfo;
use App\Lib\SiteInfo\SiteInfo;

class SystemInfoController extends Controller
{
    /**
     * Application Info
     * Server Info
     * php.ini Info
     * Extension Info
     * File System Info
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        if (request('info') == '1') {
            $data['application'] = (new SiteInfo())->application();
            $data['server'] = (new SiteInfo())->server();
            $data['database'] = (new SiteInfo())->database();

            return view('admin.system.index', $data);
        }

        $data['applicationVersion']  = martvillVersion();
        $data['phpVersion']          = phpversion();
        $data['minimumPhpVersion']   = config('installer.core.minimumPhpVersion');
        $data['mysqlVersion']        = \DB::select('select version()')[0]->{'version()'};
        $data['minimumMysqlVersion'] = config('installer.core.minimumMysqlVersion');

        $data['extensionArray'] = array_map('strtolower', array_keys(PhpInfo::phpinfo_modules()));
        $data['configurations'] = PhpInfo::phpinfo_configuration();

        if (! empty($data['configurations'])) {
            $sizeConfigs = ['upload_max_filesize', 'post_max_size', 'memory_limit'];

            foreach ($sizeConfigs as $sizeConfig) {
                $byteSize = convertToBytes($data['configurations'][$sizeConfig]);
                $megabyteValue = convertBytesToOtherUnit($byteSize, 'M');
                $data['configurations'][$sizeConfig] = $megabyteValue;
            }
        }

        $data['fileSystemPaths'] = [
            'storage/app/',
            'storage/framework/',
            'storage/logs/',
            'bootstrap/cache/',
        ];

        return view('admin.system.status', $data);
    }
}
