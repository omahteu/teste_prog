


// Define a variabel table
var table = null;

function ajustaTela () {
	var alturaJanela = $(window).height();
	var alturaNav = $('#navbarHeader').outerHeight();
	var alturaHeadder1 = $('#header1').outerHeight();
	var alturaHeadder2 = $('#header2').outerHeight();

	var alturaFinal = (alturaJanela - (alturaNav + alturaHeadder1 + alturaHeadder2 + 15));

	$('.full-page').css('min-height', alturaFinal+'px');
}

$(document).ready(function(){
	//fone form mask
	var SPMaskBehavior = function (val) {
    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
	  },
	  spOptions = {
	    onKeyPress: function(val, e, field, options) {
	        field.mask(SPMaskBehavior.apply({}, arguments), options);
	      }
	  };
	$(".fone-form").mask(SPMaskBehavior, spOptions); //Use class fone-form
	$("#senha-cadastro").mask("999999");
	$(".cep-form").mask("99999-999"); //Use class cep-form


	ajustaTela();

	$(window).resize(function () {
		ajustaTela();
	});

	// Tooltips
	$('[data-toggle="tooltip"]').tooltip();

	// DataTables
	table =  $(".data-table").DataTable({
		"lengthMenu": [25,50,100,200],
		"pageLength": 25,
		"language": {
			"lengthMenu": 		"Exibir _MENU_ registros por páginas",
            "zeroRecords": 		"Desculpe, nada encontrado.",
            "info": 			"Exibindo página _PAGE_ de _PAGES_",
            "infoEmpty": 		"Desculpe, ainda não há registros",
            "infoFiltered": 	"(filtrado do total de _MAX_ registros)",
            "decimal": 			",",
		    "emptyTable": 		"Desculpe não há registros disponíveis.",
		    "infoPostFix": 		"",
		    "thousands":    	".",
		    "loadingRecords": 	"Carregando ...",
		    "processing":     	"Processando ...",
		    "search":         	"Buscar:",
		    "paginate": {
		        "first":      	"Primeiro",
		        "last":       	"Ultimo",
		        "next":       	"Próximo",
		        "previous":   	"Anteriror"
		    },
		    "aria": {
		        "sortAscending": ": ative para classificar a coluna de maneira crescente",
		        "sortDescending":": ative para classificar a coluna de maneira decrescente"
		    }
		}
	});
});