<?php

add_action('admin_menu', 'my_admin_menu');

function my_admin_menu()
{
	add_menu_page('ПЛАТНЫЙ ДОСТУП', 'ПЛАТНЫЙ ДОСТУП', 'manage_options', 'myplugin/myplugin-admin-page.php', 'myplguin_admin_page', 'dashicons-heart', 1);
	// 	echo '<style>.dashicons-heart::before {color: red;}</style>';
}
function myplguin_admin_page()
{
	$cc_args = array(
		'posts_per_page'   => -1,
		'post_type'        => 'post',
		'meta_key'         => 'prefix-pay_per_postcheckbox_pay',
		'meta_value'       => '1'
	);
	$cc_query = new WP_Query($cc_args);
?>
	<div class="wrap">
		<h2>Платный доступ к статьям</h2>
	</div>
	<?php
	$posts = $cc_query->posts;

	?>
	<table id="post-purchased-amount" class="paid-posts-table" cellspacing='0'>
		<tr>
			<th onclick="sortTable(0)">Статья</th>
			<th onclick="sortTable(1)">Дата публикации</th>
			<th onclick="sortTable(2)">Количество купленных доступов</th>
		</tr>
		<?php
		foreach ($posts as $post) {
			echo	'<tr><td><a title="' . $post->post_title  . '" href="' .  get_edit_post_link($post->ID) . '">' . $post->post_title  . '</a></td>';
			echo	'<td>' . $post->post_date . '</td>';
			$items = get_post_meta(($post->ID), 'who_payed');

			echo	'<td>' . count($items)  . '</td></tr>';
		}
		?>
	</table>


	<?php
	wp_reset_query();
}

function blog_category($atts)
{

	$query = new WP_Query(array(
		'post_status' => 'publish',
		'category_name' => $atts['category'],
		'orderby' => 'date',
		'order' => 'DESC'
	));
	if ($query->have_posts()) : ?>
		<div id="blog-archive" class="blog-content">

			<div class="row">
				<?php
				/* Start the Loop */
				while ($query->have_posts()) : $query->the_post();
					get_template_part('content');
				endwhile;
				?>
			</div>
		</div>
	<?php
		thim_paging_nav();
	endif;
}
add_shortcode('bc', 'blog_category');


function pay_per_post($meta_boxes)
{
	$prefix = 'prefix-pay_per_post';

	$meta_boxes[] = array(
		'id' => 'pay_per_post',
		'title' => esc_html__('Настройка доступа к записи', 'pay_per_post'),
		'post_types' => array('post'),
		'context' => 'side',
		'priority' => 'high',
		'autosave' => 'true',
		'fields' => array(
			array(
				'id' => $prefix . 'post_price_amount',
				'type' => 'number',
				'name' => esc_html__('Цена доступа к записи', 'pay_per_post'),
				'desc' => esc_html__('введите стоимость, которую должен оплатить читатель, для того что бы получить доступ к записям', 'pay_per_post'),
			),
			array(
				'id' => $prefix . 'checkbox_pay',
				'name' => esc_html__('Включить платный доступ к записи', 'pay_per_post'),
				'type' => 'checkbox',
				'std' => 0,
			),
		),
	);

	return $meta_boxes;
}
add_filter('rwmb_meta_boxes', 'pay_per_post');

add_action('edit_form_advanced', 'callback__edit_form_after_editor');
function callback__edit_form_after_editor($post)
{
	if ($post->post_type != 'post') return;
	?>
	<div class="post-purchased-users-list">

		<h2>Доступ к этой статье купили</h2>
		<?php
		$items = get_post_meta(get_the_ID(), 'who_payed');
		?>

		<table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table price-plans-payment-history-admin">
			<thead>
				<tr>
					<th class='smallt'></th>
					<th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-number"><span class="nobr">Пользователь</span></th>
					<th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-date"><span class="nobr">Дата покупки доступа</span></th>
					<th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-status"><span class="nobr">Списано</span></th>
				</tr>
			</thead>
			<?php
			$count = 1;
			foreach (array_reverse($items) as $item) {
				$user       = get_userdata($item['user_id']);
				$first_name = $user->first_name;
				$last_name  = $user->last_name;
				echo '<tr class="woocommerce-orders-table__row woocommerce-orders-table__row--status-completed order">';
				echo "<td class='woocommerce-orders-table__cell smallt'>$count</td>";
				echo '<td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-number" data-title="Заказ"><a href="' . get_edit_user_link($item['user_id']) . '">' . $first_name . ' ' . $last_name . '</a></td>';
				echo '<td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-date" data-title="Дата">' . $item['date_transaction'] . '</td>';
				echo '<td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-status" data-title="Статус">' . $item['amount'] . '</td>';
				echo "</tr>";
				$count++;
			}
			?>

		</table>
	</div>
<?php
}
