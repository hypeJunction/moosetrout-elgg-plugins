<?php

/**
 * AU plugin administration tool
 */


register_elgg_event_handler('init', 'system', 'au_admin_plugins_init', 1);

/**
 * Init
 */
function au_admin_plugins_init() {

    // extend css
    extend_view('css', 'au_admin_plugins/css');
    
    // register a page handler
    register_page_handler('au_admin_plugins','au_admin_plugins_page_handler');

    // register event handler
    register_elgg_event_handler('pagesetup', 'system', 'au_admin_plugins_pagesetup');
}

/**
 * Add admin menu item
 */
function au_admin_plugins_pagesetup() {

    if (get_context() == 'admin' && isadminloggedin()) {
        global $CONFIG;
        add_submenu_item(elgg_echo('au_admin_plugins:admin_link'), $CONFIG->wwwroot . 'pg/au_admin_plugins/index');
    }
     
    return true;
}



/**
 * page handler
 *
 * @param array $page Array of page elements, forwarded by the page handling mechanism
 */
function au_admin_plugins_page_handler($page) {

    global $CONFIG;

    $tab = $page[0];
    if (!$tab) {
        $tab = "index";
    }

    set_input("tab", $tab);

    if (isset($page)) {
        switch($page[0]) {
            case 'index2':
                include($CONFIG->pluginspath . 'au_admin_plugins/index2.php');
                break;
            case 'index':
                include($CONFIG->pluginspath . 'au_admin_plugins/index.php');
                break;
            case 'list_versions':
                include($CONFIG->pluginspath . 'au_admin_plugins/list_versions.php');
                break;
            case 'list_view_overrides':
                include($CONFIG->pluginspath . 'au_admin_plugins/list_view_overrides.php');
                break;
            case 'dump_order':
                include($CONFIG->pluginspath . 'au_admin_plugins/dump_order.php');
                break;
            case 'list_dependencies':
                include($CONFIG->pluginspath . 'au_admin_plugins/list_dependencies.php');
                break;
            default:
                include($CONFIG->pluginspath . 'au_admin_plugins/index.php');
        }
    } else {
        // assume index
        include($CONFIG->pluginspath . 'au_admin_plugins/index.php');
    }

}