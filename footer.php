<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Chouquette_thème
 */

?>

</div><!-- #content -->

<script type="text/javascript" src="<?php echo esc_url(home_url('/dist/vendor.js')); ?>"></script>
<script type="text/javascript" src="<?php echo esc_url(home_url('/dist/app.js')); ?>"></script>
<?php wp_footer(); ?>

</body>
</html>
