<?php

namespace App\Livewire;

use Livewire\Component;

class DashboardComponent extends Component
{
    public $title = 'Post title...';
    public function render()
    {
        return view('livewire.dashboard-component');
    }
    public function create()
    {
        dd('d');
    }
}
