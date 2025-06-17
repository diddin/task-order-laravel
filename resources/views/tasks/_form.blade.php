@php
    $actions = ['null' => 'Not Started', 'in progress' => 'In Progress', 'completed' => 'Completed'];
@endphp

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Detail</label>
    <textarea name="detail" rows="3" class="w-full p-2 mt-1 border rounded dark:bg-gray-700 dark:text-white">{{ old('detail', $task->detail) }}</textarea>
    @error('detail') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">No. Jaringan</label>
    <select name="network_id" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
        <option value="">-- Pilih Jaringan --</option>
        @foreach($networks as $network)
            <option value="{{ $network->id }}" {{ old('network_id', $task->network_id) == $network->id ? 'selected' : '' }}>
                {{ $network->network_number }}
            </option>
        @endforeach
    </select>
    @error('network_id') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Assign</label>
    <select name="assigned_to" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
        <option value="">-- Pilih Teknisi --</option>
        @foreach($users as $user)
            <option value="{{ $user->id }}" {{ old('assigned_to', $task->assigned_to) == $user->id ? 'selected' : '' }}>
                {{ $user->name }}
            </option>
        @endforeach
    </select>
    @error('assigned_to') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
</div>

<div class="mb-6">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Aksi</label>
    <select name="action" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
        @foreach($actions as $key => $label)
            <option value="{{ $key }}" {{ old('action', $task->action) === $key ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
    @error('action') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
</div>

<button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">
    {{ $task->exists ? 'Update Tiket' : 'Buat Tiket' }}
</button>
