// JavaScript Document
$(document).ready(function () {
	"use strict";
	$("#prio").hide();
	
	$(".radiobtn").click(function(e){
		e.preventDefault();
		
		$(".radiobtn").removeClass("border");
		$(this).addClass("border");
		//alert($(this).attr('href'));
		$(".output").html($(this).attr('href'));
		$(".hidden_risico_gebied").val($(this).attr('href'));
		$("#prio").show(500);
		$("#prio").val($(this).attr('href'));
	});
	$('.message').hide();
	$( ".datepicker" ).datepicker({
		minDate: 0,
		dateFormat: 'yyyy-mm-dd', //set the format of the date
	});
	$("form[name='send']").submit(function (e) {
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: 'send.php?action=save',
			data: $(this).serialize(),
			dataType: 'text',
			success: function () {
				$('.message').show(500);
				$(".radiobtn").removeClass("border");
				$('#ticket').val("");
				$('#datum').val("");
			},
			error: function () {
				alert("Something went wrong, please try it again.");
			}
		});
	});
		
	$("form[name='response']").submit(function (e) {
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: 'send.php?action=edit',
			data: $(this).serialize(),
			dataType: 'text',
			success: function () {
				$(".bedankt").html("<div class=\"alert alert-success d-flex align-items-center\" role=\"alert\"><svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Success:\"><use xlink:href=\"#check-circle-fill\"/></svg><div>Succesvol opgeslagen!</div></div></div>");
				
			},
			error: function () {
				alert("Something went wrong, please try it again.");
			}
		});
		
	});
});