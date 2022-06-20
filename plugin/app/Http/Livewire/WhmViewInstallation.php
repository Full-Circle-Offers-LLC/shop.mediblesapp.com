<?php

namespace App\Http\Livewire;

use App\Console\Commands\AppInstallationsScan;
use App\Cpanel\CpanelApi;
use Livewire\Component;
use MicroweberPackages\SharedServerScripts\MicroweberSharedPathHelper;
use MicroweberPackages\SharedServerScripts\MicroweberInstaller;

class WhmViewInstallation extends Component
{

    public function render()
    {
        return view('livewire.whm.view_installation');
    }

    public function mount()
    {



    }
}
