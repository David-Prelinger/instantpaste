var $ = require( "jquery" );
import Echo from 'laravel-echo';
const axios = require('axios').default;
// @ts-ignore
window.Pusher = require('pusher-js');



$(() => {
    new Chest();
});

 class Chest {
    echo: Echo;
    constructor() {
        this.setupEventListeners()
        this.echo = new Echo({
            broadcaster: 'pusher',
            key: 'MyKey',
            wsHost: window.location.hostname,
            wsPort: 6001,
            forceTLS: false,
            disableStats: false,
        });
        if($('#chest-id').val() != null) {
            this.addBroadcastListener($('#chest-id').val());
        }
    }

    setupEventListeners() {
        $('#chest-text').bind('input propertychange', () => {
            axios.post('/', {
                text: $('#chest-text').val(),
            })
                .then((response: any) => {
                    console.log(response);
                    this.addBroadcastListener($('#chest-id').val());
                })
                .catch(function (error: any) {
                    console.log(error);
                });
        });
    }

     addBroadcastListener(chestId: number): void {
         this.echo.channel(`chest.${chestId}`).listen('UpdatedChest', (data: any) => {
             console.log(data.chest.text);
            $('#chest-text').val(data.chest.text);
         });
     }

}
