<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Service - Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        .chat-container {
            width: 100%;
            max-width: 500px;
            height: 90vh;
            display: flex;
            flex-direction: column;
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: #4f46e5 !important;
            /* Indigo color matching admin */
            padding: 15px 20px;
            border: none;
        }

        .chat-window {
            flex: 1;
            padding: 20px;
            background-color: #f8fafc;
            overflow-y: auto;
            scroll-behavior: smooth;
            display: flex;
            flex-direction: column;
        }

        /* Bubble Chat Logic */
        .message-wrapper {
            display: flex;
            margin-bottom: 15px;
            width: 100%;
        }

        /* User (You) di Kanan */
        .message-wrapper.sent {
            justify-content: flex-end;
        }

        /* Admin di Kiri */
        .message-wrapper.received {
            justify-content: flex-start;
        }

        .message-content {
            max-width: 75%;
            padding: 10px 15px;
            font-size: 0.9rem;
            position: relative;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        /* Style User (Sent) */
        .sent .message-content {
            background: #4f46e5;
            color: white;
            border-radius: 15px 15px 2px 15px;
        }

        /* Style Admin (Received) */
        .received .message-content {
            background: white;
            color: #1f2937;
            border-radius: 15px 15px 15px 2px;
            border: 1px solid #f1f5f9;
        }

        .message-time {
            font-size: 0.65rem;
            margin-top: 4px;
            display: block;
        }

        .sent .message-time {
            text-align: right;
            color: #c7d2fe;
        }

        .received .message-time {
            color: #94a3b8;
        }

        .btn-send {
            background: #4f46e5;
            color: white;
            border-radius: 12px !important;
            padding: 8px 15px;
            border: none;
            transition: all 0.2s;
        }

        .btn-send:hover {
            background: #4338ca;
            transform: scale(1.05);
        }

        .close-chat {
            color: rgba(255, 255, 255, 0.7);
            transition: color 0.2s;
        }

        .close-chat:hover {
            color: white;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="chat-container card">
        <div class="card-header text-white">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="mr-3">
                        <div class="bg-white rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 40px; height: 40px;">
                            <i class="fas fa-headset text-primary"></i>
                        </div>
                    </div>
                    <div>
                        <h6 class="mb-0 font-weight-bold">Customer Support</h6>
                        <small class="text-white-50"><i class="fas fa-circle text-success mr-1"
                                style="font-size: 7px;"></i> Online</small>
                    </div>
                </div>
                <a href="{{ url('/') }}" class="close-chat">
                    <i class="fas fa-times fa-lg"></i>
                </a>
            </div>
        </div>

        <div class="card-body chat-window" id="chatWindow">
            <div class="message-wrapper received">
                <div class="message-content">
                    <p class="mb-0">Halo! Ada yang bisa kami bantu hari ini? 😊</p>
                    <small class="message-time">System</small>
                </div>
            </div>

            @forelse($messages as $m)
                <div class="message-wrapper {{ $m->is_admin ? 'received' : 'sent' }}">
                    <div class="message-content">
                        <p class="mb-0">{{ $m->pesan }}</p>
                        <small class="message-time">
                            {{ $m->created_at->format('H:i') }}
                        </small>
                    </div>
                </div>
            @empty
                <div class="text-center my-auto text-muted" style="opacity: 0.5;">
                    <i class="fas fa-comments fa-3x mb-3"></i>
                    <p>Belum ada percakapan.</p>
                </div>
            @endforelse
        </div>

        <div class="card-footer bg-white border-0 py-3">
            <form action="{{ route('user.chat.store') }}" method="POST">
                @csrf
                <div class="input-group shadow-sm rounded-pill border p-1 bg-light">
                    <input type="text" name="pesan" class="form-control border-0 bg-transparent px-3"
                        placeholder="Tulis pesan..." autocomplete="off" required>
                    <div class="input-group-append">
                        <button class="btn-send mx-1" type="submit">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var chatWindow = document.getElementById("chatWindow");
            chatWindow.scrollTop = chatWindow.scrollHeight;
        });
    </script>

</body>

</html>