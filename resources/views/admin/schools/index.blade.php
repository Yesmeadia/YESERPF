@extends('layouts.app')

@section('title', 'Manage Schools - YES INDIA SCHOOLS ERP Admin')

@section('styles')
<style>
    body {
        background-color: #f8fafc !important;
        color: #1e293b !important;
        font-family: 'Inter', sans-serif;
    }

    .clean-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .form-pill-input-admin {
        width: 100%;
        background-color: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 8px 12px;
        font-size: 0.75rem;
        color: #0f172a;
        outline: none;
        transition: all 0.2s ease;
    }
    .form-pill-input-admin:focus {
        background-color: #ffffff;
        border-color: #271e6d;
        box-shadow: 0 0 0 3px rgba(39, 30, 109, 0.10);
    }

    .badge-on_going { background: #d1fae5; color: #047857; }
    .badge-registered { background: #fee2e2; color: #b91c1c; }
    .badge-trial_running { background: #f3e8ff; color: #7e22ce; }
    .badge-under_construction { background: #fef9c3; color: #a16207; }
</style>
@endsection

@section('content')

<!-- Sidebar Component -->
<x-admin-sidebar active="schools" />

<!-- Main Content Area -->
<div class="lg:pl-64 min-h-screen flex flex-col justify-between">

    <!-- Page Content Container -->
    <div class="p-6 lg:p-8 space-y-6 max-w-7xl w-full mx-auto">

        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-slate-200">
            <div>
                <h1 class="text-2xl font-extrabold text-[#271e6d] tracking-tight">School Directory &amp; Status Management</h1>
                <p class="text-xs text-slate-500 mt-1">Audit campus registrations, edit status, and export database records.</p>
            </div>
            <div>
                <a href="{{ route('admin.schools.export.csv', request()->all()) }}" 
                   class="px-3.5 py-2 bg-emerald-50 border border-emerald-200 text-emerald-700 font-semibold text-xs rounded-xl hover:bg-emerald-100 transition-colors inline-flex items-center gap-2">
                    <i class="fa-solid fa-file-csv"></i> Export Filtered CSV
                </a>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="clean-card p-5">
            <form action="{{ route('admin.schools.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <div>
                    <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" 
                           placeholder="Search code, school or email..." class="form-pill-input-admin">
                </div>
                <div>
                    <select name="state_id" class="form-pill-input-admin">
                        <option value="">All States</option>
                        @foreach($states as $st)
                            <option value="{{ $st->id }}" {{ ($filters['state_id'] ?? '') == $st->id ? 'selected' : '' }}>
                                {{ $st->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select name="status" class="form-pill-input-admin">
                        <option value="">All Statuses</option>
                        <option value="registered" {{ ($filters['status'] ?? '') == 'registered' ? 'selected' : '' }}>Registered</option>
                        <option value="under_construction" {{ ($filters['status'] ?? '') == 'under_construction' ? 'selected' : '' }}>Under Construction</option>
                        <option value="trial_running" {{ ($filters['status'] ?? '') == 'trial_running' ? 'selected' : '' }}>Trial Running</option>
                        <option value="on_going" {{ ($filters['status'] ?? '') == 'on_going' ? 'selected' : '' }}>On Going</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn-purple-action text-xs w-full py-2">
                        Filter Records
                    </button>
                </div>
            </form>
        </div>

        <!-- Datatable Card -->
        <div class="clean-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-700 border-b border-slate-200 font-bold uppercase tracking-wider">
                        <tr>
                            <th class="py-3 px-4">SUIC Code</th>
                            <th class="py-3 px-4">School &amp; Principal</th>
                            <th class="py-3 px-4">State / Zone</th>
                            <th class="py-3 px-4">Capacity</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($schools as $s)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-3 px-4 font-mono font-bold text-[#271e6d]">
                                    {{ $s->suic_code ?? $s->code }}
                                </td>
                                <td class="py-3 px-4">
                                    <div class="font-bold text-slate-900 text-xs">{{ $s->name }}</div>
                                    <div class="text-[11px] text-slate-500 flex items-center gap-2 mt-0.5">
                                        <span><i class="fa-solid fa-user mr-1 text-slate-400"></i>{{ $s->principal_name ?? 'N/A' }}</span>
                                        <span>&bull;</span>
                                        <span><i class="fa-solid fa-envelope mr-1 text-slate-400"></i>{{ $s->email }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="font-semibold text-slate-800">{{ $s->state->name ?? 'N/A' }}</div>
                                    <div class="text-[11px] text-slate-500">{{ $s->zone->name ?? 'N/A' }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="text-[11px] text-slate-600">Students: <strong>{{ $s->total_students }}</strong></div>
                                    <div class="text-[11px] text-slate-600">Staff: <strong>{{ $s->total_teachers }}</strong></div>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase badge-{{ $s->status }}">
                                        {{ str_replace('_', ' ', $s->status) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-right space-x-1">
                                    <button onclick="openDetailModal('{{ $s->id }}')"
                                            class="px-2.5 py-1 rounded-lg bg-[#271e6d] text-white hover:bg-[#1f1659] font-semibold text-[11px] transition-colors"
                                            title="View Full School Record">
                                        <i class="fa-solid fa-eye mr-1"></i> View
                                    </button>
                                    <button onclick="openStatusModal('{{ $s->id }}', '{{ addslashes($s->name) }}', '{{ $s->status }}')"
                                            class="px-2.5 py-1 rounded-lg bg-slate-100 border border-slate-200 text-slate-700 hover:bg-slate-200 font-semibold text-[11px] transition-colors"
                                            title="Edit Status">
                                        <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                                    </button>
                                    <button onclick="openTimelineModal('{{ $s->id }}')"
                                            class="px-2.5 py-1 rounded-lg bg-slate-100 border border-slate-200 text-slate-700 hover:bg-slate-200 font-semibold text-[11px] transition-colors"
                                            title="Audit Log">
                                        <i class="fa-solid fa-clock-rotate-left mr-1"></i> Logs
                                    </button>
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
            <div class="p-3.5 border-t border-slate-100">
                {{ $schools->appends($filters)->links() }}
            </div>
        </div>

    </div>

    <!-- Full School Record Modal -->
    <div id="detailModal" class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white border border-slate-200 w-full max-w-3xl rounded-2xl shadow-xl overflow-hidden relative flex flex-col max-h-[85vh]">
            <div class="p-5 bg-[#271e6d] text-white flex items-center justify-between shrink-0">
                <div>
                    <span class="px-2 py-0.5 rounded bg-white/20 text-white font-mono text-[10px] font-bold" id="detailSuicBadge">SUIC</span>
                    <h3 class="text-lg font-bold text-white mt-1" id="detailSchoolTitle">Full School Record</h3>
                </div>
                <button onclick="closeDetailModal()" class="text-indigo-200 hover:text-white"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>
            <div class="p-5 space-y-4 overflow-y-auto text-slate-700 text-xs flex-grow">
                <div id="detailContainer"></div>
            </div>
            <div class="p-3.5 bg-slate-50 border-t border-slate-200 flex items-center justify-between shrink-0">
                <a id="detailFullPageLink" href="#" target="_blank" class="text-xs font-semibold text-[#271e6d] hover:underline flex items-center gap-1">
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i> Open Page View
                </a>
                <button onclick="closeDetailModal()" class="px-4 py-1.5 rounded-lg bg-slate-200 text-slate-700 font-semibold text-xs hover:bg-slate-300">
                    Close
                </button>
            </div>
        </div>
    </div>

    <!-- Status Update Modal -->
    <div id="statusModal" class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white border border-slate-200 w-full max-w-md p-5 rounded-2xl shadow-xl relative">
            <h3 class="text-base font-bold text-slate-900 mb-1" id="modalSchoolTitle">Update Accreditation Status</h3>
            <form id="statusForm" class="space-y-3.5 mt-4">
                <input type="hidden" id="modalSchoolId">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">New Status *</label>
                    <select id="modalStatusSelect" name="status" class="form-pill-input-admin">
                        <option value="registered">Registered</option>
                        <option value="under_construction">Under Construction</option>
                        <option value="trial_running">Trial Running</option>
                        <option value="on_going">On Going</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Audit Notes (Optional)</label>
                    <textarea id="modalNotes" name="notes" rows="3" placeholder="Audit comment..." class="form-pill-input-admin"></textarea>
                </div>
                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                    <button type="button" onclick="closeStatusModal()" class="px-3.5 py-1.5 rounded-lg bg-slate-100 text-slate-700 text-xs font-semibold hover:bg-slate-200">Cancel</button>
                    <button type="submit" class="btn-purple-action text-xs px-4 py-1.5">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- History Timeline Modal -->
    <div id="timelineModal" class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white border border-slate-200 w-full max-w-xl p-5 rounded-2xl shadow-xl relative">
            <div class="flex items-center justify-between mb-3 pb-2 border-b border-slate-100">
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-timeline text-indigo-600"></i> Accreditation History Log
                </h3>
                <button onclick="closeTimelineModal()" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-base"></i></button>
            </div>
            <div id="timelineContainer" class="space-y-3 max-h-80 overflow-y-auto pr-1"></div>
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

    title.textContent = 'Loading...';
    suicBadge.textContent = 'SUIC';
    fullPageLink.href = `/admin/schools/${id}`;
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