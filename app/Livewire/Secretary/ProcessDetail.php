<?php

namespace App\Livewire\Secretary;

use App\Models\Process;
use Livewire\Component;

class ProcessDetail extends Component
{
    public $processId;
    public $process;

    public function mount($processId)
    {
        $this->processId = $processId;
        $this->process = Process::with(['steps' => function ($query) {
            $query->orderBy('order');
        }])->findOrFail($processId);
    }

    public function render()
    {
        return view('modules.secretary.process-detail')->layout('layouts.app');
    }
}
