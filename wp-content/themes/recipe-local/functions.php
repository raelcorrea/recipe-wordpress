<?php 
	/**
	 * Enqueue the style.css file.
	 * 
	 * @since 1.0.0
	 */
	function recipe_styles() {
		wp_enqueue_style(
			'recipe-style',
			get_stylesheet_uri(),
			array(),
			wp_get_theme()->get( 'Version' )
		);
	}
	add_action( 'wp_enqueue_scripts', 'recipe_styles' ); 
	
	if ( ! function_exists( 'recipelocal_setup' ) ) {
		function recipelocal_setup() {
				add_theme_support( 'wp-block-styles' );
			}
	}
	add_action( 'after_setup_theme', 'recipelocal_setup' );

?>

<?php add_action("wp_head",function(){ ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Lobster&display=swap" rel="stylesheet">
<?php }); ?>