import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({

    plugins: [
        laravel([
            'resources/css/app.css',
            'resources/js/app.js',
        ]),
    ],
    server: {
        proxy: {

            // Proxying websockets or socket.io
            '/socket.io': {
                target: 'http://laravel-advance.test',
                port: 8080,
                ws: true
            }
        }
    },
});
/*mix.options({
    hmrOptions:{
        host:'localhost',
        port: 8080,
    }
})*/
