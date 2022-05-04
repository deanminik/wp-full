import $ from 'jquery';

class Search {
    // 1. Describe and create/initiate our objebct 
    constructor() {
        this.openButton = $(".js-search-trigger");
        this.closeButton = $(".search-overlay__close");
        this.searchOverlay = $(".search-overlay");
        this.serachField = $("#search-term");
        this.events();
        this.typingTimer;
        this.resultsDiv = $("#search-overlay__results");
        this.isSpinnerVisible = false;
        this.previousValue;

    }

    // 2. Events
    events() {
        this.openButton.on("click", this.openOverlay.bind(this)); //bind(this) -> to reference the real class div and not this currently object
        this.closeButton.on("click", this.closeOverlay.bind(this));

        $(document).on("keyup", this.keyPressDispatcher.bind(this));
        this.serachField.on("keyup", this.typingLogic.bind(this));
    }


    // 3. Methods (functions)
    typingLogic() {
        if (this.serachField.val() != this.previousValue) {
            clearTimeout(this.typingTimer); //This reset the timer instead sending request to our server sin the last time we active the event keydown
            if (this.serachField.val()) {
                if (!this.isSpinnerVisible) { // ! -> is this false?
                    this.resultsDiv.html('<div class="spinner-loader"></div>');
                    this.isSpinnerVisible = true;
                }
                this.typingTimer = setTimeout(() => {
                    this.getResults().bind(this);
                }, 2000); //The gap will be for 2 seconds
            } else {
                this.resultsDiv.html('');
                this.isSpinnerVisible = false;
            }


        }
        this.previousValue = this.serachField.val();
    }

    getResults() {
        // this.resultsDiv.html("Imagine real search result here");
        // this.isSpinnerVisible = false;

        $.getJSON('http://localhost:10003/wp-json/wp/v2/posts/?search=' + this.serachField.val(), function(posts) {
            alert(posts[0].title.rendered);
        });
    }

    keyPressDispatcher(e) {
        // e -> event
        //Find the key code
        //console.log(event.keyCode); // -> 27

        /*Important key code is deprecated instead use "e.Key == "Escape" */

        if (e.keyCode == 27) {
            //Esc 
            this.closeOverlay()
        }
    }

    openOverlay() {
        this.searchOverlay.addClass("search-overlay--active");
        $("body").addClass("body-no-scroll");
    }
    closeOverlay() {
        this.searchOverlay.removeClass("search-overlay--active");
        $("body").removeClass("body-no-scroll");
    }
}

export default Search //Allow to use this class in another file