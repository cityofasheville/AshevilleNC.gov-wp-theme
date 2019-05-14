<?php 
  /**
   * Plugin Name: City of Asheville Sync Google
   * Plugin URI: https://www.prcapps.com
   * Description: Sync Wordpress user_meta fields with data provided by Google Directory plugin. Note to COA - I kept the license GPL to match other plugins developed on the site by City Staff. 
   * Version: 1.0
   * Author: Patrick Conant
   * Author URI: https://github.com/conantp
   * License: GPL2
   */

  /*  Copyright 2017  Patrick Conant  (email : patrick@prcapps.com)

      This program is free software; you can redistribute it and/or modify
      it under the terms of the GNU General Public License, version 2, as 
      published by the Free Software Foundation.

      This program is distributed in the hope that it will be useful,
      but WITHOUT ANY WARRANTY; without even the implied warranty of
      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
      GNU General Public License for more details.

      You should have received a copy of the GNU General Public License
      along with this program; if not, write to the Free Software
      Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

  */


// add_action('wp_login', 'coa_gs_sync_google_data');
add_action( 'admin_menu', 'coa_gs_add_admin_menu' );
add_action( 'admin_init', 'coa_gs_settings_init' );

// Impelemented by PRC on 03.2019
// Name Change Function - this migrates BuddyPress content from one user to another 
function coa_gs_do_name_change($old_email, $new_email, $do_updates=false){
  global $wpdb; 

  if($do_updates):
    add_settings_error('city_of_asheville_google_sync', 'testcode', "Preparing for name change content migration...", 'updated');
  else:
    add_settings_error('city_of_asheville_google_sync', 'testcode', "Test Mode: Preparing for name change content migration...", 'updated');
  endif;

  if(! $old_email):
    add_settings_error('city_of_asheville_google_sync', 'testcode', "Missing old email");
    return;
  endif;

  if(! $new_email):
    add_settings_error('city_of_asheville_google_sync', 'testcode', "Missing new email");
    return;
  endif;

  // Get User ID for old email
  $old_wp_user = get_user_by('email', $old_email);

  // Get User ID for new email
  $new_wp_user = get_user_by('email', $new_email);

  if(! $old_wp_user):
    add_settings_error('city_of_asheville_google_sync', 'testcode', "No user found: {$old_email}");
    return;
  endif;

  if(! $new_wp_user):
    add_settings_error('city_of_asheville_google_sync', 'testcode', "No user found: {$new_email}");
    return;
  endif;

  // SQL to check existing content and perform updates. 
  
  // wp_posts
  $sql_wp_posts = "UPDATE wp_posts SET post_author = {$new_wp_user->ID} WHERE post_author = {$old_wp_user->ID}";
  $test_sql_wp_posts = "SELECT * FROM wp_posts WHERE post_author = {$old_wp_user->ID}";

  // wp_bp_activity
  $sql_wp_bp_activity = "UPDATE wp_bp_activity SET user_id = {$new_wp_user->ID} WHERE user_id = {$old_wp_user->ID}";
  $test_sql_wp_bp_activity = "SELECT * FROM wp_bp_activity WHERE user_id = {$old_wp_user->ID}";

  // wp_bp_group_documents
  $sql_wp_bp_group_documents = "UPDATE wp_bp_group_documents SET user_id = {$new_wp_user->ID} WHERE user_id = {$old_wp_user->ID}";
  $test_sql_wp_bp_group_documents = "SELECT * FROM wp_bp_group_documents WHERE user_id = {$old_wp_user->ID}";

  // wp_bp_groups_members
  $sql_wp_bp_groups_members = "UPDATE wp_bp_groups_members SET user_id = {$new_wp_user->ID} WHERE user_id = {$old_wp_user->ID}";
  $test_sql_wp_bp_groups_members = "SELECT * FROM wp_bp_groups_members WHERE user_id = {$old_wp_user->ID}";

  // wp_bp_notifications
  $sql_wp_bp_notifications = "UPDATE wp_bp_notifications SET user_id = {$new_wp_user->ID} WHERE user_id = {$old_wp_user->ID}";
  $test_sql_wp_bp_notifications = "SELECT * FROM wp_bp_notifications WHERE user_id = {$old_wp_user->ID}";

  // wp_user_blogs
  $sql_wp_bp_user_blogs = "UPDATE wp_bp_user_blogs SET user_id = {$new_wp_user->ID} WHERE user_id = {$old_wp_user->ID}";
  $test_sql_wp_bp_user_blogs = "SELECT * FROM wp_bp_user_blogs WHERE user_id = {$old_wp_user->ID}";

  // BuddyPress Profile Data 
  $check_old_wp_bp_xprofile_data = "SELECT * FROM wp_bp_xprofile_data WHERE (field_id = 3 OR field_id = 4) AND user_id = {$old_wp_user->ID}";
  $check_new_wp_bp_xprofile_data = "SELECT * FROM wp_bp_xprofile_data WHERE (field_id = 3 OR field_id = 4) AND user_id = {$new_wp_user->ID}";
  $sql_wp_bp_xprofile_data = "UPDATE wp_bp_xprofile_data SET user_id = {$new_wp_user->ID} WHERE (field_id = 3 OR field_id = 4) AND user_id = {$old_wp_user->ID}";

  // Get Counts for admin notification
  $prepare_count = array();

  $test_sql_wp_posts_results = $wpdb->get_results( $test_sql_wp_posts, OBJECT );
  $prepare_count['wp_posts'] = count($test_sql_wp_posts_results);

  $test_sql_wp_bp_activity_results = $wpdb->get_results( $test_sql_wp_bp_activity, OBJECT );
  $prepare_count['wp_bp_activity'] = count($test_sql_wp_bp_activity_results);

  $test_sql_wp_bp_group_documents_results = $wpdb->get_results( $test_sql_wp_bp_group_documents, OBJECT );
  $prepare_count['wp_bp_group_documents'] = count($test_sql_wp_bp_group_documents_results);

  $test_sql_wp_bp_groups_members_results = $wpdb->get_results( $test_sql_wp_bp_groups_members, OBJECT );
  $prepare_count['wp_bp_groups_members'] = count($test_sql_wp_bp_groups_members_results);

  $test_sql_wp_bp_notifications_results = $wpdb->get_results( $test_sql_wp_bp_notifications, OBJECT );
  $prepare_count['wp_bp_notifications'] = count($test_sql_wp_bp_notifications_results);

  $test_sql_wp_bp_user_blogs_results = $wpdb->get_results( $test_sql_wp_bp_user_blogs, OBJECT );
  $prepare_count['wp_bp_user_blogs'] = count($test_sql_wp_bp_user_blogs_results);

  $check_old_wp_bp_xprofile_data_results = $wpdb->get_results( $check_old_wp_bp_xprofile_data, OBJECT );
  $prepare_count['wp_bp_xprofile_data'] = count($check_old_wp_bp_xprofile_data_results);

  // Display admin notification 
  add_settings_error('city_of_asheville_google_sync', 'testcode', "Prepaing to migrate content from {$old_wp_user->user_email} to {$new_wp_user->user_email}. <br /><br />Found the following content:<br />
    <strong>wp_posts:</strong> {$prepare_count['wp_posts']}<br />
    <strong>wp_bp_activity:</strong> {$prepare_count['wp_bp_activity']}<br />
    <strong>wp_bp_group_documents:</strong> {$prepare_count['wp_bp_group_documents']}<br />
    <strong>wp_bp_groups_members:</strong> {$prepare_count['wp_bp_groups_members']}<br />
    <strong>wp_bp_notifications:</strong> {$prepare_count['wp_bp_notifications']}<br />
    <strong>wp_bp_user_blogs:</strong> {$prepare_count['wp_bp_user_blogs']}<br />
    <strong>wp_bp_xprofile_data:</strong> {$prepare_count['wp_bp_xprofile_data']}<br />", 'updated');


  // Do Content Migration
  if($do_updates):
    $sql_wp_posts_results = $wpdb->get_results( $sql_wp_posts, OBJECT );
    add_settings_error('city_of_asheville_google_sync', 'testcode', "Updated wp_posts", 'updated');

    $sql_wp_bp_activity_results = $wpdb->get_results( $sql_wp_bp_activity, OBJECT );
    add_settings_error('city_of_asheville_google_sync', 'testcode', "Updated wp_bp_activity", 'updated');

    $sql_wp_bp_group_documents_results = $wpdb->get_results( $sql_wp_bp_group_documents, OBJECT );
    add_settings_error('city_of_asheville_google_sync', 'testcode', "Updated wp_bp_group_documents", 'updated');

    $sql_wp_bp_groups_members_results = $wpdb->get_results( $sql_wp_bp_groups_members, OBJECT );
    add_settings_error('city_of_asheville_google_sync', 'testcode', "Updated wp_bp_groups_members", 'updated');

    $sql_wp_bp_notifications_results = $wpdb->get_results( $sql_wp_bp_notifications, OBJECT );
    add_settings_error('city_of_asheville_google_sync', 'testcode', "Updated wp_bp_notifications", 'updated');

    $sql_wp_bp_user_blogs_results = $wpdb->get_results( $sql_wp_bp_user_blogs, OBJECT );
    add_settings_error('city_of_asheville_google_sync', 'testcode', "Updated wp_bp_user_blogs", 'updated');
  endif;

  // Check BuddyPress Profile fields - used on the employee directory

  // First, we see if there is field data for the new user - if so, we don't update
  $check_new_wp_bp_xprofile_data_results = $wpdb->get_results( $check_new_wp_bp_xprofile_data, OBJECT );
  if(count($check_new_wp_bp_xprofile_data_results)):
    add_settings_error('city_of_asheville_google_sync', 'testcode', "Found existing BuddyPress profile data for new user. We will not update this data, but the user can edit their profile via the 'Edit My Profile' link.", 'error');
  else:
      // Second, we check if there's actually content to mgirate
      $check_old_wp_bp_xprofile_data_results = $wpdb->get_results( $check_old_wp_bp_xprofile_data, OBJECT );

      if(count($check_old_wp_bp_xprofile_data_results)):
        add_settings_error('city_of_asheville_google_sync', 'testcode', "Found existing BuddyPress profile data for old user. Migrating to new user.", 'error');
        
        // If there is content to migrate, we do the update - but only we're in update mode.
        if($do_updates):
          $sql_wp_bp_xprofile_data_results = $wpdb->get_results( $sql_wp_bp_xprofile_data, OBJECT );
          add_settings_error('city_of_asheville_google_sync', 'testcode', "Updated BuddyPress Profile data (wp_bp_xprofile_data)", 'updated');
        endif;
      else:
        add_settings_error('city_of_asheville_google_sync', 'testcode', "No BuddyPress profile data for old user. The user can edit their profile via the 'Edit My Profile' link.", 'error');
      endif;
  endif;

  // Do a Google Sync for the new user
  $google_sync_status = coa_gs_sync_google_data_for_email($new_wp_user->user_email);
  if($google_sync_status):
    add_settings_error('city_of_asheville_google_sync', 'testcode', "Updated Google Data for new user.", 'updated');
  else:
    add_settings_error('city_of_asheville_google_sync', 'testcode', "Error updating Google Data for new user.", 'error');
  endif;

  // Notify the admin the process is complete
  if($do_updates):
    add_settings_error('city_of_asheville_google_sync', 'testcode', "Name change content migration complete!", 'updated');
  else:
    add_settings_error('city_of_asheville_google_sync', 'testcode', "Test mode: No content migrated", 'updated');
  endif;
  
  return true;
}

// Sync the Google Data for current user
function coa_gs_sync_google_data(){
  $user = wp_get_current_user();
  $user_email = $user->user_email;
  coa_gs_sync_google_data_for_email($user_email);
}

// Sync the Google Data by email
function coa_gs_sync_google_data_for_email($user_email, $google_user=false){
  $google_user_meta_mapping = array(
    'fullName' => 'name',
    'givenName' => 'first_name',    
    'familyName' => 'last_name',    
    'org_department' => 'department',     
    'phone_work' => 'telephonenumber',  
    'phone_mobile' => 'mobile',   
    'primaryEmail' => 'email',  
    'givenName' => 'givenname',    
    'familyName' => 'sn',
    'fullName' => 'adi_displayname',
    'primaryEmail' => 'mail',
  );

  if(! $google_user):
    $google_data = gadentGoogleAppsDirectory()->getGoogleAdminData( $user_email, "", "", ""); 

    if(count($google_data) != 1): // if not 1, then we either have multiple records or 0
      // echo "No google data";
      return false;
    endif;
    $google_user = array_pop($google_data);
  endif;

  $wordpress_user = get_user_by('email', $user_email);


  if(! $google_user || ! $wordpress_user):
    return false;
  endif;

  // DEBUG
  // var_dump($google_user);
  // var_dump($wordpress_user);
  // exit;

  foreach($google_user_meta_mapping as $google_key => $usermeta_key):
    if(true || isset($google_user[$google_key]) ): // Sync even blank values


      if(isset($google_user[$google_key])):
        $google_value = $google_user[$google_key];
      else:
        $google_value = false;
      endif;

      if($google_key == "phone_work"):
        $google_value = str_replace("Work Phone: ", "", $google_value);
      elseif ($google_key == "phone_mobile"):
        $google_value = str_replace("Mobile Phone: ", "", $google_value);
      endif;

      // Check wordpress meta
      $wp_meta_value = get_user_meta($wordpress_user->ID, $usermeta_key);

      if(is_array($wp_meta_value)):
        // Our meta is all single value
        $wp_meta_value = array_pop($wp_meta_value);
      endif;

      // Only update the field in Wordpress if necessary
      // This well help us with performance when we do a bigger sync
      if($wp_meta_value != $google_value):
        update_user_meta($wordpress_user->ID, $usermeta_key, $google_value);
      endif;
    endif;
  endforeach;

  // PRC 09.2018
  // We also want to update the image cache
  $avatar = get_avatar($wordpress_user, 120);
  update_user_meta($wordpress_user->ID, 'coa_avatar_url_cache_google', $avatar);
  // delete_user_meta($wordpress_user->ID, 'coa_avatar_url_cache_google');

  return true;
}

// ACTIONS
function coa_check_for_deactivated_accounts(){
  $wp_users = get_users();
  $google_data = gadentGoogleAppsDirectory()->getGoogleAdminData("", "", "", ""); 

  $google_emails = array();
  foreach($google_data as $google_user):
    if($google_user['primaryEmail']):
      $google_emails[] = strtolower($google_user['primaryEmail']);
    endif;
  endforeach;

  if(! $google_emails || count($google_emails) == 0):
    return;
  endif;

  $match = 0;
  $missing = 0;

  $wp_emails = array();
  $wp_emails_assoc = array();
  foreach($wp_users as $wp_user):
    $email = $wp_user->user_email;

    if($email):
      $email = strtolower($email);
      $wp_emails[] = $email;
      $wp_emails_assoc[$email] = $wp_user;
    endif;
  endforeach;

  $diff_emails = array_values(array_diff($wp_emails, $google_emails));

  $message = "";
  foreach($diff_emails as $diff_email):
    if(stripos($diff_email, "disabled") !== false):
      continue;
    endif;

    if($diff_email == 'asheville-city-source@coablog.ashevillenc.gov'):
      continue;
    endif;

    // User needs to be disabled
    $wp_user = $wp_emails_assoc[$diff_email];

    if(! $wp_user):
      continue;
    endif;

    $wp_user->set_role('');
    $email = $wp_user->user_email;

    $new_email = 'DISABLED-'.$email;

    $user_id = wp_update_user( array( 'ID' => $wp_user->ID, 'user_email' => $new_email ) );

    if ( is_wp_error( $user_id ) ):
     // There was an error, probably that user doesn't exist.
      echo "Error updating user: {$email}";
      continue;
      // exit;
    else:
      $message .= $diff_email."\n";
    endif;
  endforeach;

  coa_gs_clear_cache();

  $message = "Disabled: {$message}";
  if(function_exists('add_settings_error')):
    add_settings_error('city_of_asheville_google_sync', 'testcode', $message, 'updated');
  endif;
  
  return true;
}

function coa_gs_do_full_sync(){
  if(function_exists('add_settings_error')):
    add_settings_error('city_of_asheville_google_sync', 'testcode', "Doing sync of all users", 'updated');
  endif;

  $success_count = 0;
  $fail_count = 0;


  $google_user_meta_mapping = array(
    'fullName' => 'name',
    'givenName' => 'first_name',    
    'familyName' => 'last_name',    
    'org_department' => 'department',     
    'phone_work' => 'telephonenumber',  
    'phone_mobile' => 'mobile',   
    'primaryEmail' => 'email',  
    'givenName' => 'givenname',    
    'familyName' => 'sn',
    'fullName' => 'adi_displayname',
    'primaryEmail' => 'mail',
  );

  $google_data = gadentGoogleAppsDirectory()->getGoogleAdminData("", "", "", ""); 

  foreach($google_data as $google_user):
    // var_dump($google_user);
    $status = coa_gs_sync_google_data_for_email($google_user['primaryEmail'], $google_user);

    if($status):
      $success_count++;
    else:
      $fail_count++;
    endif;    
  endforeach;

  coa_gs_clear_cache();

  $message = "Updated: {$success_count} accounts, failed for {$fail_count} accounts";
  if(function_exists('add_settings_error')):
    add_settings_error('city_of_asheville_google_sync', 'testcode', $message, 'updated');
  endif;
  return $message;
}

function coa_gs_sync_user_email($user_email){
  if( coa_gs_sync_google_data_for_email($user_email) ):
    coa_gs_clear_cache();
    add_settings_error('city_of_asheville_google_sync', 'testcode', "Updated data from Google Directory for: ".$user_email, 'updated');
  else:
    add_settings_error('city_of_asheville_google_sync', 'testcode', "Error: No Google Data found for: ".$user_email);
  endif;
}

function coa_gs_clear_cache(){
  wp_cache_flush();
  delete_transient('coa_user_array');

  if(function_exists('add_settings_error')):
    add_settings_error('city_of_asheville_google_sync', 'testcode', "All caches cleared for Wordpress, Redis, and Employee Directory.", 'updated');
  endif;
}
// END ACTIONS 

function coa_gs_add_admin_menu(  ) { 
  add_menu_page( 'City of Asheville Google Sync', 'City of Asheville Google Sync', 'manage_options', 'city_of_asheville_google_sync', 'coa_gs_options_page' );
}

function coa_gs_handle_input($input){
  // OVERRIDE INPUT FOR NOW
  $input['coa_gs_text_field_0'] = 1;
  return $input;
}

function coa_gs_settings_init(  ) { 
  register_setting( 'pluginPage', 'coa_gs_settings', array('sanitize_callback' => 'coa_gs_handle_input') );

  add_settings_section(
    'coa_gs_pluginPage_section', 
    __( 'Google Sync: Scheduled Cron Task', 'wordpress' ), 
    'coa_gs_settings_section_callback', 
    'pluginPage'
  );

  // PRC 03.2019 - might want to disable this input as it's not modifyable right now.
  add_settings_field( 
    'coa_gs_text_field_0', 
    __( 'Sync frequency (hours):', 'wordpress' ), 
    'coa_gs_text_field_0_render', 
    'pluginPage', 
    'coa_gs_pluginPage_section' 
  );

  if(isset($_POST['coa_gs_actions'])):
    $action = $_POST['coa_gs_actions'];

    if(isset($action['do_full_sync']) ):
      coa_gs_do_full_sync();
    elseif(isset($action['check_for_deactivated_accounts'])):
      coa_check_for_deactivated_accounts();
    elseif(isset($action['sync_user_by_email'])):
      $user_email = trim($_POST['coa_gs_sync_user_email']);
      if(! $user_email):
        add_settings_error('city_of_asheville_google_sync', 'testcode', "No user email provided");
      else:
        coa_gs_sync_user_email($user_email);
      endif;
    elseif(isset($action['clear_cache'])):
      coa_gs_clear_cache();
    elseif(isset($action['coa_gs_change_user_name'])):
        $old_user_email = trim($_POST['coa_gs_change_user_name_old_email']);
        $new_user_email = trim($_POST['coa_gs_change_user_name_new_email']);
        coa_gs_do_name_change($old_user_email, $new_user_email, true);
    elseif(isset($action['coa_gs_change_user_name_test_mode'])):
        $old_user_email = trim($_POST['coa_gs_change_user_name_old_email']);
        $new_user_email = trim($_POST['coa_gs_change_user_name_new_email']);
        coa_gs_do_name_change($old_user_email, $new_user_email, false);
    endif;
  endif;
}

function coa_gs_text_field_0_render(  ) { 
  $options = get_option( 'coa_gs_settings' );
  ?>
  <input readonly type='text' name='coa_gs_settings[coa_gs_text_field_0]' value='<?php echo $options['coa_gs_text_field_0']; ?>'>
  <?php
}

function coa_gs_settings_section_callback(  ) { 
  echo __( 'Settings related to the custom Google Sync integration. The scheduled task processes 100 users per hour.<br /><i>Note: This is fixed at 1 hour to ensure all users are processed.</i>', 'wordpress' );
}


function coa_gs_options_page(  ) { 
  ?>
  <form action='options.php' method='post'>

    <h2>City of Asheville Google Sync</h2>
    <div>
      <?php if(isset($_GET['settings-updated']) ): ?>
        <div id="setting-updated-testcode" class="updated notice is-dismissible"> 
          <p>
              <strong>Settings updated!</strong>
          </p>
          <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
        </div>
      <?php endif; ?>
      <?php settings_errors(); 
      ?>
    </div>
    <?php
    settings_fields( 'pluginPage' );
    do_settings_sections( 'pluginPage' );
    submit_button();
    ?>

  </form>
  <hr>
  <form action='admin.php?page=city_of_asheville_google_sync' method='post'>
    <h2>Google Sync: User By Email</h2>
    <p>
      Update a user's account with data from Google.
    </p>
    <div>
      <input name='coa_gs_sync_user_email' value='' />
      <?php
        submit_button('Sync user by email', 'secondary', 'coa_gs_actions[sync_user_by_email]', false);
      ?>
      <br /><br />
    </div>
    <hr>
    <h2>User Name Change</h2>
    <div>
      <p>
        Migrate content from one user to another, for example when their name (and Google account) changes.
      </p>
      <div>
        <label style='display: inline-block; width: 75px;'>
          Old Email:
        </label>
        <input name='coa_gs_change_user_name_old_email' value='' />
      </div>
      <br />
      <div>
        <label style='display: inline-block; width: 75px;'>
          New Email:
        </label>
        <input name='coa_gs_change_user_name_new_email' value='' />
      </div>
      <br />
      <div>
      <?php
        submit_button('Test Mode', 'secondary', 'coa_gs_actions[coa_gs_change_user_name_test_mode]', false);
        echo "<span style='display: inline-block; width: 5px;'></span>";
        submit_button('Change User Name', 'primary', 'coa_gs_actions[coa_gs_change_user_name]', false);
      ?>
      </div>
      <br />
    </div>
    <hr>
    <h2>Google Sync: Other Actions</h2>
    <div>
      <?php
        submit_button('Do Full Google Sync', 'secondary', 'coa_gs_actions[do_full_sync]', false);
      ?>
      <?php
        submit_button('Check for Deactivated Accounts', 'secondary', 'coa_gs_actions[check_for_deactivated_accounts]', false);
      ?>
      <?php
        submit_button('Clear Cache', 'secondary', 'coa_gs_actions[clear_cache]', false);
      ?>
    </div>
  </form>
<?php

}

// PRC - Cron for sync
function coa_gs_cron(){
  if($message = coa_gs_do_full_sync() ):
    // wp_mail('patrick@prcapps.com', 'AVLBeta Google Sync Cron Ran', 'AVLBeta Google Sync Cron Ran\n'.$message);
  else:
    wp_mail('patrick@prcapps.com', 'ERROR: AVLBeta Google Sync Cron Ran', 'ERROR: AVLBeta Google Sync Cron Ran');
  endif;
}

function coa_gs_disabled_user_cron(){
  if($message = coa_check_for_deactivated_accounts() ):
    // wp_mail('patrick@prcapps.com', 'AVLBeta Google Sync Cron Ran', 'AVLBeta Google Sync Cron Ran\n'.$message);
  else:
    wp_mail('patrick@prcapps.com', 'ERROR: AVLBeta Disabled User Cron', 'ERROR: AVLBeta Disabled User Cron');
  endif;
}

add_action( 'coa_gs_disabled_user_cron_hook', 'coa_gs_disabled_user_cron' );

add_action( 'coa_gs_cron_hook', 'coa_gs_cron' );

if ( ! wp_next_scheduled( 'coa_gs_cron_hook' ) ) :
    wp_schedule_event( time(), 'hourly', 'coa_gs_cron_hook');
endif;

// PRC - Disabled user cron ENABLED
if ( ! wp_next_scheduled( 'coa_gs_disabled_user_cron_hook' ) ) :
    wp_schedule_event( time(), 'daily', 'coa_gs_disabled_user_cron_hook');
endif;
