<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم المحاسب</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background: #ecf0f3;
            font-family: "Tajawal", sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            direction: rtl;
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
            background: #ecf0f3;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 5px 5px 10px #babecc, -5px -5px 10px #ffffff;
        }
        h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
        }
        a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
        a:hover {
            color: #0056b3;
        }
        .btn-admin {
            display: inline-block;
            margin-bottom: 20px;
            padding: 12px 20px;
            background: linear-gradient(145deg, #17a2b8, #138496);
            color: white;
            border-radius: 8px;
            transition: 0.3s;
            box-shadow: 3px 3px 6px #babecc, -3px -3px 6px #ffffff;
            font-size: 16px;
        }
        .btn-admin:hover {
            background: linear-gradient(145deg, #138496, #17a2b8);
        }
        .btn-add {
            display: inline-block;
            margin-bottom: 20px;
            padding: 12px 20px;
            background: linear-gradient(145deg, #28a745, #218838);
            color: white;
            border-radius: 8px;
            transition: 0.3s;
            box-shadow: 3px 3px 6px #babecc, -3px -3px 6px #ffffff;
            font-size: 16px;
        }
        .btn-add:hover {
            background: linear-gradient(145deg, #218838, #28a745);
        }
        .btn-edit {
            background: linear-gradient(145deg, #ffc107, #e0a800);
            border: none;
            padding: 8px 12px;
            color: white;
            border-radius: 8px;
            transition: 0.3s;
            box-shadow: 3px 3px 6px #babecc, -3px -3px 6px #ffffff;
            font-size: 14px;
            cursor: pointer;
        }
        .btn-edit:hover {
            background: linear-gradient(145deg, #e0a800, #ffc107);
        }
        .btn-delete {
            background: linear-gradient(145deg, #ff4444, #cc0000);
            border: none;
            padding: 8px 12px;
            color: white;
            border-radius: 8px;
            transition: 0.3s;
            box-shadow: 3px 3px 6px #babecc, -3px -3px 6px #ffffff;
            font-size: 14px;
            cursor: pointer;
        }
        .btn-delete:hover {
            background: linear-gradient(145deg, #cc0000, #ff4444);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        th {
            background: #007bff;
            color: white;
            padding: 12px;
            text-align: center;
            font-weight: bold;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        tbody tr:nth-child(even) {
            background: #f8f9fa;
        }
        tbody tr:hover {
            background: #e6f7ff;
            transition: background 0.3s;
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
        .search-container {
            margin-bottom: 20px;
            display: flex;
            justify-content:flex-start;
        }
        .search-input {
            padding: 12px;
            width: 400px;
            border-radius: 8px;
            box-shadow: inset 2px 2px 5px #babecc, inset -2px -2px 5px #ffffff;
            font-size: 16px;
            background: #ecf0f3;
            outline: none;
            transition: box-shadow 0.3s;
        }
        .search-input:focus {
            box-shadow: inset 1px 1px 3px #babecc, inset -1px -1px 3px #ffffff;
        }
        @media (max-width: 768px) {
            .container {
                margin: 10px;
                padding: 15px;
            }
            table, th, td {
                font-size: 14px;
            }
            .btn-add, .btn-edit, .btn-delete, .btn-logout {
                width: 100%;
                font-size: 14px;
                padding: 10px;
                margin: 5px 0;
            }
            .search-input {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- شريط علوي -->
    <div class="header">
        <h1>💰 لوحة تحكم المحاسب</h1>
        <div>مرحبًا، {{ Auth::user()->name }}!</div>
    </div>

    <div class="container">
        <h2>سجل المعاملات</h2>
        <!-- مربع البحث -->
        <div class="search-container">
            <input type="text" id="searchInput" class="search-input" placeholder="ابحث باسم العميل..." onkeyup="searchTable()">
        </div>
        <a href="{{ route('transactions.create') }}" class="btn-add">➕ إضافة معاملة جديدة</a>
        @if (Auth::user()->role === 'admin')
            <a href="{{ route('dashboard.dashboard') }}" class="btn-admin">🏠 العودة إلى صفحة الأدمن</a>
        @endif
        <table id="transactionsTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>اسم المعاملة</th>
                    <th>كود المعاملة</th>
                    <th>اسم العميل</th>
                    <th>قيمة المعاملة</th>
                    <th>الدفعة 1</th>
                    <th>الدفعة 2</th>
                    <th>الدفعة 3</th>
                    <th>المدفوع</th>
                    <th>المتبقى</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transactions as $transaction)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $transaction->transaction_name }}</td>
                        <td>{{ $transaction->transaction_code }}</td>
                        <td>{{ $transaction->client_name }}</td>
                        <td>{{ number_format($transaction->total_amount, 2) }}</td>
                        <td>{{ number_format($transaction->installment_1, 2) }}</td>
                        <td>{{ number_format($transaction->installment_2, 2) }}</td>
                        <td>{{ number_format($transaction->installment_3, 2) }}</td>
                        <td>{{ number_format($transaction->paid_amount, 2) }}</td>
                        <td>{{ number_format($transaction->remaining_amount, 2) }}</td>
                        <td>
                            <a href="{{ route('transactions.edit', $transaction->id) }}" class="btn-edit">✏️ تعديل</a>
                            <button onclick="deleteTransaction({{ $transaction->id }})" class="btn-delete">🗑️ حذف</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11">❌ لا توجد معاملات حاليًا.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- زر تسجيل الخروج -->
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">🚪 تسجيل الخروج</button>
        </form>
    </div>

    <script>
        function deleteTransaction(id) {
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: "لن تتمكن من استرجاع هذه المعاملة بعد الحذف!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'نعم، احذفها!',
                cancelButtonText: 'إلغاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/accountant/transactions/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'تم الحذف!',
                                text: 'تم حذف المعاملة بنجاح.',
                                icon: 'success',
                                confirmButtonText: 'حسنًا'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'خطأ!',
                                text: 'حدث خطأ أثناء الحذف.',
                                icon: 'error',
                                confirmButtonText: 'حسنًا'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'خطأ!',
                            text: 'حدث خطأ غير متوقع.',
                            icon: 'error',
                            confirmButtonText: 'حسنًا'
                        });
                    });
                }
            });
        }

        // دالة البحث في الجدول
        function searchTable() {
            const input = document.getElementById("searchInput").value.toLowerCase();
            const table = document.getElementById("transactionsTable");
            const rows = table.getElementsByTagName("tr");

            for (let i = 0; i < rows.length; i++) {
                const clientNameCell = rows[i].getElementsByTagName("td")[3]; // العمود الرابع (اسم العميل)
                if (clientNameCell) {
                    const clientName = clientNameCell.textContent.toLowerCase();
                    if (clientName.includes(input)) {
                        rows[i].style.display = "";
                    } else {
                        rows[i].style.display = "none";
                    }
                }
            }
        }
    </script>
</body>
</html>