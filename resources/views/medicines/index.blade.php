@extends('layouts.valex')
@section('page-title', 'Medicine inventory')
@section('breadcrumb-parent', 'Management')
@section('breadcrumb-child', 'Medicines')

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
                <a href="{{ route('admin.medicines.create') }}" class="ti-btn !py-1 !px-2 ti-btn-primary !font-medium !text-[0.75rem]">
                    Add medicine<i class="ri-add-circle-line ms-2 inline-block align-middle"></i>
                </a>
            </div>
            <div class="box-body">
                <p class="text-textmuted text-sm mb-4">
                    Status is based on quantity, reorder level, and expiry date. Expired items are flagged even if quantity remains.
                </p>
                <div class="table-responsive">
                    <table class="table whitespace-nowrap table-bordered min-w-full">
                        <thead>
                            <tr class="border-b border-defaultborder">
                                <th scope="col" class="text-start">Name</th>
                                <th scope="col" class="text-start">SKU</th>
                                <th scope="col" class="text-start">Quantity</th>
                                <th scope="col" class="text-start">Unit</th>
                                <th scope="col" class="text-start">Expiry</th>
                                <th scope="col" class="text-start">Reorder at</th>
                                <th scope="col" class="text-start">Availability</th>
                                <th scope="col" class="text-start">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($medicines as $medicine)
                                @php $state = $medicine->availabilityState(); @endphp
                                <tr class="border-b border-defaultborder">
                                    <td class="font-medium">{{ $medicine->name }}</td>
                                    <td>{{ $medicine->sku ?: '—' }}</td>
                                    <td>{{ $medicine->quantity }}</td>
                                    <td>{{ $medicine->unit }}</td>
                                    <td>{{ $medicine->expiry_date ? $medicine->expiry_date->format('D, M j, Y') : '—' }}</td>
                                    <td>{{ $medicine->reorder_level }}</td>
                                    <td>
                                        <span class="badge {{ $state['class'] }}">{{ $state['label'] }}</span>
                                    </td>
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
                                    <td colspan="8" class="text-center text-textmuted">No medicines yet. Add your first item.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
