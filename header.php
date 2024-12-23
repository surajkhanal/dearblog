<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package dearblog
 */


if ( !function_exists( 'generate_menu_search_icon' ) ) {
	add_filter( 'wp_nav_menu_items', 'generate_menu_search_icon', 10, 2 );
	/**
	 * Add search icon to primary menu if set.
	 * Only used if using old float system.
	 *
	 * @param string $nav The HTML list content for the menu items.
	 * @param stdClass $args An object containing wp_nav_menu() arguments.
	 * @return string The search icon menu item.
	 * @since 1.2.9.7
	 *
	 */
	function generate_menu_search_icon( $nav, $args ) {
		
		
		// If our primary menu is set, add the search icon.
		if ( isset( $args->theme_location ) && 'menu-1' === $args->theme_location ) {
			$search_item = apply_filters(
				'generate_navigation_search_menu_item_output',
				sprintf(
					'<li class="search-item menu-item-align-right"><a aria-label="%1$s" href="#">%2$s</a></li>',
					esc_attr__( 'Open Search Bar', 'dearblog' ),
					get_svg_icon( 'search' ) . get_svg_icon( 'close' ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in function.
				)
			);
			
			return $nav . $search_item;
		}
		
		// Our primary menu isn't set, return the regular nav.
		// In this case, the search icon is added to the generate_menu_fallback() function in navigation.php.
		return $nav;
	}
}

if ( !function_exists( 'generate_dropdown_icon_to_menu_link' ) ) {
	add_filter( 'nav_menu_item_title', 'generate_dropdown_icon_to_menu_link', 10, 4 );
	/**
	 * Add dropdown icon if menu item has children.
	 *
	 * @param string $title The menu item title.
	 * @param WP_Post $item All of our menu item data.
	 * @param stdClass $args All of our menu item args.
	 * @param int $depth Depth of menu item.
	 * @return string The menu item.
	 * @since 1.3.42
	 *
	 */
	function generate_dropdown_icon_to_menu_link( $title, $item, $args, $depth ) {
		$role = 'presentation';
		$tabindex = '';
		$aria_label = '';
  
		if ( isset( $args->container_class ) && 'main-nav' === $args->container_class ) {
			foreach ( $item->classes as $value ) {
				if ( 'menu-item-has-children' === $value ) {
					$icon = get_svg_icon( 'arrow-down' );
					$title = $title . '<span role="' . $role . '" class="dropdown-menu-toggle"' . $tabindex . $aria_label . '>' . $icon . '</span>';
				}
			}
		}
		
		return $title;
	}
}

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
	
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'dearblog' ); ?></a>

    <header id="masthead" class="site-header">
        <div class="inside-header grid-container grid-parent">
            <div class="site-branding">
							<?php
							the_custom_logo();
							if ( is_front_page() && is_home() ) :
								?>
                  <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"
                                            rel="home"><?php bloginfo( 'name' ); ?></a></h1>
							<?php
							else :
								?>
                  <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"
                                           rel="home"><?php bloginfo( 'name' ); ?></a></p>
							<?php
							endif;
							$dearblog_description = get_bloginfo( 'description', 'display' );
							if ( $dearblog_description || is_customize_preview() ) :
								?>
                  <p class="site-description"><?php echo $dearblog_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
										?></p>
							<?php endif; ?>
            </div><!-- .site-branding -->

            <nav id="site-navigation" class="main-navigation">
				<?php get_search_form(); ?>
                <button class="menu-toggle" aria-controls="primary-menu"
                        aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'dearblog' ); ?></button>
							<?php
							wp_nav_menu(
								array(
									'theme_location' => 'menu-1',
									'container_class' => 'main-nav',
									'menu_id' => 'primary-menu',
									'fallback_cb' => 'generate_menu_fallback',
								)
							);
							?>
            </nav><!-- #site-navigation -->
        </div>
    </header><!-- #masthead -->

	<nav id="mobile-header" itemtype="https://schema.org/SiteNavigationElement" class="main-navigation mobile-header-navigation has-branding">
		<div class="inside-navigation grid-container grid-parent">
			<?php get_search_form(); ?>

			<div class="site-logo mobile-header-logo">
				<?php
					the_custom_logo();
					if ( is_front_page() && is_home() ) :
						?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"
									rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php
					else :
						?>
						<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"
									rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php
					endif;
					$dearblog_description = get_bloginfo( 'description', 'display' );
					if ( $dearblog_description || is_customize_preview() ) :
						?>
						<p class="site-description"><?php echo $dearblog_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?></p>
					<?php endif; ?>
			</div>

			<div class="mobile-bar-items">
				<div class="search-item mobile-search-item">
					<a aria-label="Open Search Bar" href="#">
						<span class="df-icon icon-search"><svg viewBox="0 0 512 512" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"><path fill-rule="evenodd" clip-rule="evenodd" d="M208 48c-88.366 0-160 71.634-160 160s71.634 160 160 160 160-71.634 160-160S296.366 48 208 48zM0 208C0 93.125 93.125 0 208 0s208 93.125 208 208c0 48.741-16.765 93.566-44.843 129.024l133.826 134.018c9.366 9.379 9.355 24.575-.025 33.941-9.379 9.366-24.575 9.355-33.941-.025L337.238 370.987C301.747 399.167 256.839 416 208 416 93.125 416 0 322.875 0 208z"></path></svg><svg viewBox="0 0 512 512" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"><path d="M71.029 71.029c9.373-9.372 24.569-9.372 33.942 0L256 222.059l151.029-151.03c9.373-9.372 24.569-9.372 33.942 0 9.372 9.373 9.372 24.569 0 33.942L289.941 256l151.03 151.029c9.372 9.373 9.372 24.569 0 33.942-9.373 9.372-24.569 9.372-33.942 0L256 289.941l-151.029 151.03c-9.373 9.372-24.569 9.372-33.942 0-9.372-9.373-9.372-24.569 0-33.942L222.059 256 71.029 104.971c-9.372-9.373-9.372-24.569 0-33.942z"></path></svg></span>
					</a>
				</div>
			</div>

			<button class="menu-toggle" aria-controls="mobile-menu" aria-expanded="false">
				<span class="df-icon icon-menu-bars">
					<svg viewBox="0 0 512 512" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"><path d="M0 96c0-13.255 10.745-24 24-24h464c13.255 0 24 10.745 24 24s-10.745 24-24 24H24c-13.255 0-24-10.745-24-24zm0 160c0-13.255 10.745-24 24-24h464c13.255 0 24 10.745 24 24s-10.745 24-24 24H24c-13.255 0-24-10.745-24-24zm0 160c0-13.255 10.745-24 24-24h464c13.255 0 24 10.745 24 24s-10.745 24-24 24H24c-13.255 0-24-10.745-24-24z"></path></svg>
					<svg viewBox="0 0 512 512" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"><path d="M71.029 71.029c9.373-9.372 24.569-9.372 33.942 0L256 222.059l151.029-151.03c9.373-9.372 24.569-9.372 33.942 0 9.372 9.373 9.372 24.569 0 33.942L289.941 256l151.03 151.029c9.372 9.373 9.372 24.569 0 33.942-9.373 9.372-24.569 9.372-33.942 0L256 289.941l-151.029 151.03c-9.373 9.372-24.569 9.372-33.942 0-9.372-9.373-9.372-24.569 0-33.942L222.059 256 71.029 104.971c-9.372-9.373-9.372-24.569 0-33.942z"></path></svg></span><span class="mobile-menu">Menu</span>					
			</button>

			<div id="mobile-menu" class="mobile-menu">
				<?php
					wp_nav_menu(
						array(
							'theme_location' => 'menu-1',
							'container_class' => 'main-nav',
							'menu_id' => 'primary-menu',
						)
					);
				?>
			</div>
		</div>
	</nav>

    <!--    <li class="search-item menu-item-align-right"><a aria-label="Open Search Bar" href="#"><span class="df-icon icon-search"><svg viewBox="0 0 512 512" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"><path fill-rule="evenodd" clip-rule="evenodd" d="M208 48c-88.366 0-160 71.634-160 160s71.634 160 160 160 160-71.634 160-160S296.366 48 208 48zM0 208C0 93.125 93.125 0 208 0s208 93.125 208 208c0 48.741-16.765 93.566-44.843 129.024l133.826 134.018c9.366 9.379 9.355 24.575-.025 33.941-9.379 9.366-24.575 9.355-33.941-.025L337.238 370.987C301.747 399.167 256.839 416 208 416 93.125 416 0 322.875 0 208z"></path></svg><svg viewBox="0 0 512 512" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"><path d="M71.029 71.029c9.373-9.372 24.569-9.372 33.942 0L256 222.059l151.029-151.03c9.373-9.372 24.569-9.372 33.942 0 9.372 9.373 9.372 24.569 0 33.942L289.941 256l151.03 151.029c9.372 9.373 9.372 24.569 0 33.942-9.373 9.372-24.569 9.372-33.942 0L256 289.941l-151.029 151.03c-9.373 9.372-24.569 9.372-33.942 0-9.372-9.373-9.372-24.569 0-33.942L222.059 256 71.029 104.971c-9.372-9.373-9.372-24.569 0-33.942z"></path></svg></span></a></li>-->
