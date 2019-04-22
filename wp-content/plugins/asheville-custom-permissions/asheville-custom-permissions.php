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

function add_avl_department_page_caps() {
  $role = get_role( 'administrator' );
  $role->add_cap( 'edit_avl_department_pages' ); 
  $role->add_cap( 'edit_avl_department_pages' ); 
  $role->add_cap( 'edit_others_avl_department_pages' ); 
  $role->add_cap( 'publish_avl_department_pages' ); 
  $role->add_cap( 'read_avl_department_pages' ); 
  $role->add_cap( 'read_private_avl_department_pages' ); 
  $role->add_cap( 'delete_avl_department_pages' ); 
  $role->add_cap( 'edit_published_avl_department_pages' );   //added
  $role->add_cap( 'delete_published_avl_department_pages' ); //added


  $role->add_cap( 'edit_avl_services' ); 
  $role->add_cap( 'edit_avl_services' ); 
  $role->add_cap( 'edit_others_avl_services' ); 
  $role->add_cap( 'publish_avl_services' ); 
  $role->add_cap( 'read_avl_services' ); 
  $role->add_cap( 'read_private_avl_services' ); 
  $role->add_cap( 'delete_avl_services' ); 
  $role->add_cap( 'edit_published_avl_services' );   //added
  $role->add_cap( 'delete_published_avl_services' ); //added
}
add_action( 'admin_init', 'add_avl_department_page_caps');

// TODO: See if there's a better way to get this
function asheville_custom_permissions_get_term_ids($term_array){
    if(! $term_array):
        return array();
    endif;
    $term_ids = array();

    foreach($term_array as $term):
        if(isset($term->term_id)):
            $term_ids[] = $term->term_id;
        endif;
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
    // Web content manager first
    if(in_array('web_content_manager', $user->roles)):
       return true;
    endif;

    $page_cats = wp_get_object_terms( $post->ID, 'avl_department');
    $page_cat_ids = asheville_custom_permissions_get_term_ids($page_cats);

    $user_access_to_cats = array();

    $user_editor_cats = get_field('department_editor', $user);

    // TODO: REVIEW THIS
    if(isset($user_editor_cats[0]->errors) ):
        return true;
    endif;
    $user_editor_cat_ids = asheville_custom_permissions_get_term_ids($user_editor_cats);

    $user_access_to_cats = array_merge($user_access_to_cats, $user_editor_cat_ids);

    if(! $check_publish): 
        // If it's not publish mode, we also check the content contributors

        $user_content_contributor_cats = get_field('department_content_contributor', $user);

        // TODO: REVIEW THIS
        if(isset($user_content_contributor_cats[0]->errors) ):
            return true;
        endif;

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
    // TODO: LOAD USER OFF ID
    $user = wp_get_current_user();
    // var_dump($user->caps);
    // var_dump($user->roles);

    // if(stripos($args[0], 'avl_service')):
    //     foreach($cap as $a_cap):
    //         $allcaps[$a_cap] = false;
    //     endforeach;
    //     return $allcaps;
    // endif;

    
    // if(! $cap):
    //     return $allcaps;
    // endif;
    // var_dump($cap[0]);
    // Bail on $_POST for now
    if(! in_array('department_content_contributor', $user->roles)):
        if(isset($_POST)):
            if(isset($_POST['post_type']) && $_POST['post_type'] == 'avl_department_page'):
                // var_dump($allcaps);
                foreach($cap as $a_cap):
                    $allcaps[$a_cap] = true;
                endforeach;
                return $allcaps;
            endif;
        endif;
    endif;


    $user = wp_get_current_user();

     // If there's no capability here, just bail
    if(! isset($cap[0])):
        return $allcaps;
    endif;
        

    if(in_array('administrator', $user->roles)):
        $allcaps[$cap[0]] = true;
        return $allcaps;
    endif;

    if(in_array('newseditor', $user->roles)):
        if (in_array($cap[0], array('assign_avl_department_term')) ):
            $allcaps[$cap[0]] = true;
            return $allcaps;
        endif;
    endif;

     
 
    if(in_array('department_content_approver', $user->roles)):
        // var_dump($args[0]);
        if (in_array($args[0], array('edit_published_posts')) ):
             $allcaps[$args[0]] = true;
            return $allcaps;
           
        endif;
        // var_dump($args[0]);
        // $allcaps[$args[0]] = true;
        // return $allcaps;
    endif;

    if(in_array('department_content_contributor', $user->roles)):
        // var_dump($args[0]);
        // var_dump($cap);
        if (in_array($cap[0], array('edit_posts', 'edit_pages', 'edit_avl_services', 'edit_tribe_events', 'edit_tribe_venues', 'edit_tribe_organizers')) ):
             $allcaps[$args[0]] = false;
            return $allcaps;
           
        endif;
        // var_dump($args[0]);
        // $allcaps[$args[0]] = true;
        // return $allcaps;
    endif;

   

    // END TESTING
    // To create new depts, add this:  , 'edit_avl_department_term',
    if (! in_array($cap[0], array('edit_post', 'unfiltered_html', 'edit_posts', 'assign_avl_department_term', 'publish_avl_department_pages', 'edit_avl_department_pages', 'edit_avl_department_page', 'edit_others_avl_department_pages')) ):
        return $allcaps;
    endif;

    // Category override
    if (in_array($cap[0], array('assign_avl_department_term', 'edit_avl_department_term')) ):
        $allcaps[$cap[0]] = true;
        return $allcaps;
    endif;

    if(isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['post'])):
        $post_id = $_GET['post'];
    elseif(isset($args[2])):
        $post_id = $args[2];
    else:
        // This is not a check we can perform, so just return here
        return $allcaps;
    endif;

    $post = get_post($post_id);

    if(! $post):
        return $allcaps;
    endif;

    if($post->post_type == 'revision'):
        $post = get_post($post->post_parent);
    endif;

    // Post type checks?
    if(! in_array($post->post_type, array('avl_department_page', 'revision') ) ):
        return $allcaps;
    endif;


    $check_publish = false;
    if(in_array($args[0], array('publish_avl_department_pages') ) ):
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



function asheville_custom_permissions_list_terms_exclusions( $exclusions, $args ) {
    global $pagenow;

    if (! in_array($pagenow,array('post.php','post-new.php')) ):
        return $exclusions;
    endif;

    // Post type check
    $post_type = false;
    if(isset($_GET['post'])):
        $post_id = $_GET['post'];    
        $post = get_post($post_id);
        $post_type = $post->post_type;
    elseif(isset($_GET['post_type'])):
        $post_type = $_GET['post_type'];
    else:
        $post_type = 'post';
    endif;

    if(! in_array($post_type, array('avl_department_page') ) ):
        return $exclusions;
    endif;

    // User role check
    $user = wp_get_current_user();

    if(in_array('administrator', $user->roles)):
        return $exclusions;
    endif;
   
    $user_access_to_cats = array();

    $user_editor_cats = get_field('department_editor', $user);
    $user_editor_cat_ids = asheville_custom_permissions_get_term_ids($user_editor_cats);

    $user_access_to_cats = array_merge($user_access_to_cats, $user_editor_cat_ids);

    $user_content_contributor_cats = get_field('department_content_contributor', $user);
    $user_content_contributor_cat_ids = asheville_custom_permissions_get_term_ids($user_content_contributor_cats);

    $user_access_to_cats = array_merge($user_access_to_cats, $user_content_contributor_cat_ids);

    $user_access_to_cats_str = "'".implode("', '", $user_access_to_cats)."'";

    if (in_array($pagenow,array('post.php','post-new.php')) ) {
        $exclusions = " {$exclusions} AND t.term_id IN ({$user_access_to_cats_str})";
    }
    return $exclusions;
}
add_filter('list_terms_exclusions', 'asheville_custom_permissions_list_terms_exclusions', 10, 2);

