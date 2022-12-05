<script>
	function selectPlan(plan){
		$("input[value='" + plan + "']").trigger("click");
		$("#lwBuyPremiumPlanBtn").trigger("click");
	}

	@if(request()->get('plan') !== null)
			setTimeout(function(){
				selectPlan("{{request()->get('plan')}}");
			}, 2000);
	@endif
</script>
<section class="plans premium-plans">
	<div class="container p-md-5">
		<div class="plan">
			<div class="title">
				<i class="fa fa-user"></i> FREE
			</div>
			<div class="content">
				<p> Use o site todos os dias, mas terá uma limitação de 30 minutos por dia;</p>
				<ul>
					<li> <i class="fa fa-check-circle"></i> Direito a uma foto no seu perfil;</li>
					<!-- <li> <i class="fa fa-check-circle"></i> Acesso à compra de moedinhas sem desconto*;</li> -->
					<!-- <li> <i class="fa fa-times-circle"></i> Direito de postar vídeos</li> -->
					<li> <i class="fa fa-check-circle"></i> Direito a mandar uma mensagem por dia;</li>
					<li> <i class="fa fa-times-circle"></i> Acesso nítido às fotos;</li>
					<!-- <li> <i class="fa fa-times-circle"></i> Mandar o telefone ou contato para ser contatado mas poderá receber o contato de outro </li> -->
					<li> <i class="fa fa-times-circle"></i> Cliente premium;</li>
					<li> <i class="fa fa-times-circle"></i> Acesso ao quem te viu quem você vê;</li>
					<!-- <li> <i class="fa fa-times-circle"></i> Acesso à recadinhos nas fotos</li> -->
					<!-- <li> <i class="fa fa-times-circle"></i> Não terá direito de receber recadinhos em sua foto.</li> -->
				</ul>
			</div>
		</div>
	</div>
	@if($userProfile['gender'] == 1 || $userProfile['gender'] == 2)
	<div class="container p-md-5 gray-container ">
		<!-- <h1>Plano 2</h1> -->
		<!-- <p>(Para suggar mommies e sugar daddies)</p> -->
			<div class="plan plan-plantium">
				<div class="title">
					<i class="fa fa-trophy"></i> Platinum
				</div>
				<div class="highlight">
					<div class="white-line"></div>
					<p> Valores a partir de :</p>
					<div class="_col col-md-12 col-sm-12"> <div class="price" onclick="selectPlan('plantium_12')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "plantium_12") ?> / 12 meses</div> </div>
				</div>
				<!-- <div class="row m-0 p-0">
					<div class="_col col-md-6 col-sm-12"> <div class="price" onclick="selectPlan('plantium_3')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "plantium_3") ?>/ 3 meses</div> </div>
					<div class="_col col-md-4 col-sm-12"> <div class="price" onclick="selectPlan('plantium_6')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "plantium_6") ?> / 6 meses</div> </div>
					<div class="_col col-md-6 col-sm-12"> <div class="price" onclick="selectPlan('plantium_12')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "plantium_12") ?> / 12 meses</div> </div>
				</div> -->
				<div class="content">
					 <ul>
			              <li> <i class="fa fa-check-circle"></i> Direito a 20 fotos no seu perfil, inclusão de 1 foto por dia e 1 foto privada por dia ao limite de 100 fotos privadas totais;</li>
			              <li> <i class="fa fa-check-circle"></i> Retorno de 100% do valor pago pela assinatura em SC$(Sugar Coins);</li>
			              <li> <i class="fa fa-check-circle"></i> Direito a mandar mensagens ilimitadas;</li>
			              <li> <i class="fa fa-check-circle"></i> Acesso nítido à todas as fotos;</li>
			              <li> <i class="fa fa-check-circle"></i> Prioridade de mensagens (sua mensagem passará na frente das mensagens enviadas por outros planos);</li>
			              <li> <i class="fa fa-check-circle"></i> Enviar e solicitar o telefone ou contato via chat e poderá receber o contato de outro cliente premium;</li>
			              <li> <i class="fa fa-check-circle"></i> Acesso ao quem te viu, quem você vê;</li>
			              <li> <i class="fa fa-check-circle"></i> Acesso às fotos dos que têm interesse;</li>
						  <li> <i class="fa fa-check-circle"></i> Direito ao Siga-me (Ser notificado quando alguém que você gosta ou está em contato)</li>
			              <!-- <li> <i class="fa fa-check-circle"></i> Acesso ao “Radar” ou Localizador,</li> -->
			              <!-- <li> <i class="fa fa-check-circle"></i> Direito de receber recadinhos em suas fotos deixando-os públicos ou privados, ( as fotos poderão receber 20 recados cada)</li> -->
			            </ul>
			            <p>Lembrando que ao optar por este plano você terá 100% (cem porcento) do valor pago em reais convertido em Sugar Coins.</p>
				</div>
			</div>
			<div class="plan plan-gold">
				<div class="title">
					<i class="fa fa-users"></i> GOLD
				</div>
				<div class="highlight">
					<div class="white-line"></div>
					<p> Valores a partir de :</p>
					<div class="_col col-md-12 col-sm-12"> <div class="price" onclick="selectPlan('gold_12')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "gold_12") ?> / 12 meses</div> </div>
				</div>
				<!-- <div class="row m-0 p-0">
					<div class="_col col-md-6 col-sm-12"> <div class="price"  onclick="selectPlan('gold_3')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "gold_3") ?> / 3 meses</div> </div>
					<div class="_col col-md-4 col-sm-12"> <div class="price" onclick="selectPlan('gold_6')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "gold_6") ?> / 6 meses</div> </div>
					<div class="_col col-md-6 col-sm-12"> <div class="price" onclick="selectPlan('gold_12')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "gold_12") ?> / 12 meses</div> </div>
				</div>  -->
				<div class="content">
					<ul>
		              <li> <i class="fa fa-check-circle"></i> Direito a 5 fotos, moldura gold no seu perfil e a inclusão de 1 foto por dia, até o limite de 100 fotos;</li>
		              <li> <i class="fa fa-check-circle"></i> Direito a mandar mensagens ilimitadas;</li>
		              <li> <i class="fa fa-check-circle"></i> Acesso nítido à todas as fotos;</li>
		              <li> <i class="fa fa-check-circle"></i> Enviar e solicitar o telefone ou contato via chat e poderá receber o contato de outro cliente premium;</li>
		              <li> <i class="fa fa-check-circle"></i> Acesso ao quem te viu, quem você vê;</li>
		              <li> <i class="fa fa-check-circle"></i> Acesso às fotos dos que tem interesse;</li>
		              <li> <i class="fa fa-times-circle"></i> Direito ao Siga-me (Ser notificado quando alguém que você gosta ou está em contato)</li>
                      <!-- <li> <i class="fa fa-check-circle"></i> Direito à postagem de 2 vídeos; </li> -->
		              <!-- <li> <i class="fa fa-check-circle"></i> Incluir 1 vídeos por semana ( com um “tamanho” determinado por nós ) com limite de 20 vídeos</li> -->
		              <!-- <li> <i class="fa fa-check-circle"></i> Acesso à compra de moedinhas, com descontos especiais*</li> -->
		              <!-- <li> <i class="fa fa-check-circle"></i> Acesso ao “Radar” ou Localizador,</li> -->
		              <!-- <li> <i class="fa fa-check-circle"></i> Direito de receber recadinhos em suas fotos deixando-os públicos ou privados, ( as fotos poderão receber 20 recados cada)</li> -->
		            </ul>
		            <p>Lembrando que ao optar por este plano você terá 50%(cinquenta porcento) do valor pago em reais convertido em Sugar Coins.</p>
				</div>
			</div>			
		</div>
		@endif

		@if($userProfile['gender'] == 3 || $userProfile['gender'] == 4)
		<div class="container p-md-5 gray-container ">
				<!-- <h1>Plano 3</h1> -->
				<!-- <p>(Para suggar babies)</p> -->
				<div class="plan plan-plantium">
					<div class="title">
						<i class="fa fa-trophy"></i> Platinum
					</div>
					<div class="highlight">
						<div class="white-line"></div>
						<p> Valores a partir de :</p>
						<div class="_col col-md-12 col-sm-12"> <div class="price" onclick="selectPlan('plantium_baby_12')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "plantium_baby_12") ?> / 12 meses</div> </div>
					</div>
					<!-- <div class="row m-0 p-0">
						<div class="_col col-md-6 col-sm-12"> <div class="price" onclick="selectPlan('plantium_baby_3')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "plantium_baby_3") ?> / 3 meses</div> </div>
						<div class="_col col-md-4 col-sm-12"> <div class="price" onclick="selectPlan('plantium_baby_6')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "plantium_baby_6") ?> / 6 meses</div> </div>
						<div class="_col col-md-6 col-sm-12"> <div class="price" onclick="selectPlan('plantium_baby_12')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "plantium_baby_12") ?> / 12 meses</div> </div>
					</div> -->
					<div class="content">
						<ul>
						  <li> <i class="fa fa-check-circle"></i> Direito a 20 fotos no seu perfil, inclusão de 1 foto por dia e 1 foto privada por dia ao limite de 100 fotos privadas totais;</li>
			              <li> <i class="fa fa-check-circle"></i> Retorno de 100% do valor pago pela assinatura em SC$(Sugar Coins);</li>
			              <li> <i class="fa fa-check-circle"></i> Acesso nítido à todas as fotos;</li>
			              <li> <i class="fa fa-check-circle"></i> Enviar e solicitar o telefone ou contato via chat e poderá receber o contato de outro cliente premium;</li>
			              <li> <i class="fa fa-check-circle"></i> Acesso ao quem te viu, quem você vê;</li>
			              <!-- <li> <i class="fa fa-check-circle"></i> Acesso ao “Radar” ou Localizador,</li> -->
			              <li> <i class="fa fa-check-circle"></i> Acesso às fotos dos que tem interesse;</li>
			              <!-- <li> <i class="fa fa-check-circle"></i> Direito de receber recadinhos em suas fotos deixando-os públicos ou privados, ( as fotos poderão receber 20 recados cada)</li> -->
			              <li> <i class="fa fa-check-circle"></i> Direito ao Siga-me (Ser notificado quando alguém que você gosta ou está em contato)</li>
			            </ul>
			            <p>Lembrando que ao optar por este plano você terá 100% (cem porcento) do valor pago em reais convertido em Sugar Coins.</p>
					</div>
				</div>
				<div class="plan plan-gold">
					<div class="title">
						<i class="fa fa-users"></i> GOLD
					</div>
					<div class="highlight">
						<div class="white-line"></div>
						<p> Valores a partir de :</p>
						<div class="_col col-md-6 col-sm-12"> <div class="price" onclick="selectPlan('gold_baby_12')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "gold_baby_12") ?> / 12 meses</div> </div>
					</div>
					<!-- <div class="row m-0 p-0">
						{{-- <div class="_col col-md-6 col-sm-12"> <div class="price" onclick="selectPlan('gold_baby_3')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "gold_baby_3") ?> / 3 meses</div> </div> --}}
						<div class="_col col-md-4 col-sm-12"> <div class="price" onclick="selectPlan('gold_baby_6')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "gold_baby_6") ?> / 6 meses</div> </div>
						<div class="_col col-md-6 col-sm-12"> <div class="price" onclick="selectPlan('gold_baby_12')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "gold_baby_12") ?> / 12 meses</div> </div>
					</div> -->
					<div class="content">
						<ul>
						<li> <i class="fa fa-check-circle"></i> Direito a 5 fotos, moldura gold no seu perfil e a inclusão de 1 foto por dia, até o limite de 100 fotos;</li>
			              <!-- <li> <i class="fa fa-check-circle"></i> Direito à postagem de 2 vídeos; </li> -->
			              <!-- <li> <i class="fa fa-check-circle"></i> Incluir 1 vídeo por semana ( com um “tamanho” determinado por nós ) com limite de 20 vídeos</li> -->
			              <!-- <li> <i class="fa fa-check-circle"></i> Acesso à compra de moedinhas, com descontos especiais*</li> -->
			              <li> <i class="fa fa-check-circle"></i> Direito a mandar mensagens ilimitadas;</li>
			              <li> <i class="fa fa-check-circle"></i> Acesso nítido à todas as fotos;</li>
			              <li> <i class="fa fa-check-circle"></i> Enviar e solicitar o telefone ou contato via chat e poderá receber o contato de outro cliente premium;</li>
			              <li> <i class="fa fa-check-circle"></i> Acesso ao quem te viu, quem você vê;</li>
			              <!-- <li> <i class="fa fa-check-circle"></i> Acesso ao “Radar” ou Localizador,</li> -->
			              <li> <i class="fa fa-check-circle"></i> Acesso às fotos dos que tem interesse;</li>
			              <!-- <li> <i class="fa fa-check-circle"></i> Direito de receber recadinhos em suas fotos deixando-os públicos ou privados, ( as fotos poderão receber 20 recados cada)</li> -->
			              <li> <i class="fa fa-times-circle"></i> Direito ao Siga-me (Ser notificado quando alguém que você gosta ou está em contato)</li>
			            </ul>
			            <p>Lembrando que ao optar por esse plano, você terá 50%(cinquenta porcento) em reais convertido em Sugar Coins</p>												
					</div>
				</div>
			</div>
			@endif
		</section>