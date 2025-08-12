<x-dynamic-layout>
    <div class="body-content">  
        <div class="container flex-1 overflow-y-auto px-4 pb-20">
            <div class="wrapper">
                <a href="{{ route('chats.index') }}" class="back-to">
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
                                            <span class="time text-white-500">
                                                {{ \Carbon\Carbon::parse($chat->created_at)->format('H.i') }}
                                                <span class="pl-1 text-white-700 font-bold"> Saya </span>
                                            </span>
                                            <p>{{ $chat->message }}</p>
                                        </div>
                                    </div>
                                @else
                                    <div class="chat-received">
                                        <div class="chat-detail">
                                            <span class="time text-gray-500">
                                                {{ \Carbon\Carbon::parse($chat->created_at)->format('H.i') }}
                                                <span class="text-gray-800 font-bold">{{ $chat->fromUser->name }}</span>
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
            <form id="chatForm" action="{{ route('chats.send') }}" method="POST">
                @csrf
            
                {{-- <div class="mb-4">
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
                </div> --}}

                <input type="hidden" name="to_user_id" id="to_user_id" value="{{ $user->id }}"/>
            
                <div class="input-group-icon relative">
                    <input type="text" id="chatInput" name="message" placeholder="Tulis update di sini..." required class="w-full pr-24">
                
                    <button type="submit"
                        class="absolute right-2 top-1/2 -translate-y-1/2 flex items-center gap-1 px-3 py-1 bg-blue-600 text-white hover:text-gray-800 rounded-md hover:bg-gray-300 transition text-sm">
                        <i class="ri-send-plane-fill text-lg"></i>
                        @if (optional(Auth::user()->role)->name !== 'technician')
                            <span class="font-semibold uppercase tracking-wide">Kirim</span>
                        @endif
                    </button>
                </div>
            </form>
        </div>
    </div>
    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        window.Laravel = {
            userId: {{ auth()->id() }}
        };

        //const YOUR_USER_ID = {{ auth()->id() }};
        const YOUR_USER_ID = window.Laravel?.userId;
        Pusher.logToConsole = true;

        const form = document.getElementById('chatForm');
        const chatInput = document.getElementById('chatInput');
        const toUserField = document.getElementById('to_user_id');
        const chatContainer = document.querySelector('.content-chat');

        if (!form || !chatInput || !toUserField) {
            console.error("❌ Form atau input tidak ditemukan di DOM.");
            return;
        }

        const toUserId = toUserField.value;

        // ======= Echo Listener =======
        if (window.Echo) {
            console.log("📡 Echo connected");

            window.Echo.channel('public-chat')
                .listen('.chat.sent', function (e) {
                    // console.log("Your User ID:", YOUR_USER_ID);
                    // console.log("Event Payload from_user_id:", e.chat.from_user_id);
                    // console.log("Event Payload from_user_name:", e.chat.from_user?.name);

                    const isMyMessage = parseInt(e.chat.from_user_id) === parseInt(YOUR_USER_ID);
                    //console.log("isMyMessage?", isMyMessage);

                    const messageBox = document.createElement('div');
                    messageBox.className = isMyMessage ? 'chat-sent' : 'chat-received';
                    messageBox.style.display = 'flex';
                    messageBox.style.justifyContent = isMyMessage ? 'flex-end' : 'flex-start';

                    // console.log('👁️ messageBox classes:', messageBox.className);
                    // console.log('👁️ isMyMessage:', isMyMessage);

                    const time = new Date(e.chat.created_at).toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false
                    });

                    const timeClass = isMyMessage ? 'text-white' : 'text-gray-500';
                    const nameClass = isMyMessage ? 'text-white' : 'text-gray-800';
                    const senderName = isMyMessage ? 'Saya' : (e.chat.from_user?.name || 'Pengguna');

                    messageBox.innerHTML = `
                        <div class="chat-detail">
                            <span class="time ${timeClass}">
                                <span class="${timeClass} font-bold">${time}</span>
                                
                                <span class="${nameClass} font-bold">${senderName}</span>
                            </span>
                            <p>${e.chat.message}</p>
                        </div>
                    `;

                    chatContainer.appendChild(messageBox);
                    scrollToBottom();
                });
        } else {
            console.error("❌ Echo tidak tersedia");
        }

        // ======= Form Submit via AJAX =======
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const message = chatInput.value.trim();
            if (!message) return;

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json', // penting!
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({
                    message: message,
                    to_user_id: toUserId
                })
            })
            .then(res => {
                if (!res.ok) {
                    throw new Error('Server response error');
                }
                return res.json();
            })
            .then(data => {
                chatInput.value = '';
                
                // // Tambahkan pesan secara langsung (opsional)
                // const messageBox = document.createElement('div');
                // messageBox.className = 'chat-sent';
                // messageBox.innerHTML = `
                //     <div class="chat-detail">
                //         <span class="time">
                //             ${new Date(data.chat.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                //             <span class="font-bold">Saya</span>
                //         </span>
                //         <p>${data.chat.message}</p>
                //     </div>
                // `;
                // chatContainer.appendChild(messageBox);
                //scrollToBottom();
            })
            .catch(error => {
                console.error("Error sending chat:", error);
            });
        });

        // ======= Auto Scroll to Bottom =======
        function scrollToBottom() {
            const container = document.querySelector('.container.flex-1.overflow-y-auto');
            container.scrollTop = container.scrollHeight;
        }

        // Scroll to bottom on initial load
        scrollToBottom();
    });
    </script>
    @endpush
</x-dynamic-layout>