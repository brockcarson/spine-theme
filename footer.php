<?php
/**
 * Project Name - Short Description
 *
 * Long Description
 * Can span several lines
 *
 * @package    demos.dev
 * @subpackage subfolder
 * @version    0.1
 * @author     paul <pauldewouters@gmail.com>
 * @copyright  Copyright (c) 2012, Paul de Wouters
 * @link       http://pauldewouters.com
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */
?>

<?php
if(is_page_template('front-page.php')){
	// nothing
} elseif(  is_404() || is_search() ){
	get_sidebar();

} else {
	/** No sidebar on full width content */
	$layout = get_post_layout( get_the_ID() );
	if('1c' != $layout)
		get_sidebar();
} // end if

?>
</div>

<!-- End Main Content and Sidebar -->


<!-- Footer -->

<footer class="row">
    <div class="twelve columns">
        <hr />
        <div class="row">
            <div class="six columns">
							<?php hybrid_footer_content(); ?>
            </div>
            <div class="six columns">
							<?php get_template_part( 'menu', 'subsidiary' ); // Loads the menu-subsidiary.php template. ?>
            </div>
        </div>
    </div>
</footer>

<!-- End Footer -->

<?php wp_footer(); ?>
</body>
</html>