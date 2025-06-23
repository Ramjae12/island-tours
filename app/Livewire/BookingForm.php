<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Package;
use App\Models\DateSetting;
use App\Models\Booking;
use App\Models\BookingPackage;
use App\Models\BookingId;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Notifications\BookingSubmittedNotification;
use App\Notifications\BookingResubmittedNotification;

class BookingForm extends Component
{
    use WithFileUploads;

    public $step = 1;

    // Step 1: Date selection
    public $calendarYear;
    public $calendarMonth;
    public $dateSettings = [];
    public $selectedDate = null;

    // Step 2: Package selection
    public $packages = [];
    public $packageQuantities = [];
    public $totalAmount = 0;

    // Step 3: Personal info + uploads
    public $full_name;
    public $email;
    public $phone;
    public $address;
    public $idUploads = [];

    // Step 4: Confirmation
    public $bookingReference;

    public $editMode = false;
    public $editingBookingId = null;

    protected $rules = [
        'selectedDate' => 'required|date',
        'full_name' => 'required|string|max:100',
        'email' => 'required|email|max:100',
        'phone' => 'required|string|max:20',
        'address' => 'required|string',
        'idUploads.*' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
    ];

    public function mount($booking = null)
    {
        $this->calendarYear = now()->year;
        $this->calendarMonth = now()->month;
        $this->loadDateSettings();
        $this->loadPackages();

        if ($booking) {
            $this->editMode = true;
            $this->editingBookingId = $booking;
            $this->loadBookingForEdit($booking);
        } elseif (Auth::check()) {
            $user = Auth::user();
            $this->full_name = $user->name;
            $this->email = $user->email;
            // Add phone/address if stored in user model
        }
    }

    public function loadDateSettings()
    {
        // Use AvailableDate instead of DateSetting
        $dates = \App\Models\AvailableDate::whereYear('date', $this->calendarYear)
            ->whereMonth('date', $this->calendarMonth)
            ->get();
        $this->dateSettings = [];
        foreach ($dates as $date) {
            $max = $date->max_capacity ?? $date->capacity ?? 0;
            $booked = $date->booked_count ?? $date->booked ?? 0;
            $this->dateSettings[$date->date] = [
                'is_closed' => (bool) $date->closed,
                'max_slots' => $max,
                'current_bookings' => $booked,
                'available_slots' => max($max - $booked, 0),
            ];
        }
    }

    public function loadPackages()
    {
        $this->packages = Package::where('active', 1)->get();
        foreach ($this->packages as $package) {
            $this->packageQuantities[$package->id] = 0;
        }
    }

    public function loadBookingForEdit($bookingId)
    {
        $booking = Booking::where('id', $bookingId)
            ->where('user_id', Auth::id())
            ->where('status', 'returned')
            ->firstOrFail();
        $this->selectedDate = $booking->date;
        $this->full_name = $booking->full_name;
        $this->email = $booking->email;
        $this->phone = $booking->phone;
        $this->address = $booking->address;
        $this->packageQuantities = [];
        foreach ($booking->bookingPackages as $pkg) {
            $this->packageQuantities[$pkg->package_id] = $pkg->quantity;
        }
        $this->calculateTotal();
        // Optionally load uploads if needed
    }

    public function updatedCalendarMonth($value)
    {
        if ($value < 1) {
            $this->calendarMonth = 12;
            $this->calendarYear--;
        } elseif ($value > 12) {
            $this->calendarMonth = 1;
            $this->calendarYear++;
        }
        $this->loadDateSettings();
    }

    public function selectDate($date)
    {
        $setting = $this->dateSettings[$date] ?? null;
        if ($setting && ($setting['is_closed'] || $setting['current_bookings'] >= $setting['max_slots'])) {
            $this->addError('selectedDate', 'This date is not available for booking.');
            return;
        }
        $this->selectedDate = $date;
        $this->step = 2;
    }

    // New methods for quantity control
    public function increaseQuantity($packageId)
    {
        if (!isset($this->packageQuantities[$packageId])) {
            $this->packageQuantities[$packageId] = 0;
        }
        $this->packageQuantities[$packageId]++;
        $this->calculateTotal();
    }

    public function decreaseQuantity($packageId)
    {
        if (!isset($this->packageQuantities[$packageId])) {
            $this->packageQuantities[$packageId] = 0;
        }
        if ($this->packageQuantities[$packageId] > 0) {
            $this->packageQuantities[$packageId]--;
            $this->calculateTotal();
        }
    }

    public function updatedPackageQuantities($value, $key)
    {
        // Ensure we always have a valid number
        if (!is_numeric($value)) {
            $parts = explode('.', $key);
            $id = $parts[0] ?? null;
            if ($id) {
                $this->packageQuantities[$id] = 0;
            }
        }
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $total = 0;
        foreach ($this->packageQuantities as $id => $qty) {
            $pkg = $this->packages->firstWhere('id', $id);
            if ($pkg && $qty > 0) {
                $price = $pkg->discount_price ?? $pkg->price;
                $total += $qty * $price;
            }
        }
        $this->totalAmount = $total;
    }

    public function nextStep()
    {
        if ($this->step == 1 && !$this->selectedDate) {
            $this->addError('selectedDate', 'Please select a date.');
            return;
        }
        if ($this->step == 2 && $this->totalAmount <= 0) {
            $this->addError('packageQuantities', 'Please select at least one package.');
            return;
        }
        $this->resetErrorBag();
        $this->step++;
    }

    public function prevStep()
    {
        $this->resetErrorBag();
        $this->step--;
    }

    public function submit()
    {
        $this->validate();
        $user = Auth::user();
        if (!$user) {
            $user = User::firstOrCreate(
                ['email' => $this->email],
                ['name' => $this->full_name, 'password' => bcrypt(Str::random(10))]
            );
        }
        if ($this->editMode && $this->editingBookingId) {
            $booking = Booking::where('id', $this->editingBookingId)
                ->where('user_id', $user->id)
                ->where('status', 'returned')
                ->firstOrFail();
            $booking->update([
                'date' => $this->selectedDate,
                'full_name' => $this->full_name,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'status' => 'pending',
                'total_amount' => $this->totalAmount,
            ]);
            // Update packages
            $booking->bookingPackages()->delete();
            foreach ($this->packageQuantities as $pkgId => $qty) {
                if ($qty > 0) {
                    $booking->bookingPackages()->create([
                        'package_id' => $pkgId,
                        'quantity' => $qty
                    ]);
                }
            }
            // Optionally update uploads
            // Notify all admins (email + dashboard) - add debug log
            $admins = \App\Models\User::role('admin')->get();
            \Log::info('BookingResubmittedNotification: sending to admins', [
                'admin_ids' => $admins->pluck('id'),
                'booking_id' => $booking->id
            ]);
            foreach ($admins as $admin) {
                $admin->notify(new \App\Notifications\BookingResubmittedNotification($booking));
            }
            // Notify the user (in-app + email)
            \Log::info('BookingResubmittedNotification: sending to user', [
                'user_id' => $user->id,
                'booking_id' => $booking->id
            ]);
            $user->notify(new \App\Notifications\BookingResubmittedNotification($booking));
            $this->bookingReference = $booking->id;
            $this->step = 4;
            $this->reset(['selectedDate', 'packageQuantities', 'totalAmount', 'full_name', 'email', 'phone', 'address', 'idUploads']);
            return;
        }

        $bookingId = (string) Str::uuid();

        $booking = Booking::create([
            'id' => $bookingId,
            'user_id' => $user->id,
            'date' => $this->selectedDate,
            'status' => 'pending',
            'full_name' => $this->full_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'adult_qty' => $this->packageQuantities[1] ?? 0,
            'child_qty' => $this->packageQuantities[2] ?? 0,
            'pwd_senior_qty' => $this->packageQuantities[3] ?? 0,
            'student_qty' => $this->packageQuantities[4] ?? 0,
            'lights_show_qty' => $this->packageQuantities[5] ?? 0,
            'exclusive_show_qty' => $this->packageQuantities[6] ?? 0,
            'total_amount' => $this->totalAmount,
        ]);

        foreach ($this->packageQuantities as $pkgId => $qty) {
            if ($qty > 0) {
                BookingPackage::create([
                    'booking_id' => $booking->id,
                    'package_id' => $pkgId,
                    'quantity' => $qty
                ]);
            }
        }

        // SECURE: Store ID uploads on the secure_ids disk
        foreach ($this->idUploads as $idx => $file) {
            $path = $file->store('ids', 'secure_ids');
            BookingId::create([
                'booking_id' => $booking->id,
                'file_path' => $path,
                'person_number' => $idx + 1
            ]);
        }

        // ---- NOTIFICATIONS ----
        // Notify user
        $user->notify(new BookingSubmittedNotification($booking));

        // Notify all admins
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new BookingSubmittedNotification($booking));
        }
        // ---- END NOTIFICATIONS ----

        $this->bookingReference = $booking->id;
        $this->step = 4;
        $this->reset(['selectedDate', 'packageQuantities', 'totalAmount', 'full_name', 'email', 'phone', 'address', 'idUploads']);
    }

    public function render()
    {
        return view('livewire.booking-form', [
            'packages' => $this->packages,
            'dateSettings' => $this->dateSettings,
            'calendarMonth' => $this->calendarMonth,
            'calendarYear' => $this->calendarYear,
            'step' => $this->step,
            'totalAmount' => $this->totalAmount,
        ])->layout('layouts.app');
    }
}
