<?php
/**
 * OB DB Excel Converter run custom sql page
 *
 * @since 2.0
 * @modified 2.1
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
function SQL_DbToExcel_ob() {
if(is_admin() && current_user_can('administrator')){
global $wpdb;
$msg=null;
$query=null;
$con = mysqli_connect($wpdb->dbhost,$wpdb->dbuser,$wpdb->dbpassword,$wpdb->dbname);
			if(isset($_POST["runSQL"]) && isset( $_POST['post_nonce_field'] ) && wp_verify_nonce( $_POST['post_nonce_field'], 'post_nonce' )){
                $query=esc_html(sanitize_textarea_field(strip_tags($_POST["sql_syntax"])));
               	$result = mysqli_query($con , $query);
				if($result != null){
				$msg='You query has been successfully executed.';
				$color='#000';
				//echo $query;
                $i=1;	
                ?>
                 <?php
				} else {
				$msg='Could not execute query.<br>'. mysqli_error($con);
				$color='red';
				//echo $query;	
				}
				}

			echo '<div class="ob_container custom-sql">
           	<h1 class="ob-main-csql-title"><span style="color:red">OB</span> DB Excel Converter</h1>
            <div class="home-img_icon">
            <a href="'.admin_url('admin.php?page=DbExcelConverter').'"><img height="24" width="24" src="'.plugins_url('../assets/image/ob-home-icon.png', __FILE__).'"></a>
            </div>
            <hr>
            <h4 style="color:#000;"><u>Run SQL query/queries on server.</u></h4>';
            if ($msg != null) {
            echo '<h5 style="color:'.$color.';">'.$msg.'</h5>';
        	} else {}
		   	echo '<form class="ob-custom-sql-run" action="" method="POST">
			<label class="button clear_btn" onClick="yourFunction();">Clear</label>
			<textarea name="sql_syntax" id="clear_txtArea" cols="109" rows="5" class="sqlRun" required>';if ($query) {echo $query;} echo '</textarea>';
            wp_nonce_field( 'post_nonce', 'post_nonce_field' );
            echo '<input class="button button-primary runsql" name="runSQL" type="submit" value="Run My SQL Query"/>
            </form>';
            ?>
            <script>
            jQuery('.sqlRun').numberedtextarea();
            </script> 
            <?php if(isset($_POST["runSQL"]) && isset( $_POST['post_nonce_field'] ) && wp_verify_nonce( $_POST['post_nonce_field'], 'post_nonce' )){ 
                $query=esc_html(sanitize_textarea_field(strip_tags($_POST["sql_syntax"])));
                $result = mysqli_query($con , $query);
                if($result != null){
                ?>
                <div class="wrapper1">
                    <div class="div1"></div>
                </div>
                <div class="obtable wrapper2">
                <div class="div2">
                <table id="customSQLrun" class="display nowrap dataTable cell-border hover order-column row-border stripe">
                <?php
                $i = 0;
                $result = mysqli_query($con , $query);
                echo "<thead><tr>";
                while ($i < mysqli_num_fields($result))
                {
                $meta = mysqli_fetch_field($result);   
                echo "<th>".$meta->name."</th>";
                $i++;
                }
                echo "</tr></thead>";

                $j = 0;
                $resultt = mysqli_query($con , $query);
                echo "<tfoot><tr>";
                while ($j < mysqli_num_fields($resultt))
                {
                $meta = mysqli_fetch_field($resultt);   
                echo "<th>".$meta->name."</th>";
                $j++;
                }
                echo "</tr></tfoot>";

                echo "<tbody>";
                while ($row = mysqli_fetch_row($result))
                {
                echo '<tr>';

                foreach($row as $item)
                {
                echo "<td>".$item."</td>";
                }

                echo '</tr>';
                }
                echo "</tbody>";
                ?>
                </table>
                </div>
                </div>
                <?php } } ?>
                
            <?php
            echo '<h2 class="ob-table-name" style="color:#000;">Table List</h2>
            <hr>';
            $sql = "SHOW TABLES";
			$table_list  = $wpdb->get_results($sql,ARRAY_N);
			foreach($table_list as $table_name){
				foreach ($table_name as $singlevalue){
					echo '<button class="button button-primary tag_table" id="tagTable">'.$singlevalue.'</button>';	
				}
			}
    		echo'</div>';
    }
}

?>
