<!DOCTYPE html>
<html>
<head>
    <title>Todo App</title>
    @vite(['resources/js/app.js'])
</head>
<body>
    <h1>Todo List</h1>
    <form >
        @csrf
        <input type="text" name="title" id="todo">
        <button onclick="sendMessage()" >Add Todo</button>
    </form>
    <ul>
        @foreach ($todos as $todo)
            <li>
                {{ $todo['title'] }}
            </li>
        @endforeach
    </ul>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        Echo.channel(`todo-channel`)
            .listen('AddTodoName', (e) => {
                const messages = document.getElementById('todo');
                const messageElement = document.createElement('div');
                messageElement.innerHTML = `<strong>${e.message}:</strong> ${e.message}`;
                messages.appendChild(messageElement);
                messages.scrollTop = messages.scrollHeight; // Scroll to the bottom
            });
    })


    function sendMessage() {
        const messageInput = document.getElementById('todo');
        const message = messageInput.value;
        messageInput.value = ''; // Clear input
        fetch(`/todos`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({message: message})
        }).catch(error => console.error('Error:', error));
    }
    </script>
</body>
</html>
