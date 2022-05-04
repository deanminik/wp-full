import $ from 'jquery';

class Search {
    // 1. Describe and create/initiate our objebct 
    constructor() {
        this.openButton = $(".js-search-trigger");
        this.closeButton = $(".search-overlay__close");
        this.searchOverlay = $(".search-overlay");
        this.events();

    }

    // 2. Events
    events() {
        this.openButton.on("click", this.openOverlay.bind(this)); //bind(this) -> to reference the real class div and not this currently object
        this.closeButton.on("click", this.closeOverlay.bind(this));
    }


    // 3. Methods (functions)
    openOverlay() {
        this.searchOverlay.addClass("search-overlay--active");
    }
    closeOverlay() {
        this.searchOverlay.removeClass("search-overlay--active");
    }
}

export default Search //Allow to use this class in another file