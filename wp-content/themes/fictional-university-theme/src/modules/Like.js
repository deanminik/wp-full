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
        alert("create test ");
    }
    deleteLike() {
        alert("delete test");
    }

}

export default Like;