<div class="newsleter">
	<form class="newsletter-form lw-ajax-form lw-form" method="post" action="<?= route('user.contact.process') ?>" data-show-processing="true" data-callback="onContactMailCallback" id="lwContactMailForm">
		<input type="hidden" class="form-control form-control-user" name="fullName" value="Newsletter" required id="lwFullName" p>
		<input type="hidden" class="form-control form-control-user" name="subject" required id="lwSubject" value="Cadastro de Newsletter">
		<textarea cols="10" rows="3" class="hide form-control form-control-user" name="message" required id="lwMessage" value="Cadastro de Newsletter">Cadastro de Newsletter</textarea>

		<div class="row">
			<div class="col-lg-6 offset-lg-3 col-md-6 offset-md-3 col-sm-8 offset-sm-2">
		    	<div class="title text-center"> Newsleter </div>
		    	<p class="text-center text-white"> Cadastre seu email e receba novidades todas as semanas </p>
				<div class="input-group mb-3">
				  <input type="text" class="form-control"  name="email" placeholder="" aria-label="Endereço de email" aria-describedby="button-addon2">
				  <div class="input-group-append">
				    <button class="btn btn-outline-secondary lw-ajax-form-submit-action" type="button" id="button-addon2">ENVIAR</button>
				  </div>
				</div>  
			</div>
		</div>  
	</form>	 
</div>

@push('appScripts')
<script>
	//on contact mail form callback
	function onContactMailCallback(response) {
		//check reaction code is 1
		if (response.reaction == 1) {
			//reset form
			$("#lwContactMailForm")[0].reset();
		}
	}
</script>
@endpush