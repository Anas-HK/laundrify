<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chat</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <style>
        .chat-messages {
            height: 300px;
            overflow-y: auto;
            padding: 15px;
            background: #f8f9fa;
        }
        
        .message {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.3s forwards;
        }
        
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .message.sent {
            align-items: flex-end;
        }
        
        .message.received {
            align-items: flex-start;
        }
        
        .message-bubble {
            max-width: 70%;
            padding: 10px 15px;
            border-radius: 15px;
            position: relative;
            word-wrap: break-word;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        
        .message-bubble:hover {
            transform: scale(1.02);
        }
        
        .message.sent .message-bubble {
            background-color: #0d6efd;
            color: white;
            border-bottom-right-radius: 5px;
        }
        
        .message.received .message-bubble {
            background-color: #e9ecef;
            color: #212529;
            border-bottom-left-radius: 5px;
        }
        
        .message-info {
            font-size: 0.75em;
            margin-top: 5px;
            opacity: 0.8;
        }
        
        .message.sent .message-info {
            color: rgba(255, 255, 255, 0.8);
        }
        
        .message.received .message-info {
            color: #6c757d;
        }

        .chat-input {
            padding: 15px;
            background: white;
            border-top: 1px solid #dee2e6;
        }

        .chat-input .form-control {
            border-radius: 20px;
            padding: 10px 20px;
        }

        .chat-input .btn {
            border-radius: 20px;
            padding: 10px 25px;
        }

        /* Typing indicator */
        .typing-indicator {
            display: none;
            padding: 5px 10px;
            font-size: 0.8em;
            color: #6c757d;
            font-style: italic;
        }

        .typing-indicator.active {
            display: block;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
    <div>
        <span>Chat for Order #{{ $order->id }}</span>
        <br>
        <small>
            <strong>Chat with:</strong> 
            {{ $isSeller ? $order->user->name : $order->seller->name }}
        </small>
        <br>
        <small>
            <strong>Payment Mode:</strong> 
            {{ $order->transaction_id ? 'Online (Transaction ID: ' . $order->transaction_id . ')' : 'Cash on Delivery' }}
        </small>
    </div>
</div>

                        <a href="{{ $backUrl }}" class="btn btn-sm btn-light">Back to Order</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="chat-messages" id="chat-messages">
                            @foreach($messages as $message)
                                <div class="message {{ $message->sender_type === ($isSeller ? 'seller' : 'user') ? 'sent' : 'received' }}">
                                    <div class="message-bubble">
                                        {{ $message->message }}
                                        <div class="message-info">
                                            {{ $message->created_at->format('M d, H:i') }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="typing-indicator" id="typing-indicator">
                            Someone is typing...
                        </div>
                        
                        <div class="chat-input">
                            <form id="message-form" class="mb-0">
                                <div class="input-group">
                                    <input type="text" id="message-input" class="form-control" placeholder="Type your message..." autocomplete="off">
                                    <button class="btn btn-primary" type="submit">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    // Initialize Pusher with debug logging
    Pusher.logToConsole = true;
    
    const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
        cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
        encrypted: true
    });
    
    document.addEventListener('DOMContentLoaded', function() {
        const chatContainer = document.getElementById('chat-messages');
        const messageForm = document.getElementById('message-form');
        const messageInput = document.getElementById('message-input');
        
        // Get user type from server-side variable
        const isSeller = {{ $isSeller ? 'true' : 'false' }};
        console.log('User type:', isSeller ? 'Seller' : 'Buyer');
        
        // Get routes based on user type
        const markReadRoute = isSeller ? '{{ route("seller.chat.mark-read", $order->id) }}' : '{{ route("chat.mark-read", $order->id) }}';
        const sendMessageRoute = isSeller ? '{{ route("seller.chat.send", $order->id) }}' : '{{ route("chat.send", $order->id) }}';
        console.log('Chat routes:', { markReadRoute, sendMessageRoute });

        // Subscribe to the chat channel
        const channelName = 'chat.{{ $order->id }}';
        console.log('Subscribing to channel:', channelName);
        const channel = pusher.subscribe(channelName);

        // Listen for new messages
        channel.bind('new-message', function(data) {
            console.log('Received new message:', data);
            const message = data.message;
            appendMessage(message);
            
            // Mark message as read if it's not from current user
            if (message.sender_type !== (isSeller ? 'seller' : 'user')) {
                console.log('Marking message as read');
                fetch(markReadRoute, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
            }
        });

        // Handle connection states
        pusher.connection.bind('connected', () => {
            console.log('Successfully connected to Pusher');
        });
        
        pusher.connection.bind('error', (err) => {
            console.error('Pusher connection error:', err);
        });

        // Handle message form submission
        messageForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const message = messageInput.value.trim();

            if (message) {
                console.log('Sending message:', message);
                fetch(sendMessageRoute, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ message: message })
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Server response:', data);
                    if (data.success) {
                        messageInput.value = '';
                    }
                })
                .catch(error => {
                    console.error('Error sending message:', error);
                });
            }
        });

        function appendMessage(message) {
            console.log('Appending message:', message);
            const isCurrentUserMessage = message.sender_type === (isSeller ? 'seller' : 'user');
            
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${isCurrentUserMessage ? 'sent' : 'received'}`;

            const messageBubble = document.createElement('div');
            messageBubble.className = 'message-bubble';
            messageBubble.textContent = message.message;

            const messageInfo = document.createElement('div');
            messageInfo.className = 'message-info';
            
            const date = new Date(message.created_at);
            messageInfo.textContent = date.toLocaleString('default', { 
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            });

            messageBubble.appendChild(messageInfo);
            messageDiv.appendChild(messageBubble);
            chatContainer.appendChild(messageDiv);
            
            // Scroll to the new message with smooth animation
            chatContainer.scrollTo({
                top: chatContainer.scrollHeight,
                behavior: 'smooth'
            });
        }

        // Initial scroll to bottom
        chatContainer.scrollTop = chatContainer.scrollHeight;
    });
</script>

</body>
</html>
