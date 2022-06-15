<?php

namespace App\Http\Livewire;

use App\Models\Option;
use Livewire\Component;
use MicroweberPackages\SharedServerScripts\MicroweberAppPathHelper;

class WhmInstall extends Component
{
    public $supportedTemplates = [];
    public $supportedLanguages = [];

    public function render()
    {
        return view('livewire.whm.install');
    }

    public function mount()
    {
        $sharedPath = new MicroweberAppPathHelper();
        $sharedPath->setPath(config('whm-cpanel.sharedPaths.app'));

        $this->supportedLanguages = $sharedPath->getSupportedLanguages();
        $this->supportedTemplates = $sharedPath->getSupportedTemplates();

    }
}
