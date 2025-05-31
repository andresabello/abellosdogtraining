<?php

if (!function_exists('pi_setup')) {
    /**
     *
     */
    function pi_setup()
    {
        //Translations available
        $lang_dir = THEME_PATH . '/languages';
        load_theme_textdomain('pibusiness', $lang_dir);
        //Add support for automatic feed links
        add_theme_support('automatic-feed-links');
        //Add support for post thumbnails
        add_theme_support('post-thumbnails');
        //Add html5 support
        add_theme_support('html5', ['comment-list', 'comment-form', 'search-form', 'gallery', 'caption']);
        //Add support for post thumbnails
        register_nav_menus(['main-menu' => __('Main Menu', 'pibusiness')]);
    }

    add_action('after_setup_theme', 'pi_setup');
}

/**
 *
 * Navigation for posts
 *
 **/
if (!function_exists('pi_paging_nav')) {
    /**
     * @return mixed
     */
    function pi_paging_nav()
    {
        $extra = get_extra_class();
        return $extra->pi_pagination();
    }
}

if (!function_exists('pi_post_meta')) {
    /**
     * @return mixed
     */
    function pi_post_meta()
    {
        $extra = get_extra_class();
        return $extra->post_meta();
    }
}

/**
 * @param string $hex
 * @param string $opacity
 * @return string
 */
function hexToRgba(string $hex, string $opacity = '.8')
{
    $hex = str_replace("#", "", $hex);

    if (strlen($hex) === 3) {
        $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
        $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
        $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
    } else {
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
    }

    $rgb = [$r, $g, $b];
    $rgba = implode(",", $rgb);
    $rgba = "rgba($rgba, $opacity)";

    return $rgba;
}

/**
 * @param $pagename
 * @return bool
 */
function get_page_by_name($pagename)
{
    $pages = get_pages();
    foreach ($pages as $page) {
        if ($page->post_name == $pagename) {
            return $page;
        }
    }
    return false;
}

/**
 * @param $email
 * @return mixed
 */
function pi_email_validate_sanitize($email)
{
    $security = get_security_class();
    return $security->email_check($email);
}

/**
 * @param $email
 * @param $title
 * @param $content
 * @return array
 */
function pi_listing_validation($email, $title, $content)
{
    $error = array();

    $check_email = pi_email_validate_sanitize($email);

    if ($check_email === false) {
        $error['email'] = 'Please add a valid Email';
        $has_error = true;
    }

    if (trim($title) === '') {
        $error['title'] = 'Please add a title';
        $has_error = true;
    }

    if (trim($content) === '') {
        $error['desc'] = 'Please add a description';
        $has_error = true;
    }

    if ($has_error = true) {
        return $error;
    }
}

/**
 * @return mixed
 */
function pi_get_user_ip()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

/**
 * @param $url
 * @return string
 */
function pi_add_http($url)
{
    if (!empty($url)) {
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = "http://" . $url;
        }
    }

    return $url;
}

/**
 * @param $lat
 * @param $lng
 * @return array|mixed|object
 */
function get_location_from_google($lat, $lng)
{
    $request = 'http://data.fcc.gov/api/block/find?format=json&latitude=' . $lat . '&longitude=' . $lng . '&showall=true';
    $file_contents = file_get_contents($request);
    $json_decode = json_decode($file_contents);
    return $json_decode;
}

/**
 * @param string $imageUrl
 * @return mixed
 */
function getImageId(string $imageUrl)
{
    global $wpdb;
    $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $imageUrl));
    return $attachment[0];
}

/**
 * @param mixed ...$data
 */
function dd($data)
{
    print_r($data);die();
}

/**
 * @param mixed ...$data
 */
function consoleLog(...$data)
{
    echo '<script>';
    echo 'console.log(' . json_encode($data) . ')';
    echo '</script>';
}

/**
 * @param string $path
 * @param array $variables
 * @return false|string|null
 */
function getTemplate(string $path, array $variables)
{
    extract($variables);
    $template = locate_template([$path]);
    if (empty($template)) {
        return null;
    }

    ob_start();
    include($template);
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}

/**
 * @param string $key
 * @param string $option
 * @return string|null
 */
function getOptionImage(string $key, string $option = 'general_settings')
{
    $options = get_option($option);
    $imageId = $options[$key] ?? null;

    if (!$imageId) {
        return null;
    }

    $image = wp_get_attachment_image($imageId, 'full', false, ['class' => 'img img-fluid']);
    if (!$image) {
        return null;
    }

    return $image;
}

/**
 * @param $postId
 */
function updateLocationDirection($postId)
{
    $lat = get_field('latitude', $postId);
    $lon = get_field('longitude', $postId);
    $key = GOOGLE_MAPS_KEY;
    $distanceMatrixLink = "https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=$lat,{$lon}&destinations=place_id:ChIJhepQpD0g2YgR2pBmSb-K5oY&key=$key";
    $response = wp_remote_post($distanceMatrixLink);
    $body = wp_remote_retrieve_body($response);
    $body = json_decode($body, true);
    $miles = isset($body['rows']) && isset($body['rows'][0]) && isset($body['rows'][0]['elements']) && isset($body['rows'][0]['elements'][0]) && isset($body['rows'][0]['elements'][0]['distance']) && isset($body['rows'][0]['elements'][0]['distance']['text']) ? $body['rows'][0]['elements'][0]['distance']['text'] : null;
    $miles = intval(str_replace('mi ', '', $miles));

    if ($miles <= 60) {
        update_field('directions', 'local', $postId);
        return;
    }

    if ($miles >= 60 && $miles <= 380) {
        update_field('directions', 'driving', $postId);
        return;
    }

    update_field('directions', 'flying', $postId);
    return;
}

/**
 * @param string $string
 * @return mixed
 */
function stringToSlug(string $string)
{
    return str_replace([' ', '_'], '-', $string);
}