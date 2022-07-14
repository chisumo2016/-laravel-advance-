import './bootstrap';
import axios from "axios";
const  form = document.getElementById('form');
const  inputMessage = document.getElementById('input-message');
const  listMessage = document.getElementById('list-message');

form.addEventListener('submit', function (event) {
       event.preventDefault();
        const userInput = inputMessage.value;

        axios.post('chat-message',{
            message:        userInput
    });
});


//Connect to our channel
const channel = Echo.channel('public.chat.1');

channel.subscribed(() => {
    console.log('subscribed');
}).listen('.chat-message', (event) =>{
    console.log('event');

    const message = event.message;

    const li = document.createElement('li');

    li.textContent = message;
    listMessage.append(li);
});
