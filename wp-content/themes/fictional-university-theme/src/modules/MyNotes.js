import $ from 'jquery';

class MyNotes {
    constructor() {
        this.events();


    }
    events() {
            $(".delete-note").on("click", this.deleteNote);
        }
        //METHODS
    deleteNote() {

        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
            },
            url: universityData.root_url + '/wp-json/wp/v2/note/106',
            type: 'DELETE',
            success: () => {
                console.log("Congrats");
                console.log(response);
            },
            error: () => {
                console.log("Sorry");
                console.log(response);
            }
        });
    }
}


export default MyNotes;