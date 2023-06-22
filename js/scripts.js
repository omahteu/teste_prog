function isoDateToShort(isoDate)
{
    data = new Date(isoDate+'T00:00:00');
    var dd = data.getDate();
    var mm = data.getMonth() + 1; //January is 0!

    var yyyy = data.getFullYear();
    if (dd < 10) {
      dd = '0' + dd;
    }
    if (mm < 10) {
      mm = '0' + mm;
    } 
    var data = dd + '/' + mm + '/' + yyyy;
    return data;
}

$(document).ready(function() {
	var textos = [];
    $('#bannerOpcoes').click(function(){
        $('.opcao').toggle(400);
    })
    $('.linkShow').click(function(){
        $('.opcaoLink').toggle(400);
    })
	$('input[type=text]').keydown(function(event) {
		if(event.which == 13){
			$(this).trigger('focusout');
			return false;
		}
	});
	//plano de fundo
	$('#image').change(function(){
		var input = this;
		if (input.files && input.files[0]) {
		    var reader = new FileReader();
		    reader.onload = function (e) {
		    	$('.previewBanner').css('background-image', 'url('+e.target.result+')')
		    };
		    reader.readAsDataURL(input.files[0]);
		}else{
			$('.previewBanner').css('background-image', 'url(../img/banner/defaultMain.jpg)');
		}
	});

	//imagem secundária
	$('#secondary').change(function(){
		var input = this;
		if (input.files && input.files[0]) {
		    var reader = new FileReader();
		    reader.onload = function (e) {
		    	$('#previewSecondaryBanner').css('background-image', 'url('+e.target.result+')')
		    };
		    reader.readAsDataURL(input.files[0]);
		}else{
			$('#previewSecondaryBanner').css('background-image', 'url(../img/banner/defaultSecondary.png)');
		}
	});
	$('#produtosImage').change(function(){
		var input = this;
		if (input.files && input.files[0]) {
		    var reader = new FileReader();
		    reader.onload = function (e) {
		    	$('.previewBanner').css('background-image', 'url('+e.target.result+')')
		    };
		    reader.readAsDataURL(input.files[0]);
		}else{
			$('.previewBanner').css('background-image', 'url(../img/banner/bgBanner4.png)');
		}
	});
	
	$('.bannerElement').click(function(){
		var text = $(this);
		var form = $('#'+text.data('input-id'));
		if(form.val() == '' || form.val() == undefined){
			textos[text.attr('id')] = text.html();
		}
		//form.val(text.html());
		text.hide();
		form.show();
		form.select();
	});

	$('.bannerForm').focusout(function(){
		var form = $(this);
		var text = $('#'+form.data('text-id'));
		form.hide();
		if(form.val().length > 0)
		{
		text.html(form.val());
		}else{
			text.html(textos[text.attr('id')]);
		}
		text.show();
	});
	
});