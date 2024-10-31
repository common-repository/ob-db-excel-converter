<?php
/**
 * OB DB Excel Converter promote page
 *
 * @since 2.1
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access denied.' );
}
	function odec_promote_callback() { ?>
	
	<style>
	.chip {
	  display: inline-block;
	  padding: 0 25px;
	  height: 50px;
	  font-size: 16px;
	  line-height: 50px;
	  border-radius: 25px;
	  background-color: #000000;
	  float: right;
	}

	.chip img {
	  float: left;
	  margin: 0 10px 0 -25px;
	  height: 50px;
	  width: 50px;
	  border-radius: 50%;
	}
	.chip span {
	color: #ffffff;
	}
	
	.card {
	  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
	  max-width: 300px;
	  margin: auto;
	  text-align: center;
	  font-family: arial;
	  display: inline-block;
	}
	.card button {
	  border: none;
	  outline: 0;
	  padding: 12px;
	  color: white;
	  background-color: #000;
	  text-align: center;
	  cursor: pointer;
	  width: 100%;
	  font-size: 18px;
	}

	.card button:hover {
	  opacity: 0.7;
	}
	</style>

<div class="wrap">
	
	<a href="<?php echo admin_url('admin.php?page=DbExcelConverter'); ?>">
		<div class="chip">
		  <img src="https://ps.w.org/ob-db-excel-converter/assets/icon-256x256.png" alt="bc-advance-search" width="96" height="96">
		  <span>Go to Home</span>
		</div>
	</a>	
	
	<div class="card">
		<img src="https://ps.w.org/bc-advance-search/assets/icon-256x256.png" alt="OB DB Excel Converter" style="width:100%">
		  <h1>BC Advance Search</h1><hr>
		  <p>BigCommerce Advance Search is Most powerful, professional and advance search engine for ::: BigCommerce For WordPress ::: store. The search is presented as
		   live search and auto-complete search suggestion.</p>
		  <p><button onclick="window.open('https://wordpress.org/plugins/bc-advance-search/')">Go to Plugin</button></p>
	</div>
		
	<div class="card">
		  <img src="https://ps.w.org/ob-event-manger/assets/icon-256x256.png" alt="OB Event Manger" style="width:100%">
		  <h1>OB Event Manger</h1><hr>
		  <p>OB Event Manger is a lightweight and full-featured event management plugin for adding event listing functionality to your WordPress site. The shortcode lists all the events with date and time with search funcility, it can work with any theme.</p>
		  <p><button onclick="window.open('https://wordpress.org/plugins/ob-event-manger/')">Go to Plugin</button></p>
	</div>
</div>
	
	<?php
		}