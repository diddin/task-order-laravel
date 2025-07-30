import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
    // Tambahkan ini jika pakai Laravel default session (bukan sanctum)
    withCredentials: true,
    authEndpoint: '/broadcasting/auth', // ← Ini penting!
});

// 👉 Tambahkan ini agar axios membawa socket ID saat mengirim request
import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.Echo.connector.pusher.connection.bind('connected', () => {
    const socketId = window.Echo.socketId();
    window.axios.defaults.headers.common['X-Socket-Id'] = socketId;
    console.log("📎 Socket ID sent with axios:", socketId);
});