$(document).ready(function () {
	"use strict";
	
	
	 $('.tooltips').tooltip({
      position: {
        my: "center bottom-20",
        at: "center top",
        using: function( position, feedback ) {
          $( this ).css( position );
          $( "<div>" )
            .addClass( "arrow" )
            .addClass( feedback.vertical )
            .addClass( feedback.horizontal )
            .appendTo( this );
        }
      }
    });
	$("#profile_btn").click(function (e) {
		e.preventDefault();
		$("#profileTraveller").hide();
		$("#refTraveller").show();
		$(".progress-bar").css("width","0%");
		$(".progress-bar").html("0%");
	});
	
	$("#to_profile").click(function (e) {
		e.preventDefault();
		$("#profileFlight").hide();
		$("#profileTraveller").show();
		$(".progress-bar").css("width","20%");
		$(".progress-bar").html("20%");
	});

	$("#to_hotel").click(function (e) {
		e.preventDefault();
		$("#profileFlight").show();
		$("#profileHotel").hide();
		$(".progress-bar").css("width","40%");
		$(".progress-bar").html("40%");
	});

	$("#to_cars").click(function (e) {
		e.preventDefault();
		$("#profileCars").hide();
		$("#profileHotel").show();
		$(".progress-bar").css("width","60%");
		$(".progress-bar").html("60%");
	});	
	
	$("#to_train").click(function (e) {
		e.preventDefault();
		$("#profileTrain").hide();
		$("#profileCars").show();
		$(".progress-bar").css("width","90%");
		$(".progress-bar").html("90%");
	});
	$("#to_send").click(function (e) {
		e.preventDefault();
		$("#send").hide();
		$("#profileTrain").show();
		$(".progress-bar").css("width","990%");
		$(".progress-bar").html("99%");
	});/*
	<input name="section_1_date" type="hidden">
			<input name="section_1_contact" type="hidden">
			<input name="section_1_phone" type="hidden">
			<input name="section_1_mail" type="hidden">
	*/
	
	$.datepicker.setDefaults($.datepicker.regional['']);
	$(".birthDatePicker").datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: '1940:2002', //set the range of years
		dateFormat: 'dd-mm-yy' //set the format of the date
	});
	var incomplete = 0;
	var nationalities = '<option value=""> - Make a choice - </option>';
	$.getJSON("airports.json?v=2", function (data) {
		var i = 0;

		$.each(data, function () {
			nationalities += ("<option value='" + data[i].name + "'>" + data[i].name + "</option>");
			i++;
		});
		$(".nationalities").html(nationalities);
	}).done(function() {
		//$('#nationality').find('option[value="Dutch, Netherlandic"]').attr("selected",true);
  	});
	
	var countries = '<option value=""> - Make a choice - </option>';
	$.getJSON("airports.json?v=2", function (data) {
		var i = 0;

		$.each(data, function () {
			countries += ("<option value='" + data[i].name + "'>" + data[i].name + "</option>");
			i++;
		});
		$(".countries").html(countries);
	});
	$(".reference").datepicker({
		minDate: 0,
		dateFormat: 'dd-mm-yy' //set the format of the date
	});
	$(".hasDatePicker").datepicker({
		minDate: 0,
		dateFormat: 'dd-mm-yy', //set the format of the date
		onSelect: function(date) {
           
			$(".hasDatePicker2").datepicker({
				minDate: date,
				dateFormat: 'dd-mm-yy' //set the format of the date
			});
        },
	});
	$(".hasDatePickerhotel").datepicker({
		minDate: 0,
		dateFormat: 'dd-mm-yy', //set the format of the date
		onSelect: function(date) {
           
			$(".hasDatePickerhotel2").datepicker({
				minDate: date,
				dateFormat: 'dd-mm-yy' //set the format of the date
			});
        },
	});
	$(".hasDatePickerCar").datepicker({
		minDate: 0,
		dateFormat: 'dd-mm-yy', //set the format of the date
		onSelect: function(date) {
           
			$(".hasDatePickerCar2").datepicker({
				minDate: date,
				dateFormat: 'dd-mm-yy' //set the format of the date
			});
        },
	});
	$(".hasDatePickerTrain").datepicker({
		minDate: 0,
		dateFormat: 'dd-mm-yy', //set the format of the date
		onSelect: function(date) {
           
			$(".hasDatePickerTrain2").datepicker({
				minDate: date,
				dateFormat: 'dd-mm-yy' //set the format of the date
			});
        },
	});
	$(".hasDatePicker3").datepicker({
		minDate: 0,
		dateFormat: 'dd-mm-yy', //set the format of the date
		onSelect: function(date) {
           
			$(".hasDatePicker4").datepicker({
				minDate: date,
				dateFormat: 'dd-mm-yy' //set the format of the date
			});
        },
	});
	$('.timepicker').timepicker({
		timeFormat: 'HH:mm',
		interval: 60,
		dynamic: false,
		dropdown: true,
		scrollbar: true
	});
	$('.quantity_bagage0').hide();
	$(".addTraveller_checkinLuggageAmount").prop('required', false);
	$("input[name='travelSegment_luggage[0]']").change(function () {
		// Do something interesting here
		if ($(this).val() === 'Nee') {
			$('.quantity_bagage0').hide();
			$("input[name='addTraveller_checkinLuggageAmount[0]']").prop('required', false);
		} else {
			$('.quantity_bagage0').show();
			$("input[name='addTraveller_checkinLuggageAmount[0]']").prop('required', true);
		}
	});
	var clickedbtn2;
	$("button[name='trainButton']").click(function () {
		clickedbtn2 = ($(this).val());
	});
	
	$("form[name='refTraveller']").submit(function (e) {
		e.preventDefault();
			$("form[name='refTraveller'] :disabled").removeAttr('disabled');
			$.ajax({
				type: 'POST',
				url: 'send.php?action=ref',
				data: $(this).serialize(),
				dataType: 'text',
				success: function () {
					$("form[name='profileTraveller']").show();
					$(".progress-bar").css("width","20%");
					$(".progress-bar").html("20%");
					$("form[name='refTraveller']").hide();
					//$('#edit_profile').val('yes');
					
				},
				error: function () {
					alert("Something went wrong, please try it again.");
				}
			});
		
	});
	$("form[name='profileTraveller']").submit(function (e) {
		e.preventDefault();
			$("form[name='profileTraveller'] :disabled").removeAttr('disabled');
			$.ajax({
				type: 'POST',
				url: 'send.php?action=traveller',
				data: $(this).serialize(),
				dataType: 'text',
				success: function () {
					$("form[name='profileFlight']").show();
					$(".progress-bar").css("width","40%");
					$(".progress-bar").html("40%");
					$("form[name='profileTraveller']").hide();
					//$('#edit_profile').val('yes');
					
				},
				error: function () {
					alert("Something went wrong, please try it again.");
				}
			});
		
	});
	function addTraveller(){
		var traveler ="<div id='flight{count}'><hr><span class='f-title'>Reiziger #{counter}</span><a href='#close' class='float-right closeFlight'> <img src='images/cancel.svg' alt='' width='20'/> </a><input type='hidden' name='actual_count_travellers' value='{count}'><table width='100%' border='0' align='center' cellpadding='5' cellspacing='5' class='container-fluid'><tbody><tr><td><strong>Aanhef* : </strong></td><td> <div class=\"form-check form-check-inline\"><input class='form-check-input' name='addTraveller_title[{count}]' type='radio' required='required' id='addTraveller_titlea[{count}]' value='Dhr.'><label for='addTraveller_title1a' class='radioLabel'>Dhr.</label></div><div class=\"form-check form-check-inline\"><input class='form-check-input' name='addTraveller_title[{count}]' type='radio' required='required' id='addTraveller_title[{count}]' value='Mevr.'><label class='form-check-label' for='inlineRadio2'>Mevr.</label></div></td></tr><tr><td width='20%' align='left'><div class='input-group'><strong>Achternaam* : </strong><br><small> &nbsp;(zoals vermeld in paspoort)</small></div></td><td width='80%'><input name='addTraveller_lastName[{count}]' type='text' required='required' id='addTraveller_lastName' size='40' class='form-control' placeholder='Achternaam'></td></tr><tr><td align='left'><strong>Voornaam* :  </strong><br><small> &nbsp;(zoals vermeld in paspoort)</small></td><td><input name='addTraveller_firstName[{count}]' type='text' required='required' id='addTraveller_firstName' class='form-control' placeholder='Voornaam'></td></tr><tr><td align='left'><strong>E-mail* :  </strong></td><td><input name='addTraveller_email[{count}]' type='email' required='required' id='addTraveller_email' class='form-control' placeholder='E-mail'></td></tr><tr><td align='left'><strong>Mobiel nummer :<a href='#' title='' class='tooltips' data-original-title='Via de AirGo-M app kunt u uw actuele vluchtgegevens inzien'><span class='ui-icon ui-icon-info'></span></a>  </strong><br><small> &nbsp;(t.b.v. AirGo-M app)</small></td><td><input id='traveller_phonenumber[{count}]' name='traveller_phonenumber[{count}]' type='text' class='form-control' placeholder='Mobiel nummer'></td></tr><tr><td align='left'><strong>Geboortedatum* :  </strong></td><td><input required='required' id='traveller_birthdate[{count}]' name='traveller_birthdate[{count}]' type='text' class='form-control birthDatePicker ' placeholder='Birthdate'></td></tr><tr><td align='left'><strong>Opmerkingen</strong></td><td><textarea name='addTraveller_remarks[{count}]' id='addTraveller_remarks[{count}]' class='form-control'></textarea></td></tr><tr></tbody></table><br></div>";
		var actualcount = 1;
		$('#addTraveller').click(function (e) {
			e.preventDefault();
			var person = traveler.replace(/{count}/g, actualcount);
			var person2 = person.replace(/{countries}/g, countries);
			var person3 = person2.replace(/{counter}/g, (actualcount + 1));
			$('#extraTravellerContainer').append(person3);

			$('.closeFlight').click(function (e) {
				e.preventDefault();
				$(this).parent().remove();

			});
			$(".birthDatePicker").datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: '1940:2002', //set the range of years
		dateFormat: 'dd-mm-yy' //set the format of the date
	});
			actualcount++;
				$('.tooltips').tooltip({
      position: {
        my: "center bottom-20",
        at: "center top",
        using: function( position, feedback ) {
          $( this ).css( position );
          $( "<div>" )
            .addClass( "arrow" )
            .addClass( feedback.vertical )
            .addClass( feedback.horizontal )
            .appendTo( this );
        }
      }
    });
		});
	}
	 addTraveller();
	var clickedbtn;
	$("button[name='sbmitbtn']").click(function () {
		clickedbtn = ($(this).val());
	});

	$("form[name='profileFlight']").submit(function (e) {
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: 'send.php?action=flights',
			data: $(this).serialize(),
			dataType: 'text',
			success: function () {
				if (clickedbtn === 'next') {
					$("form[name='profileHotel']").show();
					$("form[name='profileFlight']").hide();
					$(".progress-bar").css("width","60%");
					$(".progress-bar").html("60%");
				}
				if (clickedbtn === 'save') {
					$(".progress-bar").css("width","99%");
					$(".progress-bar").html("99%");
					$("form[name='send']").show();
					$("form[name='profileFlight']").hide();
					list();
				}
				$('#edit_flight').val('yes');
			},
			error: function () {
				alert("error");
			}

		});
	});
	
	function flight() {
		var extraFlight = "<div id='flight{count}'><a href='#close' class='float-right closeFlight'> <img src='images/cancel.svg' alt='' width='20'/> </a><input type='hidden' name='actual_count_flights' value='{count}'><table border='0' cellspacing='5' cellpadding='5' align='center' width='100%'> <tbody> <tr> <td width='155'><h2>Vlucht #{counter}</h2></td><td width='822'><img src='images/plane-only.png' alt='Flight'></td></tr></tbody> </table> <table width='100%' border='0' cellspacing='5' cellpadding='5'> <tbody> <tr><td width='19%'><strong>Zitcomfort en service: </strong></td><td width='81%'><select name='travelSegment_class[{count}]' id='travelSegment_class[{count}]'class='form-control' required><option value=''> - Maak een keuze - </option><option value='Economy'>Economy</option><option value='Economy comfort'>Economy comfort</option><option value='Businessclass'>Businessclass</option></select></td></tr><tr> <td width='15%'><strong>Van: </strong></td><td width='85%'><input name='travelSegment_from[{count}]' id='travelSegment_from_{count}' type='text' class='form-control ' placeholder='Van' ></td></tr><tr> <td><strong>Naar:  </strong> </td><td><input name='travelSegment_to[{count}]' id='travelSegment_to_{count}' type='text' class='form-control ' placeholder='Naar'/></td></tr><tr> <td><strong>Datum reis: </strong></td><td><input name='travelSegment_prefDate[{count}]' id='travelSegment_prefDate[{count}]' type='text' class='form-control hasDatePicker' placeholder='Datum reis'></td></tr><tr> <td><strong>Tijdstip: </strong></td><td><table width='100%' border='0' cellspacing='5' cellpadding='5'> <tbody> <tr> <td><input name='travelSegment_prefTime[{count}]' type='text' class='form-control timepicker' placeholder='Tijdstip'></td><td><div class='form-check form-check-inline'><input class='form-check-input' name='travelSegment_departOn[{count}]' type='radio' value='departure'><label for='addTraveller_title1a' class='radioLabel'>Vertrek</label></div><div class='form-check form-check-inline'><input class='form-check-input' name='travelSegment_departOn[{count}]' type='radio' value='arrival at'><label for='addTraveller_title1a' class='radioLabel'>Aankomst</label></div></td></tr></tbody> </table></td></tr><tr> <td><strong>Baggage: </strong></td><td><div class='form-check form-check-inline'><input class='form-check-input' name='travelSegment_luggage[{count}]' type='radio' value='Ja'><label for='addTraveller_title1a' class='radioLabel'>Ja</label></div><div class='form-check form-check-inline'><input class='form-check-input' name='travelSegment_luggage[{count}]' type='radio' value='Nee'><label for='addTraveller_title1a' class='radioLabel'>Nee</label></div></td></tr><tr> <td></td><td> <table width='100%' border='0' cellspacing='5' cellpadding='5' class='input-group quantity_bagage0' id='flight{count}'> <tbody> <tr> <td width='10%'><strong>Aantal: </strong></td><td width='90%'><select name='addTraveller_checkinLuggageAmount[{count}]' class='addTraveller_checkinLuggageAmount[{count}]'> <option value=''> - selecteer -</option> <option value='1'>1</option> <option value='2'>2</option> <option value='3'>3</option> <option value='4'>4</option> <option value='5'>5</option> </select></td></tr></tbody> </table> </td></tr><tr> <td><strong>Maaltijd voorkeur: </strong></td><td><select name='addTraveller_meals[{count}]' class='addTraveller_meals[{count}]'><option value=''>- Geen voorkeur -</option><option value='Vegetarisch'>Vegetarisch</option><option value='Hindu (niet vegetarisch) (HNML)'>Hindu (niet vegetarisch)</option><option value='Moslim (MOML)'>Moslim</option><option value='Diabetic (DBML)'>Diabetisch</option><option value='Gluten-free (GFML)'>Gluten-vrij</option><option value='Kosher (KSML)'>Kosher</option></select></td></tr><tr><td><strong>Opmerkingen:</strong></td><td><textarea name='travelSegment_remarks[{count}]' type='text' class='form-control ' placeholder='Opmerkingen'></textarea></td></tr></tbody></table><br><div class='input-group'><h2 style=' line-height: 21px; font-size: 12px; text-transform: uppercase; border-bottom: 2px solid #eaeaea; background-color: rgba(0,0,0,0) !important; border-top: 0px solid white; color: #969696; letter-spacing: 0.15em; padding: 0;'>Terugreis (OPTIONEEL)</h2></div><table width='100%' border='0' cellspacing='5' cellpadding='5'> <tbody> <tr> <td width='15%'><strong>Van: </strong></td><td width='85%'><input name='travelSegment_fromReturn[{count}]' id='travelSegment_fromReturn_{count}' type='text' class='form-control countries' placeholder='Van'></td></tr><tr> <td><strong>Naar:  </strong></td><td><input name='travelSegment_toReturn[{count}]' id='travelSegment_toReturn_{count}' type='text' class='form-control countries' placeholder='Naar'></td></tr><tr> <td><strong>Datum: </strong></td><td><input name='travelSegment_prefDateReturn[{count}]' type='text' class='form-control hasDatePicker' placeholder='Datum'></td></tr><tr> <td><strong>Tijdstip:</strong></td><td><table width='100%' border='0' cellspacing='5' cellpadding='5'> <tbody> <tr> <td><input name='travelSegment_prefTimeReturn[{count}]' type='text' class='form-control timepicker' placeholder='Tijd'></td><td><div class='form-check form-check-inline'><input class='form-check-input' name='travelSegment_departingReturn[{count}]' type='radio' value='departure'><label for='addTraveller_title1a' class='radioLabel'>Vertrek</label></div><div class='form-check form-check-inline'><input class='form-check-input' name='travelSegment_departingReturn[{count}]' type='radio' value='arrival at'><label for='addTraveller_title1a' class='radioLabel'>Aankomst</label></div></td></tr></tbody> </table></td></tr><tr> <td><strong>Opmerkingen:</strong></td><td><textarea name='travelSegment_add[{count}]' type='text' class='form-control ' placeholder='Opmerkingen'></textarea></td></tr></tbody></table><hr><br></div>";


		var actualcount = 1;
		$('#next2').click(function (e) {
			e.preventDefault();
			var fl = extraFlight.replace(/{count}/g, actualcount);
			var flight = fl.replace(/{countries}/g, countries);
			var flght = flight.replace(/{counter}/g, (actualcount + 1));
			$('#extraFlightContainer').append(flght);

			$('.closeFlight').click(function (e) {
				e.preventDefault();
				$(this).parent().remove();

			});
			$('#flight' + actualcount + ' .quantity_bagage').hide();
			$(".hasDatePicker").datepicker({
				minDate: 0,
				dateFormat: 'dd-mm-yy'
			});
			$('.timepicker').timepicker({
				timeFormat: 'HH:mm',
				interval: 60,
				
				dynamic: false,
				dropdown: true,
				scrollbar: true
			});
			$('.quantity_bagage0').hide();
			var name2 = "travelSegment_luggage[" + actualcount + "]";
			var target = "#flight" + actualcount;

			$("input[name='" + name2 + "']").change(function () {
				// Do something interesting here
				if ($(this).val() === 'Nee') {
					$(target + ' .quantity_bagage0').hide();
					$($("input[name='addTraveller_checkinLuggageAmount[" + actualcount + "]']")).prop('required', false);
				} else {
					$(target + ' .quantity_bagage0').show();
					$("input[name='addTraveller_checkinLuggageAmount[" + actualcount + "]']").prop('required', true);
				}
			});
				var airports = [
		"Abu Dhabi, UAE",
		"Abuja, Nigeria",
		"Accra, Ghana",
		"Addis Abeba, Ethiopia",
		"Algiers, Algeria",
		"Almaty, Kazachstan",
		"Amman, Jordany",
		"Amsterdam, Netherlands",
		"Ankara, Turkey",
		"Antwerp, Belgium",
		"Asmara, Eritrea",
		"Astana, Kazachstan",
		"Athens, Greece",
		"Bagdad, Irak",
		"Bakoe, Azerbaijan",
		"Bamako, Mali",
		"Bangkok, Thailand",
		"Barcelona, Spain",
		"Beirut, Lebanon",
		"Bejing, China",
		"Belgrado, Serbia",
		"Berlin, Germany",
		"Bern, Switzerland",
		"Budapest, Hungary",
		"Bukarest, Romania",
		"Bogota, Colombia",
		"Brasilia, Brazil",
		"Bratislava, Slovakia",
		"Brussel AMB, Belgium",
		"Buenos Aires, Argentina",
		"Bujumbura, Burundi",
		"Cairo, Egypt",
		"Canberra, Australia",
		"Caracas, Venezuela",
		"Casablanca, Morocco",
		"Chicago, USA",
		"Colombo, Sri Lanka",
		"Cotonou, Benin",
		"Dakar, Senegal",
		"Damascus, Syria",
		"Dar es Salaam, Tanzania",
		"Dhaka, Bangladesh",
		"Doha, Qatar",
		"Dubai, UAE",
		"Dublin, Ireland",
		"Dusseldorf, Germany",
		"Geneva PV VN, Switzerland",
		"Guangzhou, China",
		"Guatemala, Guatemala",
		"Hanoi, Vietnam",
		"Harare, Zimbabwe",
		"Havanna, Cuba",
		"Helsinki, Finland",
		"Ho Chi Minh City, Vietnam",
		"Holy See, Vatican",
		"Hongkong, China",
		"Islamabad, Pakistan",
		"Istanbul, Turkey",
		"Jakarta, Indonesia",
		"Juba, South Sudan",
		"Kaapstad, South Africa",
		"Kabul, Afghanistan",
		"Kampala, Uganda",
		"Khartoem, Sudan",
		"Kiev, Ukraine",
		"Kigali, Rwanda",
		"Kinshasa, Congo",
		"Koeweit, Kuwait",
		"Copenhagen, Denmark",
		"Kosovo, Kosovo",
		"Kuala Lumpur, Malasia",
		"La Paz, Bolivia",
		"Lagos, Nigeria",
		"Lima, Peru",
		"Lissabon, Portugal",
		"Ljubljana, Slovenia",
		"London, UK",
		"Luanda, Angola",
		"Lusaka, Zambia",
		"Luxemburg, Luxemburg",
		"Madrid, Spain",
		"Managua, Nicaragua",
		"Manilla, Philipines",
		"Maputo, Mozambic",
		"Mexico, Mexico",
		"Miami, USA",
		"Milan, Italy",
		"Montevideo, Uruguay",
		"Moscow, Russia",
		"Mumbai, India",
		"Munich, Germany",
		"Muscat, Oman",
		"Nairobi, Kenia",
		"New Delhi, India",
		"New York CG, USA",
		"New York PV VN, USA",
		"Nicosia, Cyprus",
		"Osaka-Kobe, Japan",
		"Oslo, Norway",
		"Ottawa, Canada",
		"Ouagadougou, Burkina Faso",
		"Paramaribo, Suriname",
		"Paris AMB/UNESCO, France",
		"Paris PV OESO, France",
		"Port of Spain, Trinidad and Tobago",
		"Prague, Czech Republic",
		"South, Soth Africa",
		"Pristina, Kosovo",
		"Quito, Ecuador",
		"Rabat, Morocco",
		"Ramallah, Palestine Territories",
		"Riga, Latvia",
		"Rio de Janeiro, Brazil",
		"Riyad, Saudi-Arabia",
		"Rome AMB, Italy",
		"Rome PV FAO, Italy",
		"San Francisco, USA",
		"San Jose, Costa Rica",
		"Sana'a, Yemen",
		"Santiago de Chile, Chile",
		"Santo Domingo, Domenican Republic",
		"São Paulo, Brazil",
		"Sarajevo, Bosnia-Herzegovina",
		"Seoul, Korea",
		"Shanghai, China",
		"Singapore, Singapore",
		"Skopje, Macedonia",
		"Sophia, Bulgaria",
		"St Petersburg, Russia",
		"Stockholm, Sweden",
		"Straatsburg PV, France",
		"Sydney, Australia",
		"Tallinn, Estonia",
		"Tbilisi, Georgia",
		"Teheran, Iran",
		"Tel Aviv, Israel",
		"Tirana, Albania",
		"Tokyo, Japan",
		"Toronto, Canada",
		"Tripoli, Libia",
		"Tunis, Tunesia",
		"Valletta, Malta",
		"Vancouver, Canada",
		"Vienna AMB, Austria",
		"Vienna Task Force OVSE, Austria",
		"Vilnius, Lituania",
		"Warschau, Poland",
		"Washington D.C., USA",
		"Wellington, New-Zealand",
		"Yaounde, Camerun",
		"Zagreb, Croatia",
		"Billund, Denmark" ,
		"Zurich, Switzerland",
		"Minsk, Belarus"
	];
			$( "#travelSegment_fromReturn_"+actualcount ).autocomplete({source: airports});
			$( "#travelSegment_toReturn_"+actualcount ).autocomplete({source: airports});
			$( "#travelSegment_from_"+actualcount ).autocomplete({source: airports});
			$( "#travelSegment_to_"+actualcount ).autocomplete({source: airports});
			actualcount++;

		});
	}
	flight();
	function getHotel() {
		var hotel = "<div id='hotel{count}'><a href='#close' class='float-right closeHotel'> <img src='images/cancel.svg' alt='' width='20'/> </a> <table border='0' cellspacing='5' cellpadding='5' align='center' width='100%'> <tbody> <tr> <td width='155'><h2>Hotel #{counter}</h2></td><td width='822'><img src='images/hotel.png' alt='Hotel'></td></tr></tbody> </table><table width='100%' border='0' cellspacing='5' cellpadding='5'> <tbody> <tr> <td width='19%'><strong>Stad: </strong></td><td width='81%'><input name='hotelSegment_place[{count}]' id='hotelSegment_place[{count}]' class='form-control'></td></tr><tr> <td><strong>Voorkeurshotel : </strong></td><td><input name='hotelSegment_prefHotel[{count}]' id='hotelSegment_prefHotel[{count}]' class='form-control '></td></tr><tr> <td><strong>Voorkeursplaats: </strong> </td><td><input name='hotelSegment_prefLocation[{count}]' id='hotelSegment_prefLocation[{count}]' class='form-control'></td></tr><tr> <td><strong>Aankomstdatum: </strong></td><td><input name='hotelSegment_arrivalDate[{count}]' id='hotelSegment_arrivalDate[{count}]' class='form-control hasDatePickerHotelfirst{count}' ></td></tr><tr> <td><strong>Vertrekdatum: </strong></td><td><input name='hotelSegment_nights[{count}]' id='hotelSegment_nights[{count}]' class='form-control hasDatePickerHotelsecond{count}'></td></tr><tr> <td><strong>Kamer type: </strong></td><td><select name='hotelSegment_roomType[{count}]' id='hotelSegment_roomType[{count}]' class='form-control'><option value=''>- Kamer type -</option><option value='Eenpersoonskamer'>Eenpersoonskamer</option><option value='Tweepersoonskamer'>Tweepersoonskamer </option><option value='Drie- of vierpersoonskamer'>Drie- of vierpersoonskamer</option><option value='Familiekamer'>Familiekamer</option></select></td></tr><tr> <td><strong>Opmerkingen:</strong></td><td><textarea name='hotelSegment_remarks[{count}]' id='hotelSegment_remarks[{count}]' class='form-control'></textarea></td></tr></tbody></table><br><hr></div>";

		var actualcount = 1;
		$('#next3').click(function (e) {
			e.preventDefault();
			$("#actualcountHotel").val(actualcount + 1);
			var hl 					= hotel.replace(/{count}/g, actualcount);
			var hotelxtra 			= hl.replace(/{countries}/g, countries);
			var htl 				= hotelxtra.replace(/{counter}/g, actualcount + 1);
			$('#hotelContainer').append(htl);
			var htlpicker 			= ".hasDatePickerHotelfirst{count}";
			var htlpicker2 			= ".hasDatePickerHotelsecond{count}";
			
			var firsthotel			= htlpicker.replace("{count}", actualcount);
			var secondhotel			= htlpicker2.replace("{count}", actualcount);
			
			$('.closeHotel').click(function (e) {
				e.preventDefault();
				$(this).parent().remove();

				$("#actualcountHotel").val(actualcount);
			});
			$(""+firsthotel+"").datepicker({
				minDate: 0,
				dateFormat: 'dd-mm-yy', //set the format of the date
				onSelect: function(date) {

					$(""+secondhotel+"").datepicker({
						minDate: date,
						dateFormat: 'dd-mm-yy' //set the format of the date
					});
				},
			});
			actualcount++;
		});
	}
	getHotel();
	$("form[name='profileHotel']").submit(function (e) {
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: 'send.php?action=hotels',
			data: $(this).serialize(),
			dataType: 'text',
			success: function () {


				if (clickedbtn === "sbmitbtn") {
					$("form[name='profileHotel']").hide();
					$("form[name='profileCars']").show();
					$(".progress-bar").css("width","80%");
					$(".progress-bar").html("80%");
				}
				if (clickedbtn === 'saveHotel') {
					$("form[name='send']").show();
					$("form[name='profileHotel']").hide();
					list();
				}
				$('#edit_hotel').val('yes');
			},
			error: function () {
				alert("error");
			}
		});
	});
	
	$("form[name='profileCars']").submit(function (e) {
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: 'send.php?action=cars',
			data: $(this).serialize(),
			dataType: 'text',
			success: function () {
				if (clickedbtn === "submitCars") {
					$("form[name='profileTrain']").show();
					$("form[name='profileCars']").hide();
					$(".progress-bar").css("width","90%");
					$(".progress-bar").html("90%");
				}
				if (clickedbtn === 'saveCars') {
					$("form[name='send']").show();
					$("form[name='profileCars']").hide();
					list();
				}
				$('#edit_car').val('yes');
			},
			error: function () {
				alert("Something went wrong, please try it again.");
			}
		});
	});
	function train() {
		var extraTrain = "<div id='train{count}'><a href='#close' class='float-right closeTrain'> x<img src='images/cancel.svg' alt='' width='20'/> </a> <table border='0' cellspacing='5' cellpadding='5' align='center' width='100%'><tbody><tr><td width='125'><h2>Trein #{counter}<input type='hidden' name='edit_train' id='edit_train' value='no'></h2></td><td width='663'><img src='images/train-only.png' alt='Trein'></td><td width='302' align='right' valign='top'></td></tr></tbody></table><div class='input-group'> <h2 style=' line-height: 21px; font-size: 12px; text-transform: uppercase; border-bottom: 2px solid #eaeaea; background-color: rgba(0,0,0,0) !important; border-top: 0px solid white; color: #CCCCCC; letter-spacing: 0.15em; padding: 0;'><strong>HEENREIS</strong></h2> </div><table width='100%' border='0'> <tbody> <tr> <td><strong>Klasse:</strong></td><td><span class='input-group'> <select name='trainSegment_class[{count}]' id='trainSegment_class[{count}]' class='form-control'><option value=''> - Maak een keuze - </option><option value='1e klas'>1e klas</option><option value='2e klas'>2e klas</option> </select> </span></td></tr><tr> <td><strong>Wijzigbaar:</strong></td><td><span class='input-group'> <select name='trainSegment_editable[{count}]' id='trainSegment_editable[{count}]' class='form-control'><option value=''> - Maak een keuze - </option><option value='Niet wijzigbaar '>Niet wijzigbaar </option><option value='Wijzigbaar tegen kosten'>Wijzigbaar tegen kosten</option><option value='Kostenloos wijzigbaar'>Kostenloos wijzigbaar</option> </select> </span></td></tr><tr> <td width='12%'><strong>Van:</strong></td><td width='88%'><span class='input-group'> <input name='trainSegment_from[{count}]' type='text' id='trainSegment_from[{count}]' class='form-control '> </span></td></tr><tr> <td><strong>Naar:</strong></td><td><span class='input-group'> <input name='trainSegment_to[{count}]' type='text' id='trainSegment_to[{count}]' class='form-control'> </span></td></tr><tr> <td><strong>Datum reis:</strong></td><td><span class='input-group'> <input name='trainSegment_prefDate[{count}]' type='text' id='trainSegment_prefDate[{count}]' class='form-control hasDatePickerTrain' ></span></td></tr><tr> <td><strong>Tijdstip:</strong></td><td><table width='100%' border='0' cellspacing='5' cellpadding='5'> <tbody> <tr> <td><span class='input-group'> <input name='trainSegment_prefTime[{count}]' type='text' class='form-control timepicker'> </span></td><td><div class='input-group'> <div class='form-check form-check-inline'> <input class='form-check-input' name='trainSegment_departing[{count}]' type='radio' value='Vertrek'> <label class='radioLabel'>Vertrek</label> </div><div class='form-check form-check-inline'> <input class='form-check-input' name='trainSegment_departing[{count}]' type='radio' value='Aankomst'> <label class='radioLabel'>Aankomst</label> </div></div></td></tr></tbody></table></td></tr></tbody></table><table width='100%' border='0'> <tbody> <tr> <td><div class='input-group'> <h2 style=' line-height: 21px; font-size: 12px; text-transform: uppercase; border-bottom: 2px solid #eaeaea; background-color: rgba(0,0,0,0) !important; border-top: 0px solid white; color: rgb(141,160,38); letter-spacing: 0.15em; padding: 0;'><strong>TERUGREIS (OPTIONEEL)</strong></h2> </div></td></tr></tbody></table><table width='100%' border='0'> <tbody> <tr> <td width='12%'><strong>Van:</strong></td><td width='88%'><span class='input-group'> <input name='trainSegment_fromReturn[{count}]' type='text' id='trainSegment_fromReturn2[{count}]' class='form-control '> </span></td></tr><tr> <td><strong>Naar:</strong></td><td><span class='input-group'> <input name='trainSegment_toReturn[{count}]' type='text' id='trainSegment_toReturn2[{count}]' class='form-control'> </span></td></tr><tr> <td><strong>Datum reis:</strong></td><td><span class='input-group'> <input name='trainSegment_prefDateReturn[{count}]' type='text' id='trainSegment_prefDateReturn[{count}]' class='form-control hasDatePickerTrain2'> </span></td></tr><tr> <td><strong>Tijdstip:</strong></td><td><table width='100%' border='0' cellspacing='5' cellpadding='5'> <tbody> <tr> <td><span class='input-group'> <input name='trainSegment_prefTimeReturn[{count}]' type='text' class='form-control timepicker'> </span></td><td><div class='form-check form-check-inline'><input class='form-check-input' name='trainSegment_departingReturn[{count}]' type='radio' value='Departure'><label for='addTraveller_title1a' class='radioLabel'>Departure</label></div><div class='form-check form-check-inline'><input class='form-check-input' name='trainSegment_departingReturn[{count}]' type='radio' value='Arrival at'><label for='addTraveller_title1a' class='radioLabel'>Arrival at</label></div></td></tr></tbody> </table></td></tr><tr> <td><strong>Opmerkingen:</strong></td><td><span class='input-group'> <textarea name='trainSegment_add[{count}]' type='text' class='form-control '></textarea> </span></td></tr></tbody></table><hr></div>";


		var actualcount = 1;
		$('#train_button').click(function (e) {
			e.preventDefault();
			var fl = extraTrain.replace(/{count}/g, actualcount);
			var flight = fl.replace(/{countries}/g, countries);
			var flght = flight.replace(/{counter}/g, (actualcount + 1));
			$('#trainContainer').append(flght);

			$('.closeTrain').click(function (e) {
				e.preventDefault();
				$(this).parent().remove();

			});
			
			$(".hasDatePickerTrain").datepicker({
				minDate: 0,
				dateFormat: 'dd-mm-yy', //set the format of the date
				onSelect: function(date) {

					$(".hasDatePickerTrain2").datepicker({
						minDate: date,
						dateFormat: 'dd-mm-yy' //set the format of the date
					});
				},
			});
			$('.timepicker').timepicker({
				timeFormat: 'HH:mm',
				interval: 60,
				
				dynamic: false,
				dropdown: true,
				scrollbar: true
			});
			
			actualcount++;

		});
	}
	autoFill();
	train();
	$("form[name='profileTrain']").submit(function (e) {
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: 'send.php?action=trains',
			data: $(this).serialize(),
			dataType: 'text',
			success: function () {
				$(".progress-bar").css("width","99%");
				$(".progress-bar").html("99%");
				$("form[name='profileTrain']").hide();
				$("form[name='send']").show();
				$('#edit_train').val('yes');
				list();
			},
			error: function () {
				alert("Something went wrong, please try it again.");
			}
		});
	});
	$("form[name='send']").submit(function (e) {
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: 'send.php?action=save',
			data: $(this).serialize(),
			dataType: 'text',
			success: function () {
				$(".progress-bar").css("width","100%");
				$(".progress-bar").html("100%");
				$("form[name='send']").hide();
				$("#thankyou").show();

			},
			error: function () {
				alert("Something went wrong, please try it again.");
			}
		});
	});
});
function list(){
	$.ajax({
			type: 'POST',
			url: 'send.php?action=list',
			data: $(this).serialize(),
			dataType: 'text',
			success: function (e) {
				
				$("#formdata").html(e);
			
			},
			error: function () {
				alert("Something went wrong, please try it again.");
			}
		});
}
function autoFill(){
	var airports = [
		"Abu Dhabi, UAE",
		"Abuja, Nigeria",
		"Accra, Ghana",
		"Addis Abeba, Ethiopia",
		"Algiers, Algeria",
		"Almaty, Kazachstan",
		"Amman, Jordany",
		"Amsterdam, Netherlands",
		"Ankara, Turkey",
		"Antwerp, Belgium",
		"Asmara, Eritrea",
		"Astana, Kazachstan",
		"Athens, Greece",
		"Bagdad, Irak",
		"Bakoe, Azerbaijan",
		"Bamako, Mali",
		"Bangkok, Thailand",
		"Barcelona, Spain",
		"Beirut, Lebanon",
		"Bejing, China",
		"Belgrado, Serbia",
		"Berlin, Germany",
		"Bern, Switzerland",
		"Budapest, Hungary",
		"Bukarest, Romania",
		"Bogota, Colombia",
		"Brasilia, Brazil",
		"Bratislava, Slovakia",
		"Brussel AMB, Belgium",
		"Buenos Aires, Argentina",
		"Bujumbura, Burundi",
		"Cairo, Egypt",
		"Canberra, Australia",
		"Caracas, Venezuela",
		"Casablanca, Morocco",
		"Chicago, USA",
		"Colombo, Sri Lanka",
		"Cotonou, Benin",
		"Dakar, Senegal",
		"Damascus, Syria",
		"Dar es Salaam, Tanzania",
		"Dhaka, Bangladesh",
		"Doha, Qatar",
		"Dubai, UAE",
		"Dublin, Ireland",
		"Dusseldorf, Germany",
		"Geneva PV VN, Switzerland",
		"Guangzhou, China",
		"Guatemala, Guatemala",
		"Hanoi, Vietnam",
		"Harare, Zimbabwe",
		"Havanna, Cuba",
		"Helsinki, Finland",
		"Ho Chi Minh City, Vietnam",
		"Holy See, Vatican",
		"Hongkong, China",
		"Islamabad, Pakistan",
		"Istanbul, Turkey",
		"Jakarta, Indonesia",
		"Juba, South Sudan",
		"Kaapstad, South Africa",
		"Kabul, Afghanistan",
		"Kampala, Uganda",
		"Khartoem, Sudan",
		"Kiev, Ukraine",
		"Kigali, Rwanda",
		"Kinshasa, Congo",
		"Koeweit, Kuwait",
		"Copenhagen, Denmark",
		"Kosovo, Kosovo",
		"Kuala Lumpur, Malasia",
		"La Paz, Bolivia",
		"Lagos, Nigeria",
		"Lima, Peru",
		"Lissabon, Portugal",
		"Ljubljana, Slovenia",
		"London, UK",
		"Luanda, Angola",
		"Lusaka, Zambia",
		"Luxemburg, Luxemburg",
		"Madrid, Spain",
		"Managua, Nicaragua",
		"Manilla, Philipines",
		"Maputo, Mozambic",
		"Mexico, Mexico",
		"Miami, USA",
		"Milan, Italy",
		"Montevideo, Uruguay",
		"Moscow, Russia",
		"Mumbai, India",
		"Munich, Germany",
		"Muscat, Oman",
		"Nairobi, Kenia",
		"New Delhi, India",
		"New York CG, USA",
		"New York PV VN, USA",
		"Nicosia, Cyprus",
		"Osaka-Kobe, Japan",
		"Oslo, Norway",
		"Ottawa, Canada",
		"Ouagadougou, Burkina Faso",
		"Paramaribo, Suriname",
		"Paris AMB/UNESCO, France",
		"Paris PV OESO, France",
		"Port of Spain, Trinidad and Tobago",
		"Prague, Czech Republic",
		"South, Soth Africa",
		"Pristina, Kosovo",
		"Quito, Ecuador",
		"Rabat, Morocco",
		"Ramallah, Palestine Territories",
		"Riga, Latvia",
		"Rio de Janeiro, Brazil",
		"Riyad, Saudi-Arabia",
		"Rome AMB, Italy",
		"Rome PV FAO, Italy",
		"San Francisco, USA",
		"San Jose, Costa Rica",
		"Sana'a, Yemen",
		"Santiago de Chile, Chile",
		"Santo Domingo, Domenican Republic",
		"São Paulo, Brazil",
		"Sarajevo, Bosnia-Herzegovina",
		"Seoul, Korea",
		"Shanghai, China",
		"Singapore, Singapore",
		"Skopje, Macedonia",
		"Sophia, Bulgaria",
		"St Petersburg, Russia",
		"Stockholm, Sweden",
		"Straatsburg PV, France",
		"Sydney, Australia",
		"Tallinn, Estonia",
		"Tbilisi, Georgia",
		"Teheran, Iran",
		"Tel Aviv, Israel",
		"Tirana, Albania",
		"Tokyo, Japan",
		"Toronto, Canada",
		"Tripoli, Libia",
		"Tunis, Tunesia",
		"Valletta, Malta",
		"Vancouver, Canada",
		"Vienna AMB, Austria",
		"Vienna Task Force OVSE, Austria",
		"Vilnius, Lituania",
		"Warschau, Poland",
		"Washington D.C., USA",
		"Wellington, New-Zealand",
		"Yaounde, Camerun",
		"Zagreb, Croatia",
		"Billund, Denmark" ,
		"Zurich, Switzerland",
		"Minsk, Belarus"
	];
			$( "#travelSegment_fromReturn" ).autocomplete({source: airports});
			$( "#travelSegment_toReturn" ).autocomplete({source: airports});
			$( "#travelSegment_from" ).autocomplete({source: airports});
			$( "#travelSegment_to" ).autocomplete({source: airports});
}