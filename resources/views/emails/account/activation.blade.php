<?php 
$firstParaMsg = ("Por favor confirme seu email dentro de $expirationTime horas, ou então seu cadastro se tornará inválido e você tera que se registrar novamente.");
?>
<table cellspacing="0" cellpadding="0" width="600" class="w320" style="border-collapse: collapse !important; font-family: Helvetica, Arial, sans-serif;">
	<tbody>
		<tr style="font-family: Helvetica, Arial, sans-serif;">
			<td class="header-lg" style="border-collapse: collapse; color: #4d4d4d; font-family: Helvetica, Arial, sans-serif; font-size: 32px; font-weight: 700; line-height: normal; padding: 35px 0 0; text-align: center;">
				<?= ( 'Confirme seu e-mail!' ) ?>
			</td>
		</tr>
		<tr style="font-family: Helvetica, Arial, sans-serif;">
			<td class="free-text" style="border-collapse: collapse; color: #777777; font-family: Helvetica, Arial, sans-serif; font-size: 14px; line-height: 21px; padding: 10px 60px 0px; text-align: center; width: 100% !important;">                    
				<?= ( "Para confirmar seu e-mail, por favor clique no botão abaixo." ) ?>
			</td>
		</tr>
		<tr style="font-family: Helvetica, Arial, sans-serif;">
			<td class="button" style="border-collapse: collapse; color: #777777; font-family: Helvetica, Arial, sans-serif; font-size: 14px; line-height: 21px; padding: 30px 0; text-align: center;">
				<div style="font-family: Helvetica, Arial, sans-serif;">
				<a href="<?= $activation_url ?>" style="-webkit-text-size-adjust: none; background-color: #9e140e; border-radius: 5px; color: #ffffff; display: inline-block; font-family: 'Cabin', Helvetica, Arial, sans-serif; font-size: 14px; font-weight: regular; line-height: 45px; mso-hide: all; text-align: center; text-decoration: none !important; width: 155px;"><?= ( 'Confirmar e-mail' ) ?></a></div>
			</td>
		</tr>
		<tr style="font-family: Helvetica, Arial, sans-serif;">
			<td class="free-text" style="border-collapse: collapse; color: #777777; font-family: Helvetica, Arial, sans-serif; font-size: 14px; line-height: 21px; padding: 10px 60px 0px; text-align: center; width: 100% !important;">                    
				<?= ( "Ou no link abaixo" ) ?>
			</td>
		</tr>
		<tr style="font-family: Helvetica, Arial, sans-serif;">
			<td class="button" style="border-collapse: collapse; color: #777777; font-family: Helvetica, Arial, sans-serif; font-size: 14px; line-height: 21px; padding: 30px 0; text-align: center;">
				<div style="font-family: Helvetica, Arial, sans-serif;">
				<a href="<?= $activation_url ?>" style=""><?= ( 'Confirmar e-mail' ) ?></a></div>
			</td>
		</tr>
		<tr style="font-family: Helvetica, Arial, sans-serif;">
			<td class="free-text" style="border-collapse: collapse; color: #777777; font-family: Helvetica, Arial, sans-serif; font-size: 18px; line-height: 21px; padding: 10px 60px 0px; text-align: center; width: 100% !important;">                    
				<?= e( $firstParaMsg ) ?>
			</td>
		</tr>
		<tr style="font-family: Helvetica, Arial, sans-serif;">
			<td class="free-text" style="border-collapse: collapse; color: #777777; font-family: Helvetica, Arial, sans-serif; font-size: 13px; line-height: 21px; padding: 10px 60px 0px; text-align: center; width: 100% !important;">                    
				<?= ('Você pode usar apenas seu endereço de email para acessar sua conta. Seus dados de acesso:') ?>
			</td>
		</tr>
		<tr>
			<td class="mini-container-right" style="border-collapse: collapse; color: #777777; font-family: Helvetica, Arial, sans-serif; font-size: 14px; line-height: 21px; padding: 10px 14px 10px 15px; text-align: center; width: 278px;">
				<table cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse !important; font-family: Helvetica, Arial, sans-serif;">
					<tbody>
						<tr style="font-family: Helvetica, Arial, sans-serif;">
							<td class="mini-block-padding" style="border-collapse: collapse; color: #777777; font-family: Helvetica, Arial, sans-serif; font-size: 14px; line-height: 21px; text-align: center;">
								<table cellspacing="0" cellpadding="0" width="100%" style="border-collapse: collapse !important; font-family: Helvetica, Arial, sans-serif;">
									<tbody>
										<tr style="font-family: Helvetica, Arial, sans-serif;">
											<td class="mini-block" style="background-color: #ffffff; border: 1px solid #e5e5e5; border-collapse: collapse; border-radius: 5px; color: #777777; font-family: Helvetica, Arial, sans-serif; font-size: 14px; line-height: 21px; padding: 12px 15px 15px; text-align: center; width: 253px;">
												<span class="header-sm" style="color: #4d4d4d; font-family : Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 700; line-height: 1.3; padding: 5px 0;">    <?= ( 'Detalhes do login' ) ?></span><br style="font-family:Helvetica, Arial, sans-serif;"> 
												<strong><?= ('Nome :') ?> </strong><?= e( $fullName ) ?><br>
												<strong><?= ('E-mail :') ?> </strong> <a href="<?= e( $email ) ?>" style="color: #2ba6cb; text-decoration: none;"><?= e( $email ) ?></a>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>