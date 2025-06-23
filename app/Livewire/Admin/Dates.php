<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Date;
use Livewire\WithPagination;

class Dates extends Component
{
    use WithPagination;

    public $date, $label, $active = true, $dateId;
    public $isEditing = false;

    protected $rules = [
        'date' => 'required|date',
        'label' => 'nullable|string|max:255',
        'active' => 'boolean',
    ];

    public function render()
    {
        return view('livewire.admin.dates', [
            'dates' => Date::orderBy('date', 'asc')->paginate(10),
        ])->layout('layouts.admin');
    }

    public function resetForm()
    {
        $this->date = '';
        $this->label = '';
        $this->active = true;
        $this->dateId = null;
        $this->isEditing = false;
    }

    public function store()
    {
        $this->validate();
        Date::create([
            'date' => $this->date,
            'label' => $this->label,
            'active' => $this->active,
        ]);
        session()->flash('success', 'Date added successfully.');
        $this->resetForm();
    }

    public function edit($id)
    {
        $date = Date::findOrFail($id);
        $this->dateId = $date->id;
        $this->date = $date->date;
        $this->label = $date->label;
        $this->active = $date->active;
        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate();
        $date = Date::findOrFail($this->dateId);
        $date->update([
            'date' => $this->date,
            'label' => $this->label,
            'active' => $this->active,
        ]);
        session()->flash('success', 'Date updated successfully.');
        $this->resetForm();
    }

    public function delete($id)
    {
        Date::findOrFail($id)->delete();
        session()->flash('success', 'Date deleted successfully.');
        $this->resetForm();
    }
}
