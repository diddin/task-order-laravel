<x-dynamic-layout>
    <div class="body-content">  
        <div class="container flex-1 overflow-y-auto px-4 pb-20">
            <div class="wrapper">
                <a href="/dashboard" class="back-to">
                    <span class="text-xl ri-arrow-left-s-line"></span>
                    <span>Kembali</span>
                </a>
                <div class="content-chat">
                    @foreach ($chats as $date => $messages)
                        <div class="chat-perdate">
                            <div class="w-full flex justify-center py-2">
                                <div class="bg-gray-300 text-gray-700 text-xs px-3 py-1 rounded-full shadow-sm">
                                    {{ $date }}
                                </div>
                            </div>
                
                            @foreach ($messages as $chat)
                                @if ($chat->from_user_id === auth()->id())
                                    <div class="chat-sent">
                                        <div class="chat-detail">
                                            <span class="time">
                                                {{ \Carbon\Carbon::parse($chat->created_at)->format('H.i') }}
                                                <span class="pl-1 text-orange-700"> Saya </span>
                                            </span>
                                            <p>{{ $chat->message }}</p>
                                        </div>
                                    </div>
                                @else
                                    <div class="chat-received">
                                        <div class="chat-detail">
                                            <span class="time">
                                                {{ \Carbon\Carbon::parse($chat->created_at)->format('H.i') }}
                                                <span class="text-gray-400">{{ $chat->fromUser->name }}</span>
                                            </span>
                                            <p>{{ $chat->message }}</p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                </div>                
            </div>
        </div>
    </div>

     <!-- footer -->
    <div class="avara-keyboard contact">
        <div class="container">
            {{-- <form action="{{ route('chat.send') }}" method="POST">
                @csrf
                <input type="hidden" name="to_user_id" value="3">
                
                <div class="input-group-icon">
                    <input type="text" name="message" placeholder="Tulis update di sini..." required>
                    <button type="submit" class="icon ri-send-plane-fill"></button>
                </div>
            </form> --}}
            <form action="{{ route('chat.send') }}" method="POST">
                @csrf
            
                <div class="mb-4">
                    <label for="to_user_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Penerima</label>
                    <select name="to_user_id" id="to_user_id" required
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-sm px-3 py-2">
                        <option value="">Pilih penerima</option>
                        @foreach ($users as $user)
                            @if ($user->id !== auth()->id())
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            
                <div class="input-group-icon">
                    <input type="text" name="message" placeholder="Tulis update di sini..." required>
                    <button type="submit" class="icon ri-send-plane-fill"></button>
                </div>
            </form>
        </div>
    </div>
</x-dynamic-layout>