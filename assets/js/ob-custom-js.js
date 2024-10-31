 /**
 * OB DB Excel Converter custom js
 *
 * @since 1.0
 * @modified 2.1
 */

function yourFunction(){
     document.getElementById('clear_txtArea').value = "";
};

//forbidden words in run mysql textarea
var forbiddenWords = ['Delete', 'Drop'];
jQuery(function () {
  jQuery('#clear_txtArea').on('keyup', function(e) {
    forbiddenWords.forEach(function(val, index) {
      if (e.target.value.toUpperCase().indexOf(val.toUpperCase()) >= 0) {
        e.target.value = e.target.value.replace(new RegExp( "(" + val + ")" , 'gi' ), '');
		alert('You can not use this word.');
      }
    });
  });
});

//bind table name in textbox
jQuery(document).ready(function() {
    jQuery(".tag_table").click(function(){
		var ButtonText = jQuery(this).text();
		var TextboxText = jQuery('#clear_txtArea').val();
		var finalSql = TextboxText +ButtonText;
		jQuery('#clear_txtArea').val(finalSql);
        //alert(TextboxText);
    }); 
});

jQuery(document).ready(function() {
    jQuery('#customSQLrun').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );

jQuery(function () {
    jQuery('.wrapper1').on('scroll', function (e) {
        jQuery('.wrapper2').scrollLeft(jQuery('.wrapper1').scrollLeft());
    }); 
    jQuery('.wrapper2').on('scroll', function (e) {
        jQuery('.wrapper1').scrollLeft(jQuery('.wrapper2').scrollLeft());
    });
});
jQuery(window).on('load', function (e) {
    jQuery('.div1').width(jQuery('table').width());
    jQuery('.div2').width(jQuery('table').width());
});
