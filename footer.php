<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Eduardo_Domingos_Photography
 */

?>

<footer class="site-footer">
    <div class="container">
        <div class="site-footer__socials">
            <p>Siga-me nas redes:</p>    
            <?php bem_menu('menu-2', 'social'); ?>
        </div>
        <div class="site-footer__newsletter">
            Newsletter here!
        </div>
        <div class="site-footer__widgets">
            <?php get_sidebar('footer'); ?>
        </div>
        <p class="site-footer__copyright">&copy; <?php echo date('Y'); ?> Eduardo Domingos Photography. Todos os direitos reservados.</p>
    </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>
