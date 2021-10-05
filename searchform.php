<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ) ?>" autocomplete="off">
    <input required type="search" class="search-form__input" placeholder="Procurar..." value="<?php get_search_query(); ?>" name="s" />
    <button class="search-form__submit" type="submit"><i class="icon icon-search"></i><span class="screen-reader-text">Pesquisar</span></button>
</form>