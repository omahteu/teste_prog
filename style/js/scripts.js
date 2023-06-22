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

	$('#imagem').change(function(){
		var input = this;
		if (input.files && input.files[0]) {
		    var reader = new FileReader();
		    reader.onload = function (e) {
		    	$('.imagePreview').attr('src', e.target.result)
		    };
		    reader.readAsDataURL(input.files[0]);
		}else{
			$('.imagePreview').attr('src', oldImage);
		}
	});	
});