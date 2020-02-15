//var url = "js/bikerentals.json";
var url = "js/shopping-cart.json?1";

/* this tells the page to wait until jQuery has loaded, so you can use the Ajax call */

$(document).ready(function(){

  $.ajax({
    url: url,
	method: "GET",
      error: function(){
        console.log('JSON FAILED for data');
      },
    success:function(results){

  /* the results is your json, you can reference the elements directly by using it here, without creating any additional variables */

      var cartItemsList = document.getElementById("cartItemsList");

      results.products.forEach(function(element) {
      cartItemsList.insertAdjacentHTML( 'beforeend',
"<form method='POST' action='cart.php' class='cartForm'><li>" +
	"<div class='quantity'>" +
		"<button class='plus-btn' type='button' name='button'>" +
			"<img src='images/plus.svg' alt='plus' />" +
		"</button>" +
	"<input class='num' type='number' name='quantity' id='numb_" + element.id + "' value='0' min='0' max='100'>" +
		"<button class='minus-btn' type='button' name='button'>"+
		"<img src='images/minus.svg' alt='minus'/>" + "</button></div>" +
	"<input type='hidden' name='element_id' value=" + element.id + ">" + element.name + "<br />" +
	"<input type='submit' value='Add to Cart' class='btnAddAction' />"  + "$" + element.price.toFixed(2) + "<br />" + "<img src=" +  element.image + " alt="  + element.name + " height='250' width='250'>" + "</li></form>");
 }); // end of forEach



   $('.minus-btn').on('click', function(e) {
    		e.preventDefault();
    		var $this = $(this);
    		var $input = $this.closest('div').find('input');
    		var value = parseInt($input.val());

    		if (value > 1) {
    			value = value - 1;
    		} else {
    			value = 0;
    		}

        $input.val(value);

    	});

    	$('.plus-btn').on('click', function(e) {
			// alert("test 1");
    		e.preventDefault();
    		var $this = $(this);
    		var $input = $this.closest('div').find('input');
    		var value = parseInt($input.val());

    		if (value < 100) {
      		value = value + 1;
    		} else {
    			value =100;
    		}

    		$input.val(value);
    	});



	}  // end of success fn
	}) // end of Ajax call
	}) // end of $(document).ready() function

