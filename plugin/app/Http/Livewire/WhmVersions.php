<?php

namespace App\Http\Livewire;

use Livewire\Component;
use MicroweberPackages\SharedServerScripts\MicroweberDownloader;

class WhmVersions extends Component
{
    public $currentVersionOfApp = 0;
    public $latestVersionOfApp = 0;
    public $latestDownloadDateOfApp = 0;
    public $availableTemplatesOfApp = [
        'new-world'=>[
            'name'=>'New World',
            'version'=>'1.2',
        ]
    ];

    public function checkForUpdate()
    {
        $sharedAppPath = config('whm-cpanel.sharedPaths.app');
        if(!is_dir(dirname($sharedAppPath))) {
            mkdir(dirname($sharedAppPath));
        }

        $downloader = new MicroweberDownloader();
        $status = $downloader->download(config('whm-cpanel.sharedPaths.app'));

    }

    public function render()
    {
        return view('livewire.whm.versions');
    }
}