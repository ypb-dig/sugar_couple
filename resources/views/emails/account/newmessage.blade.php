<?php 
$title = ('Você tem uma Nova Mensagem!');
?>
<table cellspacing="0" cellpadding="0" width="600" class="w320" style="border-collapse: collapse !important; font-family: Helvetica, Arial, sans-serif;">
	<tbody>
		<tr style="font-family: Helvetica, Arial, sans-serif;">
			<td class="header-lg" style="border-collapse: collapse; color: #4d4d4d; font-family: Helvetica, Arial, sans-serif; font-size: 32px; font-weight: 700; line-height: normal; padding: 35px 0 0; text-align: center;">
				<?= e( $title ) ?>
			</td>
		</tr>
		<tr style="font-family: Helvetica, Arial, sans-serif;">
			<td class="free-text" style="border-collapse: collapse; color: #777777; font-family: Helvetica, Arial, sans-serif; font-size: 14px; line-height: 21px; padding: 10px 60px 0px; text-align: center; width: 100% !important;">                    
				Olá <?= $firstName ?>!<br>
				O <?= $visitorName ?> quer conversar com você.	
			</td>
		</tr>
		<tr style="font-family: Helvetica, Arial, sans-serif;">
			<td class="button" style="border-collapse: collapse; color: #777777; font-family: Helvetica, Arial, sans-serif; font-size: 14px; line-height: 21px; padding: 30px 0; text-align: center;">
				<div style="font-family: Helvetica, Arial, sans-serif;">
				<a href="<?= $url ?>" style=""><?= ( 'Clique aqui e não deixe esperando' ) ?></a></div>
			</td>
	</tbody>
</table>