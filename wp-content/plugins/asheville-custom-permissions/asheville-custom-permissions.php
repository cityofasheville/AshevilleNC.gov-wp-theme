<?php
/*
Plugin Name: Asheville Custom Permissions
Plugin URI: http://www.ashevillenc.gov
Description: This plugin contains the logic for Asheville custom permissions.
Version: 0.1
Author: Patrick Conant
Author URI: https://www.prcapps.com
License: GPL2
*/

// TODO: See if there's a better way to get this
function asheville_custom_permissions_get_term_ids($term_array){
    if(! $term_array):
        return array();
    endif;
    $term_ids = array();

    foreach($term_array as $term):
        $term_ids[] = $term->term_id;
    endforeach;
    return $term_ids;
}

function asheville_custom_permissions_get_user_ids($user_array){
    if(! $user_array):
        return array();
    endif;
    $user_ids = array();
    foreach($user_array as $user):
        $user_ids[] = $user->ID;
    endforeach;
    return $user_ids;
}

function asheville_custom_permissions_check_department_access($user, $post, $check_publish){
    $page_cats = wp_get_object_terms( $post->ID, 'avl_department');
    $page_cat_ids = asheville_custom_permissions_get_term_ids($page_cats);

    $user_access_to_cats = array();

    $user_editor_cats = get_field('department_editor', $user);
    $user_editor_cat_ids = asheville_custom_permissions_get_term_ids($user_editor_cats);

    $user_access_to_cats = array_merge($user_access_to_cats, $user_editor_cat_ids);

    if(! $check_publish): 
        // If it's not publish mode, we also check the content contributors

        $user_content_contributor_cats = get_field('department_content_contributor', $user);
        $user_content_contributor_cat_ids = asheville_custom_permissions_get_term_ids($user_content_contributor_cats);

        $user_access_to_cats = array_merge($user_access_to_cats, $user_content_contributor_cat_ids);
    endif;

    $intersect = array_intersect($page_cat_ids, $user_access_to_cats);

    if(count($intersect)):
        return true;
    else:
        return false;
    endif;
}

function asheville_custom_permissions_check_per_page_access($user, $post, $check_publish){
    $page_editors = get_field('page_editors', $post->ID);
    $page_editor_ids = asheville_custom_permissions_get_user_ids($page_editors);

    $page_acecss_user_ids = array();
    $page_acecss_user_ids = array_merge($page_acecss_user_ids, $page_editor_ids);

    if(! $check_publish): 
        // If it's not publish mode, we also check the content contributors
        $page_content_contributors = get_field('page_content_contributors', $post->ID);
        $page_content_contributor_ids = asheville_custom_permissions_get_user_ids($page_content_contributors);

        $page_acecss_user_ids = array_merge($page_acecss_user_ids, $page_content_contributor_ids);
    endif;

    if(in_array($user->ID, $page_acecss_user_ids) ):
        return true;
    else:
        return false;
    endif;
}

/**
 * asheville_custom_permissions_cap_filter()
 *
 * Filter on the current_user_can() function.
 * This function is used to explicitly allow authors to edit contributors and other
 * authors posts if they are published or pending.
 *
 * @param array $allcaps All the capabilities of the user
 * @param array $cap     [0] Required capability
 * @param array $args    [0] Requested capability
 *                       [1] User ID
 *                       [2] Associated object ID
 */
function asheville_custom_permissions_cap_filter( $allcaps, $cap, $args ) {
    if (! in_array($args[0], array('publish_posts', 'edit_posts', 'edit_post', 'edit_others_posts')) ):
        return $allcaps;
    endif;

    if(isset($_GET['action']) && $_GET['action'] == 'edit'):
        $post_id = $_GET['post'];
    elseif(isset($args[2])):
        $post_id = $args[2];
    else:
        // This is not a check we can perform, so just return here
        return $allcaps;
    endif;

    $post = get_post($post_id);

    // Post type checks?
    if(! in_array($post->post_type, array('avl_department_page') ) ):
        return $allcaps;
    endif;

    $user = wp_get_current_user();
    // var_dump($user->caps);
    // var_dump($user->roles);

    $check_publish = false;
    if(in_array($args[0], array('publish_posts') ) ):
        $check_publish = true;
    endif;

    $user_has_department_access = asheville_custom_permissions_check_department_access($user, $post, $check_publish);
    $user_has_page_access = asheville_custom_permissions_check_per_page_access($user, $post, $check_publish);

    // DEBUG on access control
    // var_dump("Dept");
    // var_dump($user_has_department_access);
    // var_dump("PAGE");
    // var_dump($user_has_page_access);

    if($user_has_department_access || $user_has_page_access):
        $allcaps[$cap[0]] = true;
    else:
        $allcaps[$cap[0]] = false;
    endif;

    return $allcaps;

    // // Below notes - these are for reference 
    // // Bail out if we're not asking about a post:
    // if ( 'edit_post' != $args[0] )
    //     return $allcaps;

    // // Bail out for users who can already edit others posts:
    // if ( $allcaps['edit_others_posts'] )
    //     return $allcaps;

    // // Bail out for users who can't publish posts:
    // if ( !isset( $allcaps['publish_posts'] ) or !$allcaps['publish_posts'] )
    //     return $allcaps;

    // // Load the post data:
    // $post = get_post( $args[2] );

    // // Bail out if the user is the post author:
    // if ( $args[1] == $post->post_author )
    //     return $allcaps;

    // // Bail out if the post isn't pending or published:
    // if ( ( 'pending' != $post->post_status ) and ( 'publish' != $post->post_status ) )
    //     return $allcaps;

    // // Load the author data:
    // $author = new WP_User( $post->post_author );

    // // Bail out if post author can edit others posts:
    // if ( $author->has_cap( 'edit_others_posts' ) )
    //     return $allcaps;

    // $allcaps[$cap[0]] = true;

    // return $allcaps;
}
add_filter( 'user_has_cap', 'asheville_custom_permissions_cap_filter', 10, 3 );
