<?php

namespace App\Livewire\Project;

use App\Models\KeuanganProject;
use Livewire\Component;

class ProjectFee extends Component
{
    public $data;
    public $isset = true;

    public function mount($data)
    {
        $this->data = $data;
    }

    public function render()
    {
        $data['model'] = KeuanganProject::where('project_id', $this->data->id)->first();

        if($data['model']) {
            $this->isset = false;
        }

        return view('livewire.project.project-fee', $data);
    }
}