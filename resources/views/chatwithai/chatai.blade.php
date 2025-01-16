<style>
  /* Sidebar Chat Container */
  .ai-chat-sidebar {
      position: fixed;
      top: 0;
      right: -400px;
      width: 400px;
      height: 100vh;
      background-color: #ffffff;
      box-shadow: -2px 0 15px rgba(0, 0, 0, 0.2);
      transition: right 0.3s ease-in-out;
      display: flex;
      flex-direction: column;
      z-index: 1000;
      font-family: 'Arial', sans-serif;
  }

  /* Show sidebar when active */
  .ai-chat-sidebar.active {
      right: 0;
  }

  /* Chat Header */
  .ai-chat-header {
      padding: 15px;
      background: linear-gradient(135deg, #007bff, #0056b3);
      color: #fff;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-radius: 0 0 10px 10px;
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
      border: 2px solid #fff;
  }

  .agent-info h5 {
      margin: 0;
      font-size: 18px;
      font-weight: 600;
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
      transition: opacity 0.2s;
  }

  .ai-chat-header .close:hover {
      opacity: 0.8;
  }

  /* Chat Output Area */
  .ai-chat-output {
      flex: 1;
      padding: 15px;
      overflow-y: auto;
      background-color: #f9f9f9;
  }

  .chat-welcome-message {
      text-align: center;
      color: #666;
      margin-bottom: 20px;
  }

  /* Suggestive Prompts */
  .suggestive-prompts {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-bottom: 20px;
  }

  .suggestive-prompts button {
      background-color: #e9ecef;
      border: none;
      border-radius: 20px;
      padding: 8px 15px;
      font-size: 14px;
      cursor: pointer;
      transition: background-color 0.2s;
  }

  .suggestive-prompts button:hover {
      background-color: #007bff;
      color: #fff;
  }

  /* Chat Input Container */
  .ai-chat-input-container {
      padding: 15px;
      background-color: #fff;
      border-top: 1px solid #eee;
      display: flex;
      gap: 10px;
      align-items: center;
  }

  .ai-chat-input {
      flex: 1;
      resize: none;
      border: 1px solid #ddd;
      border-radius: 25px;
      padding: 10px 15px;
      font-size: 14px;
      outline: none;
      transition: border-color 0.2s;
  }

  .ai-chat-input:focus {
      border-color: #007bff;
  }

  .ai-chat-send {
      background-color: #007bff;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 25px;
      cursor: pointer;
      transition: background-color 0.2s;
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
      border-top: 1px solid #eee;
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
      padding: 12px 24px;
      border-radius: 25px;
      cursor: pointer;
      font-size: 16px;
      font-weight: 600;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      transition: background-color 0.2s, transform 0.2s;
  }

  .btn-buy-now:hover {
      background-color: #c82333;
      transform: translateY(-2px);
  }

  /* Chat Messages */
  .message {
      margin-bottom: 15px;
      animation: fadeIn 0.3s ease-in-out;
  }

  @keyframes fadeIn {
      from {
          opacity: 0;
          transform: translateY(10px);
      }
      to {
          opacity: 1;
          transform: translateY(0);
      }
  }

  .user-message {
      text-align: right;
  }

  .user-message p {
      background-color: #007bff;
      color: #fff;
      display: inline-block;
      padding: 10px 15px;
      border-radius: 15px 15px 0 15px;
      max-width: 80%;
      word-wrap: break-word;
  }

  .ai-message p {
      background-color: #f1f1f1;
      color: #333;
      display: inline-block;
      padding: 10px 15px;
      border-radius: 15px 15px 15px 0;
      max-width: 80%;
      word-wrap: break-word;
  }

  /* Loading Spinner */
  .spinner-border {
      display: inline-block;
      width: 2rem;
      height: 2rem;
      vertical-align: text-bottom;
      border: 0.25em solid currentColor;
      border-right-color: transparent;
      border-radius: 50%;
      animation: spinner-border 0.75s linear infinite;
  }

  @keyframes spinner-border {
      to {
          transform: rotate(360deg);
      }
  }
</style>
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
      <!-- Welcome Message -->
      <div class="chat-welcome-message">
          <p>Hi, let us know if you have any questions.</p>
      </div>

      <!-- Suggestive Prompts -->
      <div class="suggestive-prompts">
          <button onclick="sendPrompt('Show top-selling products this month')">Top Selling Products</button>
          <button onclick="sendPrompt('Show least sold products this month')">Least Sold Products</button>
          <button onclick="sendPrompt('Show retailers with most orders')">Top Retailers</button>
          <button onclick="sendPrompt('Show growth from last year')">Company Growth</button>
          <button onclick="sendPrompt('Show top-performing brands')">Top Brands</button>
          <button onclick="sendPrompt('Show orders by region')">Orders by Region</button>
          <button onclick="sendPrompt('Show customer details')">Customer Details</button>
          <button onclick="sendPrompt('Show product inventory')">Product Inventory</button>
          <button onclick="sendPrompt('Show recent orders')">Recent Orders</button>
          <button onclick="sendPrompt('Show sales trends')">Sales Trends</button>
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

  // Send a predefined prompt
  function sendPrompt(prompt) {
      const inputField = document.getElementById('chat-input');
      inputField.value = prompt;
      sendAIMessage();
  }

  // Send message to AI
  async function sendAIMessage() {
      const inputField = document.getElementById('chat-input');
      const outputDiv = document.getElementById('chat-output');
      const userMessage = inputField.value.trim();

      if (!userMessage) {
          outputDiv.innerHTML += `<div class="message ai-message">
              <p><strong>AI:</strong> Please provide a valid query.</p>
          </div>`;
          return;
      }

      // Display the user's message
      outputDiv.innerHTML += `<div class="message user-message">
          <p><strong>You:</strong> ${userMessage}</p>
      </div>`;
      inputField.value = ''; // Clear the input field

      // Show a loading spinner
      outputDiv.innerHTML += `<div id="loading" class="spinner-border text-primary" role="status">
          <span class="sr-only">Loading...</span>
      </div>`;
      outputDiv.scrollTop = outputDiv.scrollHeight;

      try {
          // Send the message to the backend
          const response = await fetch('/generate-and-analyze-data', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': csrfToken,
              },
              body: JSON.stringify({
                  message: userMessage
              }),
          });
          const data = await response.json();

          if (data.error) {
              outputDiv.innerHTML += `<div class="message ai-message">
                  <p><strong>Error:</strong> ${data.error}</p>
              </div>`;
          } else {
              displayResults(data.analysis); // Call the function to show results in a table
          }

          // Remove the loading spinner
          document.getElementById('loading').remove();
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

  // Display results in a table
  function displayResults(results) {
      const outputDiv = document.getElementById('chat-output');

      if (!results || results.length === 0) {
          outputDiv.innerHTML += `<div class="message ai-message">
              <p><strong>AI:</strong> No results found.</p>
          </div>`;
          return;
      }

      let table = '<table border="1" style="width:100%; border-collapse:collapse;"><thead>';
      table += '<tr>' + Object.keys(results[0]).map(col => `<th>${col}</th>`).join('') + '</tr></thead><tbody>';
      results.forEach(row => {
          table += '<tr>' + Object.values(row).map(val => `<td>${val}</td>`).join('') + '</tr>';
      });
      table += '</tbody></table>';

      outputDiv.innerHTML += `<div class="message ai-message">
          <p><strong>AI:</strong></p>${table}</div>`;
  }
</script>