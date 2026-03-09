<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>حركة المشروع</title>
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
        .btn-back {
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
        .btn-back:hover {
            background-color: #218838;
        }
        @media (max-width: 768px) {
            table, th, td {
                font-size: 14px;
            }
            .btn-back {
                width: 150px;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <!-- شريط علوي -->
    <div class="header">
        <div>مرحبًا، {{ Auth::user()->name }}!</div>
    </div>
    <h1> حركة المشروع: {{ $project->title }}</h1>

    <div class="container">
        <table>
            <thead>
                <tr>
                    
                    <th>اسم المشروع</th>
                    <th>المرسل</th>
                    <th>المهندس المستقبل</th>
                    <th>رابط التحميل</th>
                    <th>تاريخ الإرسال</th>
                </tr>
            </thead>
            <tbody>
                <!-- عرض المشروع الأصلي -->
                <tr>
                    
                    <td>{{ $project->title }}</td>
                    <td>{{ $project->sender->name }}</td>
                    <td>{{ optional($project->receiver)->name ?? 'غير معروف' }}</td>
                    <td>
                        @if ($project->file_path)
                            <a href="{{ asset('storage/' . $project->file_path) }}" target="_blank">📥 تحميل</a>
                        @else
                            لا يوجد ملف
                        @endif
                    </td>
                    <td>{{ $project->created_at->format('Y-m-d H:i') }}</td>
                </tr>
                <!-- عرض المشاريع المعاد توجيهها -->
                @forelse ($project->children as $index => $child)
                    <tr>
                       
                        <td>{{ $child->title }}</td>
                        <td>{{ $child->sender->name }}</td>
                        <td>{{ optional($child->receiver)->name ?? 'غير معروف' }}</td>
                        <td>
                            @if ($child->file_path)
                                <a href="{{ asset('storage/' . $child->file_path) }}" target="_blank">📥 تحميل</a>
                            @else
                                لا يوجد ملف
                            @endif
                        </td>
                        <td>{{ $child->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">❌ لا توجد حركات إعادة توجيه لهذا المشروع.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- زر العودة -->
        <a href="{{ route('received.projects') }}" class="btn-back"> العودة للمشاريع المستلمة</a>
    </div>
</body>
</html>