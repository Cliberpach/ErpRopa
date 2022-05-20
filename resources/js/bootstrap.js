window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    //require('bootstrap');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

/*En el servidor*/
<<<<<<< HEAD
=======
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'ASDASF2121',
    wsHost: window.location.hostname,
    wssPort: 6001,
    encrypted: false,
    disableStats: true,
    enabledTransports: ['ws', 'wss'],
    //forceTLS:false,
});

/*En el local
>>>>>>> 25caa68adec72e9c33fc9705007d0e6a3865f008
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'ASDASF2121',
    wsHost: window.location.hostname,
<<<<<<< HEAD
    wssPort: 6001,
    encrypted:false,
    disableStats:true,
    enabledTransports: ['ws', 'wss'],
    //forceTLS:false,
});
=======
    wsPort: 6001,
    forceTLS:false,
    disableStats: true,
});*/
>>>>>>> 25caa68adec72e9c33fc9705007d0e6a3865f008

/*En el local*/
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'ASDASF2121',
//     wsHost: window.location.hostname,
//     wsPort: 6001,
//     forceTLS:false,
//     disableStats: true,
// });


