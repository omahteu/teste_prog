$(document).ready(function() {
	//Chama ação quando mudar a imagem
  $('#imagem').change(function(){
    router(this);
  });

  //Ação quando mudar algum campo
  $('#cor').change(function(){
    router();
  });

  //Ação ao mudar alguma legenda
  $('#texto, #textoDestaque').keyup(function(){
    router();
  });

  /*
  *
  *
  * Function router()
  *
  * Call all functions to change bannerPreview
  *
  * @param imageField field that sent the image
  *
  *
  */
  function router(imageField = null){
    try{

    	//Check if image refresh is required
    	if(imageField != null){
    		getImage(imageField);
    	}

    	//Call functions
    	setLegend();
			setPosition();
			setColor();

      //Show banner preview
      $('.img').show();

    }catch(e){
      //Show Exception
      alert(e.name + ": " + e.message);

    }
  }

  /*
  *
  *
  * Function router()
  *
  * Call all functions to change bannerPreview
  *
  * @param input field that sent the image
  *
  *
  */
  function getImage(input) {
    //Check if have files
    if (input.files && input.files[0]){

      //Check if is not an image
      if((input.files[0].type).split("/")[0] != "image"){
        //Throw type exception
        throw new typeException('Unsupported file type.');
      }

      //Init a new reader
      var reader = new FileReader();

      //Get encrypted file on base64
      reader.readAsDataURL(input.files[0]);

      reader.onload = function (e) {
        //Set temporary src to banner preview
        $('.img').attr('src', e.target.result);

        //Call function set BG
        setBg();

        //Remove src atribute
        $('.img').removeAttr('src');
      };
    }else{
        var img = input.value;
        $('.img').attr('src', img);
    }
  }

  /*
  *
  *
  * Function setBg()
  *
  * Get value of src atribute and put in background-image
  *
  *
  */
  function setBg(){
    $('.img').css('background-image', 'url('+$('.img').attr('src')+')');
  }

  /*
  *
  *
  * Function setPosition()
  *
  * Set banner background-position
  *
  *
  */
  function setPosition(){
    if($('#position').val() == 'right'){
      $('.img').css('background-position', 'right');
      $('.img div.legend').addClass('left');
      $('.img div.legend').removeClass('right');
    }else{
      $('.img').css('background-position', 'left');
      $('.img div.legend').addClass('right');
      $('.img div.legend').removeClass('left');
    }
  }

  /*
  *
  *
  * Function setColor()
  *
  * Set banner background-color
  *
  *
  */
  function setColor(){
    $('.img').css('background-color', $('#color').val());
  }

  /*
  *
  *
  * Function setLegend()
  *
  * Set text of legend
  *
  *
  */
  function setLegend(){
    $('.img .legend span').text($('#legend').val());
  }

  /*
  *
  *
  * Type exception
  *
  *
  */
  function typeException(message){
    this.message = message;
    this.name = 'Type Exception';
  }
});