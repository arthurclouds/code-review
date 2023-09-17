<?php

namespace Elje\Plugin;

if (!defined('ABSPATH')) {
	die('Wanna hack?');
}

/**
 * Assets actions registerer class.
 *
 * @since 1.0.2
 */
class Assets
{
	/**
	 * Class constructor.
	 *
	 * @since 1.0.2
	 */
	public function __construct()
	{
		add_action('wp_enqueue_scripts', [
			$this,
			'registerScripts',
		], 5);

		add_action('admin_enqueue_scripts', [
			$this,
			'enqueueAdminAssets',
		]);

		add_action('wp_enqueue_scripts', [
			$this,
			'enqueueFrontAssets',
		]);

		add_action('wp_enqueue_scripts', [
			$this,
			'disable_gutenberg_wp_enqueue_scripts',
		], 100);

		add_action('admin_enqueue_scripts', [
			$this,
			'disable_gutenberg_wp_enqueue_scripts',
		], 100);
	}

	/**
	 * Register all assets for reusable calls from plugin environment.
	 *
	 * @return void
	 * @since 1.0.2
	 */
	public function registerScripts(): void
	{
	}

	/**
	 * Enqueue admin assets.
	 *
	 * @return void
	 * @since 1.0.2
	 */
	public function enqueueAdminAssets(): void
	{
		if (defined('ELJE_CDN_MODE') && ELJE_CDN_MODE) {
			wp_register_script('elje-bootstrap', '//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.1/js/bootstrap.min.js', [], '4.6.1', TRUE);

			wp_register_script('elje-select2', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js', [], '4.0.13', TRUE);
			wp_register_style('elje-select2', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css', [], '4.0.13');
		} else {
			wp_register_script('elje-bootstrap', ELJE_PLUGIN_URI . 'shared/js/bootstrap.min.js', [], '4.6.1', TRUE);

			wp_register_script('elje-select2', ELJE_PLUGIN_URI . 'shared/js/select2.full.min.js', [], '4.0.13', TRUE);
			wp_register_style('elje-select2', ELJE_PLUGIN_URI . 'shared/css/select2.min.css', [], '4.0.13');
		}

		wp_enqueue_script('elje-admin-settings', ELJE_PLUGIN_URI . 'shared/js/admin.js', [
			'jquery',
		], '0.0.1', TRUE);
		wp_enqueue_style('elje-admin-settings', ELJE_PLUGIN_URI . 'shared/css/admin.css', [], '0.0.1');
	}

	/**
	 * Enqueue frontend assets.
	 *
	 * @return void
	 * @since 1.0.2
	 */
	public function enqueueFrontAssets(): void
	{
		if (defined('ELJE_CDN_MODE') && ELJE_CDN_MODE) {
			wp_enqueue_style('swiper', 'https://unpkg.com/swiper@8/swiper-bundle.min.css', [], '8.3.1');
			wp_enqueue_script('swiper', 'https://unpkg.com/swiper@8/swiper-bundle.min.js', ['jquery'], '8.3.1', TRUE);
		} else {
			wp_enqueue_style('swiper', ELJE_PLUGIN_URI . 'shared/css/swiper-bundle.min.css', [], '8.3.1');
			wp_enqueue_script('swiper', ELJE_PLUGIN_URI . 'shared/js/swiper-bundle.min.js', ['jquery'], '8.3.1', TRUE);
		}
		wp_enqueue_style('elje-frontend', ELJE_PLUGIN_URI . 'shared/css/frontend.css', [], ELJE_PLUGIN_VERSION);
		wp_enqueue_script('elje-frontend', ELJE_PLUGIN_URI . 'shared/js/frontend.js', ['jquery'], ELJE_PLUGIN_VERSION, TRUE);

		wp_localize_script('elje-frontend', 'ELJE_PLUGIN', [
			'ajaxUrl'   => admin_url('admin-ajax.php'),
			'pluginUrl' => ELJE_PLUGIN_URI,
			'version'   => ELJE_PLUGIN_VERSION,
		]);

		wp_enqueue_script('jquery', '//code.jquery.com/jquery-1.11.0.min.js', array(), null);

		wp_enqueue_style('slick-styles', get_template_directory_uri() . '/assets/js/slick/slick.css', array(), null);
		wp_enqueue_script('slick-js', get_template_directory_uri() . '/assets/js/slick/slick.min.js', array(), null);

		//echo "valod";
	}

	/**
	 * Disable default block styles.
	 *
	 * @return void
	 * @since 1.0.1
	 */
	public function disable_gutenberg_wp_enqueue_scripts(): void
	{
		wp_dequeue_style('wp-block-library');
		wp_dequeue_style('wp-block-library-theme');
	}
}

new Assets();
