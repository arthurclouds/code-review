<?php

namespace Elje\Plugin;

if( !defined( 'ABSPATH' ) ) {
	die( 'Wanna hack?' );
}

/**
 * Admin Options page init.
 *
 * @since 1.0.2
 */
class Options
{
	/**
	 * @var array
	 * @since 1.0.2
	 */
	private array $settings = [];

	/**
	 * Class constructor.
	 *
	 * @since 1.0.2
	 */
	public function __construct()
	{
		$this->setSettings();

		add_action( 'admin_menu', [
			$this,
			'registerEljeOptionsPage',
		] );

		add_action( 'admin_enqueue_scripts', [
			$this,
			'enqueueScripts',
		] );

		add_action( 'wp_ajax_elje-settings-models-info', [
			$this,
			'ajaxHandler',
		] );
	}

	/**
	 * Set settings array for class usage.
	 *
	 * @return void
	 * @since 1.0.2
	 */
	protected function setSettings()
	: void
	{
		$this->settings = [];
	}

	/**
	 * Get provided or all option settings.
	 *
	 * @param  string  $option  Option name. Optional. If nothing found, empty array will return, if not passed all setting will return.
	 *
	 * @return array|mixed
	 * @since 1.0.2
	 */
	public function getSettings( string $option = '' )
	{
		return $option ? ( $this->settings[ $option ] ?? [] ) : $this->settings;
	}

	/**
	 * Enqueue assets for options page.
	 *
	 * @return void
	 * @since 1.0.2
	 */
	public function enqueueScripts()
	: void
	{
		if( !empty( $_GET[ 'page' ] ) && in_array( $_GET[ 'page' ], [
				'elje-settings',
				'elje-settings-models',
			], TRUE ) ) {
			wp_enqueue_media();
			wp_enqueue_script( 'elje-bootstrap' );
			wp_enqueue_style( 'elje-bootstrap' );
			wp_enqueue_style( 'elje-select2' );
			wp_enqueue_script( 'elje-select2' );
		}

		$this->enqueueLocalize();
	}

	/**
	 * Localize selected options data for blocks usage from window global elje-settings.
	 *
	 * @return void
	 * @since 1.0.2
	 */
	protected function enqueueLocalize()
	: void
	{
		$data = [];
		foreach( $this->getSettings() as $setting_name => $setting ) {
			$data[ $setting_name ] = get_option( $setting[ 'option_name' ], [] );
		}
		wp_localize_script( 'elje-admin-settings', 'eljeAdminSettings', $data );
	}

	/**
	 * Register menu item.
	 *
	 * @return void
	 * @since 1.0.2
	 */
	public function registerEljeOptionsPage()
	: void
	{
		add_menu_page(
			__( 'Elje settings', 'elje' ),
			__( 'Elje settings', 'elje' ),
			'manage_options',
			'elje-settings',
			[
				$this,
				'renderMenuPage',
			],
			ELJE_PLUGIN_URI . 'images/elje-logo-black-icon.png',
			6
		);

		add_submenu_page(
			'elje-settings',
			__( 'Models settings', 'elje' ),
			__( 'Models settings', 'elje' ),
			'manage_options',
			'elje-settings-models',
			[
				$this,
				'renderMenuPage',
			], 7,
		);
	}

	/**
	 * Page content markup.
	 *
	 * @return void
	 * @since 1.0.2
	 */
	public function renderMenuPage()
	: void
	{
		$this->renderHeader();
		$this->renderBody();
		$this->renderFooter();
	}

	/**
	 * Render header for current page.
	 *
	 * @return void
	 * @since 1.0.2
	 */
	protected function renderHeader()
	: void
	{
		echo '<div class="elje-admin-wrap">';
		$current = $_GET[ 'page' ] ?? 'elje-settings';
		?>
		<div class="privacy-settings-header">
			<div class="privacy-settings-title-section">
				<h1><?php _e( 'Elje settings', 'elje' ); ?></h1>
			</div>
			<nav class="privacy-settings-tabs-wrapper" aria-label="Secondary menu">
				<a href="<?php echo admin_url( 'admin.php?page=elje-settings' ); ?>" class="privacy-settings-tab <?php echo $current === 'elje-settings' ? 'active' : ''; ?>" aria-current="true">Globals</a>
				<a href="<?php echo admin_url( 'admin.php?page=elje-settings-models' ); ?>" class="privacy-settings-tab <?php echo $current === 'elje-settings-models' ? 'active' : ''; ?>" aria-current="false">Models</a>
			</nav>
		</div>
		<?php
	}

	/**
	 * Render body for current page.
	 *
	 * @return void
	 * @since 1.0.2
	 */
	protected function renderBody()
	: void
	{
		$current = $_GET[ 'page' ] ?? 'elje-settings';
		switch( $current ) {
			case 'elje-settings-models':
				$this->renderModelTabs();
				break;
			case 'elje-settings':
			default:
				$this->renderGlobalTabs();
				break;
		}
	}

	/**
	 * Render footer for current page.
	 *
	 * @return void
	 * @since 1.0.2
	 */
	protected function renderFooter()
	: void
	{
		echo '</div>';
	}

	/**
	 * Modal models settings tab markup.
	 *
	 * @return void
	 * @since 1.0.2
	 */
	protected function renderModelTabs()
	: void
	{
		?>
		<div class="container-fluid">
			<?php

			foreach( $this->getSettings() as $setting_name => $settings ) :
				if( !is_array( $settings[ 'data' ] ) ) {
					$settings[ 'data' ] = [];
				}

				if( empty( $settings[ 'data' ] ) ) {
					$settings[ 'data' ][] = [];
				}

				?>
				<section class="elje-admin-section">
					<h3><?php echo $settings[ 'title' ]; ?></h3>
					<div class="elje-multi-form elje-multi-colors" data-action="elje-settings-models-info" data-action-type="<?php echo $setting_name; ?>">
						<div class="elje-multi-form-add">
							<?php
							foreach( $settings[ 'data' ] as $setting ) :
								?>
								<div class="elje-multi-form-add-wrap row align-items-end">
									<div class="form-column col-sm-6 col-md-4 col-xl-5">
										<label>
											<span>Title</span>
											<input type="text" class="elje-multi-form-add-title" value="<?php echo $setting[ 'title' ] ?? ''; ?>"/>
										</label>
									</div>
									<div class="form-column col-sm-6 col-md-4 col-xl-5">
										<label>
											<span>Price</span>
											<input type="number" min="0" class="elje-multi-form-add-price" value="<?php echo $setting[ 'price' ] ?? ''; ?>"/>
										</label>
									</div>
									<div class="form-column col-sm-6 col-md-2 col-xl-1 text-center">
										<?php if( empty( $setting[ 'image' ] ) ): ?>
											<button class="elje-multi-form-add-image btn btn-outline-primary btn-sm" type="button">Upload image</button>
											<img class="elje-multi-form-image" style="display: none" alt="" src=""/>
										<?php else: ?>
											<button class="elje-multi-form-add-image btn btn-outline-primary btn-sm" type="button" style="display: none">Upload image</button>
											<img class="elje-multi-form-image" alt="" src="<?php echo esc_url( $setting[ 'image' ] ); ?>"/>
										<?php endif; ?>
									</div>
									<div class="form-column col-sm-6 col-md-2 col-xl-1">
										<button class="elje-multi-form-remove btn btn-danger btn-sm" type="button">remove</button>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
						<button type="button" class="elje-multi-form-add-btn btn btn-warning">Add</button>
						<button type="button" class="elje-multi-form-save btn btn-success">Save</button>
					</div>
				</section>
			<?php endforeach; ?>
		</div>
		<?php
	}

	/**
	 * Global options tab markup.
	 *
	 * @return void
	 * @since 1.0.2
	 */
	protected function renderGlobalTabs()
	: void
	{

	}

	/**
	 * Form save actions ajax handler.
	 *
	 * @return void
	 */
	public function ajaxHandler()
	: void
	{
		if( empty( $_POST[ 'actionType' ] ) || empty( $_POST[ 'data' ] ) || !is_array( $_POST[ 'data' ] ) ) {
			wp_send_json_error( [
				'message' => 'One or more required attribute is missing.',
			], 403 );
		}

		$settings    = $this->getSettings() ? : [];
		$action_type = $_POST[ 'actionType' ];

		if( empty( $settings[ $action_type ] ) ) {
			wp_send_json_error( [
				'message' => 'Invalid action type provided.',
			], 403 );
		}

		$action = $settings[ $action_type ];

		if( empty( $action[ 'option_name' ] ) ) {
			wp_send_json_error( [
				'message' => 'Invalid option type provided.',
			], 403 );
		}

		$type = $action[ 'type' ] ?? '';

		if( $type === 'dropdown' ) {
			$this->processDropDownValues( $_POST[ 'data' ], $action[ 'option_name' ] );
		}

		//todo
	}

	/**
	 * Helper for parsing multirow elements data.
	 *
	 * @param  null|array  $data    Data for parsing.
	 * @param  string      $option  Db option name
	 *
	 * @return void
	 * @since 1.0.2
	 */
	private function processDropDownValues( ?array $data, string $option )
	: void
	{
		$db_ready = [];
		foreach( $data as $row_index => $row ) {
			if( empty( $row[ 'title' ] ) ||
				empty( $row[ 'image' ] ) ||
				( !empty( $row[ 'price' ] ) &&
					!is_numeric( $row[ 'price' ] ) )
			) {
				wp_send_json_error( [
					'message'  => 'Incomplete data passed on Roof form ' . ( $row_index + 1 ) . ' row.',
					'rowIndex' => $row_index,
					'rowData'  => $row,
				], 403 );
			}

			$db_ready[] = [
				'key'   => sanitize_title( $row[ 'title' ] ),
				'title' => sanitize_text_field( $row[ 'title' ] ),
				'image' => sanitize_url( $row[ 'image' ] ),
				'price' => (int)( $row[ 'price' ] || 0 ),
			];
		}

		$db_updated = update_option( $option, $db_ready );
		wp_send_json_success( [
			'message'   => 'Data successfully saved.',
			'dbUpdated' => $db_updated,
		] );
	}
}

new Options();
