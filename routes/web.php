<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\NetworkController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskOrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeknisiController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Broadcast;

Broadcast::routes();

Route::get('/test-event', function () {
    $app_id = '2029022';
    $app_key = 'c25a48f35d6e35faeae4';
    $app_secret = '2d28a4956d14f5d44ab8'; // Ganti dengan secret kamu
    $channel = 'my-channel';
    $event = 'my-event';

    // 1. Data asli
    $data_array = ['message' => 'hello world'];

    // 2. Harus di-encode sebagai STRING JSON
    $data_string = json_encode($data_array, JSON_UNESCAPED_SLASHES);

    // 3. Siapkan payload yang AKAN DIKIRIM KE PUSHER
    $payload_array = [
        'name' => $event,
        'channel' => $channel,
        'data' => $data_string // ← STRING JSON!
    ];

    // 4. Encode payload jadi JSON
    $payload_json = json_encode($payload_array, JSON_UNESCAPED_SLASHES);

    // 5. Hitung body_md5 dari JSON payload itu
    $body_md5 = md5($payload_json);

    // 6. Buat query params
    $auth_timestamp = time();
    $query_string = http_build_query([
        'auth_key' => $app_key,
        'auth_timestamp' => $auth_timestamp,
        'auth_version' => '1.0',
        'body_md5' => $body_md5
    ]);

    // 7. Buat string to sign
    $string_to_sign = "POST\n/apps/{$app_id}/events\n{$query_string}";

    // 8. Generate HMAC SHA256 signature
    $auth_signature = hash_hmac('sha256', $string_to_sign, $app_secret);

    // 9. Final URL
    $url = "https://api-ap1.pusher.com/apps/{$app_id}/events?{$query_string}&auth_signature={$auth_signature}";

    // 10. Kirim via CURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload_json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    echo "📡 RESPONSE:\n$response\n";
});

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('role:master')->prefix('master')->group(function () {

    Route::get('dashboard', function () {
        return redirect()->route('master.admins.index');
    })->name('master.dashboard');

    Route::get('/register', [RegisteredUserController::class, 'createAccount'])
        ->name('registerAccount');
    Route::post('register', [RegisteredUserController::class, 'store']);

    // Tambahkan dulu route khusus sebelum resource
    Route::put('admins/password/{user}', [PasswordController::class, 'updateAdminPassword'])
        ->name('master.admins.password.update');
    // Baru definisikan resource setelahnya
    Route::resource('admins', AdminController::class)
        ->parameters(['admins' => 'user']) // ganti {admin} jadi {user}
        ->names('master.admins');
    // Tambahkan dulu route khusus sebelum resource
    Route::put('technicians/password/{user}', [PasswordController::class, 'updateTechnicianPassword'])
        ->name('master.technicians.password.update');
    // Baru definisikan resource setelahnya
    Route::resource('technicians', TeknisiController::class)
        ->parameters(['technicians' => 'user'])
        ->names('master.technicians');
    Route::resource('customers', CustomerController::class)->names('master.customers');
    Route::resource('networks', NetworkController::class)->names('master.networks');
    Route::resource('tasks', TaskController::class)->names('master.tasks');
    Route::resource('announcements', AnnouncementController::class)->names('master.announcements');

    Route::controller(ProfileController::class)->group(function () {
        Route::get('profile', 'editMaster')->name('master.profile.edit');
        Route::patch('profile', 'updateMaster')->name('master.profile.update');
        Route::delete('profile', 'destroy')->name('master.profile.destroy');
    });

    // Route::get('admins', [AdminController::class, 'index'])->name('master.admins.index');
    // Route::get('admins/create', [AdminController::class, 'create'])->name('master.admins.create');
    // Route::post('admins', [AdminController::class, 'store'])->name('master.admins.store');
    // Route::get('admins/{user}', [AdminController::class, 'show'])->name('master.admins.show');
    // Route::get('admins/{user}/edit', [AdminController::class, 'edit'])->name('master.admins.edit');
    // Route::match(['put', 'patch'], 'admins/{user}', [AdminController::class, 'update'])->name('master.admins.update');
    // Route::delete('admins/{user}', [AdminController::class, 'destroy'])->name('master.admins.destroy');
    // Route::put('admins/password/{user}', [PasswordController::class, 'updateAdminPassword'])->name('master.admins.password.update');

    // Route::get('technicians', [TeknisiController::class, 'index'])->name('master.technicians.index');
    // Route::get('technicians/create', [TeknisiController::class, 'create'])->name('master.technicians.create');
    // Route::post('technicians', [TeknisiController::class, 'store'])->name('master.technicians.store');
    // Route::get('technicians/{user}', [TeknisiController::class, 'show'])->name('master.technicians.show');
    // Route::get('technicians/{user}/edit', [TeknisiController::class, 'edit'])->name('master.technicians.edit');
    // Route::put('technicians/{user}', [TeknisiController::class, 'update'])->name('master.technicians.update');
    // Route::patch('technicians/{user}', [TeknisiController::class, 'update'])->name('master.technicians.update');
    // Route::delete('technicians/{user}', [TeknisiController::class, 'destroy'])->name('master.technicians.destroy');
    // Route::put('technicians/password/{user}', [PasswordController::class, 'updateTechnicianPassword'])->name('master.technicians.password.update');

    // Route::get('customers', [CustomerController::class, 'index'])->name('master.customers.index');
    // Route::get('customers/create', [CustomerController::class, 'create'])->name('master.customers.create');
    // Route::post('customers', [CustomerController::class, 'store'])->name('master.customers.store');
    // Route::get('customers/{customer}', [CustomerController::class, 'show'])->name('master.customers.show');
    // Route::get('customers/{customer}/edit', [CustomerController::class, 'edit'])->name('master.customers.edit');
    // Route::put('customers/{customer}', [CustomerController::class, 'update'])->name('master.customers.update');
    // Route::delete('customers/{customer}', [CustomerController::class, 'destroy'])->name('master.customers.destroy');

    // Route::get('networks', [NetworkController::class, 'index'])->name('master.networks.index');
    // Route::get('networks/create', [NetworkController::class, 'create'])->name('master.networks.create');
    // Route::post('networks', [NetworkController::class, 'store'])->name('master.networks.store');
    // Route::get('networks/{network}', [NetworkController::class, 'show'])->name('master.networks.show');
    // Route::get('networks/{network}/edit', [NetworkController::class, 'edit'])->name('master.networks.edit');
    // Route::put('networks/{network}', [NetworkController::class, 'update'])->name('master.networks.update');
    // Route::delete('networks/{network}', [NetworkController::class, 'destroy'])->name('master.networks.destroy');

    // Route::get('tasks', [TaskController::class, 'index'])->name('master.tasks.index');
    // Route::get('tasks/create', [TaskController::class, 'create'])->name('master.tasks.create');
    // Route::post('tasks', [TaskController::class, 'store'])->name('master.tasks.store');
    // Route::get('tasks/{task}', [TaskController::class, 'show'])->name('master.tasks.show');
    // Route::get('tasks/{task}/edit', [TaskController::class, 'edit'])->name('master.tasks.edit');
    // Route::put('tasks/{task}', [TaskController::class, 'update'])->name('master.tasks.update');
    // Route::delete('tasks/{task}', [TaskController::class, 'destroy'])->name('master.tasks.destroy');

    // Route::get('profile', [ProfileController::class, 'editMaster'])->name('master.profile.edit');
    // Route::patch('profile', [ProfileController::class, 'updateMaster'])->name('master.profile.update');
    // Route::delete('profile', [ProfileController::class, 'destroy'])->name('master.profile.destroy');
});


Route::middleware('role:admin')->prefix('admin')->group(function () {

    Route::get('dashboard', fn () => redirect()->route('admin.customers.index'))->name('admin.dashboard');

    Route::resource('customers', CustomerController::class)->names('admin.customers');
    Route::resource('networks', NetworkController::class)->names('admin.networks');
    Route::resource('tasks', TaskController::class)->names('admin.tasks');
    Route::resource('announcements', AnnouncementController::class)->names('admin.announcements');

    Route::controller(ProfileController::class)->group(function () {
        Route::get('profile', 'editAdmin')->name('admin.profile.edit');
        Route::patch('profile', 'updateAdmin')->name('admin.profile.update');
        Route::delete('profile', 'destroy')->name('admin.profile.destroy');
    });

    // Route::get('dashboard', function () {
    //     return redirect()->route('admin.customers.index');
    // })->name('admin.dashboard');

    // Route::get('customers', [CustomerController::class, 'index'])->name('admin.customers.index');
    // Route::get('customers/create', [CustomerController::class, 'create'])->name('admin.customers.create');
    // Route::post('customers', [CustomerController::class, 'store'])->name('admin.customers.store');
    // Route::get('customers/{customer}', [CustomerController::class, 'show'])->name('admin.customers.show');
    // Route::get('customers/{customer}/edit', [CustomerController::class, 'edit'])->name('admin.customers.edit');
    // Route::put('customers/{customer}', [CustomerController::class, 'update'])->name('admin.customers.update');
    // Route::delete('customers/{customer}', [CustomerController::class, 'destroy'])->name('admin.customers.destroy');

    // Route::get('networks', [NetworkController::class, 'index'])->name('admin.networks.index');
    // Route::get('networks/create', [NetworkController::class, 'create'])->name('admin.networks.create');
    // Route::post('networks', [NetworkController::class, 'store'])->name('admin.networks.store');
    // Route::get('networks/{network}', [NetworkController::class, 'show'])->name('admin.networks.show');
    // Route::get('networks/{network}/edit', [NetworkController::class, 'edit'])->name('admin.networks.edit');
    // Route::put('networks/{network}', [NetworkController::class, 'update'])->name('admin.networks.update');
    // Route::delete('networks/{network}', [NetworkController::class, 'destroy'])->name('admin.networks.destroy');

    // Route::get('tasks', [TaskController::class, 'index'])->name('admin.tasks.index');
    // Route::get('tasks/create', [TaskController::class, 'create'])->name('admin.tasks.create');
    // Route::post('tasks', [TaskController::class, 'store'])->name('admin.tasks.store');
    // Route::get('tasks/{task}', [TaskController::class, 'show'])->name('admin.tasks.show');
    // Route::get('tasks/{task}/edit', [TaskController::class, 'edit'])->name('admin.tasks.edit');
    // Route::put('tasks/{task}', [TaskController::class, 'update'])->name('admin.tasks.update');
    // Route::delete('tasks/{task}', [TaskController::class, 'destroy'])->name('admin.tasks.destroy');

    // Route::resource('announcements', AnnouncementController::class)->names('admin.announcements');

    // Route::get('profile', [ProfileController::class, 'editAdmin'])->name('admin.profile.edit');
    // Route::patch('profile', [ProfileController::class, 'updateAdmin'])->name('admin.profile.update');
    // Route::delete('profile', [ProfileController::class, 'destroy'])->name('admin.profile.destroy');
});

Route::middleware('role:technician')->group(function () {
    
    Route::get('dashboard', [TeknisiController::class, 'dashboard'])->name('technician.dashboard');

    Route::get('tasks', [TaskController::class, 'index'])->name('technician.tasks.index');
    Route::get('tasks/{task}', [TaskController::class, 'show'])->name('technician.tasks.show');
    Route::post('/tasks/{task}/complete', [TaskController::class, 'completeProgress'])->name('technician.task.complete');

    Route::get('taskorders/{task}', [TaskOrderController::class, 'addProgress'])->name('technician.taskorders.progress');
    Route::post('taskorders/{task}', [TaskOrderController::class, 'storeProgress'])->name('technician.taskorders.store-progress');

    Route::get('profile', [ProfileController::class, 'editTeknisi'])->name('technician.profile.edit');
    Route::patch('profile', [ProfileController::class, 'updateTeknisi'])->name('technician.profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('technician.profile.destroy');

});

Route::middleware('auth')->group(function () {

    Route::resource('announcements', AnnouncementController::class);
    
    Route::delete('/profile/image', [ProfileController::class, 'destroyImage'])->name('profile.image.delete');

    Route::get('assets', [AssetController::class, 'index'])->name('assets.index');
    Route::get('assets/create', [AssetController::class, 'create'])->name('assets.create');
    Route::post('assets', [AssetController::class, 'store'])->name('assets.store');
    Route::get('assets/{asset}/task/{task}', [AssetController::class, 'show'])->name('assets.show');
    Route::get('assets/{asset}/edit', [AssetController::class, 'edit'])->name('assets.edit');
    Route::put('assets/{asset}', [AssetController::class, 'update'])->name('assets.update');
    Route::delete('assets', [AssetController::class, 'destroy'])->name('assets.destroy');

    Route::get('chats', [ChatController::class, 'index'])->name('chats.index');
    Route::get('/chats/thread-redirect', [ChatController::class, 'redirectToThread'])->name('chats.thread.redirect');
    Route::get('chats/thread/{user}', [ChatController::class, 'thread'])->name('chats.thread');
    Route::post('chats', [ChatController::class, 'send'])->name('chats.send');
    
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('notifications/{id}', [NotificationController::class, 'detail'])->name('notifications.detail');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllTasksAsRead'])
            ->name('notifications.markAllTasksAsRead');

    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});

require __DIR__.'/auth.php';

// Broadcast::channel('private-chat.{userId}', function ($user, $userId) {
//     // Cek user yang login ID-nya sama dengan userId channel
//     return (int) $user->id === (int) $userId;
// });

// require __DIR__.'/channels.php';
    
// Route::resource('/taskorders', TaskOrderController::class)
//     ->name('taskorders.index', 'taskorders.store', 'taskorders.create', 
//     'taskorders.show', 'taskorders.edit', 'taskorders.update', 'taskorders.destroy');
