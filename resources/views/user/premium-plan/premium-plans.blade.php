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
				<p> Use o site todos os dias, mas terá uma limitação de 5 ou 7 minutos por dia.  </p>
				<ul>
					<li> <i class="fa fa-check-circle"></i> Direito a uma foto no seu perfil </li>
					<li> <i class="fa fa-times-circle"></i> Direito de postar vídeos</li>
					<li> <i class="fa fa-check-circle"></i> Acesso à compra de moedinhas sem desconto*</li>
					<li> <i class="fa fa-check-circle"></i> Direito a mandar uma mensagem por dia </li>
					<li> <i class="fa fa-times-circle"></i> Acesso nítido às fotos </li>
					<li> <i class="fa fa-times-circle"></i> Mandar o telefone ou contato para ser contatado mas poderá receber o contato de outro </li>
					<li> <i class="fa fa-times-circle"></i> cliente premium </li>
					<li> <i class="fa fa-times-circle"></i> Acesso ao quem te viu quem você vê</li>
					<li> <i class="fa fa-times-circle"></i> Acesso à recadinhos nas fotos</li>
					<li> <i class="fa fa-times-circle"></i> Não terá direito de receber recadinhos em sua foto.</li>
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
					<div class="price" onclick="selectPlan('plantium_1')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "plantium_1") ?> / mês</div>
				</div>
				<div class="row m-0 p-0">
					<div class="_col col-md-6 col-sm-12"> <div class="price" onclick="selectPlan('plantium_3')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "plantium_3") ?>/ 3 meses</div> </div>
					<!-- <div class="_col col-md-4 col-sm-12"> <div class="price" onclick="selectPlan('plantium_6')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "plantium_6") ?> / 6 meses</div> </div> -->
					<div class="_col col-md-6 col-sm-12"> <div class="price" onclick="selectPlan('plantium_12')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "plantium_12") ?> / 12 meses</div> </div>
				</div>
				<div class="content">
					 <ul>
			              <li> <i class="fa fa-check-circle"></i> Direito a 20 fotos no seu perfil podendo escolher uma moldura nas fotos, que demonstra ser um “ RICH MAN”e a inclusão de 1 foto ou vídeo por dia, sem limite de fotos e vídeos e 1 foto privada por dia ao limite de 100 fotos privadas</li>
			              <li> <i class="fa fa-check-circle"></i> Acesso SC$ 1.500 por mês sem precisar pagar e super descontos especiais para a aquisição de mais moedas. Retorno de 100% do valor pago pela assinatura em SC$ (Sugar Coins), ou seja, por exemplo: SC$ 18.530 (plano anual);</li>
			              <li> <i class="fa fa-check-circle"></i> Direito a mandar mensagens ilimitadas, </li>
			              <li> <i class="fa fa-check-circle"></i> Acesso nítido à todas as fotos, </li>
			              <li> <i class="fa fa-check-circle"></i> Prioridade de mensagens (sua mensagem passará na frente das mensagens enviadas por outros planos);</li>
			              <li> <i class="fa fa-check-circle"></i> Enviar e solicitar o telefone ou contato para ser contatado, poderá receber o contato de outro cliente premium, </li>
			              <li> <i class="fa fa-check-circle"></i> Acesso ao “Quem te viu, quem você vê”</li>
			              <li> <i class="fa fa-check-circle"></i> Acesso ao “Radar” ou Localizador,</li>
			              <li> <i class="fa fa-check-circle"></i> Acesso às fotos dos que tem interesse, podendo deixar recados nas fotos emojis e etc...</li>
			              <li> <i class="fa fa-check-circle"></i> Direito de receber recadinhos em suas fotos deixando-os públicos ou privados, ( as fotos poderão receber 20 recados cada)</li>
			            </ul>
			            <p>Lembrando que ao optar pelo plano PLATINUM ANUAL, você terá 100% (cem porcento) do valor pago em reais convertido em Sugar Coins (SC$ 18.570 ).</p>
				</div>
			</div>
			<div class="plan plan-gold">
				<div class="title">
					<i class="fa fa-users"></i> GOLD
				</div>
				<div class="highlight">
					<div class="white-line"></div>
					<p> Valores a partir de :</p>
					<div class="price" onclick="selectPlan('gold_1')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "gold_1") ?> / mês</div>
				</div>
				<div class="row m-0 p-0">
					<div class="_col col-md-6 col-sm-12"> <div class="price"  onclick="selectPlan('gold_3')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "gold_3") ?> / 3 meses</div> </div>
					<!-- <div class="_col col-md-4 col-sm-12"> <div class="price" onclick="selectPlan('gold_6')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "gold_6") ?> / 6 meses</div> </div> -->
					<div class="_col col-md-6 col-sm-12"> <div class="price" onclick="selectPlan('gold_12')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "gold_12") ?> / 12 meses</div> </div>
				</div>
				<div class="content">
					<ul>
		              <li> <i class="fa fa-check-circle"></i> Direito a 5 fotos, com moldura gold, no seu perfil e a inclusão de 1 foto por dia, até o limite de 100 fotos, e uma foto privada por dia ao limite de 10 fotos.</li>
                        <li> <i class="fa fa-check-circle"></i> Direito à postagem de 2 vídeos; </li
		              <li> <i class="fa fa-check-circle"></i> Incluir 1 vídeos por semana ( com um “tamanho” determinado por nós ) com limite de 20 vídeos</li>
		              <li> <i class="fa fa-check-circle"></i> Acesso à compra de moedinhas, com descontos especiais*</li>
		              <li> <i class="fa fa-check-circle"></i> Direito a mandar mensagens ilimitadas, </li>
		              <li> <i class="fa fa-check-circle"></i> Acesso nítido à todas as fotos, </li>
		              <li> <i class="fa fa-check-circle"></i> Enviar e solicitar o telefone ou contato para ser contatado, poderá receber o contato de outro cliente premium, </li>
		              <li> <i class="fa fa-check-circle"></i> Acesso ao quem te viu, quem você vê</li>
		              <li> <i class="fa fa-check-circle"></i> Acesso ao “Radar” ou Localizador,</li>
		              <li> <i class="fa fa-check-circle"></i> Acesso às fotos dos que tem interesse, podendo deixar recados nas fotos emojis e etc...</li>
		              <li> <i class="fa fa-check-circle"></i> Direito de receber recadinhos em suas fotos deixando-os públicos ou privados, ( as fotos poderão receber 20 recados cada)</li>
		              <li> <i class="fa fa-times-circle"></i> Direito ao Siga-me (Ser notificado quando alguém que você gosta ou está em contato coloca uma foto nova, para poder comentar)</li>
		            </ul>
		            <p>Lembrando que ao optar pelo plano GOLD ANUAL, você terá 50% (cinquenta porcento) do valor pago em reais convertido em Sugar Coins (SC$ 6.470).</p>
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
						<div class="price" onclick="selectPlan('plantium_baby_1')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "plantium_baby_1") ?> / mês</div>
					</div>
					<div class="row m-0 p-0">
						<div class="_col col-md-6 col-sm-12"> <div class="price" onclick="selectPlan('plantium_baby_3')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "plantium_baby_3") ?> / 3 meses</div> </div>
						<!-- <div class="_col col-md-4 col-sm-12"> <div class="price" onclick="selectPlan('plantium_baby_6')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "plantium_baby_6") ?> / 6 meses</div> </div> -->
						<div class="_col col-md-6 col-sm-12"> <div class="price" onclick="selectPlan('plantium_baby_12')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "plantium_baby_12") ?> / 12 meses</div> </div>
					</div>
					<div class="content">
						<ul>
			              <li> <i class="fa fa-check-circle"></i> Direito a 20 fotos no seu perfil podendo escolher uma moldura nas fotos, que demonstra ser um “ RICH BB” ou um nível melhor, para atingir objetivos maiores... e a inclusão de 1 foto ou vídeo por dia, sem limite de fotos e vídeos,</li>
			              <li> <i class="fa fa-check-circle"></i> Acesso a SC$ 500,00 moedinhas, sem precisar pagar e super descontos especiais para a aquisição de mais moedasDireito a mandar mensagens ilimitadas, </li>
			              <li> <i class="fa fa-check-circle"></i> Acesso nítido à todas as fotos, </li>
			              <li> <i class="fa fa-check-circle"></i> Poderá mandar e solicitar o telefone ou contato para ser contatado, poderá receber o contato de outro cliente premium, </li>
			              <li> <i class="fa fa-check-circle"></i> Acesso ao quem te viu, quem você vê</li>
			              <li> <i class="fa fa-check-circle"></i> Acesso ao “Radar” ou Localizador,</li>
			              <li> <i class="fa fa-check-circle"></i> Acesso às fotos dos que tem interesse, podendo deixar recados nas fotos emojis e etc...</li>
			              <li> <i class="fa fa-check-circle"></i> Direito de receber recadinhos em suas fotos deixando-os públicos ou privados, ( as fotos poderão receber 20 recados cada)</li>
			              <li> <i class="fa fa-check-circle"></i> Direito ao Siga-me ( Ser notificado quando alguém que você gosta ou está em contato coloca uma foto nova, para poder comentar)</li>
			            </ul>
			            <p>Lembrando que ao optar por esse plano, você terá 100% (cem porcento) do valor pago em reais convertido em Sugar Coins (SC$ 5.630).</p>
					</div>
				</div>
				<div class="plan plan-gold">
					<div class="title">
						<i class="fa fa-users"></i> GOLD
					</div>
					<div class="highlight">
						<div class="white-line"></div>
						<p> Valores a partir de :</p>
						<div class="price" onclick="selectPlan('gold_baby_1')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "gold_baby_1") ?> / mês</div>
					</div>
					<div class="row m-0 p-0">
						<div class="_col col-md-6 col-sm-12"> <div class="price" onclick="selectPlan('gold_baby_3')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "gold_baby_3") ?> / 3 meses</div> </div>
						<!-- <div class="_col col-md-4 col-sm-12"> <div class="price" onclick="selectPlan('gold_baby_6')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "gold_baby_6") ?> / 6 meses</div> </div> -->
						<div class="_col col-md-6 col-sm-12"> <div class="price" onclick="selectPlan('gold_baby_12')"> <?= getPlanPrice($premiumPlanData['premiumPlans'], "gold_baby_12") ?> / 12 meses</div> </div>
					</div>
					<div class="content">
						<ul>
			              <li> <i class="fa fa-check-circle"></i> Direito a 5 fotos, com moldura gold, no seu perfil e a inclusão de 1 foto por dia, até o limite de 100 fotos e uma foto privada por dia ao limite de 10 fotos (poderá alterar as fotos quando completa)</li>
			              <li> <i class="fa fa-check-circle"></i> Direito à postagem de 2 vídeos; </li>
			              <li> <i class="fa fa-check-circle"></i> Incluir 1 vídeo por semana ( com um “tamanho” determinado por nós ) com limite de 20 vídeos</li>
			              <li> <i class="fa fa-check-circle"></i> Acesso à compra de moedinhas, com descontos especiais*</li>
			              <li> <i class="fa fa-check-circle"></i> Direito a mandar mensagens ilimitadas, </li>
			              <li> <i class="fa fa-check-circle"></i> Acesso nítido à todas as fotos, </li>
			              <li> <i class="fa fa-check-circle"></i> Poderá mandar e solicitar o telefone ou contato para ser contatado, poderá receber o contato de outro cliente premium, </li>
			              <li> <i class="fa fa-check-circle"></i> Acesso ao quem te viu, quem você vê</li>
			              <li> <i class="fa fa-check-circle"></i> Acesso ao “Radar” ou Localizador,</li>
			              <li> <i class="fa fa-check-circle"></i> Acesso às fotos dos que tem interesse, podendo deixar recados nas fotos emojis e etc...</li>
			              <li> <i class="fa fa-check-circle"></i> Direito de receber recadinhos em suas fotos deixando-os públicos ou privados, ( as fotos poderão receber 20 recados cada)</li>
			              <li> <i class="fa fa-times-circle"></i> Direito ao Siga-me (Ser notificado quando alguém que você gosta ou está em contato coloca uma foto nova, para poder comentar)</li>

			            </ul>
			            <p>Lembrando que ao optar por esse plano, você terá 50% (cinquenta porcento) do valor pago em reais convertido em Sugar Coins (SC$ 1.555).</p>												
					</div>
				</div>
			</div>
			@endif
		</section>