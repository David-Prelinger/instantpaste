var $ = require( "jquery" );
//require("dropzone");
import Echo from 'laravel-echo';
import Dropzone from "dropzone";
const axios = require('axios').default;
// @ts-ignore
window.Pusher = require('pusher-js');

let myDropzone: Dropzone;
Dropzone.options.file = {
    maxFiles: 20,
    init: function() {
        myDropzone = this;
        this.on("addedfile", function(file) {
            console.log("Added file.");
        });
    }
};
$(() => {
    new Chest();
});

class Chest {
    echo: Echo;
    constructor() {
        this.setupEventListeners()
        this.fillDropzone()
        this.echo = new Echo({
            broadcaster: 'pusher',
            key: 'MyKey',
            wsHost: window.location.hostname,
            wsPort: 6001,
            forceTLS: false,
            disableStats: true,
        });
            this.addBroadcastListener($('#chest-ip').val());
    }

    setupEventListeners() {
        $('#chest-text').bind('input propertychange', () => {
            axios.post('/', {
                text: $('#chest-text').val(),
            })
                .then((response: any) => {
                    console.log(response)
                })
                .catch(function (error: any) {
                    console.log(error);
                });
        });
        $('#chest-delete').on('click', () => {
            this.clearData();
        })
    }

     addBroadcastListener(chestIp: number): void {
         this.echo.channel(`chest.${chestIp}`).listen('UpdatedChest', (data: any) => {
             console.log(data.chest);
            $('#chest-text').val(data.chest.text);
            if(data.chest.files.length > 0) {
                this.displayExistingFiles(data.chest.files);
            }
         });
     }

     displayExistingFiles(files: any) {
        $('.dz-preview').remove();
         files.forEach(function (file: any) {
             let mockFile = { name: file.file_path, size: 120};
             myDropzone.displayExistingFile(mockFile, "./thumbnails/" + file.file_path, ()=>{}, undefined, false);
             $('span[data-dz-name=""]:contains("' + file.file_path + '")').append('<br/><a href="./files/' + file.file_path + '" download> Download</a>')
         });
     }

     fillDropzone() {
        let files: Array<any> = [];
        $('.file-path').each((index: any, element: HTMLElement) => {
            files.push({ file_path: $(element).val()});
        })
         this.displayExistingFiles(files);
     }

     clearData() {
         axios.delete('/delete')
             .then((response: any) => {
                 console.log(response)
             })
             .catch(function (error: any) {
                 console.log(error);
             });
        // $('.dz-preview').remove();
     }
}
