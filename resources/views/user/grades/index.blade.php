@extends('layouts.user')

@section('content')
<style>
    table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border-radius: 10px;
        overflow: hidden;
        margin-top: 20px;
    }
    th, td {
        padding: 10px 12px;
        border-bottom: 1px solid #eee;
        text-align: center;
    }
    th {
        background: #e3f2fd;
        color: #1565c0;
    }
    tr:hover {
        background: #f9fbff;
    }
    .btn {
        padding: 6px 10px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        font-size: 13px;
    }
    .btn-add { background: #4caf50; color: white; margin-bottom: 15px; }
    .btn-edit { background: #2196f3; color: white; }
    .btn-delete { background: #e53935; color: white; margin-left: 5px; }
    .btn-save { background: #ff9800; color: white; }
    input[type="text"], input[type="number"], select {
        width: 80px;
        padding: 4px 6px;
        font-size: 13px;
    }
    .status-pass { color: #4caf50; font-weight: bold; }
    .status-fail { color: #e53935; font-weight: bold; }
</style>
<h2>Quản lý bảng điểm</h2>
<br>
<button class="btn btn-add" id="btn-add-row">+ Thêm môn</button>

<form id="grade-form" method="POST">
    @csrf
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên môn học</th>
                <th>QT</th>
                <th>GK</th>
                <th>CK</th>
                <th>KQ</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>

        <tbody id="grade-table-body">
            @php $stt = 1; @endphp
            @foreach($grades as $grade)
                <tr data-id="{{ $grade->id }}" data-mode="view">
                    <td>{{ $stt++ }}</td>

                    {{-- Tên môn --}}
                    <td class="col-subject">
                        <span class="text">{{ $grade->subject_name }}</span>
                        <input type="text" 
                               class="edit-input" 
                               name="subject_name"
                               value="{{ $grade->subject_name }}" 
                               style="display:none;">
                    </td>

                    {{-- QT --}}
                    <td class="col-qt">
                        <span class="text-score">{{ $grade->process_score }}</span>
                        <input type="number" 
                               class="edit-score" 
                               name="process_score"
                               value="{{ $grade->process_score }}" 
                               min="0" max="10" step="0.1" 
                               style="display:none;">

                        <br>

                        <span class="text-weight">{{ $grade->process_weight }}%</span>
                        <select class="edit-weight" 
                                name="process_weight"
                                style="display:none;">
                            <option value="">%</option>
                            @for($i=0;$i<=100;$i+=5)
                                <option value="{{ $i }}" {{ $grade->process_weight == $i ? 'selected' : '' }}>
                                    {{ $i }}%
                                </option>
                            @endfor
                        </select>
                    </td>

                    {{-- GK --}}
                    <td class="col-gk">
                        <span class="text-score">{{ $grade->midterm_score }}</span>
                        <input type="number" 
                               class="edit-score" 
                               name="midterm_score"
                               value="{{ $grade->midterm_score }}" 
                               min="0" max="10" step="0.1" 
                               style="display:none;">

                        <br>

                        <span class="text-weight">{{ $grade->midterm_weight }}%</span>
                        <select class="edit-weight" 
                                name="midterm_weight"
                                style="display:none;">
                            <option value="">%</option>
                            @for($i=0;$i<=100;$i+=5)
                                <option value="{{ $i }}" {{ $grade->midterm_weight == $i ? 'selected' : '' }}>
                                    {{ $i }}%
                                </option>
                            @endfor
                        </select>
                    </td>

                    {{-- CK --}}
                    <td class="col-ck">
                        <span class="text-score">{{ $grade->final_score }}</span>
                        <input type="number" 
                               class="edit-score" 
                               name="final_score"
                               value="{{ $grade->final_score }}" 
                               min="0" max="10" step="0.1" 
                               style="display:none;">

                        <br>

                        <span class="text-weight">{{ $grade->final_weight }}%</span>
                        <select class="edit-weight" 
                                name="final_weight"
                                style="display:none;">
                            <option value="">%</option>
                            @for($i=0;$i<=100;$i+=5)
                                <option value="{{ $i }}" {{ $grade->final_weight == $i ? 'selected' : '' }}>
                                    {{ $i }}%
                                </option>
                            @endfor
                        </select>
                    </td>

                    {{-- KQ --}}
                    <td class="col-kq">{{ $grade->result_score }}</td>

                    {{-- Trạng thái --}}
                    <td class="col-status">
                        <span class="{{ $grade->status === 'đạt' ? 'status-pass' : 'status-fail' }}">
                            {{ $grade->status }}
                        </span>
                    </td>

                    {{-- Thao tác --}}
                    <td class="col-actions">
                        <button type="button" class="btn btn-edit" onclick="editRow(this)">Sửa</button>
                        <button type="button" class="btn btn-delete" onclick="confirmDelete('{{ $grade->id }}')">Xóa</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</form>

<form id="delete-form" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>
<script>
const addBtn = document.getElementById('btn-add-row');
const tbody = document.getElementById('grade-table-body');
let newRowIndex = Number("{{ count($grades) + 1 }}");

/* ============================
   1) TẠO DÒNG MỚI
============================ */
addBtn.addEventListener('click', () => {
    const tr = document.createElement('tr');
    tr.dataset.mode = 'new';

    tr.innerHTML = `
        <td>${newRowIndex++}</td>
        <td><input type="text" name="subject_name" placeholder="Tên môn" required></td>

        ${generateScoreColumn('process')}
        ${generateScoreColumn('midterm')}
        ${generateScoreColumn('final')}

        <td class="col-kq">0</td>
        <td class="col-status"><span class="status-fail">không đạt</span></td>

        <td class="col-actions">
            <button type="button" class="btn btn-save" onclick="saveNewRow(this)">Lưu</button>
        </td>
    `;

    tbody.appendChild(tr);
});

/* ============================
   2) TẠO CỘT ĐIỂM + TRỌNG SỐ
============================ */
function generateScoreColumn(prefix) {
    return `
        <td class="col-${prefix}">
            <input type="number" name="${prefix}_score" class="score-input"
                   min="0" max="10" step="0.1" placeholder="Điểm">

            <br>

            <select name="${prefix}_weight" class="weight-select"
                    onchange="onWeightChange(this)">
                <option value="">%</option>
                ${Array.from({length: 21}, (_, i) => `<option value="${i*5}">${i*5}%</option>`).join('')}
            </select>
        </td>
    `;
}

/* ============================
   3) RÀNG BUỘC: 0% → KHÔNG CHO NHẬP ĐIỂM
============================ */
// function onWeightChange(selectEl) {
//     const td = selectEl.closest('td');
//     const scoreInput = td.querySelector('.score-input');

//     const weight = Number(selectEl.value || 0);

//     if (weight === 0) {
//         scoreInput.value = "";
//         scoreInput.disabled = true;
//     } else {
//         scoreInput.disabled = false;
//     }
// }

/* ============================
   4) KIỂM TRA TỔNG % = 100
============================ */
function validateWeights(row) {
    const qt = Number(row.querySelector('[name="process_weight"]')?.value || 0);
    const gk = Number(row.querySelector('[name="midterm_weight"]')?.value || 0);
    const ck = Number(row.querySelector('[name="final_weight"]')?.value || 0);

    const total = qt + gk + ck;

    if (total !== 100) {
        showMessageBox(`Tổng phần trăm QT (${qt}%) + GK (${gk}%) + CK (${ck}%) phải bằng 100% (hiện tại = ${total}%).`);
        return false;
    }

    return true;
}

/* ============================
   5) LƯU DÒNG MỚI
============================ */
function saveNewRow(btn) {
    const row = btn.closest('tr');
    const form = document.getElementById('grade-form');

    if (!validateWeights(row)) return;

    form.action = `{!! route('user.grades.store') !!}`;
    form.method = "POST";

    const inputs = row.querySelectorAll('input, select');
    inputs.forEach(input => {
        const hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.name = input.name;
        hidden.value = input.value;
        form.appendChild(hidden);
    });

    form.submit();
}

/* ============================
   6) CHUYỂN SANG CHẾ ĐỘ SỬA
============================ */
function editRow(btn) {
    const row = btn.closest('tr');
    row.dataset.mode = 'edit';

    row.querySelectorAll('.text, .text-score, .text-weight').forEach(el => el.style.display = 'none');
    row.querySelectorAll('.edit-input, .edit-score, .edit-weight').forEach(el => {
        el.style.display = 'inline-block';

        // Nếu weight = 0 → disable điểm
        if (el.classList.contains('edit-weight')) {
            const weight = Number(el.value || 0);
            const scoreInput = el.closest('td').querySelector('.edit-score');
            if (weight === 0) scoreInput.disabled = true;
        }
    });

    row.querySelector('.col-actions').innerHTML =
        `<button type="button" class="btn btn-save" onclick="saveEditRow(this)">Lưu</button>`;
}

/* ============================
   7) LƯU KHI SỬA
============================ */
function saveEditRow(btn) {
    const row = btn.closest('tr');
    const id = row.dataset.id;
    const form = document.getElementById('grade-form');

    if (!validateWeights(row)) return;

    form.action = `{!! url('/user/grades') !!}/${id}`;
    form.method = "POST";

    const method = document.createElement('input');
    method.type = 'hidden';
    method.name = '_method';
    method.value = 'PUT';
    form.appendChild(method);

    row.querySelectorAll('.edit-input, .edit-score, .edit-weight').forEach(input => {
        const hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.name = input.getAttribute('name');
        hidden.value = input.value;
        form.appendChild(hidden);
    });

    form.submit();
}

/* ============================
   8) XÓA
============================ */
function confirmDelete(id) {
    const deleteUrl = `{!! url('/user/grades') !!}/${id}`;

    showConfirmBox(
        "Bạn có chắc muốn xoá môn học này?",
        deleteUrl,
        function(url) {
            const form = document.getElementById('delete-form');
            form.action = url;
            form.submit();
        }
    );
}
</script>


@endsection
