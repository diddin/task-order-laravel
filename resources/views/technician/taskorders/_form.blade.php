<div>
    <!-- Task Selection -->
    <div class="mb-4">
        <label for="task_id" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Tiket</label>
        <select name="task_id" id="task_id" class="mt-1 block w-full">
            <option value="">-- Pilih Tiket --</option>
            @foreach($tasks as $task)
                <option value="{{ $task->id }}"
                    {{ old('task_id', $taskOrder->task_id ?? '') == $task->id ? 'selected' : '' }}>
                    {{ $task->detail }}
                </option>
            @endforeach
        </select>
        @error('task_id') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
    </div>

    <!-- Status Input -->
    <div class="mb-4">
        <label for="status" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Status</label>
        <textarea name="status" id="status" rows="5"
            class="mt-1 block w-full">{{ old('status', $taskOrder->status ?? '') }}</textarea>
        @error('status') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
    </div>
</div>
