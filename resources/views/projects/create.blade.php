<form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="title" class="form-label">عنوان المشروع</label>
        <input type="text" name="title" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="file" class="form-label">تحميل الملف</label>
        <input type="file" name="file" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="receiver_id" class="form-label">اختر المهندس</label>
        <select name="receiver_id" class="form-control" required>
            @foreach($engineers as $engineer)
                <option value="{{ $engineer->id }}">{{ $engineer->name }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary">إرسال المشروع</button>
</form>