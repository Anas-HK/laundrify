@if($isSeller)
    @extends('seller.layouts.app')
    
    @section('styles')
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @endsection
    
    @section('content')
    <div class="container chat-container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="chat-card">
                    <div class="chat-header">
                        <div>
                            <div class="chat-title">Chat for Order #{{ $order->id }}</div>
                            <div class="chat-subtitle">
                                <strong>Chat with:</strong> 
                                {{ $order->user->name }}
                            </div>
                            <div class="chat-subtitle">
                                <strong>Payment Mode:</strong> 
                                {{ $order->transaction_id ? 'Online (Transaction ID: ' . $order->transaction_id . ')' : 'Cash on Delivery' }}
                            </div>
                        </div>
                        <a href="{{ $backUrl }}" class="chat-back-btn">
                            <i class="fas fa-arrow-left"></i> Back to Order
                        </a>
                    </div>
                    <div class="chat-messages" id="chat-messages">
                        @foreach($messages as $message)
                            <div class="message {{ $message->sender_type === 'seller' ? 'sent' : 'received' }}">
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
                        <span>Someone is typing</span>
                        <div class="typing-dots">
                            <span class="typing-dot"></span>
                            <span class="typing-dot"></span>
                            <span class="typing-dot"></span>
                        </div>
                    </div>
                    
                    <div class="chat-input-container">
                        <form id="message-form" class="chat-input-form">
                            <input type="text" id="message-input" class="chat-input" placeholder="Type your message..." autocomplete="off">
                            <button class="chat-send-btn" type="submit">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    
    @section('scripts')
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
            let isSending = false;
            
            // Get user type from server-side variable
            const isSeller = true;
            console.log('User type: Seller');
            
            // Get routes for seller
            const markReadRoute = '{{ route("seller.chat.mark-read", $order->id) }}';
            const sendMessageRoute = '{{ route("seller.chat.send", $order->id) }}';
            console.log('Chat routes:', { markReadRoute, sendMessageRoute });
    
            // Subscribe to the chat channel
            const channelName = 'chat.{{ $order->id }}';
            console.log('Subscribing to channel:', channelName);
            const channel = pusher.subscribe(channelName);
    
            // Listen for new messages
            channel.bind('new-message', function(data) {
                console.log('Received new message:', data);
                const message = data.message;
                
                // Only append if it's from the other person (not myself)
                // The messages I send are already displayed locally
                if (message.sender_type !== 'seller') {
                    appendMessage(message);
                    
                    // Mark message as read
                    console.log('Marking message as read');
                    fetch(markReadRoute, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    }).catch(error => {
                        console.error('Error marking as read:', error);
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
    
                if (message && !isSending) {
                    isSending = true;
                    
                    // Create temp message object for immediate display
                    const tempMessage = {
                        message: message,
                        sender_type: 'seller',
                        created_at: new Date().toISOString()
                    };
                    
                    // Clear input field and immediately display the message in UI
                    messageInput.value = '';
                    const messageElement = appendMessage(tempMessage);
                    
                    // Send to server
                    console.log('Sending message:', message);
                    fetch(sendMessageRoute, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ message: message })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Server response:', data);
                        if (!data.success) {
                            console.error('Server indicated failure');
                        }
                        isSending = false;
                    })
                    .catch(error => {
                        console.error('Error sending message:', error);
                        // Don't show alerts, just log to console
                        isSending = false;
                    });
                }
            });
    
            function appendMessage(message) {
                console.log('Appending message:', message);
                const isCurrentUserMessage = message.sender_type === 'seller';
                
                const messageDiv = document.createElement('div');
                messageDiv.className = `message ${isCurrentUserMessage ? 'sent' : 'received'} animate__animated animate__fadeIn`;
    
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
                
                return messageDiv;
            }
    
            // Initial scroll to bottom
            chatContainer.scrollTop = chatContainer.scrollHeight;
            
            // Focus on input field when page loads
            messageInput.focus();
        });
    </script>
    @endsection
@else
    @extends('layouts.app')
    
    @section('styles')
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @endsection
    
    @section('content')
    <div class="container chat-container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="chat-card">
                    <div class="chat-header">
                        <div>
                            <div class="chat-title">Chat for Order #{{ $order->id }}</div>
                            <div class="chat-subtitle">
                                <strong>Chat with:</strong> 
                                {{ $order->seller->name }}
                            </div>
                            <div class="chat-subtitle">
                                <strong>Payment Mode:</strong> 
                                {{ $order->transaction_id ? 'Online (Transaction ID: ' . $order->transaction_id . ')' : 'Cash on Delivery' }}
                            </div>
                        </div>
                        <a href="{{ $backUrl }}" class="chat-back-btn">
                            <i class="fas fa-arrow-left"></i> Back to Order
                        </a>
                    </div>
                    <div class="chat-messages" id="chat-messages">
                        @foreach($messages as $message)
                            <div class="message {{ $message->sender_type === 'user' ? 'sent' : 'received' }}">
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
                        <span>Someone is typing</span>
                        <div class="typing-dots">
                            <span class="typing-dot"></span>
                            <span class="typing-dot"></span>
                            <span class="typing-dot"></span>
                        </div>
                    </div>
                    
                    <div class="chat-input-container">
                        <form id="message-form" class="chat-input-form">
                            <input type="text" id="message-input" class="chat-input" placeholder="Type your message..." autocomplete="off">
                            <button class="chat-send-btn" type="submit">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    
    @section('scripts')
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
            let isSending = false;
            
            // Get user type from server-side variable
            const isSeller = false;
            console.log('User type: Buyer');
            
            // Get routes for buyer
            const markReadRoute = '{{ route("chat.mark-read", $order->id) }}';
            const sendMessageRoute = '{{ route("chat.send", $order->id) }}';
            console.log('Chat routes:', { markReadRoute, sendMessageRoute });
    
            // Subscribe to the chat channel
            const channelName = 'chat.{{ $order->id }}';
            console.log('Subscribing to channel:', channelName);
            const channel = pusher.subscribe(channelName);
    
            // Listen for new messages
            channel.bind('new-message', function(data) {
                console.log('Received new message:', data);
                const message = data.message;
                
                // Only append if it's from the other person (not myself)
                // The messages I send are already displayed locally
                if (message.sender_type !== 'user') {
                    appendMessage(message);
                    
                    // Mark message as read
                    console.log('Marking message as read');
                    fetch(markReadRoute, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    }).catch(error => {
                        console.error('Error marking as read:', error);
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
    
                if (message && !isSending) {
                    isSending = true;
                    
                    // Create temp message object for immediate display
                    const tempMessage = {
                        message: message,
                        sender_type: 'user',
                        created_at: new Date().toISOString()
                    };
                    
                    // Clear input field and immediately display the message in UI
                    messageInput.value = '';
                    const messageElement = appendMessage(tempMessage);
                    
                    // Send to server
                    console.log('Sending message:', message);
                    fetch(sendMessageRoute, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ message: message })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Server response:', data);
                        if (!data.success) {
                            console.error('Server indicated failure');
                        }
                        isSending = false;
                    })
                    .catch(error => {
                        console.error('Error sending message:', error);
                        // Don't show alerts, just log to console
                        isSending = false;
                    });
                }
            });
    
            function appendMessage(message) {
                console.log('Appending message:', message);
                const isCurrentUserMessage = message.sender_type === 'user';
                
                const messageDiv = document.createElement('div');
                messageDiv.className = `message ${isCurrentUserMessage ? 'sent' : 'received'} animate__animated animate__fadeIn`;
    
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
                
                return messageDiv;
            }
    
            // Initial scroll to bottom
            chatContainer.scrollTop = chatContainer.scrollHeight;
            
            // Focus on input field when page loads
            messageInput.focus();
        });
    </script>
    @endsection
@endif 