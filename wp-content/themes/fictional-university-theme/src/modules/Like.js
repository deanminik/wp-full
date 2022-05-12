import $ from 'jquery';

class Like {
    constructor() {

        this.events();
    }
    events() {
        $(".like-box").on("click", this.ourClickDispatcher.bind(this));
    }

    //Methods
    ourClickDispatcher(e) {
        var currentLikeBox = $(e.target).closest(".like-box"); // this is only to select the heard or number instead the all square background
        if (currentLikeBox.data('exists') == 'yes') {
            this.deleteLike();
        } else {
            this.createLike();
        }
    }

    createLike() {
        $.ajax({
            url: universityData.root_url + "/wp-json/university/v1/manageLike",
            type: "POST",
            success: response => {
                console.log(response)
            },
            error: response => {
                console.log(response)
            }
        })
    }
    deleteLike() {
        $.ajax({
            url: universityData.root_url + "/wp-json/university/v1/manageLike",
            type: "DELETE",
            success: response => {
                console.log(response)
            },
            error: response => {
                console.log(response)
            }
        })
    }

}

export default Like;