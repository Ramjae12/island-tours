<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Package;
use Livewire\WithPagination;

class Packages extends Component
{
    use WithPagination;

    public $name, $description, $price, $discount_price, $type, $active = true, $price_label = 'per person/day', $requires_id = true, $packageId;
    public $isEditing = false;
    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'discount_price' => 'nullable|numeric|min:0',
        'type' => 'required|string|max:255',
        'active' => 'boolean',
        'price_label' => 'nullable|string|max:255',
        'requires_id' => 'boolean'
    ];

    public function render()
    {
        $packages = Package::query()
            ->when($this->search, function($query) {
                $search = $this->search;
                $query->where('name', 'like', "%$search%")
                      ->orWhere('type', 'like', "%$search%")
                      ->orWhereRaw("CAST(active AS CHAR) LIKE ?", ["%$search%"])
                      ->orWhereRaw("CAST(requires_id AS CHAR) LIKE ?", ["%$search%"]);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.admin.packages', [
            'packages' => $packages,
        ])->layout('layouts.admin');
    }

    public function resetForm()
    {
        $this->reset([
            'name', 'description', 'price', 'discount_price', 'type', 
            'active', 'price_label', 'requires_id', 'packageId', 'isEditing'
        ]);
        $this->active = true;
        $this->requires_id = true;
    }

    public function store()
    {
        $this->validate();
        Package::create($this->only([
            'name', 'description', 'price', 'discount_price', 
            'type', 'active', 'price_label', 'requires_id'
        ]));
        session()->flash('success', 'Package created!');
        $this->resetForm();
    }

    public function edit($id)
    {
        $package = Package::findOrFail($id);
        $this->packageId = $id;
        $this->fill($package->only([
            'name', 'description', 'price', 'discount_price', 
            'type', 'active', 'price_label', 'requires_id'
        ]));
        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate();
        $package = Package::findOrFail($this->packageId);
        $package->update($this->only([
            'name', 'description', 'price', 'discount_price', 
            'type', 'active', 'price_label', 'requires_id'
        ]));
        session()->flash('success', 'Package updated!');
        $this->resetForm();
    }

    public function delete($id)
    {
        Package::findOrFail($id)->delete();
        session()->flash('success', 'Package deleted!');
        $this->resetForm();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function searchNow()
    {
        $this->search = $this->search;
        $this->resetPage();
    }
}
