<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Chat Assistant</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            flex-direction: column;
            height: 100vh;
        }
        .chat-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            padding: 10px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
        }
        .message {
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
        }
        .message.user {
            background-color: #007bff;
            color: white;
            align-self: flex-end;
        }
        .message.ai {
            background-color: #f1f1f1;
            align-self: flex-start;
        }
        .input-group {
            margin-top: auto;
        }
        .predefined-buttons {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin-bottom: 10px;
        }
        .predefined-buttons button {
            margin: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="chat-container" id="chat-container">
            <!-- Messages will be appended here -->
        </div>
        <div class="predefined-buttons">
            <button class="btn btn-info" data-question="stock bajo en la semana">Stock bajo en la semana</button>
            <button class="btn btn-info" data-question="stock alto en el mes">Stock alto en el mes</button>
            <button class="btn btn-info" data-question="producto con más ventas en el año">Producto con más ventas en el año</button>
            <button class="btn btn-info" data-question="producto con más ventas">Producto con más ventas</button>
            <button class="btn btn-info" data-question="consejo del día">Consejo del día</button>
        </div>
        <div class="input-group mb-3">
            <input type="text" class="form-control" id="user-input" placeholder="Type a message">
            <div class="input-group-append">
                <button class="btn btn-primary" id="send-button">Send</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.predefined-buttons button').on('click', function() {
                const question = $(this).data('question');
                appendMessage('user', question);
                sendToAPI(question);
            });

            $('#send-button').on('click', function() {
                const userInput = $('#user-input').val();
                if (userInput.trim() !== '') {
                    appendMessage('user', userInput);
                    $('#user-input').val('');
                    sendToAPI(userInput);
                }
            });

            $('#user-input').on('keypress', function(e) {
                if (e.which === 13) {
                    $('#send-button').click();
                }
            });

            function appendMessage(sender, text) {
                const messageElement = $('<div>').addClass('message').addClass(sender).text(text);
                $('#chat-container').append(messageElement);
                $('#chat-container').scrollTop($('#chat-container')[0].scrollHeight);
            }

            function sendToAPI(userInput) {
                $.ajax({
                    url: 'chat.php',
                    method: 'POST',
                    data: { message: userInput },
                    success: function(response) {
                        appendMessage('ai', response);
                    },
                    error: function() {
                        appendMessage('ai', 'Error communicating with the server.');
                    }
                });
            }
        });
    </script>
</body>
</html>
