<?php
 $cgss_page_list_ids = get_all_page_ids();
 global $post;
 $cgss_call_posts = get_posts();
 $cgss_post_list_ids = array();
 foreach( $cgss_call_posts as $cgss_call_post ) {
  $cgss_post_list_ids[] = $cgss_call_post->ID;
 }
?>
<br />
<h2 class="nav-tab-wrapper">
 <a id="tabsonelink" class="nav-tab" style="color:#6495ed;font-weight:normal;"><?php _e( 'New Scan', 'cgss' ); ?></a>
 <a id="tabstwolink" class="nav-tab" style="color:inherit;font-weight:normal;"><?php _e( 'Notes', 'cgss' ); ?></a>
</h2>
<div id="tabsone" class="tabs-panel">
 <h4><?php _e( 'Chose any page or post or enter custom url to Scan', 'cgss' ); ?></h4>
 <br />
 <table>
  <tbody>
  <tr>
   <form action="<?php echo $cgss_scan_admin; ?>" method="post" style="padding-top:10px;padding-bottom:10px;">
   <td>
    <label for="cgss-page"><?php _e( 'Select a Page to Scan', 'cgss' ); ?></label>
    <select type="dropdown" name="cgss-page" id="page_on_front" />
     <?php foreach ( $cgss_page_list_ids as $cgss_page_list_id ) : ?>
      <?php if ( get_post_status ( $cgss_page_list_id ) == 'publish' ) : ?>
       <option value="<?php echo get_permalink( $cgss_page_list_id ); ?>"><?php echo get_the_title( $cgss_page_list_id ); ?></option>
      <?php endif; ?>
     <?php endforeach; ?>
    </select>
   </td>
   <td>
    &nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="<?php _e( 'Scan Page', 'cgss' ); ?>" name="submit-cgss-page" class="button button-primary" /><span class="spinner"></span>
   </td>
   </form>
  </tr>
  <tr><td><br /><?php _e( 'OR', 'cgss' ); ?><br /><br /></td><td><br /></td></tr>
  <tr>
   <form action="<?php echo $cgss_scan_admin; ?>" method="post" style="padding-top:10px;padding-bottom:10px;">
   <td>
    <label for="cgss-post"><?php _e( 'Select a Post to Scan', 'cgss' ); ?></label>
    <select type="dropdown" name="cgss-post" id="page_on_front" />
    <?php foreach ( $cgss_post_list_ids as $cgss_post_list_id ) : ?>
     <?php if ( get_post_status ( $cgss_page_list_id ) == 'publish' ) : ?>
      <option value="<?php echo get_permalink( $cgss_post_list_id ); ?>"><?php echo get_the_title( $cgss_post_list_id ); ?></option>
     <?php endif; ?>
    <?php endforeach; ?>
    </select>
   </td>
   <td>
    &nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="<?php _e( 'Scan Post', 'cgss' ); ?>" name="submit-cgss-post" class="button button-primary" /><span class="spinner"></span>
   </td>
   </form>
  </tr>
  <tr><td><br /><?php _e( 'OR', 'cgss' ); ?><br /><br /></td><td><br /></td></tr>
  <tr>
   <form action="<?php echo $cgss_scan_admin; ?>" method="post" style="padding-top:10px;padding-bottom:10px;">
   <td>
    <label for="cgss-url"><?php _e( 'Enter a custom url', 'cgss' ); ?></label>
    <input type="text" name="cgss-url" class="regular-text code" />
   </td>
   <td>
    &nbsp;&nbsp;&nbsp;&nbsp;<input id="submitUrl" type="submit" value="<?php _e( 'Scan URL', 'cgss' ); ?>" name="submit-cgss-url" class="button button-primary" /><span class="spinner"></span>
   </td>
   </form>
  </tr>
  </tbody>
 </table>
</div>
<div id="tabstwo" class="tabs-panel cgss-none">
 <h4><?php _e( 'Things to know before scanning', 'cgss' ); ?></h4>
 <br />
 <ul>
  <li>
   <p><strong>&rarr; </strong> <?php _e( 'Scanning time depends on your server and your website quality. Actual process takes less than 0.01 seconds to complete.', 'cgss' ); ?></p>
  </li>
  <li>
   <p><strong>&rarr; </strong> <?php _e( 'The overview chart data is approximate calculation and does not represent calculations by any search engine algorithm.', 'cgss' ); ?></p>
  </li>
  <li>
   <p><strong>&rarr; </strong> <?php _e( 'Some parameters displayed in results are not included directly in google guidelines. But they affect indirectly.', 'cgss' ); ?></p>
  </li>
  <li>
   <p><strong>&rarr; </strong> <?php _e( 'Hover over underlined elements to see the explanations in result page.', 'cgss' ); ?></p>
  </li>
  <li>
   <p><strong>&rarr; </strong> <?php _e( 'No data from your website, server or anything is captured by any server. Scanning is done entirely on browser.', 'cgss' ); ?></p>
  </li>
 </ul>
</div>
