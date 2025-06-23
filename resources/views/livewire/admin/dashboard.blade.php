<!-- Dashboard Section -->
<div class="content-section active" id="dashboard-section">
    <h2>Dashboard</h2>
    <div class="stats-cards">
        <div class="stat-card">
            <div class="stat-value">{{ $newBookings ?? 0 }}</div>
            <div class="stat-label">New Bookings</div>
            <div class="stat-icon"><i class="fas fa-calendar-plus"></i></div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $pendingApproval ?? 0 }}</div>
            <div class="stat-label">Pending Approval</div>
            <div class="stat-icon"><i class="fas fa-clock"></i></div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $registeredUsers ?? 0 }}</div>
            <div class="stat-label">Registered Users</div>
            <div class="stat-icon"><i class="fas fa-user-plus"></i></div>
        </div>
        <div class="stat-card">
            <div class="stat-value">₱{{ number_format($revenueThisMonth ?? 0, 2) }}</div>
            <div class="stat-label">Revenue This Month</div>
            <div class="stat-icon"><i class="fas fa-money-bill-wave"></i></div>
        </div>
    </div>
    <div class="recent-section">
        <h3>Recent Bookings</h3>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Customer</th>
                        <th>Package</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentBookings ?? [] as $booking)
                        <tr>
                            <td>{{ $booking->id }}</td>
                            <td>{{ $booking->customer_name }}</td>
                            <td>{{ $booking->package_name }}</td>
                            <td>{{ $booking->date }}</td>
                            <td>₱{{ number_format($booking->total_amount, 2) }}</td>
                            <td>
                                <span class="status {{ strtolower($booking->status) }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.bookings') }}" class="btn-review">Review</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No recent bookings.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
