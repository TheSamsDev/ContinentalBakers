<style>
    /* Sidebar Chat Container */
/* Sidebar Chat Container */
.ai-chat-sidebar {
  position: fixed;
  top: 0;
  right: -400px; /* Hide sidebar by default */
  width: 400px;
  height: 100vh;
  background-color: #fff;
  box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
  transition: right 0.3s ease-in-out;
  display: flex;
  flex-direction: column;
  z-index: 1000;
}

/* Show sidebar when active */
.ai-chat-sidebar.active {
  right: 0;
}

/* Chat Header */
.ai-chat-header {
  padding: 15px;
  background-color: #007bff;
  color: #fff;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.ai-chat-header-content {
  display: flex;
  align-items: center;
  gap: 10px;
}

.agent-avatar {
  width: 50px;
  height: 50px;
  border-radius: 50%;
}

.agent-info h5 {
  margin: 0;
  font-size: 18px;
}

.agent-info p {
  margin: 0;
  font-size: 14px;
  color: #e0e0e0;
}

.ai-chat-header .close {
  color: #fff;
  font-size: 24px;
  cursor: pointer;
}

/* Chat Output Area */
.ai-chat-output {
  flex: 1;
  padding: 15px;
  overflow-y: auto;
  border-bottom: 1px solid #eee;
}

.chat-welcome-message {
  text-align: center;
  color: #666;
  margin-bottom: 20px;
}

/* Chat Input Container */
.ai-chat-input-container {
  padding: 15px;
  background-color: #f8f9fa;
  display: flex;
  gap: 10px;
  align-items: center;
}

.ai-chat-input {
  flex: 1;
  resize: none;
  border: 1px solid #ddd;
  border-radius: 5px;
  padding: 10px;
}

.ai-chat-send {
  background-color: #007bff;
  color: #fff;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  cursor: pointer;
}

.ai-chat-send:hover {
  background-color: #0056b3;
}

/* Footer */
.ai-chat-footer {
  padding: 10px;
  text-align: center;
  background-color: #f8f9fa;
  font-size: 12px;
  color: #666;
}

/* Toggle Button */
.ai-chat-toggle {
  position: fixed;
  bottom: 20px;
  right: 20px;
  z-index: 1001;
}

.btn-buy-now {
  background-color: #dc3545;
  color: #fff;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  cursor: pointer;
}

.btn-buy-now:hover {
  background-color: #c82333;
}
.message {
  margin-bottom: 15px;
}

.user-message {
  text-align: right;
}

.user-message p {
  background-color: #007bff;
  color: #fff;
  display: inline-block;
  padding: 10px;
  border-radius: 10px 10px 0 10px;
}

.ai-message p {
  background-color: #f1f1f1;
  color: #333;
  display: inline-block;
  padding: 10px;
  border-radius: 10px 10px 10px 0;
}
</style>
<!-- Sidebar Chat Interface -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Sidebar Chat Interface -->
<div id="aiChatSidebar" class="ai-chat-sidebar">
    <!-- Chat Header -->
    <div class="ai-chat-header">
      <div class="ai-chat-header-content">
        <img src="{{ asset('path/to/agent-avatar.png') }}" alt="Agent Avatar" class="agent-avatar">
        <div class="agent-info">
          <h5>Mia Patrick</h5>
          <p>Product Expert</p>
        </div>
      </div>
      <button type="button" class="close" onclick="closeChatSidebar()">×</button>
    </div>
  
    <!-- Chat Output Area -->
    <div id="chat-output" class="ai-chat-output">
      <!-- AI responses will appear here -->
      <div class="chat-welcome-message">
        <p>Hi, let us know if you have any questions.</p>
      </div>
    </div>
  
    <!-- Chat Input Container -->
    <div class="ai-chat-input-container">
      <textarea id="chat-input" class="form-control ai-chat-input" placeholder="Type your message..." rows="1"></textarea>
      <button type="button" class="btn btn-primary ai-chat-send" onclick="sendAIMessage()">Send</button>
    </div>
  
    <!-- Footer -->
    <div class="ai-chat-footer">
      <p>Powered by <strong>Your Brand</strong></p>
    </div>
  </div>
  
  <!-- Button to open the chat sidebar -->
  <div class="ai-chat-toggle">
    <a class="btn btn-danger btn-buy-now" onclick="toggleChatSidebar()">Chat with AI</a>
  </div>

  <script>
       const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  // Toggle the chat sidebar
function toggleChatSidebar() {
  const sidebar = document.getElementById('aiChatSidebar');
  sidebar.classList.toggle('active');
}

// Close the chat sidebar
function closeChatSidebar() {
  const sidebar = document.getElementById('aiChatSidebar');
  sidebar.classList.remove('active');
}

// Send message to AI
async function sendAIMessage() {
  const inputField = document.getElementById('chat-input');
  const outputDiv = document.getElementById('chat-output');
  const userMessage = inputField.value;

  if (!userMessage.trim()) return; // Ignore empty messages

  // Display the user's message
  outputDiv.innerHTML += `<div class="message user-message">
    <p><strong>You:</strong> ${userMessage}</p>
  </div>`;
  inputField.value = ''; // Clear the input field

  // Show a loading spinner
  outputDiv.innerHTML += `<div class="message ai-message" id="loading">
    <p><em>Analayzing Data plz wait...</em></p>
  </div>`;
  outputDiv.scrollTop = outputDiv.scrollHeight;
  //Option 1
//Option 2
  try {
    // Send the message to the backend
    const response = await fetch('/generate-and-analyze-data', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN':csrfToken,
      },
      body: JSON.stringify({ message: userMessage }),
    });

    const data = await response.json();
    console.log("Analysis: ", data.analysis);

    // Remove the loading spinner
    document.getElementById('loading').remove();

    // Display the AI's response
    outputDiv.innerHTML += `<div class="message ai-message">
      <p><strong>AI:</strong> ${data.analysis}</p>
    </div>`;
  } catch (error) {
    // Handle errors
    document.getElementById('loading').remove();
    outputDiv.innerHTML += `<div class="message ai-message">
      <p><strong>Error:</strong> Unable to connect to the AI.</p>
    </div>`;
  }

  // Scroll to the bottom of the chat
  outputDiv.scrollTop = outputDiv.scrollHeight;
}
  </script>