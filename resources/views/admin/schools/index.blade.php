@extends('layouts.app')

@section('title', 'School Directory & Management - YES INDIA SCHOOLS ERP Admin')

@section('styles')
    <style>
        body {
            background-color: #ffffff !important;
            color: #0f172a !important;
            font-family: 'Figtree', 'Inter', sans-serif;
            font-weight: 400;
        }

        .admin-card-light {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
            transition: all 0.2s ease;
        }

        .form-pill-input-admin {
            width: 100%;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 9px 14px;
            font-size: 0.8125rem;
            color: #0f172a;
            font-weight: 400;
            outline: none;
            transition: all 0.2s ease;
        }

        .form-pill-input-admin:focus {
            background-color: #ffffff;
            border-color: #271e6d;
            box-shadow: 0 0 0 3px rgba(39, 30, 109, 0.1);
        }

        /* Status Badges */
        .badge-on_going {
            background: #ecfdf5;
            color: #047857;
            border: 1px solid #a7f3d0;
        }

        .badge-registered {
            background: #fff1f2;
            color: #be123c;
            border: 1px solid #fecdd3;
        }

        .badge-trial_running {
            background: #faf5ff;
            color: #7e22ce;
            border: 1px solid #e9d5ff;
        }

        .badge-under_construction {
            background: #fffbeb;
            color: #b45309;
            border: 1px solid #fde68a;
        }

        /* Custom Table Styling */
        .table-custom th {
            font-size: 0.725rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #475569;
            background-color: #f8fafc;
            padding: 12px 16px;
            border-bottom: 1px solid #e2e8f0;
        }

        .table-custom td {
            padding: 12px 16px;
            vertical-align: middle;
            font-size: 0.8125rem;
            font-weight: 400;
        }

        .table-custom tbody tr {
            transition: background-color 0.15s ease;
        }

        .table-custom tbody tr:hover {
            background-color: #f8fafc;
        }
    </style>
@endsection

@section('content')

    <!-- Sidebar Component -->
    <x-admin-sidebar active="schools" />

    <!-- Main Content Area -->
    <div class="lg:pl-64 min-h-screen flex flex-col justify-between bg-white">

        <!-- Page Content Container -->
        <div class="p-4 sm:p-6 lg:p-8 space-y-6 max-w-7xl w-full mx-auto">

            <!-- Page Header Section -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-5 border-b border-slate-200/80">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        School Directory
                    </h1>
                    <p class="text-xs text-slate-500 font-normal mt-1">Audit campus registrations, edit profile records, update status, and export database records</p>
                </div>

                <div class="flex items-center gap-2.5">
                    <a href="{{ route('admin.schools.export.csv', request()->all()) }}"
                        class="px-4 py-2 bg-emerald-50 border border-emerald-200 text-emerald-700 font-bold text-xs rounded-xl hover:bg-emerald-100 transition-all inline-flex items-center gap-2 shadow-sm">
                        <i class="fa-solid fa-file-csv"></i> Export CSV
                    </a>
                    <a href="{{ route('register') }}" target="_blank"
                        class="btn-purple-action text-xs px-4 py-2 inline-flex items-center gap-2 shadow-sm">
                        <i class="fa-solid fa-plus text-xs"></i>
                        <span>Register Campus</span>
                    </a>
                </div>
            </div>

            <!-- Filter Bar Card -->
            <div class="admin-card-light p-4">
                <form action="{{ route('admin.schools.index') }}" method="GET"
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-center">
                    
                    <!-- Search Input -->
                    <div class="lg:col-span-4">
                        <input type="text"
                               name="search"
                               value="{{ $filters['search'] ?? '' }}"
                               placeholder="Search SUIC code, school name, principal or email..."
                               class="form-pill-input-admin">
                    </div>

                    <!-- State Filter -->
                    <div class="lg:col-span-3">
                        <select name="state_id" class="form-pill-input-admin">
                            <option value="">All States</option>
                            @foreach($states as $st)
                                <option value="{{ $st->id }}" {{ ($filters['state_id'] ?? '') == $st->id ? 'selected' : '' }}>
                                    {{ $st->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div class="lg:col-span-3">
                        <select name="status" class="form-pill-input-admin">
                            <option value="">All Statuses</option>
                            <option value="registered" {{ ($filters['status'] ?? '') == 'registered' ? 'selected' : '' }}>Registered</option>
                            <option value="under_construction" {{ ($filters['status'] ?? '') == 'under_construction' ? 'selected' : '' }}>Under Construction</option>
                            <option value="trial_running" {{ ($filters['status'] ?? '') == 'trial_running' ? 'selected' : '' }}>Trial Running</option>
                            <option value="on_going" {{ ($filters['status'] ?? '') == 'on_going' ? 'selected' : '' }}>On Going</option>
                        </select>
                    </div>

                    <!-- Submit & Reset Buttons -->
                    <div class="lg:col-span-2 flex items-center gap-2">
                        <button type="submit" class="btn-purple-action text-xs w-full py-2.5 px-3">
                            Filter
                        </button>
                        @if(request()->hasAny(['search', 'state_id', 'status']))
                            <a href="{{ route('admin.schools.index') }}"
                               class="p-2.5 rounded-xl bg-slate-100 text-slate-500 hover:text-slate-800 hover:bg-slate-200 transition-colors shrink-0"
                               title="Reset Filters">
                                <i class="fa-solid fa-xmark text-sm"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Clean Datatable Card -->
            <div class="admin-card-light overflow-visible">
                <div class="overflow-x-auto rounded-xl min-h-[400px] pb-16">
                    <table class="w-full text-left text-xs table-custom">
                        <thead>
                            <tr>
                                <th>SUIC Code</th>
                                <th>School &amp; Principal</th>
                                <th>State &amp; Zone</th>
                                <th>Census Strength</th>
                                <th>Status</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#e2e1f0] text-slate-700">
                            @forelse($schools as $s)
                                <tr>
                                    
                                    <!-- SUIC Code Badge -->
                                    <td class="font-mono font-bold text-[#271e6d] whitespace-nowrap">
                                        <span class="bg-[#f3f2fa] px-2.5 py-1 rounded-lg border border-[#e2e1f0] inline-block">
                                            {{ $s->suic_code ?? $s->code }}
                                        </span>
                                    </td>

                                    <!-- School & Principal Details -->
                                    <td>
                                        <div class="font-bold text-slate-900 text-sm leading-snug">
                                            <a href="{{ route('admin.schools.show', $s->id) }}" class="hover:text-[#271e6d] transition-colors">
                                                {{ $s->name }}
                                            </a>
                                        </div>
                                        <div class="text-[11px] text-slate-500 flex items-center gap-2 mt-0.5">
                                            <span>{{ $s->principal_name ?? 'N/A' }}</span>
                                            <span>&bull;</span>
                                            <span class="font-mono text-[#271e6d]">{{ $s->email }}</span>
                                        </div>
                                    </td>

                                    <!-- State & Zone -->
                                    <td class="whitespace-nowrap">
                                        <div class="font-semibold text-slate-800">{{ $s->state->name ?? 'N/A' }}</div>
                                        <div class="text-[11px] text-slate-500">{{ $s->zone->name ?? 'N/A' }}</div>
                                    </td>

                                    <!-- Census Strength -->
                                    <td class="whitespace-nowrap">
                                        <div class="text-[11px] text-slate-600">Students: <strong class="font-mono text-[#271e6d]">{{ number_format($s->total_students) }}</strong></div>
                                        <div class="text-[11px] text-slate-600">Staff: <strong class="font-mono text-emerald-700">{{ number_format($s->total_teachers) }}</strong></div>
                                    </td>

                                    <!-- Status Pill Badge -->
                                    <td class="whitespace-nowrap">
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider badge-{{ $s->status }}">
                                            {{ str_replace('_', ' ', $s->status) }}
                                        </span>
                                    </td>

                                    <!-- Action Dropdown Menu -->
                                    <td class="text-right whitespace-nowrap">
                                        <div class="relative inline-block text-left" x-data="{ open: false }" @click.away="open = false">
                                            <button @click="open = !open"
                                                    type="button"
                                                    class="w-8 h-8 rounded-xl bg-[#f3f2fa] border border-[#e2e1f0] text-[#271e6d] hover:bg-[#271e6d] hover:text-white flex items-center justify-center transition-all shadow-sm ml-auto"
                                                    title="Options">
                                                <i class="fa-solid fa-ellipsis-vertical text-sm"></i>
                                            </button>

                                            <div x-show="open"
                                                 x-cloak
                                                 x-transition:enter="transition ease-out duration-100"
                                                 x-transition:enter-start="transform opacity-0 scale-95"
                                                 x-transition:enter-end="transform opacity-100 scale-100"
                                                 x-transition:leave="transition ease-in duration-75"
                                                 x-transition:leave-start="transform opacity-100 scale-100"
                                                 x-transition:leave-end="transform opacity-0 scale-95"
                                                 class="absolute right-0 mt-1.5 w-48 rounded-xl bg-white shadow-xl border border-[#e2e1f0] py-1.5 z-50 text-xs font-medium text-slate-700 divide-y divide-slate-100 text-left">
                                                
                                                <div class="py-1">
                                                    <!-- 1. View Record Modal -->
                                                    <button @click="open = false; openDetailModal('{{ $s->id }}')"
                                                            class="w-full text-left px-3.5 py-2 hover:bg-[#f3f2fa] text-slate-700 hover:text-[#271e6d] flex items-center gap-2">
                                                        <i class="fa-solid fa-eye text-indigo-500 w-4"></i> View Details
                                                    </button>
                                                    
                                                    <!-- 2. Edit School Page -->
                                                    <a href="{{ route('admin.schools.edit', $s->id) }}"
                                                       class="block w-full text-left px-3.5 py-2 hover:bg-amber-50 text-slate-700 hover:text-amber-700 flex items-center gap-2 font-bold">
                                                        <i class="fa-solid fa-pen-to-square text-amber-500 w-4"></i> Edit Profile
                                                    </a>
                                                </div>

                                                <div class="py-1">
                                                    <!-- 3. Update Status Modal -->
                                                    <button @click="open = false; openStatusModal('{{ $s->id }}', '{{ addslashes($s->name) }}', '{{ $s->status }}')"
                                                            class="w-full text-left px-3.5 py-2 hover:bg-purple-50 text-slate-700 hover:text-purple-700 flex items-center gap-2">
                                                        <i class="fa-solid fa-tags text-purple-500 w-4"></i> Update Status
                                                    </button>

                                                    <!-- 4. Audit History Logs -->
                                                    <button @click="open = false; openTimelineModal('{{ $s->id }}')"
                                                            class="w-full text-left px-3.5 py-2 hover:bg-slate-50 text-slate-700 flex items-center gap-2">
                                                        <i class="fa-solid fa-clock-rotate-left text-slate-400 w-4"></i> Audit History
                                                    </button>
                                                </div>

                                                <div class="py-1">
                                                    <a href="{{ route('admin.schools.show', $s->id) }}"
                                                       class="block w-full text-left px-3.5 py-2 hover:bg-indigo-50 text-[#271e6d] flex items-center gap-2 font-bold">
                                                        <i class="fa-solid fa-arrow-up-right-from-square text-indigo-500 w-4"></i> Full Record Page
                                                    </a>
                                                </div>

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-10 text-center text-slate-400 text-xs">
                                        No school records found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Footer -->
                <div class="p-3.5 border-t border-[#e2e1f0] bg-[#f8fafc] rounded-b-xl">
                    {{ $schools->appends($filters)->links() }}
                </div>
            </div>

        </div>

        <!-- Quick Detail Modal -->
        <div id="detailModal"
            class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white border border-slate-200 w-full max-w-3xl rounded-2xl shadow-xl overflow-hidden relative flex flex-col max-h-[85vh]">
                <div class="p-5 bg-[#271e6d] text-white flex items-center justify-between shrink-0">
                    <div>
                        <span class="px-2 py-0.5 rounded bg-white/20 text-white font-mono text-[10px] font-bold"
                            id="detailSuicBadge">SUIC</span>
                        <h3 class="text-lg font-bold text-white mt-1" id="detailSchoolTitle">Full School Record</h3>
                    </div>
                    <button onclick="closeDetailModal()" class="text-indigo-200 hover:text-white"><i
                            class="fa-solid fa-xmark text-lg"></i></button>
                </div>
                
                <div class="p-5 space-y-4 overflow-y-auto text-slate-700 text-xs flex-grow">
                    <div id="detailContainer"></div>
                </div>

                <div class="p-3.5 bg-slate-50 border-t border-slate-200 flex items-center justify-between shrink-0">
                    <div class="flex items-center gap-2">
                        <a id="detailEditPageBtn" href="#"
                           class="btn-purple-action text-xs px-4 py-1.5 inline-flex items-center gap-1.5 shadow-sm">
                            <i class="fa-solid fa-pen-to-square"></i> Open Edit Page
                        </a>
                        <a id="detailFullPageLink" href="#" target="_blank"
                            class="px-3.5 py-1.5 rounded-lg bg-white border border-slate-200 text-slate-700 font-semibold text-xs hover:bg-slate-50 flex items-center gap-1">
                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i> View Record
                        </a>
                    </div>
                    <button onclick="closeDetailModal()"
                        class="px-4 py-1.5 rounded-lg bg-slate-200 text-slate-700 font-semibold text-xs hover:bg-slate-300">
                        Close
                    </button>
                </div>
            </div>
        </div>

        <!-- Status Update Modal -->
        <div id="statusModal"
            class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white border border-slate-200 w-full max-w-md p-5 rounded-2xl shadow-xl relative space-y-3.5">
                <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                    <h3 class="text-base font-bold text-slate-900" id="modalSchoolTitle">Update Accreditation Status</h3>
                    <button onclick="closeStatusModal()" class="text-slate-400 hover:text-slate-600">
                        <i class="fa-solid fa-xmark text-base"></i>
                    </button>
                </div>

                <form id="statusForm" class="space-y-3.5">
                    <input type="hidden" id="modalSchoolId">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">New Status *</label>
                        <select id="modalStatusSelect" name="status" class="form-pill-input-admin font-medium">
                            <option value="registered">Registered</option>
                            <option value="under_construction">Under Construction</option>
                            <option value="trial_running">Trial Running</option>
                            <option value="on_going">On Going</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Audit Notes (Optional)</label>
                        <textarea id="modalNotes" name="notes" rows="3" placeholder="Audit comment..."
                            class="form-pill-input-admin"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                        <button type="button" onclick="closeStatusModal()"
                            class="px-3.5 py-1.5 rounded-lg bg-slate-100 text-slate-700 text-xs font-semibold hover:bg-slate-200">Cancel</button>
                        <button type="submit" class="btn-purple-action text-xs px-4 py-1.5">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- History Timeline Modal -->
        <div id="timelineModal"
            class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white border border-slate-200 w-full max-w-xl p-5 rounded-2xl shadow-xl relative space-y-3">
                <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                    <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-timeline text-indigo-600"></i> Accreditation History Log
                    </h3>
                    <button onclick="closeTimelineModal()" class="text-slate-400 hover:text-slate-600">
                        <i class="fa-solid fa-xmark text-base"></i>
                    </button>
                </div>
                <div id="timelineContainer" class="space-y-2.5 max-h-80 overflow-y-auto pr-1"></div>
            </div>
        </div>

        <!-- Admin Footer -->
        <x-admin-footer />

    </div>

@endsection

@section('scripts')
    <script>
        function openDetailModal(id) {
            const modal = document.getElementById('detailModal');
            const container = document.getElementById('detailContainer');
            const title = document.getElementById('detailSchoolTitle');
            const suicBadge = document.getElementById('detailSuicBadge');
            const fullPageLink = document.getElementById('detailFullPageLink');
            const editPageBtn = document.getElementById('detailEditPageBtn');

            title.textContent = 'Loading...';
            suicBadge.textContent = 'SUIC';
            fullPageLink.href = `/admin/schools/${id}`;
            editPageBtn.href = `/admin/schools/${id}/edit`;
            
            container.innerHTML = '<div class="text-center text-slate-400 text-xs py-8"><i class="fa-solid fa-spinner fa-spin mr-2"></i> Loading record...</div>';
            modal.classList.remove('hidden');

            fetch(`/admin/schools/${id}`, { headers: { 'Accept': 'application/json' } })
                .then(res => res.json())
                .then(data => {
                    const s = data.school;
                    title.textContent = s.name;
                    suicBadge.textContent = `SUIC: ${s.suic_code || s.code}`;

                    const teachingTotal = (s.teaching_male_staff || 0) + (s.teaching_female_staff || 0);
                    const nonTeachingTotal = (s.non_teaching_male_staff || 0) + (s.non_teaching_female_staff || 0);
                    const grandStaffTotal = teachingTotal + nonTeachingTotal;
                    const totalStudents = (s.male_students || 0) + (s.female_students || 0);

                    container.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
                        <div class="font-bold text-slate-800 text-xs border-b border-slate-200 pb-1.5">School Information</div>
                        <div class="space-y-1.5 text-xs text-slate-600">
                            <div class="flex justify-between"><span>SUIC Code:</span> <strong class="font-mono text-[#271e6d]">${s.suic_code || 'N/A'}</strong></div>
                            <div class="flex justify-between"><span>Category:</span> <strong>${s.category ? s.category.name : 'N/A'}</strong></div>
                            <div class="flex justify-between"><span>State:</span> <strong>${s.state ? s.state.name : 'N/A'}</strong></div>
                            <div class="flex justify-between"><span>Zone:</span> <strong>${s.zone ? s.zone.name : 'N/A'}</strong></div>
                            <div class="pt-1"><span class="text-slate-500 block mb-0.5">Address:</span> <div class="p-2 bg-white border border-slate-200 rounded-lg text-slate-800 uppercase font-semibold">${s.address || 'N/A'}</div></div>
                        </div>
                    </div>

                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
                        <div class="font-bold text-slate-800 text-xs border-b border-slate-200 pb-1.5">Principal & Contact</div>
                        <div class="space-y-2 text-xs text-slate-600">
                            <div><span class="text-slate-500 block mb-0.5">Principal:</span> <div class="p-2 bg-white border border-slate-200 rounded-lg font-bold text-[#271e6d] uppercase">${s.principal_name || 'N/A'}</div></div>
                            <div class="p-2 bg-white border border-slate-200 rounded-lg flex justify-between"><span>Phone:</span> <strong class="font-mono">${s.phone || 'N/A'}</strong></div>
                            <div class="p-2 bg-white border border-slate-200 rounded-lg flex justify-between"><span>Email:</span> <strong class="font-mono text-[#271e6d]">${s.email || 'N/A'}</strong></div>
                        </div>
                    </div>

                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
                        <div class="font-bold text-slate-800 text-xs border-b border-slate-200 pb-1.5">Staff Census</div>
                        <div class="space-y-1.5 text-xs text-slate-600">
                            <div class="p-2 bg-white border border-slate-200 rounded-lg flex justify-between"><span>Teaching Staff:</span> <strong>${teachingTotal} (M: ${s.teaching_male_staff || 0}, F: ${s.teaching_female_staff || 0})</strong></div>
                            <div class="p-2 bg-white border border-slate-200 rounded-lg flex justify-between"><span>Non-Teaching Staff:</span> <strong>${nonTeachingTotal} (M: ${s.non_teaching_male_staff || 0}, F: ${s.non_teaching_female_staff || 0})</strong></div>
                            <div class="p-2 bg-[#271e6d] text-white rounded-lg flex justify-between font-bold"><span>Grand Total Staff:</span> <span class="font-mono">${grandStaffTotal}</span></div>
                        </div>
                    </div>

                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
                        <div class="font-bold text-slate-800 text-xs border-b border-slate-200 pb-1.5">Student Census</div>
                        <div class="space-y-1.5 text-xs text-slate-600">
                            <div class="grid grid-cols-2 gap-2 text-center">
                                <div class="p-2 bg-white border border-slate-200 rounded-lg">Male: <strong class="font-mono text-[#271e6d]">${s.male_students || 0}</strong></div>
                                <div class="p-2 bg-white border border-slate-200 rounded-lg">Female: <strong class="font-mono text-[#271e6d]">${s.female_students || 0}</strong></div>
                            </div>
                            <div class="p-2 bg-indigo-50 border border-indigo-200 text-[#271e6d] rounded-lg flex justify-between font-bold"><span>Total Enrolled Students:</span> <span class="font-mono">${totalStudents}</span></div>
                        </div>
                    </div>
                </div>
            `;
                });
        }

        function closeDetailModal() { document.getElementById('detailModal').classList.add('hidden'); }

        function openStatusModal(id, name, currentStatus) {
            document.getElementById('modalSchoolId').value = id;
            document.getElementById('modalSchoolTitle').textContent = `Update Status: ${name}`;
            document.getElementById('modalStatusSelect').value = currentStatus;
            document.getElementById('statusModal').classList.remove('hidden');
        }

        function closeStatusModal() { document.getElementById('statusModal').classList.add('hidden'); }

        document.getElementById('statusForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const id = document.getElementById('modalSchoolId').value;
            const status = document.getElementById('modalStatusSelect').value;
            const notes = document.getElementById('modalNotes')?.value || '';

            fetch(`/admin/schools/${id}/status`, {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: JSON.stringify({ status: status, notes: notes })
            }).then(res => res.json()).then(data => {
                if (data.success) { closeStatusModal(); window.location.reload(); }
                else { alert(data.message || 'Error updating status'); }
            });
        });

        function openTimelineModal(id) {
            const container = document.getElementById('timelineContainer');
            container.innerHTML = '<div class="text-center text-slate-400 text-xs py-6"><i class="fa-solid fa-spinner fa-spin mr-2"></i> Loading timeline...</div>';
            document.getElementById('timelineModal').classList.remove('hidden');

            fetch(`/admin/schools/${id}`, { headers: { 'Accept': 'application/json' } })
                .then(res => res.json())
                .then(data => {
                    if (!data.status_histories || data.status_histories.length === 0) {
                        container.innerHTML = '<div class="text-center text-slate-400 text-xs py-6">No status logs recorded.</div>';
                        return;
                    }
                    let html = '<div class="space-y-2.5">';
                    data.status_histories.forEach(h => {
                        const date = new Date(h.created_at).toLocaleString();
                        html += `
                    <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs space-y-1">
                        <div class="flex justify-between items-center"><span class="font-bold uppercase text-[#271e6d]">${h.status.replace('_', ' ')}</span> <span class="text-[10px] text-slate-400">${date}</span></div>
                        <div class="text-slate-600 text-[11px]">${h.notes || 'No comments'}</div>
                    </div>
                `;
                    });
                    html += '</div>';
                    container.innerHTML = html;
                });
        }

        function closeTimelineModal() { document.getElementById('timelineModal').classList.add('hidden'); }
    </script>
@endsection