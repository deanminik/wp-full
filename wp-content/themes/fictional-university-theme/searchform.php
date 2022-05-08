    <!-- esc_url -> this is for secuerity best practice  -->
    <!-- action=echo esc_url(site_url('/')) -> this redirect to the main url with the result like this http://localhost:10003/?s=math  -->
    <!-- get -> to see the url with the parameter  -->
    <form class="search-form" method="get" action="<?php echo esc_url(site_url('/')) ?>">
        <label class="headline headline--medium" for="s">Perform a New Search</label>
        <div class="search-form-row">
            <input class="s" id="s" type="search" name="s" placeholder="What are you looking for?">
            <input class="search-submit" type="submit" value="Search">
        </div>
    </form>