@extends('layouts.valex')

@section('page-title', 'Clinic Dashboard')
@section('breadcrumb-parent', 'Dashboard')
@section('breadcrumb-child', 'Analytics')

@section('content')
<!-- Start::row-1 -->
<div class="grid grid-cols-12 gap-x-6">
    <div class="xxl:col-span-9 xl:col-span-12 col-span-12">
        <div class="grid grid-cols-12 gap-x-6">
            <div class="xxl:col-span-4 lg:col-span-4 col-span-12">
                <div class="box">
                    <div class="box-body">
                        <div class="">
                            <div class="flex justify-between  mb-1">
                                <span class="avatar avatar-md icon-1 bg-primary">
                                    <i class="ti ti-calendar-check text-[1.25rem] text-white"></i>
                                </span>
                                <span class="text-[1rem] mb-0 font-medium">Today Appointments</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-[1.5rem] font-medium mb-0 flex items-center">{{ number_format($todayAppointments) }}
                                </span>
                                <span
                                    class="badge bg-success/20 text-success py-1 !rounded-full font-medium ltr:mr-1 rtl:ml-1">+{{ $todayAppointments > 0 ? '1' : '0' }}%</span>
                                <span class="text-[0.75rem] text-textmuted">Actual scheduled today</span>
                            </div>
                            <div id="compltedprojects"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="xxl:col-span-4 lg:col-span-4 col-span-12">
                <div class="box">
                    <div class="box-body">
                        <div class="">
                            <div class="flex justify-between  mb-1">
                                <span class="avatar avatar-md icon-1 bg-danger">
                                    <i class="ti ti-heart text-[1.25rem] text-white"></i>
                                </span>
                                <span class="text-[1rem] mb-0 font-medium">New Pets Today</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-[1.5rem] font-medium mb-0 flex items-center">{{ number_format($newPetsToday) }}
                                </span>
                                <span
                                    class="badge bg-danger/20 text-danger py-1 !rounded-full font-medium ltr:mr-1 rtl:ml-1">+{{ $newPetsToday }}</span>
                                <span class="text-[0.75rem] text-textmuted">New registrations today</span>
                            </div>
                            <div id="overdueprojects"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="xxl:col-span-4 lg:col-span-4 col-span-12">
                <div class="box">
                    <div class="box-body">
                        <div class="">
                            <div class="flex justify-between  mb-1">
                                <span class="avatar avatar-md icon-1 bg-success">
                                    <i class="ti ti-activity text-[1.25rem] text-white"></i>
                                </span>
                                <span class="text-[1rem] mb-0 font-medium">Total Consultations</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-[1.5rem] font-medium mb-0 flex items-center">{{ number_format($totalConsultations) }}
                                </span>
                                <span
                                    class="badge bg-success/20 text-success py-1 !rounded-full font-medium ltr:mr-1 rtl:ml-1">Live</span>
                                <span class="text-[0.75rem] text-textmuted">Total recorded visits</span>
                            </div>
                            <div id="pendingprojects"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="xxl:col-span-7 col-span-12">
                <div class="box">
                    <div class="box-header ">
                        <div class="flex justify-between">
                            <h4 class="box-title mb-2">Clinic Performance Analysis</h4>
                            <div class="hs-dropdown ti-dropdown">
                                <a aria-label="anchor" href="javascript:void(0);"
                                    class="flex items-center justify-center w-[1.75rem] h-[1.75rem] !text-defaulttextcolor !text-[0.8rem] !pt-1 !pb-[0.1rem] !px-2 avatar-rounded border border-light shadow-none !font-[500]"
                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                        class="fe fe-more-horizontal text-[0.8rem]"></i>
                                </a>
                                <ul class="hs-dropdown-menu ti-dropdown-menu hidden">
                                    <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-[500] block"
                                            href="javascript:void(0);">Daily</a></li>
                                    <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-[500] block"
                                            href="javascript:void(0);">Weekly</a></li>
                                    <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-[500] block"
                                            href="javascript:void(0);">Monthly</a></li>
                                </ul>
                            </div>
                        </div>
                        <div>
                            <p class="text-[.75rem] text-textmuted font-normal mb-0">Overview of clinic appointment statuses and scheduled visits.</p>
                        </div>
                    </div>
                    <div class="box-body !pb-0">
                        <div id="projectsanalysis"></div>
                    </div>
                </div>
            </div>
            <div class="xxl:col-span-5 col-span-12">
                <div class="box">
                    <div class="box-header ">
                        <div class="justify-between flex">
                            <h4 class="box-title mb-2">Upcoming Appointments</h4>
                            <div class="hs-dropdown ti-dropdown">
                                <a aria-label="anchor" href="javascript:void(0);"
                                    class="flex items-center justify-center w-[1.75rem] h-[1.75rem] !text-defaulttextcolor !text-[0.8rem] !pt-1 !pb-[0.1rem] !px-2 avatar-rounded border border-light shadow-none !font-[500]"
                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                        class="fe fe-more-horizontal text-[0.8rem]"></i>
                                </a>
                                <ul class="hs-dropdown-menu ti-dropdown-menu hidden">
                                    <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-[500] block"
                                            href="javascript:void(0);">View All</a></li>
                                </ul>
                            </div>

                        </div>
                        <div>
                            <p class="text-[.75rem] text-textmuted font-normal mb-0">Scheduled visits for the current week.</p>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="overflow-auto">
                            <nav class="flex space-x-1 rtl:space-x-reverse justify-between mb-6"
                                aria-label="Tabs" role="tablist">
                                @php
                                    $daysOfWeek = [
                                        Carbon\Carbon::now()->startOfWeek(),
                                        Carbon\Carbon::now()->startOfWeek()->addDay(),
                                        Carbon\Carbon::now()->startOfWeek()->addDays(2),
                                        Carbon\Carbon::now()->startOfWeek()->addDays(3),
                                        Carbon\Carbon::now()->startOfWeek()->addDays(4),
                                    ];
                                @endphp
                                @foreach ($daysOfWeek as $index => $day)
                                    @php
                                        $dayKey = $day->format('D d');
                                        $isActive = $index === 0;
                                    @endphp
                                    <button type="button"
                                        class="hs-tab-active:text-white hs-tab-active:bg-primary dark:hs-tab-active:bg-primary dark:hs-tab-active:text-white p-2 sm:p-3 w-full text-[0.925rem] leading-none font-medium text-center bg-light text-defaulttextcolor rounded-sm hover:text-defaulttextcolor dark:bg-light dark:text-white/70 dark:hover:text-gray-300 {{ $isActive ? 'active' : '' }}"
                                        id="day-item-{{ $index }}" data-hs-tab="#day-{{ $index }}"
                                        aria-controls="day-{{ $index }}" role="tab">
                                        <span class="block mb-1">{{ $day->format('d') }}</span>
                                        <span class="block mb-0 opacity-70 text-xs">{{ $day->format('D') }}</span>
                                    </button>
                                @endforeach
                            </nav>
                            <div class="pt-2">
                                @foreach ($daysOfWeek as $index => $day)
                                    @php
                                        $dayKey = $day->format('D d');
                                        $dayAppointments = $upcomingAppointments[$dayKey] ?? collect();
                                        $isActive = $index === 0;
                                    @endphp
                                    <div id="day-{{ $index }}" class="{{ $isActive ? '' : 'hidden' }}"
                                        role="tabpanel" aria-labelledby="day-item-{{ $index }}">
                                        <ul class="list-unstyled mb-0 upcoming-events-list">
                                            @forelse($dayAppointments as $appointment)
                                                <li class="ti-list-group !border-0 p-0 w-full">
                                                    <div class="sm:flex justify-between w-full">
                                                        <div class="flex-auto">
                                                            <p class="mb-0 text-[0.925rem] font-medium">
                                                                {{ $appointment->service_type }}:
                                                                {{ $appointment->pet->name }}</p>
                                                            <p class="mb-0 text-textmuted">
                                                                {{ $appointment->owner->name }} •
                                                                {{ $appointment->status }}</p>
                                                        </div>
                                                        <div> <span class="text-textmuted inline-flex"><i
                                                                    class="ri-time-line align-middle ltr:mr-1 rtl:ml-1"></i>{{ Carbon\Carbon::parse($appointment->appointment_time)->format('h:ia') }}</span>
                                                        </div>
                                                    </div>
                                                </li>
                                            @empty
                                                <li class="ti-list-group !border-0 p-0 w-full text-center py-4">
                                                    <p class="text-textmuted text-sm">No appointments scheduled</p>
                                                </li>
                                            @endforelse
                                        </ul>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="xxl:col-span-3 col-span-12">
        <div class="grid grid-cols-12 gap-x-6">
            <div class="xxl:col-span-12 md:col-span-6 col-span-12">
                <div class="box !bg-primary !text-white">
                    <div class="box-body !p-0">
                        <div class="flex relative p-5 !pb-0">
                            <div class="flex-1">
                                <div class="flex items-center mb-1">
                                    <p class="mb-0 font-medium text-base !text-white">Active Pet Owners</p>
                                </div>
                                <p class="mb-0 font-medium"> <span
                                        class=" !text-white ltr:mr-1 rtl:ml-1">Records:</span>
                                    <span class="opacity-60 !text-white">{{ number_format($activePetOwners) }}</span>
                                </p>
                            </div>
                            <div class="ltr:ml-2 rtl:mr-2 min-w-fit">
                                <div class="avatar bg-white/20 text-white ring-transparent p-3"><i
                                        class="ri-group-2-line text-2xl leading-none"></i></div>
                            </div>
                        </div>
                        <div class="flex justify-between items-center p-5 !pb-0">
                            <div class="flex -space-x-2 rtl:space-x-reverse"> 
                                <img class="inline-block avatar avatar-sm !rounded-full ring-0" src="{{ asset('backend/assets/images/faces/11.jpg') }}" alt="Image Description"> 
                                <img class="inline-block avatar avatar-sm !rounded-full ring-0" src="{{ asset('backend/assets/images/faces/15.jpg') }}" alt="Image Description"> 
                                <img class="inline-block avatar avatar-sm !rounded-full ring-0" src="{{ asset('backend/assets/images/faces/16.jpg') }}" alt="Image Description"> 
                                <span class="inline-flex items-center justify-center avatar avatar-sm !rounded-full bg-white/20 border-2 border-white/20 ring-0">
                                    <span class="font-medium text-white leading-none">9+</span> 
                                </span>
                            </div>
                        </div>
                        <div id="totalclients" class="pe-2"></div>
                    </div>
                </div>
            </div>
            <div class="xxl:col-span-12 md:col-span-6 col-span-12">
                <div class="box overflow-hidden">
                    <div class="box-body !p-0">
                        <div class="px-4 pt-4">
                            <div class="flex items-center mb-3"> 
                                <span class="avatar avatar-md stat-avatar !rounded-full bg-primary/10 !text-primary me-2">
                                    <i class="bi bi-bar-chart text-[1.25rem]"></i> 
                                </span>
                                <p class="mb-0 box-title flex-grow">Vaccination Overview</p>
                            </div> 
                            <span class="text-[1.25rem] font-medium">{{ $vaccinationRate }}%</span> 
                            <span class="text-[0.75rem] text-success ms-1">
                                <i class="ti ti-trending-up mx-1"></i>Dynamic
                            </span>
                        </div>
                        <div id="totalRevenue"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End::row-1 -->

<!-- Start::row-2 -->
<div class="grid grid-cols-12 gap-x-6">
    <div class="xxl:col-span-3 col-span-12">
        <div class="box">
            <div class="box-header flex justify-between">
                <div>
                    <h4 class="box-title mb-2">On Going Treatments</h4>
                    <div>
                        <p class="text-[.75rem] text-textmuted font-normal mb-0">Active Medical Cases.</p>
                    </div>
                </div>
                <button class="!py-1 !px-2 ti-btn ti-btn-primary">View All</button>
            </div>
            <div class="box-body">
                <ul class="list-unstyled mb-0">
                    @forelse($ongoingTreatments as $treatment)
                        <li class="ti-list-group mb-4 !border-0 !p-0 w-full">
                            <div class="flex w-full">
                                <div class="ltr:mr-3 rtl:ml-3">
                                    <div class="flex"> <input type="checkbox" {{ $treatment->status == 'Completed' ? 'checked' : '' }} class="form-check-input mt-0.5" id="hs-checkbox-{{ $treatment->id }}"> </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-1">
                                        <h5 class="mb-0 text-[0.875rem] font-medium">{{ $treatment->service_type }}: {{ $treatment->pet->name }}</h5>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex -space-x-2 rtl:space-x-reverse"> 
                                            <img class="inline-block avatar avatar-sm !rounded-full" src="{{ $treatment->owner->photo ? asset('storage/' . $treatment->owner->photo) : asset('backend/assets/images/faces/9.jpg') }}" alt="Image Description">
                                        </div> 
                                        <span class="text-textmuted flex text-xs"><i class="ri-time-line ltr:mr-1 rtl:ml-1 my-auto "></i>{{ \Carbon\Carbon::parse($treatment->appointment_date)->format('d-m-y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="text-center text-textmuted py-4">No ongoing treatments</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
    <div class="xxl:col-span-6 col-span-12">
        <div class="box">
            <div class="box-header !pb-3 !border-b">
                <div class=" flex justify-between">
                    <h4 class="box-title mb-2">Recent Medical Consultations</h4>
                </div>
                <div>
                    <p class="text-[.75rem] text-textmuted font-normal mb-0">Latest clinic visits and medical notes.</p>
                </div>
            </div>
            <div class="box-body !p-0">
                <div class="overflow-auto">
                    <table class="table ti-custom-table-head w-full">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center ">Pet Owner</th>
                                <th scope="col" class="">Pet Name</th>
                                <th scope="col" class="">Vet</th>
                                <th scope="col" class="">Date</th>
                                <th scope="col" class="">Status</th>
                                <th scope="col" class="">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentConsultations as $consultation)
                                <tr class="border-b border-defaultborder dark:border-defaultborder/10">
                                    <td class="leading-none ">
                                        <div class="flex">
                                            <div class="ltr:mr-3 rtl:ml-3"> 
                                                <span class="avatar avatar-md">
                                                    <img src="{{ $consultation->pet->owner->photo ? asset('storage/' . $consultation->pet->owner->photo) : asset('backend/assets/images/faces/9.jpg') }}" alt="img" class="!rounded-full">
                                                </span> 
                                            </div>
                                            <div class="flex-1">
                                                <h6 class="font-medium text-[0.925rem]">{{ $consultation->pet->owner->name }}</h6>
                                                <span class="text-xs text-textmuted">{{ $consultation->pet->owner->email }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="!text-primary">{{ $consultation->pet->name }}</td>
                                    <td class="">{{ $consultation->vet->name }}</td>
                                    <td class="">{{ Carbon\Carbon::parse($consultation->visit_date)->format('d M Y') }}</td>
                                    <td class=" text-[0.925rem]"><span class="badge leading-none bg-primary/10 !text-primary rounded-sm py-1">Completed</span></td>
                                    <td class=""> <a href="{{ route('medical-records.show', $consultation->id) }}" class="text-primary font-medium">View Result</a></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-textmuted">No recent consultations</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="xxl:col-span-3 col-span-12">
        <div class="box">
            <div class="box-header ">
                <div class="flex justify-between">
                    <h4 class="box-title mb-2">Clinic Activity</h4>
                </div>
                <div>
                    <p class="text-[.75rem] text-textmuted font-normal mb-0">Recent updates from the management system.</p>
                </div>
            </div>
            <div class="box-body">
                <ul class="project-list mb-0">
                    @forelse($recentLogs as $log)
                        <li class="">
                            <div class=""> <i class="task-icon border-primary"></i>
                                <div class="flex">
                                    <h6 class="font-medium mb-0 !text-[0.875rem]">{{ $log->action }}</h6> 
                                    <span class="font-medium text-textmuted text-[0.75rem] ms-auto my-auto">{{ $log->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-textmuted text-[0.75rem]">{{ $log->description }} - <span class="font-medium text-primary">{{ $log->user->name ?? 'System' }}</span> </p>
                            </div>
                        </li>
                    @empty
                        <li class="text-center text-textmuted py-4">No recent activity</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End::row-2 -->

<!-- Start::row-3 -->
<div class="grid grid-cols-12 gap-x-6">
    <div class="col-span-12">
        <div class="box">
            <div class="box-header ">
                <div class="flex justify-between">
                    <h4 class="box-title mb-2">Recent Pet Registrations</h4>
                </div>
                <div>
                    <p class="text-[.75rem] text-textmuted font-normal mb-0">History of newly registered pets and owners.</p>
                </div>
            </div>
            <div class="box-body project-table">
                <div class="table-responsive">
                    <table class="table table-auto order-table ti-custom-table table-bordered mb-0 text-nowrap w-full !border-defaultborder dark:!border-defaultborder/10">
                        <thead class="bg-light dark:bg-black/20">
                            <tr>
                                <th scope="col">S.no</th>
                                <th scope="col">Owner Name</th>
                                <th scope="col">Pet Breed</th>
                                <th scope="col">Owner ID</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentPets as $index => $pet)
                                <tr class="border-b border-defaultborder dark:border-defaultborder/10">
                                    <td>{{ $index + 1 }}</td>
                                    <td> <span class="text-sm text-gray-800 dark:text-white font-semibold">{{ $pet->owner->name }}</span> </td>
                                    <td>{{ $pet->breed }} ({{ $pet->species }})</td>
                                    <td>#PET-{{ $pet->id }}</td>
                                    <td><span class="truncate whitespace-nowrap inline-block badge !rounded-full text-xs font-medium bg-primary/10 text-primary">Registered</span> </td>
                                    <td class="font-medium space-x-2 rtl:space-x-reverse">
                                        <a href="{{ route('pets.show', $pet->id) }}" class="ti-btn ti-btn-soft-primary !border !border-primary/20"><i class="ti ti-eye"></i> </a>
                                        <a href="{{ route('pets.edit', $pet->id) }}" class="ti-btn ti-btn-soft-info !border !border-info/20"><i class="ti ti-pencil"></i> </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-textmuted">No recent registrations</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="box-footer">
                <div class="sm:flex items-center">
                    <div class="text-defaulttextcolor dark:text-defaulttextcolor/70">
                        Showing 5 Entries <i class="bi bi-arrow-right ms-2 font-semibold"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End::row-3 -->
@endsection

@section('scripts')
    <!-- Projects Dashboard JS -->
    <script src="{{ asset('backend/assets/js/projectsdashboard.js') }}"></script>
    <script>
        // Override charts with dynamic data
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Clinic Performance Analysis
            if (typeof chart5 !== 'undefined') {
                chart5.updateOptions({
                    xaxis: {
                        categories: {!! json_encode($performanceAnalysis['months']) !!}
                    },
                    series: [{
                        name: 'Appointments',
                        type: "column",
                        data: {!! json_encode($performanceAnalysis['appointments']) !!}
                    }, {
                        name: "Consultations",
                        type: "line",
                        data: {!! json_encode($performanceAnalysis['consultations']) !!},
                    }, {
                        name: "Growth",
                        type: "line",
                        data: {!! json_encode($performanceAnalysis['growth']) !!},
                    }]
                });
            }

            // 2. Active Pet Owners (New registrations)
            if (typeof chart !== 'undefined') {
                chart.updateOptions({
                    series: [{
                        name: 'Registrations',
                        type: "bar",
                        data: {!! json_encode($petRegistrations) !!}
                    }]
                });
            }

            // 3. Vaccination Overview Sparkline
            if (typeof charttotalRevenue !== 'undefined') {
                charttotalRevenue.updateOptions({
                    series: [{
                        name: "Vaccinations",
                        data: {!! json_encode($vaccinationTrend) !!},
                    }]
                });
            }
        });
    </script>
@endsection
