<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\AvailableDate;
use Livewire\WithPagination;

class AvailableDates extends Component
{
    use WithPagination;

    public $date_type = 'single';
    public $start_date, $end_date, $max_capacity, $closed = false;
    public $isEditing = false;
    public $availableDateId;
    public $calendarYear;
    public $calendarMonth;
    public $show_picker = false;

    protected function rules()
    {
        $rules = [
            'date_type' => 'required|in:single,range',
            'closed' => 'boolean',
        ];
        if ($this->date_type === 'range') {
            $rules['start_date'] = 'required|date|after:today';
            $rules['end_date'] = 'required|date|after_or_equal:start_date';
        } else {
            $rules['start_date'] = 'required|date|after:today';
            $rules['end_date'] = 'nullable|date|after_or_equal:start_date';
        }
        if (!$this->closed) {
            $rules['max_capacity'] = 'required|integer|min:1';
        }
        return $rules;
    }

    public function mount()
    {
        $this->calendarYear = now()->year;
        $this->calendarMonth = now()->month;
    }

    public function render()
    {
        return view('livewire.admin.available-dates', [
            'availableDates' => AvailableDate::latest()->paginate(10),
        ])->layout('layouts.admin');
    }

    public function updatedDateType()
    {
        if ($this->date_type === 'single') {
            $this->end_date = null;
        }
        $this->show_picker = false;
    }

    public function selectCalendarDate($dateStr)
    {
        if ($this->date_type === 'single') {
            $this->start_date = $dateStr;
            $this->end_date = null;
        } else {
            if (!$this->start_date || ($this->start_date && $this->end_date)) {
                $this->start_date = $dateStr;
                $this->end_date = null;
            } elseif ($dateStr < $this->start_date) {
                $this->end_date = $this->start_date;
                $this->start_date = $dateStr;
            } else {
                $this->end_date = $dateStr;
            }
        }
    }

    public function save()
    {
        $this->validate();
        $dates = collect();
        if ($this->date_type === 'range' && $this->start_date && $this->end_date) {
            $start = \Carbon\Carbon::parse($this->start_date);
            $end = \Carbon\Carbon::parse($this->end_date);
            for ($d = $start->copy(); $d->lte($end); $d->addDay()) {
                $dates->push($d->format('Y-m-d'));
            }
        } else if ($this->start_date) {
            $dates->push($this->start_date);
        }
        foreach ($dates as $date) {
            \App\Models\AvailableDate::updateOrCreate(
                [ 'date' => $date ],
                [
                    'capacity' => $this->closed ? 0 : $this->max_capacity,
                    'max_capacity' => $this->closed ? 0 : $this->max_capacity,
                    'closed' => $this->closed ? 1 : 0,
                ]
            );
        }
        $this->reset(['start_date', 'end_date', 'max_capacity', 'closed', 'show_picker']);
        // Do not reset date_type, keep user's selection
        session()->flash('success', 'Date(s) updated!');
    }
    
    public function delete($id)
    {
        \App\Models\AvailableDate::findOrFail($id)->delete();
        $this->show_picker = false;
        session()->flash('success', 'Date deleted successfully!');
    }

    public function edit($id)
    {
        $date = \App\Models\AvailableDate::findOrFail($id);
        $this->isEditing = true;
        $this->availableDateId = $id;
        $this->start_date = $date->date;
        $this->max_capacity = $date->capacity ?? $date->max_capacity;
        $this->closed = $date->closed;
        $this->date_type = 'single';
        $this->end_date = null;
        $this->show_picker = false;
    }
}
