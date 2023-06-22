$(document).ready(function() {
	const swalWithBootstrapButtons = Swal.mixin({
	  customClass: {
	    confirmButton: 'btn btn-success',
	    cancelButton: 'btn btn-danger'
	  },
	  buttonsStyling: false,
	});

	var textos = [];
	$('.categoria').click(function(){
		var text = $(this);
		var form = $('#'+text.data('input-id'));
		if(form.val() == '' || form.val() == undefined){
			textos[text.attr('id')] = text.html();
		}
		form.val(text.html());
		text.hide();
		form.show();
		form.select();
	});
	$('.catEdit').keyup(function(ev) {
	    // 13 is ENTER
	    if (ev.which === 13) {
	    	$(this).blur();    
	    }
	});
	$('.catEdit').focusout(function(){
		var form = $(this);
		var text = $('#'+form.data('text-id'));
		form.hide();
		if(form.val().length > 0)
		{
			if(text.html() != form.val())
			{
				Swal.fire({
					title: 'tem certeza?',
					text: "esta ação irá mudar o nome da categoria, deseja continuar?",
					type: 'warning',
					showCancelButton: true,
					confirmButtonText: 'Sim, modificar Categoria.',
					cancelButtonText: 'Não, cancelar.',
					reverseButtons: false
				}).then((result) => {
					if (result.value) {
							$.ajax({
				                url: "ajax/editaCategoria.php",
				                type: 'POST',
				                dataType: "json",
				                data: {
				                    'id': text.attr('id'),
				                    'nome': form.val()
				                },
				                success: function( data ) {
				                    if(data == '200')
				                    {
				                    	text.html(form.val());
				                    	Swal.fire({
				                    		type:'success',
											text:'Categoria editada!'
										});
				                    }
				                }
				            });
						
					}
				});
			}
		}else{
			text.html(textos[text.attr('id')]);
		}
		text.show();
	});
});
