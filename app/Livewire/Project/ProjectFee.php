<?php

namespace App\Livewire\Project;

use App\Models\KeuanganProject;
use Livewire\Component;

class ProjectFee extends Component
{
    public $data;
    public $isset = true;
    public $type, $project_id;

    public function mount($data)
    {
        $this->data = $data;
        $this->project_id = $data->id;
    }

    public function render()
    {
        $data['project'] = $this->data;
        $data['model'] = KeuanganProject::where('project_id', $this->data->id)->first();

        if($data['model']) {
            $this->isset = false;
        }

        return view('livewire.project.project-fee', $data);
    }

    public function submit()
    {
        $validate = $this->validate([
            'type'       => 'required',
            'project_id' => 'required',
        ]);
        dd($validate);

        KeuanganProject::create($validate);
        $this->isset = false;
    }
}