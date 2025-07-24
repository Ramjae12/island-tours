<div>
    <div class="mb-4 flex justify-end">
        <a href="/user/bookings" class="btn btn-secondary">My Bookings</a>
    </div>

    @if(Auth::check())
        <div style="color:green;">User is authenticated: {{ Auth::user()->email }}</div>
    @else
        <div style="color:red;">User is NOT authenticated</div>
    @endif

    <div class="booking-form-bg">
        <!-- Progress Bar Section -->
        <div class="progress-bg">
            <div class="progress-container">
                <div class="progress-bar">
                    <div class="progress" style="width: {{ ($step-1)/3*100 }}%"></div>
                    <div class="step {{ $step >= 1 ? 'active' : '' }}">1</div>
                    <div class="step {{ $step >= 2 ? 'active' : '' }}">2</div>
                    <div class="step {{ $step >= 3 ? 'active' : '' }}">3</div>
                    <div class="step {{ $step == 4 ? 'active' : '' }}">4</div>
                </div>
                <div class="step-labels">
                    <div class="step-label {{ $step == 1 ? 'active' : '' }}">Select Date</div>
                    <div class="step-label {{ $step == 2 ? 'active' : '' }}">Choose Package</div>
                    <div class="step-label {{ $step == 3 ? 'active' : '' }}">Personal Info</div>
                    <div class="step-label {{ $step == 4 ? 'active' : '' }}">Confirmation</div>
                </div>
            </div>
        </div>

        <!-- Main Booking Card -->
        <div class="booking-form-section">
            <div class="container">
                <h2>Book Your Tour</h2>

                {{-- Step 1: Date Selection --}}
                @if($step == 1)
                <div class="form-step active">
                    <h3>Select Your Tour Date</h3>
                    <div class="calendar-container">
                        <div class="calendar-header">
                            <button type="button" wire:click="$set('calendarMonth', $calendarMonth - 1)" class="btn btn-link"><i class="fas fa-chevron-left"></i></button>
                            <h4>{{ \Carbon\Carbon::create($calendarYear, $calendarMonth)->format('F Y') }}</h4>
                            <button type="button" wire:click="$set('calendarMonth', $calendarMonth + 1)" class="btn btn-link"><i class="fas fa-chevron-right"></i></button>
                        </div>
                        <div class="weekdays">
                            <div>Sun</div><div>Mon</div><div>Tue</div><div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div>
                        </div>
                        <div class="days">
                            @php
                                $firstDay = \Carbon\Carbon::create($calendarYear, $calendarMonth, 1);
                                $daysInMonth = $firstDay->daysInMonth;
                                $startDay = $firstDay->dayOfWeek;
                            @endphp
                            @for ($i = 0; $i < $startDay; $i++)
                                <div class="calendar-day empty"></div>
                            @endfor
                            @for ($day = 1; $day <= $daysInMonth; $day++)
                                @php
                                    $dateStr = \Carbon\Carbon::create($calendarYear, $calendarMonth, $day)->toDateString();
                                    $setting = $dateSettings[$dateStr] ?? null;
                                    $isClosed = $setting && $setting['is_closed'];
                                    $isFull = $setting && $setting['current_bookings'] >= $setting['max_slots'];
                                @endphp
                                <div class="calendar-day
                                    {{ $isClosed ? 'disabled' : '' }}
                                    {{ $isFull ? 'full' : '' }}
                                    {{ $selectedDate === $dateStr ? 'selected' : '' }}"
                                    @if(!$isClosed && !$isFull)
                                        wire:click="selectDate('{{ $dateStr }}')"
                                        style="cursor:pointer; display: flex; flex-direction: column; align-items: center; justify-content: flex-start; height: 48px; position: relative;"
                                    @else
                                        style="cursor:not-allowed; display: flex; flex-direction: column; align-items: center; justify-content: flex-start; height: 48px; position: relative;"
                                    @endif
                                >
                                    <span style="margin-bottom:2px; display: block;">{{ $day }}</span>
                                    @if($setting && !$isClosed && !$isFull)
                                        <span class="slot-info" style="font-size:0.8em;color:#2563eb;font-weight:bold;line-height:1; margin-top:0; position: absolute; top: 22px; left: 50%; transform: translateX(-50%);">{{ $setting['available_slots'] }} slot{{ $setting['available_slots'] == 1 ? '' : 's' }}</span>
                                    @elseif($setting && $isClosed)
                                        <span class="slot-info" style="font-size:0.8em;color:#dc2626;font-weight:bold;line-height:1; margin-top:0; position: absolute; top: 22px; left: 50%; transform: translateX(-50%);">Closed</span>
                                    @elseif($setting && $isFull)
                                        <span class="slot-info" style="font-size:0.8em;color:#ca8a04;font-weight:bold;line-height:1; margin-top:0; position: absolute; top: 22px; left: 50%; transform: translateX(-50%);">Full</span>
                                    @endif
                                </div>
                            @endfor
                        </div>
                    </div>
                    <div class="selected-date-display">
                        <p>Selected Date: <span>{{ $selectedDate ?? 'None' }}</span></p>
                        @error('selectedDate') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-buttons">
                        <button type="button" class="btn btn-primary btn-next next-btn" wire:click="nextStep" @if(!$selectedDate) disabled @endif>Next</button>
                    </div>
                </div>
                @endif

                {{-- Step 2: Package Selection --}}
                @if($step == 2)
                <div class="form-step active">
                    <h3>Choose Your Package</h3>
                    <div class="rates-container">
                        @foreach($packages->groupBy('type') as $type => $group)
                            <div>
                                <h4>{{ strtoupper(str_replace('_', ' ', $type)) }}</h4>
                                @foreach($group as $pkg)
                                    <div class="rate-item">
                                        <div class="rate-info">
                                            <span class="rate-name">{{ $pkg->name }}</span>
                                            <span class="rate-price">
                                                ₱{{ number_format($pkg->discount_price ?? $pkg->price, 2) }}
                                                {{ $pkg->price_label ?? 'per person/day' }}
                                                @if($pkg->discount_price)
                                                    <span class="original-price">₱{{ number_format($pkg->price, 2) }}</span>
                                                @endif
                                            </span>
                                            @if($pkg->requires_id)
                                                <span class="badge-id">ID Required</span>
                                            @endif
                                        </div>
                                        <div class="quantity-selector">
                                            <button type="button" class="quantity-btn" wire:click="decreaseQuantity({{ $pkg->id }})">-</button>
                                            <span class="quantity-value">{{ $packageQuantities[$pkg->id] ?? 0 }}</span>
                                            <button type="button" class="quantity-btn" wire:click="increaseQuantity({{ $pkg->id }})">+</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                    <div class="booking-summary">
                        <h4>Booking Summary</h4>
                        <div>
                            @foreach($packages as $pkg)
                                @if(($packageQuantities[$pkg->id] ?? 0) > 0)
                                    <div>{{ $pkg->name }}: {{ $packageQuantities[$pkg->id] }} × ₱{{ number_format($pkg->discount_price ?? $pkg->price, 2) }} = ₱{{ number_format($packageQuantities[$pkg->id] * ($pkg->discount_price ?? $pkg->price), 2) }}</div>
                                @endif
                            @endforeach
                        </div>
                        <div class="total-amount">
                            <p>Total Amount: <span>₱{{ number_format($totalAmount, 2) }}</span></p>
                        </div>
                    </div>
                    @error('packageQuantities') <span class="text-danger">{{ $message }}</span> @enderror
                    <div class="form-buttons">
                        <button type="button" class="btn btn-secondary prev-btn" wire:click="prevStep">Previous</button>
                        <button type="button" class="btn btn-primary btn-next next-btn" wire:click="nextStep" @if($totalAmount <= 0) disabled @endif>Next</button>
                    </div>
                </div>
                @endif

                {{-- Step 3: Personal Information --}}
                @if($step == 3)
                <div class="form-step active">
                    <h3>Personal Information</h3>
                    <div class="form-group mb-3">
                        <label for="fullName" class="form-label">Full Name</label>
                        <input type="text" wire:model="full_name" id="fullName" required class="form-control">
                        @error('full_name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" wire:model="email" id="email" required class="form-control">
                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" wire:model="phone" id="phone" required class="form-control">
                        @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea wire:model="address" id="address" required class="form-control"></textarea>
                        @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="id-upload-section">
                        <h4>Upload Valid IDs</h4>
                        <p>Please upload a valid ID for each person in your group (required for verification)</p>
                        <div class="id-uploads">
                            @php
                                $totalIds = 0;
                                foreach($packages as $pkg) {
                                    if($pkg->requires_id && ($packageQuantities[$pkg->id] ?? 0) > 0) {
                                        $totalIds += $packageQuantities[$pkg->id];
                                    }
                                }
                            @endphp
                            @for ($i = 0; $i < $totalIds; $i++)
                                <div class="file-upload-row mb-2">
                                    <label class="form-label">ID for Person {{ $i + 1 }}:</label>
                                    <input type="file" wire:model="idUploads.{{ $i }}" accept="image/jpeg,image/png,application/pdf" required class="form-control">
                                    @error('idUploads.' . $i) <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            @endfor
                            @if($totalIds == 0)
                                <p>No ID uploads required for selected packages.</p>
                            @endif
                        </div>
                    </div>
                    <div class="form-buttons">
                        <button type="button" class="btn btn-secondary prev-btn" wire:click="prevStep">Previous</button>
                        <button type="button" class="btn btn-primary btn-next next-btn" wire:click="submit">Submit</button>
                    </div>
                </div>
                @endif

                {{-- Step 4: Confirmation --}}
                @if($step == 4)
                <div class="form-step active">
                    <h3>Booking Confirmation</h3>
                    <div class="confirmation-message">
                        <div class="confirmation-icon"><i class="fas fa-check-circle"></i></div>
                        <h4>Thank You for Your Booking!</h4>
                        <p>Your booking has been submitted and is pending approval from our administrators.</p>
                        <p>Booking Reference: <span>{{ $bookingReference }}</span></p>
                        <p>Please wait for an email confirmation with payment instructions once your booking is approved.</p>
                    </div>
                    <div class="form-buttons">
                        <a href="{{ route('user.bookings') }}" class="btn btn-primary">Return to My Bookings</a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
