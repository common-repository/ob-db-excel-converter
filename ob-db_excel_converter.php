<?php
/**
 * Plugin Name: OB DB Excel Converter
 * Description: This plugin provide you the functionality to export MySqli database table to excel file. This plugin is very easy to use. It also allow you to show all database table's value with "export to excel" option in admin panel.
 * Version:  2.1
 * Author: Oudaryamay Burai
 * Author URI: https://oudarya.wordpress.com/
 * License: GPLv2 or later
 */
 
 /**
 * OB DB Excel Converter
 *
 * @since 1.0
 * @modified 2.0
 * @modified 2.1
 */
include_once( plugin_dir_path( __FILE__ ) .'includes/SQL_DbToExcel_ob.php');
include_once( plugin_dir_path( __FILE__ ) .'includes/promote/promote.php');

add_action('admin_menu', 'DbExcelConverter_admin_menu');
function DbExcelConverter_admin_menu() {
	add_menu_page('DbExcelConverter', 'OB DB Excel Converter', 'administrator',
		'DbExcelConverter', 'DbToExcel_ob',plugins_url( 'assets/image/ob-db_excel_converter_logo.png', __FILE__ ));
    add_submenu_page(
        'DbExcelConverter',       // parent slug
        'Run SQL',               // page title
        'Run SQL',              // menu title
        'administrator',       // capability
        'SQLDbExcelConverter',// slug
        'SQL_DbToExcel_ob'   // callback
    ); 
	add_submenu_page(
        'DbExcelConverter',       // parent slug
        'Promotion',               // page title
        'Promotion',              // menu title
        'administrator',       // capability
        'odec-promotion',// slug
        'odec_promote_callback'   // callback
    ); 

    if (isset($_GET['page'])) {
    $ob_spl_condn=esc_html(sanitize_text_field(trim($_GET['page'])));
        if($ob_spl_condn == 'DbExcelConverter' || $ob_spl_condn == 'SQLDbExcelConverter') {
    /*Datable CSS*/
    wp_enqueue_style('ob-datatable-css', plugins_url('assets/datatable/css/ob-datatable.css',__FILE__));
    wp_enqueue_style('ob-datatable-button-css', plugins_url('assets/datatable/css/ob-datatable-button.css',__FILE__));
    wp_enqueue_style('ob-datatable-theme-css', plugins_url('assets/datatable/css/ob-datatable-theme.css',__FILE__));
    /*Numbered textarea css*/
    wp_enqueue_style('ob-numberedtextarea-css', plugins_url('assets/css/ob-jquery.numberedtextarea.css',__FILE__));
    
    wp_enqueue_style('ob-css', plugins_url('assets/css/ob-style.css',__FILE__));
    wp_enqueue_style('ob-responsive-css', plugins_url('assets/css/ob-responsive.css',__FILE__));
    /*Datable JS*/
    wp_enqueue_script('ob-js-lib', plugins_url('assets/datatable/js/ob-jquery-v1.12.4.js',__FILE__));
    wp_enqueue_script('ob-datatable', plugins_url('assets/datatable/js/ob-datatable.js',__FILE__));
    wp_enqueue_script('ob-datatable-button', plugins_url('assets/datatable/js/ob-datatable-button.js',__FILE__));
    wp_enqueue_script('ob-datatable-flash', plugins_url('assets/datatable/js/ob-datatable-flash.js',__FILE__));
    wp_enqueue_script('ob-datatable-zip', plugins_url('assets/datatable/js/ob-datatable-zip.js',__FILE__));
    wp_enqueue_script('ob-datatable-pdf', plugins_url('assets/datatable/js/ob-datatable-pdf.js',__FILE__));
    wp_enqueue_script('ob-datatable-pdf-fonts', plugins_url('assets/datatable/js/ob-datatable-pdf-fonts.js',__FILE__));
    wp_enqueue_script('ob-datatable-button-html5', plugins_url('assets/datatable/js/ob-datatable-button-html5.js',__FILE__));
    wp_enqueue_script('ob-datatable-print-button', plugins_url('assets/datatable/js/ob-datatable-print-button.js',__FILE__));
    /*Numbered textarea js*/
    wp_enqueue_script('ob-numberedtextarea-js', plugins_url('assets/js/ob-jquery.numberedtextarea.js',__FILE__));
    /*Global custom script*/
    wp_enqueue_script('ob-js', plugins_url('assets/js/ob-custom-js.js',__FILE__));
    ob_start();    
     }
    }
}

function DbToExcel_ob(){
       if(is_admin() && current_user_can('administrator')){
        global $wpdb;
		$table_name = '';
            if(isset($_POST["ob_tbl_name"]) && isset( $_POST['post_nonce_field'] ) && wp_verify_nonce( $_POST['post_nonce_field'], 'post_nonce' )){
                $tablename = esc_html(sanitize_text_field(trim($_POST["ob_tbl_name"])));
                $sql = "SHOW TABLES";
                $table_list  = $wpdb->get_results($sql,ARRAY_N);
                $IsValidTableName = 0;
                foreach($table_list as $table_name){
                    foreach ($table_name as $singlevalue){
                        if($singlevalue == $tablename){
                            $IsValidTableName = 1;
                        }
                    }
                }
                if($IsValidTableName==1){                                   
                    $con = mysqli_connect($wpdb->dbhost,$wpdb->dbuser,$wpdb->dbpassword,$wpdb->dbname);    
                    $sql = "SELECT * FROM $tablename";
                    $result = @mysqli_query($con, $sql) or die("Couldn't execute query:<br>".mysqli_error().'<br>'.mysqli_errno());
                    header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
                    header("Content-Disposition: attachment; filename=".$tablename."-ob-".uniqid().".xls");  //File name extension was wrong
                    header("Expires: 0");
                    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                    header("Cache-Control: private",false);
                    ob_clean();
                    echo "<html>";
                    echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
                    echo "<body>";
                    echo "<table>";
                    print("<tr>");
                    for ($i = 0; $i < mysqli_num_fields($result); $i++) {  // display name of the column as names of the database fields
                        echo "<th  style='border: thin solid; background-color: #83b4d8;'>" .mysqli_fetch_field_direct($result,$i)->name . "</th>";
                    }
                    print("</tr>");
                    while($row = mysqli_fetch_row($result)){
                        $output = '';
                        $output = "<tr>";
                        for($j=0; $j<mysqli_num_fields($result); $j++){
                            if(!isset($row[$j]))
                                $output .= "<td>NULL\t</td>";
                            else
                                $output .= "<td style='border: thin solid;'>$row[$j]\t</td>";
                        }
                        $output .= "</tr>";
                        $output = preg_replace("/\r\n|\n\r|\n|\r/", ' ', $output);
                        print(trim($output));
                    }
                    echo "</table>";
                    echo "</body>";
                    echo "</html>";
                    }
                else{
                    echo '<h3><span style="color:red;">Invalid Request...</span></h3>';
                }
            }
    ?>
    <div class="ob_container">
            <div class="">
                <h1><span style="color:red">OB</span> DB Excel Converter</h1>
                <hr>
                    <div>
                    <form action="" method="POST">
                    <h4 style="color:green;"><u>Select your table name from drop-down list</u></h4>
                    <select name="table_name" class="blue semi-square styled-select">
                        <option style="color:green;" value=0>Select your table name</option>
                            <?php
                            $sql = "SHOW TABLES";
                            $table_list  = $wpdb->get_results($sql,ARRAY_N);

                            foreach($table_list as $table_name){
                                foreach ($table_name as $singlevalue){
                                    if ($_POST['table_name'] == $singlevalue)
                                      {
                                       $selected = 'selected="selected"';
                                        }
                                        else
                                       {
                                        $selected = '';
                                        }
                                    ?>
                                    <option value="<?php echo $singlevalue; ?>" <?php echo $selected; ?>><?php echo $singlevalue; ?></option>   
                                    <?php   
                                }
                            }
                            ?>
                        </select>
                        <?php wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>
                        <input type="submit" class="button button-primary"  value="Show Table Value"/>
                    </form>
                </div>
            </div>
            
            <?php
			$tablename = '';
            if(isset($_POST["table_name"]) && isset( $_POST['post_nonce_field'] ) && wp_verify_nonce( $_POST['post_nonce_field'], 'post_nonce' )){
            ?>
            <form action="" method="POST">
            <?php wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>
            <input class="button button-primary exportbtn" name="exportbtn" type="submit" name="table_display" value="Convert To Excel"/>
            <div class="obtable">
              <div id="doublescroll" style="overflow-x:scroll;">
                <table id="table">
                    <?php
                        $tablename = esc_html(sanitize_text_field(trim($_POST["table_name"])));
                        $i=1;
                        echo "<tr>";
                        $t = mysqli_connect($wpdb->dbhost,$wpdb->dbuser,$wpdb->dbpassword,$wpdb->dbname);
                        $result = mysqli_query($t ,"SHOW COLUMNS FROM $tablename");
                        if (!$result) {
                            echo 'Could not run query: ' . mysqli_error();
                            exit;
                        }
                        if (mysqli_num_rows($result) > 0){
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<th style=''>".$row["Field"]."</th>";
                                $i++;
                            }
                        }
                        echo "</tr>";
                        $query = mysqli_query($t,"SELECT * FROM $tablename");
        
                        while($row = mysqli_fetch_array($query)){
                            echo "<tr>";
                            for($d = 0;$d<$i-1; $d++)
                                echo "<td>".$row[$d]."</td>";
                            echo "</tr>";
                        } ?>
                        <?php } ?>
                        </table>
                        </div>
                        </div>
                        <input type="hidden" name="ob_tbl_name" value="<?php echo $tablename; ?>"/> 
                        </form>
                    </div>
<?php }
 }
