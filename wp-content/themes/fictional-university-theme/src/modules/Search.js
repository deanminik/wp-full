import $ from 'jquery';

class Search {
    // 1. Describe and create/initiate our objebct 
    constructor() {
        this.addSearchHTML();

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
                this.typingTimer = setTimeout(this.getResults.bind(this), 750);
            } else {
                this.resultsDiv.html('');
                this.isSpinnerVisible = false;
            }


        }
        this.previousValue = this.serachField.val();
    }

    getResults() {
            var posts_getJSON = $.getJSON(universityData.root_url + '/wp-json/wp/v2/posts?search=' + this.serachField.val());
            var pages_getJSON = $.getJSON(universityData.root_url + '/wp-json/wp/v2/pages?search=' + this.serachField.val());

            //asynchronic 
            $.when(posts_getJSON, pages_getJSON).then((posts, pages) => {
                        var combineResults = posts[0].concat(pages[0]);
                        this.resultsDiv.html(`
                    
                    <h2 class="search-overlay__section-title">General Information</h2>
                    ${ combineResults.length ? '<ul class="link-list min-list">':'<p>No general information matches that search </p>'}  
                    ${combineResults.map(item => `<li><a href="${item.link}">${item.title.rendered}</a>${item.type == 'post'? ` by ${item.authorName}` :''}</li>`).join('')}
                    ${combineResults.length ? '</ul>':''}
                    `);
                    
                    this.isSpinnerVisible = false;
                                }, () => {
                                    this.resultsDiv.html('<p>Unexpected error; please try again</p>');
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
        this.serachField.val('');
        setTimeout(() => this.serachField.focus(), 301);

    }
    closeOverlay() {
        this.searchOverlay.removeClass("search-overlay--active");
        $("body").removeClass("body-no-scroll");
    }

    addSearchHTML() {
        $("body").append(`
        <div class="search-overlay">
    <div class="search-overlay__top">
        <div class="container">
            <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
            <input type="text" class="search-term" placeholder="What are you looking for?" id="search-term">
            <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
        </div>
    </div>
    <div class="container">
        <div id="search-overlay__results">
            
        </div>
    </div>
</div>
        
        `);
    }
}

export default Search //Allow to use this class in another file