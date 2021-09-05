$(function () {
	//приховує всі сторінки
	function hiddenAll() {
		$('.page_1').addClass('hidden');
		$('.page_2').addClass('hidden');
		$('.page_3').addClass('hidden');
		$('.page_4').addClass("hidden");
	}
	//перевірка пошти і відкривання 2 сторінки
	var p2 = $('.butt1').click(function () {

		var em = $('#emaillll').val();
		if (IsEmail(em)) {
			hiddenAll();
			$('.page_2').removeClass('hidden');
			$('#qua').css('color', 'cornflowerblue');
			$('#con').css('color', 'black');

		} else {
			alert("Enter a valid email address");
		}

	});

	//при поверненні назад появляється 1 сторінка
	var bck = $('.butt3').click(function () {

		hiddenAll();
		$('.page_1').removeClass('hidden');
		$('#con').css('color', 'cornflowerblue');
		$('#qua').css('color', 'black');

	});


	//валідація значення
	var prc = $('.butt2').click(function () {

		var x = $('#innnn').val();
		if (x > 0 && x < 1000) {
			hiddenAll();
			$('.page_3').removeClass('hidden');
			$('#pr').css('color', 'cornflowerblue');
			$('#qua').css('color', 'black');

			$('#final_price').text(getPrice(x) + '$');
		} else {
			alert("Enter the correct value");
		};
	});

	//забирає класс хіден з 2 сторінки
	var bck2 = $('.butt5').click(function () {

		hiddenAll();
		$('.page_2').removeClass('hidden');
		$('#qua').css('color', 'cornflowerblue');
		$('#pr').css('color', 'black');


	});


	//прирівння ціни
	function getPrice(x) {
		var y;
		if (x <= 10) {
			y = 10
		} else if (x <= 100) {
			y = 100
		} else {
			y = 1000
		}
		return y;
	}
	//валідація пошти
	function IsEmail(email) {
		var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if (!regex.test(email)) {
			return false;
		} else {
			return true;
		}
	}


	//			$('.butt4').click(function() {
	//				hiddenAll();
	//				$('.page_4').removeClass('hidden');
	//
	//			});
	//Очищення полів
	$('.butt6').click(function () {
		$('.ph').val('');
		hiddenAll();
		$('.page_1').removeClass('hidden');
		$('#con').css('color', 'cornflowerblue');
		$('#do').css('color', 'black');


	});

	//відправка пошти на бекенд
	$('.butt4').click(function () {
		$.ajax({
			url: 'http:wartyg.com',
			method: 'post',
			dataType: 'html',
			data: {
				email: $('#emaillll').value,
			},
			success: function (data) {
				//                        hiddenAll();
				//						$('.page_4').removeClass('hidden');

			},
			error: function (data) {
				hiddenAll()
				$('.page_4').removeClass('hidden');
				$('#do').css('color', 'cornflowerblue');
				$('#pr').css('color', 'black');


			}

		});
	});

});