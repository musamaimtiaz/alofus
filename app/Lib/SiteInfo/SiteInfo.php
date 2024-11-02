<?php

namespace App\Lib\SiteInfo;

class SiteInfo
{
    public function application()
    {
        return (new Application())->getInfo();
    }

    public function server()
    {
        return (new Server())->getInfo();
    }

    public function database()
    {
        return (new Database())->getInfo();
    }
}
