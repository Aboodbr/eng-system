@extends('layouts.app')

@section('title', 'لوحة تحكم السكرتير')
@section('header_title', 'لوحة تحكم السكرتير')

@section('styles')
<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: center;
        font-weight: bold;
    }
    thead th {
        background-color: #007bff;
        color: white;
    }
    tr:nth-child(even) {
        background-color: #f8f9fa;
    }
    tr:hover {
        background-color: #e9ecef;
        transition: background 0.3s;
    }
    a {
        text-decoration: none;
        color: #007bff;
        font-weight: bold;
    }
    a:hover {
        color: #0056b3;
    }
    .card {
        border-radius: 15px;
        background: #ecf0f3;
        box-shadow: 5px 5px 10px #babecc, -5px -5px 10px #ffffff;
        margin-bottom: 20px;
        padding: 15px;
    }
    .card-header {
        background: #007bff;
        color: white;
        font-size: 18px;
        font-weight: bold;
        padding: 12px;
        text-align: center;
        border-radius: 10px;
    }
    .btn-primary {
        background: linear-gradient(145deg, #2980b9, #3498db);
        border: none;
        padding: 10px 15px;
        font-size: 14px;
        color: white;
        border-radius: 8px;
        transition: 0.3s;
        box-shadow: 3px 3px 6px #babecc, -3px -3px 6px #ffffff;
        text-decoration: none;
    }
    .btn-primary:hover {
        background: linear-gradient(145deg, #3498db, #2980b9);
    }
    .btn-success {
        background: linear-gradient(145deg, #28a745, #218838);
        font-size: 18px;
        padding: 12px;
        border-radius: 10px;
        transition: 0.3s;
        display: block;
        width: 50%;
        margin: 20px auto;
        color: white;
        text-align: center;
        cursor: pointer;
        box-shadow: 3px 3px 6px #babecc, -3px -3px 6px #ffffff;
    }
    .btn-success:hover {
        background: linear-gradient(145deg, #218838, #28a745);
    }
    #sendProjectForm {
        background: #ecf0f3;
        padding: 20px;
        border-radius: 15px;
        box-shadow: 5px 5px 10px #babecc, -5px -5px 10px #ffffff;
        max-width: 500px;
        margin: 20px auto;
        display: none;
    }
    .form-title {
        font-size: 20px;
        font-weight: bold;
        color: #007bff;
        margin-bottom: 15px;
        text-align: center;
    }
    .form-group {
        margin-bottom: 15px;
        text-align: right;
    }
    label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
    }
    .form-control {
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 8px;
        background: #ecf0f3;
        box-shadow: inset 3px 3px 6px #d1d9e6, inset -3px -3px 6px #ffffff;
        font-size: 16px;
    }
    .form-control:focus {
        outline: none;
        box-shadow: inset 3px 3px 6px #babecc, inset -3px -3px 6px #ffffff;
    }
    input[type="file"] {
        padding: 8px;
        background: #ecf0f3;
        border-radius: 8px;
        box-shadow: inset 3px 3px 6px #d1d9e6, inset -3px -3px 6px #ffffff;
        cursor: pointer;
    }
    .btn-submit {
        width: 100%;
        padding: 12px;
        background: linear-gradient(145deg, #007bff, #0056b3);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        transition: 0.3s;
        cursor: pointer;
        box-shadow: 3px 3px 6px #babecc, -3px -3px 6px #ffffff;
    }
    .btn-submit:hover {
        background: linear-gradient(145deg, #0056b3, #007bff);
    }
    @media (max-width: 768px) {
        table, th, td {
            font-size: 14px;
        }
        .btn-success, .btn-submit, .btn-logout {
            width: 100%;
            font-size: 16px;
            padding: 10px;
        }
    }
</style>
@endsection

@section('content')
        <!-- المشاريع المرسلة -->
        <div class="card">
            <div class="card-header">📌 المشاريع المرسلة</div>
            <div class="card-body">
                @if ($projects->isEmpty())
                    <p class="text-muted text-center">❌ لا توجد مشاريع مرسلة.</p>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>📁 اسم المشروع</th>
                                <th>👨‍💻 اسم المهندس</th>
                                <th>📅 تاريخ الإرسال</th>
                                <th>🔗 الملف</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projects as $project)
                                <tr>
                                    <td>{{ $project->title }}</td>
                                    <td>{{ $project->receiver->name }}</td>
                                    <td>{{ $project->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <a href="{{ asset('storage/' . $project->file_path) }}" target="_blank" class="btn-primary">
                                            📄 عرض الملف
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        <!-- زر إرسال مشروع جديد -->
        <button class="btn-success" onclick="toggleForm()">➕ إرسال مشروع جديد</button>

        <!-- نموذج إرسال المشروع -->
        <div id="sendProjectForm">
            <form id="projectForm" action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <h3 class="form-title">📤 إرسال مشروع</h3>
                <div class="form-group">
                    <label for="title">📁 اسم المشروع:</label>
                    <input type="text" name="title" required class="form-control" placeholder="أدخل اسم المشروع">
                </div>
                <div class="form-group">
                    <label for="receiver_id">👨‍💻 اختر المهندس:</label>
                    <select name="receiver_id" required class="form-control">
                        <option value="" disabled selected>🔍 اختر المهندس...</option>
                        @foreach ($engineers as $engineer)
                            <option value="{{ $engineer->id }}">{{ $engineer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="file">📄 رفع الملف:</label>
                    <input type="file" name="file" required class="form-control" accept=".pdf">
                </div>
                <button type="submit" class="btn-submit">🚀 إرسال المشروع</button>
            </form>
        </div>

        <!-- زر تسجيل الخروج -->
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout" style="width: 100%; margin-top: 20px;">🚪 تسجيل الخروج</button>
        </form>
@endsection

@section('scripts')
<script>
    function toggleForm() {
        var form = document.getElementById("sendProjectForm");
        form.style.display = form.style.display === "none" ? "block" : "none";
    }

    document.getElementById("projectForm").addEventListener("submit", function(event) {
        event.preventDefault();

        // عرض تأثير اللودينج
        Swal.fire({
            title: "جارٍ الإرسال...",
            text: "يرجى الانتظار قليلاً أثناء معالجة المشروع.",
            icon: "info",
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        var formData = new FormData(this);
        var submitButton = this.querySelector(".btn-submit");
        var originalButtonText = submitButton.innerHTML;

        // تغيير نص الزر وتعطيله
        submitButton.innerHTML = "جارٍ الإرسال...";
        submitButton.disabled = true;

        fetch(this.action, {
            method: "POST",
            body: formData,
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            // إغلاق تأثير اللودينج
            Swal.close();

            // إعادة الزر إلى حالته الأصلية
            submitButton.innerHTML = originalButtonText;
            submitButton.disabled = false;

            if (data.success) {
                // عرض رسالة النجاح مع انتظار الضغط على "حسنًا"
                Swal.fire({
                    title: "تم الإرسال ✅",
                    text: "تم إرسال المشروع بنجاح!",
                    icon: "success",
                    confirmButtonText: "حسنًا",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
            } else {
                // عرض رسالة الخطأ مع انتظار الضغط على "حسنًا"
                Swal.fire({
                    title: "خطأ ❌",
                    text: data.message || "حدث خطأ أثناء الإرسال",
                    icon: "error",
                    confirmButtonText: "حسنًا",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: true
                });
            }
        })
        .catch(error => {
            // إغلاق تأثير اللودينج
            Swal.close();

            // إعادة الزر إلى حالته الأصلية
            submitButton.innerHTML = originalButtonText;
            submitButton.disabled = false;

            // عرض رسالة خطأ غير متوقع
            console.error("Error:", error);
            Swal.fire({
                title: "خطأ ❌",
                text: "حدث خطأ غير متوقع",
                icon: "error",
                confirmButtonText: "حسنًا",
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: true
            });
        });
    });
</script>
@endsection