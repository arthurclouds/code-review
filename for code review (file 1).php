<?php

// Rename, re-order my account menu items
function rename_reorder_my_account_menu()
{
    $neworder = array(
        'dashboard'          => __('Dashboard', 'woocommerce'),
        'orders'             => __('История пополнений', 'woocommerce'),
        'paid-history'       => __('paid-history', 'woocommerce'),
        'edit-account'       => __('Профиль', 'woocommerce'),
        'customer-logout'    => __('Logout', 'woocommerce'),
    );
    return $neworder;
}
add_filter('woocommerce_account_menu_items', 'rename_reorder_my_account_menu');



/**
 * 1. Register new endpoint slug to use for My Account page
 */

/**
 * @important-note	Resave Permalinks or it will give 404 error
 */
function ts_custom_add_premium_support_endpoint()
{
    add_rewrite_endpoint('paid-history', EP_ROOT | EP_PAGES);
    add_rewrite_endpoint('added-funds-history', EP_ROOT | EP_PAGES);
    //add_rewrite_endpoint( 'faq', EP_ROOT | EP_PAGES );
}

add_action('init', 'ts_custom_add_premium_support_endpoint');


/**
 * 2. Add new query var
 */

function ts_custom_premium_support_query_vars($vars)
{
    $vars[] = 'paid-history';
    $vars[] = 'added-funds-history';
    //$vars[] = 'faq';
    return $vars;
}

add_filter('woocommerce_get_query_vars', 'ts_custom_premium_support_query_vars', 0);


/**
 * 3. Insert the new endpoint into the My Account menu
 */

function ts_custom_add_premium_support_link_my_account($items)
{
    $items['paid-history'] = 'История покупок';
    //$items['added-funds-history'] = 'История Пополнений';
    //$items['faq'] = 'ЧЗВ';
    return $items;
}

add_filter('woocommerce_account_menu_items', 'ts_custom_add_premium_support_link_my_account');


/**
 * 4. Add content to the new endpoint
 */

function ts_custom_premium_support_content()
{
    $items = get_user_meta(get_current_user_id(), 'history_payd');
    $tarifs = get_user_meta(get_current_user_id(), 'tarifs_bought');
    if (empty($items) && empty($tarifs)) {
        //echo "<p class='prem-support-p'>Вы пока не купили ни одной статьи и тарифа</p>";
        return;
    }

?>

    <div class="price-plans-table">

        <?php
        $user_id = get_current_user_id();
        $purchased_premium = get_user_meta($user_id, 'purchased_premium');
        //echo "pp: ".$purchased_premium;
        if ($purchased_premium) {

        ?>

            <table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">
                <thead>
                    <tr>
                        <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-number"><span class="nobr">Тариф</span></th>
                        <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-date"><span class="nobr">Дата</span></th>
                        <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-status"><span class="nobr">Списано</span></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach (array_reverse($tarifs) as $tarif) {
                        $i_pur_prem         = $tarif['pur_prem'];
                        $i_date_transaction = $tarif['date_transaction'];
                        $i_amount             = $tarif['amount'];



                    ?>
                        <tr class="woocommerce-orders-table__row woocommerce-orders-table__row--status-completed order">
                            <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-number" data-title="Заказ">
                                <?php

                                echo "Премиум Тариф";
                                ?>
                            </td>
                            <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-date" data-title="Дата">
                                <?php echo $i_date_transaction; ?>
                            </td>
                            <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-status" data-title="Статус">
                                <?php echo $i_amount . ' ' . get_woocommerce_currency_symbol(); ?>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        <?php


        }

        if ($items) {

        ?>
            <table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">
                <thead>
                    <tr>

                        <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-number"><span class="nobr">Статья</span></th>
                        <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-date"><span class="nobr">Дата</span></th>
                        <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-status"><span class="nobr">Списано</span></th>
                    </tr>
                </thead>

                <tbody>
                    <?php




                    foreach (array_reverse($items) as $item) {
                        $i_post_id             = $item['post_id'];
                        $i_date_transaction = $item['date_transaction'];
                        $i_amount             = $item['amount'];
                    ?>

                        <tr class="woocommerce-orders-table__row woocommerce-orders-table__row--status-completed order">
                            <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-number" data-title="Заказ">
                                <?php echo '<a href="' . get_permalink($i_post_id) . '">' . get_the_title($i_post_id)  . '</a>'; ?>
                            </td>
                            <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-date" data-title="Дата">
                                <?php echo $i_date_transaction; ?>
                            </td>
                            <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-status" data-title="Статус">
                                <?php echo $i_amount . ' ' . get_woocommerce_currency_symbol(); ?>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>

                </tbody>
            </table>

        <?php


        }


        /*if (empty($items)) echo "<p class='prem-support-p'>Вы пока не купили ни одной статьи</p>";
	
if (empty($tarifs))	echo "<p class='prem-support-p'>Вы пока не купили ни одного тарифа</p>";*/



        ?>

        <div class="woocommerce-notices-wrapper"></div>
    </div>
<?php
}
/**
 * @important-note	"add_action" must follow 'woocommerce_account_{your-endpoint-slug}_endpoint' format
 */
add_action('woocommerce_account_paid-history_endpoint', 'ts_custom_premium_support_content');
/*add_action( 'woocommerce_account_added-funds-history_endpoint', 'ts_custom_added_funds_history_content' );
add_action( 'woocommerce_account_faq_endpoint', 'ts_custom_faq_content' );*/

function get_money()
{
    $user_id = get_current_user_id();
    $item = get_user_meta($user_id, 'available_posts_new');
    $post_id = get_queried_object_id();
    if (in_array($post_id, $item)) return false;

    $customer = new YITH_YWF_Customer($user_id);
    $fund_on_deposits_available = apply_filters('yith_show_available_funds', $customer->get_funds());

    $price_of_this_post = get_post_meta($post_id, 'prefix-pay_per_postpost_price_amount', true);

    /*if(isset($_POST['SubmitButtonForever'])){
        $price_of_this_post = 10000;
	}*/
    //echo "1before: ".$price_of_this_post;


    if ($price_of_this_post == 0 || $fund_on_deposits_available < $price_of_this_post) {
        return false;
    }

    if ((!isset($_POST['SubmitButtonForever']) && !isset($_POST['SubmitButton'])) || current_user_can('premium')) {
        return false;
    }


    date_default_timezone_set('Europe/Moscow');
    $date = date('d-m-Y h:i:s a', time());

    $who_payd = array(
        'user_id' => $user_id,
        'date_transaction' =>  $date,
        'amount' => $price_of_this_post,
    );
    $history_payd = array(
        'post_id' => $post_id,
        'date_transaction' =>  $date,
        'amount' => $price_of_this_post,
    );


    if (isset($_POST['SubmitButton'])) {
        add_post_meta($post_id, 'who_payd', $who_payd);
    }



    add_user_meta($user_id, 'history_payd', $history_payd);
    $customer->set_funds($fund_on_deposits_available - $price_of_this_post);
    add_user_meta($user_id, 'available_posts_new', $post_id);
}

add_action('template_redirect', 'get_money');
