<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم المهندس</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background: #ecf0f3;
            font-family: "Tajawal", sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .header {
            background: #007bff;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
        }
        .container {
            max-width: 900px;
            margin: 20px auto;
            background: #ecf0f3;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 5px 5px 10px #babecc, -5px -5px 10px #ffffff;
            direction: rtl;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }
        thead th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
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
            overflow: hidden;
            border: none;
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
        }
        .btn-primary:hover {
            background: linear-gradient(145deg, #3498db, #2980b9);
        }
        .btn-success {
            background: linear-gradient(145deg, #28a745, #218838);
            font-size: 18px;
            font-weight: bold;
            padding: 12px;
            border-radius: 10px;
            transition: 0.3s;
            display: block;
            width: 100%;
            color: white;
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
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 15px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
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
            box-shadow: 3px 3px 6px #babecc, -3px -3px 6px #ffffff;
        }
        .btn-submit:hover {
            background: linear-gradient(145deg, #0056b3, #007bff);
        }
        .btn-logout {
            background: #ff4444;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
            width: 100%;
            margin-top: 20px;
        }
        .btn-logout:hover {
            background: #cc0000;
        }
        @media (max-width: 768px) {
            .container {
                margin: 10px;
                padding: 15px;
            }
            table, th, td {
                font-size: 14px;
            }
            .btn-success, .btn-submit, .btn-logout {
                font-size: 16px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- شريط علوي -->
    <div class="header">
        <h1>لوحة تحكم المهندس</h1>
        <div>مرحبًا، {{ Auth::user()->name }}!</div>
    </div>

    <div class="container">
        <!-- عرض المشاريع المستلمة -->
        <div class="card mb-4">
            <div class="card-header">المشاريع المستلمة</div>
            <div class="card-body">
                @if ($receivedProjects->isEmpty())
                    <p class="text-muted text-center">لا توجد مشاريع مستلمة.</p>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>اسم المشروع</th>
                                <th>المرسل</th>
                                <th>المستقبل</th>
                                <th>تاريخ الإرسال</th>
                                <th>الملف</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($receivedProjects as $project)
                                <tr>
                                    <td>{{ $project->title }}</td>
                                    <td>{{ $project->sender->name }}</td>
                                    <td>{{ $project->receiver->name }}</td>
                                    <td>{{ $project->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <a href="{{ asset('storage/' . $project->file_path) }}" target="_blank" class="btn-primary">
                                            عرض الملف
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        <!-- عرض المشاريع المرسلة -->
        <div class="card mb-4">
            <div class="card-header">المشاريع المرسلة إلى مهندسين آخرين</div>
            <div class="card-body">
                @if ($sentProjects->isEmpty())
                    <p class="text-muted text-center">لم يتم إرسال أي مشاريع بعد.</p>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>اسم المشروع</th>
                                <th>المرسل</th>
                                <th>المستقبل</th>
                                <th>الملف</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sentProjects as $project)
                                <tr>
                                    <td>{{ $project->title }}</td>
                                    <td>{{ $project->sender->name }}</td>
                                    <td>{{ $project->receiver->name }}</td>
                                    <td>
                                        <a href="{{ asset('storage/' . $project->file_path) }}" target="_blank" class="btn-primary">
                                            عرض الملف
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        <!-- زر لفتح نموذج إرسال مشروع -->
        <button class="btn btn-success" onclick="toggleForm()">📤 إرسال مشروع إلى مهندس آخر</button>

        <!-- نموذج إرسال المشروع -->
        <div id="sendProjectForm">
            <form id="projectForm" action="{{ route('projects.forward') }}" method="POST">
                @csrf
                <h3 class="form-title">إعادة إرسال المشروع</h3>
                <div class="form-group">
                    <label for="project_id">اختر المشروع:</label>
                    <select name="project_id" required class="form-control">
                        <option value="" disabled selected>اختر مشروعًا...</option>
                        @foreach ($receivedProjects as $project)
                            <option value="{{ $project->id }}">{{ $project->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="receiver_id">إرسال إلى مهندس آخر:</label>
                    <select name="receiver_id" required class="form-control">
                        <option value="" disabled selected>اختر مهندسًا...</option>
                        @foreach ($engineers as $engineer)
                            <option value="{{ $engineer->id }}">{{ $engineer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn-submit">إرسال</button>
            </form>
        </div>

        <!-- زر تسجيل الخروج -->
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">🚪 تسجيل الخروج</button>
        </form>
    </div>

    <script>
        function toggleForm() {
            var form = document.getElementById("sendProjectForm");
            form.style.display = form.style.display === "none" ? "block" : "none";
        }

        document.getElementById("projectForm").addEventListener("submit", function(event) {
            event.preventDefault();

            var formData = new FormData(this);

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
                if (data.success) {
                    Swal.fire({
                        title: "تم الإرسال ✅",
                        text: "تم إرسال المشروع بنجاح!",
                        icon: "success",
                        confirmButtonText: "حسنًا"
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: "خطأ ❌",
                        text: "حدث خطأ أثناء الإرسال",
                        icon: "error",
                        confirmButtonText: "حسنًا"
                    });
                }
            })
            .catch(error => {
                console.error("Error:", error);
                Swal.fire({
                    title: "خطأ ❌",
                    text: "حدث خطأ غير متوقع",
                    icon: "error",
                    confirmButtonText: "حسنًا"
                });
            });
        });
    </script>
</body>
</html>