@extends('layouts.valex')
@section('page-title', 'Medicine inventory')

@section('styles')
    <style>
        .inventory-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .inventory-stat-card {
            border: 1px solid rgb(var(--light-rgb) / 0.8);
            border-radius: 0.75rem;
            padding: 0.85rem 1rem;
            background: var(--custom-white);
        }

        .inventory-stat-label {
            font-size: 0.75rem;
            color: rgb(var(--text-muted));
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 0.25rem;
        }

        .inventory-stat-value {
            font-size: 1.15rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .inventory-filter-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 220px auto;
            gap: 0.65rem;
            align-items: end;
        }

        .inventory-pill {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 0.2rem 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .inventory-expiry {
            display: inline-flex;
            gap: 0.35rem;
            align-items: center;
            font-size: 0.75rem;
        }

        .inventory-table th {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
    </style>
@endsection

@section('content')
    <div class="xl:col-span-12 col-span-12">
        @if (session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        <div class="box custom-box mt-3">
            <div class="box-header flex justify-between">
                <div class="box-title">
                    Stock &amp; availability
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.medicines.create') }}" class="ti-btn !py-1 !px-2 ti-btn-primary !font-medium !text-[0.75rem]">
                        Add medicine<i class="ri-add-circle-line ms-2 inline-block align-middle"></i>
                    </a>
                </div>
            </div>
            <div class="box-body">
                <div class="inventory-stats-grid">
                    <div class="inventory-stat-card">
                        <div class="inventory-stat-label">Total medicines</div>
                        <div class="inventory-stat-value">{{ number_format($inventorySummary['total_items']) }}</div>
                    </div>
                    <div class="inventory-stat-card">
                        <div class="inventory-stat-label">Total units in stock</div>
                        <div class="inventory-stat-value">{{ number_format($inventorySummary['total_units']) }}</div>
                    </div>
                    <div class="inventory-stat-card">
                        <div class="inventory-stat-label">Available</div>
                        <div class="inventory-stat-value text-success">{{ number_format($inventorySummary['ok']) }}</div>
                    </div>
                    <div class="inventory-stat-card">
                        <div class="inventory-stat-label">Needs attention</div>
                        <div class="inventory-stat-value text-warning">{{ number_format($inventorySummary['low'] + $inventorySummary['out'] + $inventorySummary['expired']) }}</div>
                    </div>
                </div>

                <form action="{{ route('admin.medicines.index') }}" method="GET" class="mb-4">
                    <div class="inventory-filter-grid">
                        <div>
                            <label for="search" class="form-label">Search inventory</label>
                            <input
                                type="text"
                                id="search"
                                name="search"
                                class="form-control"
                                value="{{ $search }}"
                                placeholder="Search by medicine name, SKU, or note"
                            >
                        </div>
                        <div>
                            <label for="status" class="form-label">Availability</label>
                            <select id="status" name="status" class="form-control">
                                <option value="all" {{ $status === 'all' ? 'selected' : '' }}>All</option>
                                <option value="ok" {{ $status === 'ok' ? 'selected' : '' }}>Available</option>
                                <option value="low" {{ $status === 'low' ? 'selected' : '' }}>Low stock</option>
                                <option value="out" {{ $status === 'out' ? 'selected' : '' }}>Out of stock</option>
                                <option value="expired" {{ $status === 'expired' ? 'selected' : '' }}>Expired</option>
                            </select>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="ti-btn ti-btn-primary-full ti-btn-wave">Apply</button>
                            <a href="{{ route('admin.medicines.index') }}" class="ti-btn ti-btn-light ti-btn-wave">Reset</a>
                        </div>
                    </div>
                </form>

                <p class="text-textmuted text-sm mb-4">
                    Status is based on quantity, reorder level, and expiry date. Expired items are flagged even with remaining quantity.
                </p>
                <div class="table-responsive">
                    <table class="table whitespace-nowrap table-bordered min-w-full inventory-table">
                        <thead>
                            <tr class="border-b border-defaultborder">
                                <th scope="col" class="text-start">#</th>
                                <th scope="col" class="text-start">Name</th>
                                <th scope="col" class="text-start">SKU</th>
                                <th scope="col" class="text-start">Stock</th>
                                <th scope="col" class="text-start">Expiry</th>
                                <th scope="col" class="text-start">Reorder at</th>
                                <th scope="col" class="text-start">Availability</th>
                                <th scope="col" class="text-start">Notes</th>
                                <th scope="col" class="text-start">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($medicines as $medicine)
                                @php
                                    $state = $medicine->availabilityState();
                                    $daysToExpiry = $medicine->expiry_date
                                        ? now()->startOfDay()->diffInDays($medicine->expiry_date->startOfDay(), false)
                                        : null;
                                @endphp
                                <tr class="border-b border-defaultborder">
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="font-medium">{{ $medicine->name }}</td>
                                    <td>{{ $medicine->sku ?: '—' }}</td>
                                    <td>{{ number_format($medicine->quantity) }} {{ $medicine->unit }}</td>
                                    <td>
                                        @if ($medicine->expiry_date)
                                            <span class="inventory-expiry">
                                                <span>{{ $medicine->expiry_date->format('M j, Y') }}</span>
                                                @if ($daysToExpiry !== null)
                                                    @if ($daysToExpiry < 0)
                                                        <span class="inventory-pill bg-danger/10 text-danger">Expired</span>
                                                    @elseif ($daysToExpiry <= 30)
                                                        <span class="inventory-pill bg-warning/10 text-warning">{{ $daysToExpiry }}d left</span>
                                                    @endif
                                                @endif
                                            </span>
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td>{{ $medicine->reorder_level }}</td>
                                    <td>
                                        <span class="badge {{ $state['class'] }}">{{ $state['label'] }}</span>
                                    </td>
                                    <td>{{ $medicine->notes ? \Illuminate\Support\Str::limit($medicine->notes, 42) : '—' }}</td>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('admin.medicines.edit', $medicine) }}" class="text-info text-[.875rem] leading-none">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                            <form action="{{ route('admin.medicines.destroy', $medicine) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-danger text-[.875rem] leading-none" onclick="return confirm('Remove this medicine from inventory?')">
                                                    <i class="ri-delete-bin-5-line"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-textmuted">No medicines found. Add your first item or adjust filters.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
