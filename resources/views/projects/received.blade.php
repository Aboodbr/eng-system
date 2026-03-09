<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المشاريع المستلمة</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            direction: rtl;
            background-color: #f8f9fa;
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
            max-width: 1200px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .search-container {
            margin-bottom: 20px;
        }
        .search-box {
            width: 50%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }
        th {
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
        .btn-home {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 12px;
            background-color: #28a745;
            color: white;
            text-align: center;
            border-radius: 5px;
            font-size: 18px;
            font-weight: bold;
            text-decoration: none;
            transition: background 0.3s;
        }
        .btn-home:hover {
            background-color: #218838;
        }
        @media (max-width: 768px) {
            .search-box {
                width: 90%;
            }
            table, th, td {
                font-size: 14px;
            }
            .btn-home {
                width: 150px;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <!-- شريط علوي -->
    <div class="header">
        <h1>📥 المشاريع المستلمة</h1>
        <div>مرحبًا، {{ Auth::user()->name }}!</div>
    </div>

    <div class="container">
        <!-- مربع البحث -->
        <div class="search-container">
            <input type="text" id="searchInput" class="search-box" placeholder="🔍 ابحث بأسم المشروع...">
        </div>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>اسم المشروع</th>
                    <th>رابط التحميل</th>
                    <th>تاريخ الإرسال</th>
                    <th>عرض حركة المشروع</th>
                </tr>
            </thead>
            <tbody id="projectsTable">
                @forelse ($projects as $index => $project)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="project-title">{{ $project->title }}</td>
                        
                        <td>
                            @if ($project->file_path)
                                <a href="{{ asset('storage/' . $project->file_path) }}" target="_blank"> تحميل</a>
                            @else
                                لا يوجد ملف
                            @endif
                        </td>
                        <td>{{ $project->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <a href="{{ route('projects.history', $project->id) }}"> عرض الحركة</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">❌ لا توجد مشاريع مستلمة.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- زر العودة -->
        <a href="{{ route('dashboard.dashboard') }}" class="btn-home">🏠 العودة للصفحة الرئيسية</a>
    </div>

    <script>
        document.getElementById('searchInput').addEventListener('keyup', function () {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('#projectsTable tr');

            rows.forEach(row => {
                let projectTitle = row.querySelector('.project-title')?.textContent.toLowerCase() || '';
                let senderName = row.querySelector('.sender-name')?.textContent.toLowerCase() || '';
                let is_VISIBLE = projectTitle.includes(filter) || senderName.includes(filter);
                row.style.display = is_VISIBLE ? '' : 'none';
            });
        });
    </script>
</body>
</html>