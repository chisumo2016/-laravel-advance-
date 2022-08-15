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

//Login inn private change

function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) {
        return parts.pop().split(';').shift();
    }
}

function request(url, options) {
    // get cookie
    const csrfToken = getCookie('XSRF-TOKEN');
    return fetch(url, {
        headers: {
            'content-type': 'application/json',
            'accept': 'application/json',
            'X-XSRF-TOKEN': decodeURIComponent(csrfToken),
        },
        credentials: 'include',
        ...options,
    })
}

function logout() {
    return request('/logout', {
        method: 'POST'
    });
}

function login(email, password) {

    return fetch('/sanctum/csrf-cookie', {
        headers: {
            'content-type': 'application/json',
            'accept': 'application/json'
        },
        credentials: 'include'
    }).then(() => logout())
        .then(() => {
            return request('/login', {
                method: "POST",
                body: JSON.stringify({
                    email: email,
                    'password': password
                })
            });
        }).then(() => {
            document.getElementById('section-login').classList.add('hide')
            document.getElementById('section-chat').classList.remove('hide')
        })

}


//Connect to our channel
const channel = Echo.private('private.chat.1');
//const channel = Echo.channel('public.chat.1');

channel.subscribed(() => {
    console.log('subscribed');
}).listen('.chat-message', (event) =>{
    console.log('event');

    const message = event.message;

    const li = document.createElement('li');

    li.textContent = message;
    listMessage.append(li);
});
