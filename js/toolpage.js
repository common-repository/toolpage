jQuery(function() {
	
	jQuery('#myTab a').click(function (e) {
	  e.preventDefault();
	  jQuery(this).tab('show');
	})	
});


jQuery("#titolo").focus(function() {
    //console.log('in');
}).blur(function() {
    //console.log('out');
	
	var t=document.getElementById("url");
	t.value = this.value;
});

jQuery(function(){
  // bind change event to select
  jQuery('#tipoSel').bind('change', function () {
	  var url = jQuery(this).val(); // get selected value
	  if (url) { // require a URL
		  window.location = url; // redirect
	  }
	  return false;
  });
});

jQuery(document).ready(function($){
	var myOptions = {
	// you can declare a default color here,
	// or in the data-default-color attribute on the input
	//defaultColor: false,
	// a callback to fire whenever the color changes to a valid color
	change: function(event, ui){},
	// a callback to fire when the input is emptied or an invalid color
	clear: function() {},
	// hide the color picker controls on load
	hide: true,
	// show a group of common colors beneath the square
	// or, supply an array of colors to customize further
	palettes: true
	};

	jQuery('.my-color-field1').wpColorPicker(myOptions);
	jQuery('.my-color-field2').wpColorPicker(myOptions);
	jQuery('.my-color-field3').wpColorPicker(myOptions);
	jQuery('.my-color-field4').wpColorPicker(myOptions);
	jQuery('.my-color-field5').wpColorPicker(myOptions);
	jQuery('.my-color-field6').wpColorPicker(myOptions);
	jQuery('.my-color-field7').wpColorPicker(myOptions);
	jQuery('.my-color-field8').wpColorPicker(myOptions);
	jQuery('.my-color-field9').wpColorPicker(myOptions);
	jQuery('.my-color-field10').wpColorPicker(myOptions);
	//jQuery('.my-color-field').wpColorPicker();
	
	jQuery(function () {
        jQuery('#js-news').ticker({
			controls: false,
			speed: 0.10,
			fadeInSpeed: 600,
			titleText: 'Latest News' // Latest News		
		});
    });
});