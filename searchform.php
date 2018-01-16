<?php
/**
 * Template for displaying search forms in Paymo
 *
 * @package PAYMO
 * @version 1.0
 */

?>
<form class="site-search" data-js="site-search" role="search" method="get"
      action="<?php echo esc_url(home_url('/')); ?>">
    <div class="site-search__wrap">
        <button class="site-search__button" type="submit"></button>
        <input class="site-search__field" type="text" autocomplete="off"
               placeholder="Поиск по документации"
               value="<?php echo get_search_query() ?>" name="s" id="s"/>
        <div class="search-result">
            <div data-js="search-result"></div>
        </div>
    </div>
</form>
