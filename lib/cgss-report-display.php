<div class="cgss-no-print">
<!--Top overview-->
<table>
 <tbody>
  <tr>
   <td><p>
    <div id="overall_chart" style="width:450px;height:250px;"></div>
   </p></td>
   <td><p>
    <table>
     <?php foreach ( $cgss_scaned_page_props as $cgss_scaned_page_prop ) : ?>
     <tr>
      <td><p><?php echo $cgss_scaned_page_prop[0]; ?></p></td>
      <td><p>&nbsp;&nbsp;&nbsp;<?php echo $cgss_scaned_page_prop[1]; ?></p></td>
     </tr>
     <?php endforeach; ?>
     <tr>
      <table>
       <tr>
        <td id="printHide"><p>
         <script>function cgssPRINTpage() { window.print(); }</script>
         <a class="button" onclick="cgssPRINTpage()"><?php echo __( 'Print Report', 'cgss' ); ?></a>&nbsp;&nbsp;&nbsp;
        </p></td>
        <td id="printHide"><p>
         <a class="button" href="<?php echo home_url(); ?>/wp-admin/tools.php?page=cgss-scan-page/" target="_blank"><?php echo __( 'New Scan', 'cgss' ); ?></a>&nbsp;&nbsp;&nbsp;
        </p></td>
        <td id="printHide"><p>
         <a class="button-primary" href="http://gogretel.com/" target="_blank"><?php echo __( 'SEO Tips &rarr;', 'cgss' ); ?></a>&nbsp;&nbsp;&nbsp;
        </p></td>
       </tr>
      </table>
     </tr>
    </table>
   </p></td>
  </tr>
 </tbody>
</table>

<!--Tab button group-->
<?php
 $cgss_gen_dis_list_items = array(
  array( 'tabsonelink', __( 'Data', 'cgss' ), '#6495ed' ),
  array( 'tabstwolink', __( 'Content', 'cgss' ), 'inherit' ),
  array( 'tabsthreelink', __( 'Design', 'cgss' ), 'inherit' ),
  array( 'tabsfourlink', __( 'Technical', 'cgss' ), 'inherit' ),
 );
?>
<h2 class="nav-tab-wrapper">
 <?php foreach ( $cgss_gen_dis_list_items as $cgss_gen_dis_list_item ) : ?>
 <a id="<?php echo $cgss_gen_dis_list_item[0]; ?>" class="nav-tab" style="color:<?php echo $cgss_gen_dis_list_item[2]; ?>;font-weight:normal;"><?php echo $cgss_gen_dis_list_item[1]; ?></a>
 <?php endforeach; ?>
</h2>

<div class="cgss-display-box">
 <!--First Tab (Data)-->
 <div id="tabsone">
  <table>
   <tr>
    <td>
     <table class="widefat">
      <?php
      $cgss_ogp_gen_def = __( 'Social Sharing Data (', 'cgss' ) . ' <abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="' . __( 'Open Graph Protocol by Facebook and accepted by almost all major social media including Google +', 'cgss' ) . '">' . __( 'OGP', 'cgss' ) . '</abbr>)';
      $cgss_gen_data_tab_points = array(
       array( __( 'Web Page Data', 'cgss' ), $cgss_page_data_results, 'Page Data' ),
       array( $cgss_ogp_gen_def, $cgss_social_data_results, 'OGP Data' ),
      );
      foreach ( $cgss_gen_data_tab_points as $cgss_gen_data_tab_point ) :
      ?>
      <!--<?php echo $cgss_gen_data_tab_point[2]; ?> Display-->
      <thead>
       <tr>
        <th>
         <strong><?php echo $cgss_gen_data_tab_point[0]; ?></strong>
        </th>
        <th>
         <strong><?php _e( 'Result', 'cgss' ); ?></strong>
        </th>
        <th>
         <strong><?php _e( 'Remarks', 'cgss' ); ?></strong>
        </th>
       </tr>
      </thead>
      <tbody>
       <?php foreach ( $cgss_gen_data_tab_point[1] as $cgss_result ) : ?>
       <tr>
        <td>
         <p class="inside-po"><abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="<?php echo $cgss_result[1]; ?>"><?php echo $cgss_result[0]; ?></abbr></p>
        </td>
        <td>
         <?php echo $cgss_result[2]; ?>
        </td>
        <td>
         <p class="inside-po"><?php echo $cgss_result[3]; ?></p>
        </td>
       </tr>
       <?php endforeach; ?>
      </tbody>
      <?php endforeach; ?>
     </table>
    </td>
    <td>
     <table>
     <?php
      $cgss_gen_top_plots = array( 'page_data_chart', 'ogp_data_chart' );
      foreach ( $cgss_gen_top_plots as $cgss_gen_top_plot ) :
     ?>
      <tr>
       <td>
        <br /><br />
        <!--Page Data Plot-->
        <div id="<?php echo $cgss_gen_top_plot; ?>" style="width:500px;height:300px;"></div>
       </td>
      </tr>
      <?php endforeach; ?>
     </table>
    </td>
   </tr>
  </table>
 </div>
 <!--Short php html generator for content, design and technical tabs-->
 <?php
 $cgss_html_gen_tabs = array(
  array( 'tabstwo', __( 'Content issues', 'cgss' ), $cgss_content_results, 'content_data_chart', 'Second Tab (Content)' ),
  array( 'tabsthree', __( 'Design points', 'cgss' ), $cgss_design_results, 'visual_comp_chart', 'Third Tab (Design)' ),
  array( 'tabsfour', __( 'Server points', 'cgss' ), $cgss_server_results, 'server_data_chart', 'Fourth Tab (Technical)' ),
 );
 foreach ( $cgss_html_gen_tabs as $cgss_html_gen_tab ) :
 ?>
 <!--<?php echo $cgss_html_gen_tabs[4]; ?>-->
 <div id="<?php echo $cgss_html_gen_tab[0]; ?>" class="cgss-none">
  <table>
   <tr>
    <td>
     <table class="widefat">
      <!--Page Data Display-->
      <thead>
       <tr>
        <th>
         <strong><?php echo $cgss_html_gen_tab[1]; ?></strong>
        </th>
        <th>
         <strong><?php _e( 'Result', 'cgss' ); ?></strong>
        </th>
        <th>
         <strong><?php _e( 'Remarks', 'cgss' ); ?></strong>
        </th>
       </tr>
      </thead>
      <tbody>
       <?php foreach ( $cgss_html_gen_tab[2] as $cgss_result ) : ?>
       <tr>
        <td>
         <p class="inside-po"><abbr class="cgss-tip" data-toggle="tooltip" data-placement="top" data-delay="20" data-trigger="hover focus" title="<?php echo $cgss_result[1]; ?>"><?php echo $cgss_result[0]; ?></abbr></p>
        </td>
        <td>
         <?php echo $cgss_result[2]; ?>
        </td>
        <td>
         <p class="inside-po"><?php echo $cgss_result[3]; ?></p>
        </td>
       </tr>
       <?php endforeach; ?>
      </tbody>
     </table>
    </td>
    <td>
     <table>
      <tr>
       <td>
        <!--Content overview Data Plot-->
        <div id="<?php echo $cgss_html_gen_tab[3]; ?>" style="width:500px;height:300px;"></div>
       </td>
      </tr>
     </table>
    </td>
   </tr>
  </table>
  <?php if ( $cgss_html_gen_tab[0] == 'tabstwo' ) : ?>
  <br />
  <div class="control-section accordion-section">
   <h3 class="accordion-section-title hndle-one"><?php _e( '&rarr;&nbsp;Crawled Text Content', 'cgss' ); ?></h3>
   <div class="accordion-section-content body-one">
    <?php
     $cgss_content_printers = array(
      array( __( 'Total Text', 'cgss' ), trim( $cgss_only_text ) ),
      array( __( 'Anchor Text', 'cgss' ), trim( $cgss_link_text_value ) ),
      array( __( 'Alt Text', 'cgss' ), trim( $cgss_alt_text_value ) ),
      array( __( 'In page Style', 'cgss' ), trim( $cgss_style_text_value ) ),
      array( __( 'In page Script', 'cgss' ), trim( $cgss_js_text_value ) ),
     );
     ?>
    <div class="con-box">
     <?php
      foreach ( $cgss_content_printers as $cgss_content_printer ) : 
       if ( $cgss_html_gen_tab[1] != null ) :
     ?>
       <h3><?php echo $cgss_content_printer[0]; ?> :</h3>
       <small><?php echo $cgss_content_printer[1]; ?></small>
     <?php
       endif;
      endforeach;
     ?>
    </div>
   </div>
  </div>
  <?php endif; ?>
 </div>
 <?php endforeach; ?>
</div>
<br />
</div>
<div class="printCGSS widefat">
<!--Printing Data-->
<?php
 $cgss_print_vars = array( $cgss_page_data_results, $cgss_social_data_results, $cgss_content_results, $cgss_design_results, $cgss_server_results );
?>
  <table>
   <?php foreach ( $cgss_scaned_page_props as $cgss_scaned_page_prop ) : ?>
    <tr>
     <td><p><?php echo $cgss_scaned_page_prop[0]; ?></p></td>
     <td><p>&nbsp;&nbsp;&nbsp;<?php echo $cgss_scaned_page_prop[1]; ?></p></td>
    </tr>
   <?php endforeach; ?>
    <tr>
     <td><p><?php _e( 'Scan by', 'cgss' ); ?></p></td>
     <td><p>&nbsp;&nbsp;&nbsp;<?php _e( 'gogretel.com', 'cgss' ); ?></p></td>
    </tr>
  </table>
  <div class="cgss-print-break"></div>
  <?php foreach ( $cgss_print_vars as $cgss_print_var ) : ?>
  <table>
   <thead>
    <tr>
     <th>
      <strong><?php _e( 'Name', 'cgss' ); ?></strong>
     </th>
     <th>
      <strong><?php _e( 'Description', 'cgss' ); ?></strong>
     </th>
     <th>
      <strong><?php _e( 'Result', 'cgss' ); ?></strong>
     </th>
     <th>
      <strong><?php _e( 'Action', 'cgss' ); ?></strong>
     </th>
    </tr>
   </thead>
   <tbody>
    <?php foreach ( $cgss_print_var as $cgss_print_var_data ) : ?>
    <tr>
     <td>
      <p><?php echo $cgss_print_var_data[0]; ?></p>
     </td>
     <td>
      <p><?php echo $cgss_print_var_data[1]; ?></p>
     </td>
     <td>
      <p><?php echo $cgss_print_var_data[2]; ?></p>
     </td>
     <td>
      <p><?php echo $cgss_print_var_data[3]; ?></p>
     </td>
    </tr>
    <?php endforeach; ?>
   </tbody>
  </table>
  <div class="cgss-print-break"></div>
  <?php endforeach; ?>
</div>
