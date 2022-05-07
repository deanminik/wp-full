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
            //Use our custom REST API URL
            //generalInfo -> came from the search-route file inside of an array 
            var customURL_getJSON = universityData.root_url + '/wp-json/university/v1/search?term=' + this.serachField.val();
            $.getJSON(customURL_getJSON, (results) => {
                        this.resultsDiv.html(`
            <div class="row">
                <div class="one-third">
                    <h2 class="search-overlay__section-title">General Information</h2>
                    ${results.generalInfo.length ? '<ul class="link-list min-list">':'<p>No general information matches that search </p>'}  
                    ${results.generalInfo.map(item => `<li><a href="${item.permalink}">${item.title}</a>${item.postType == 'post'? ` by ${item.authorName}` :''}</li>`).join('')}
                    ${results.generalInfo.length ? '</ul>':''}
                </div>
                <div class="one-third">
                    <h2 class="search-overlay__section-title">Programs</h2>
                    ${results.programs.length ? '<ul class="link-list min-list">':`<p>No programs match that search <a href="${universityData.root_url}/programs">View all programs</a> </p>`}  
                    ${results.programs.map(item => `<li><a href="${item.permalink}">${item.title}</a></li>`).join('')}
                    ${results.programs.length ? '</ul>':''}
                    <h2 class="search-overlay__section-title">Professors</h2>
                </div>
                <div class="one-third">
                    <h2 class="search-overlay__section-title">Campuses</h2>
                    ${results.campuses.length ? '<ul class="link-list min-list">':`<p>No campuses match that search <a href="${universityData.root_url}/programs">View all programs</a></p>`}  
                    ${results.campuses.map(item => `<li><a href="${item.permalink}">${item.title}</a></li>`).join('')}
                    ${results.campuses.length ? '</ul>':''}
        
                    <h2 class="search-overlay__section-title">Events</h2>
                </div>
            </div>
                
                `);
                this.isSpinnerVisible = false;
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