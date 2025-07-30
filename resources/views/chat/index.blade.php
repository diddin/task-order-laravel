<x-dynamic-layout>
    <div class="body-content">  
        <div class="container space-y-6">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Percakapan</h3>
            @if($availableUsers->count())
                <form action="{{ route('chats.thread.redirect') }}" method="GET" class="mb-6">
                    <label for="to_user_id" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-200">Mulai Chat Baru</label>
                    <div class="flex items-center gap-2">
                        <select id="to_user_id" name="to_user_id" class="select2 w-full">
                            @if(Auth::user()->role->name !== 'technician')
                                <option  value="0">
                                    -- Pilih Teknisi --
                                </option>
                            @else
                                <option value="0">
                                    -- Pilih Admin --
                                </option>
                            @endif
                            @foreach($availableUsers as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}  {{-- ({{ $user->role->name }}) --}}</option>
                            @endforeach
                        </select>
                        <button type="submit" id="send" 
                            class="bg-gray-500 text-gray hover:bg-gray-700 hover:text-white 
                            disabled:bg-gray-300 disabled:text-gray-500 disabled:cursor-not-allowed 
                            border border-gray-600 disabled:border-gray-400
                            px-4 py-2 rounded-md text-sm transition">
                            Mulai
                        </button>
                    </div>
                </form>
            @endif
            <div class="wrapper mt-10 bg-white dark:bg-gray-900 py-6 px-4 max-w-4xl mx-auto rounded-md shadow-md">
                @forelse($chats as $chat)
                    @php
                        $otherUser = $chat->from_user_id == Auth::id() ? $chat->toUser : $chat->fromUser;
                    @endphp
                    <a href="{{ route('chats.thread', $otherUser) }}" 
                    class="flex items-center justify-between gap-4 p-4 
                    hover:bg-gray-100 dark:hover:bg-gray-800 
                    border-b border-gray-100 dark:border-gray-700 last:border-none
                    {{ $chat->is_read == 0 ? 'bg-blue-50 dark:bg-gray-900' : '' }}">
                        <div class="flex items-center gap-3">
                            <!-- Avatar Placeholder -->
                            <div class="w-10 h-10 rounded-full bg-gray-300 dark:bg-gray-700 flex items-center justify-center overflow-hidden text-sm font-bold text-white">
                                @if(!empty($otherUser->profile_image) && file_exists(storage_path('app/public/' . $otherUser->profile_image)))
                                    <img 
                                        src="{{ asset('storage/' . $otherUser->profile_image) }}" 
                                        alt="{{ $otherUser->name }}" 
                                        class="w-full h-full object-cover rounded-full"
                                    >
                                @else
                                    {{ strtoupper(substr($otherUser->name, 0, 1)) }}
                                @endif
                            </div>
                            <!-- Name & Message -->
                            <div>
                                <div class="font-medium text-gray-800 dark:text-gray-100">{{ $otherUser->name }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ Str::limit($chat->message, 50) }}</div>
                            </div>
                        </div>
                        <!-- Time -->
                        <div class="text-xs text-gray-400 dark:text-gray-500 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($chat->created_at)->translatedFormat('d F Y') }} <br/>
                            {{ \Carbon\Carbon::parse($chat->created_at)->translatedFormat('H.i') }}
                        </div>
                    </a>
                @empty
                    <div class="text-center text-gray-500 dark:text-gray-400 py-10">Belum ada percakapan.</div>
                @endforelse
            </div>            
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            $('#to_user_id').select2({
                //placeholder: '-- Pilih Admin --',
                allowClear: true
            });

            function toggleButton() {
                var selectedValue = $('#to_user_id').val();
                $('#send').prop('disabled', selectedValue === '0');
            }

            // Jalankan saat halaman pertama kali dimuat
            toggleButton();

            // Jalankan saat nilai select berubah
            $('#to_user_id').on('change', toggleButton);
        });
    </script>
    @endpush
</x-dynamic-layout>