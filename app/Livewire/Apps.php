<?php

namespace App\Livewire;

use App\Fly;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Native\Laravel\Facades\Shell;

class Apps extends Component
{
    public $apps;

    public function loadApps()
    {
        Log::info('we are making api calls again');
        $this->apps = (new Fly)->getApps();
    }

    public function openApp($app)
    {
        Log::info("are we doing this?", ['app' => $app]);
        Shell::openExternal("https://fly.io/apps/".$app);
    }

    public function render()
    {
        return view('livewire.apps');
    }
}
