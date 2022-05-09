import $ from 'jquery';

class MyNotes {
    constructor() {
        this.events();


    }
    events() {
            $(".delete-note").on("click", this.deleteNote);
            $(".edit-note").on("click", this.editNote);
        }
        //METHODS
    deleteNote(e) {
        var thisNote = $(e.target).parents("li");

        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
            },
            url: universityData.root_url + '/wp-json/wp/v2/note/' + thisNote.data('id'),
            type: 'DELETE',
            success: () => {
                thisNote.slideUp();
                console.log("Congrats");
                console.log(response);
            },
            error: () => {
                console.log("Sorry");
                console.log(response);
            }
        });
    }
    editNote(e) {
        var thisNote = $(e.target).parents("li");
        thisNote.find(".note-title-field, .note-body-field").removeAttr("readonly").addClass("note-active-field");
        thisNote.find(".update-note").addClass("update-note--visible");
    }
}


export default MyNotes;