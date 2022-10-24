@if(!isPremiumUser() && !isAdmin())
<script>

	var minutes = <?= getFreeUserMaxSessionTime() ?>;
	var loggedDate = new Date("<?= getLastSeen() ?> UTC").getTime() + minutes * 60000;

	// Update the count down every 1 second
	var x = setInterval(function() {

		// Get today's date and time
		var now = new Date().getTime();

		// Find the distance between now and the count down date
		var distance = loggedDate - now;

		// Time calculations for days, hours, minutes and seconds
		var days = Math.floor(distance / (1000 * 60 * 60 * 24));
		var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
		var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
		var seconds = Math.floor((distance % (1000 * 60)) / 1000);

		// Display the result in the element with id="demo"
		document.getElementById("sessiontimer-minutos").innerHTML = (minutes < 10 ) ? "0" + minutes: minutes;
		document.getElementById("sessiontimer-segundos").innerHTML = (seconds < 10 ) ? "0" + seconds: seconds;;

		// Countdown finished, logout user
		if (distance <= 0) {
			clearInterval(x);
			// alert("Seu tempo de uso diário terminou.");
			document.getElementById("sessiontimer-minutos").innerHTML =  "00";
			document.getElementById("sessiontimer-segundos").innerHTML =  "00";
			// window.location.reload();
			document.getElementById("sessiontimer-message").innerHTML =  "Seu tempo de navegação terminou.";

		}

	}, 1000);
</script>
<style>
	.timer-title {
	    font-size: 20px;
	    color: #9e221f;
	    font-weight: bold;
	}

	.timer span {
		margin: 0px 5px;	   
		background: #403f3f;
	    padding: 15px 20px;
	    color: #FFF;
	    border-radius: 4px;
	}

	.timer {
	    padding: 12px 0px;
	    margin-top: 20px;
	}

	.timer-panel {
	    margin-top: 10px;
	    margin-bottom: 10px;
	}

	.timer-labels span {
	    margin: 6px;
	    font-size: 13px;
	    text-align: center;
	    width: 55px;
	    display: inline-block;
	}
	#sessiontimer-message {
	    color: #9e2320;
	    font-size: 18px;
	}
</style>
<div class="timer-panel">
	<div class="timer-title"> Tempo </div>
	<div class="timer">
		<span id="sessiontimer-minutos"></span>
		<span id="sessiontimer-segundos"></span>
	</div>
	<div class="timer-labels">
		<span class="label">minutos</span>
		<span class="label">segundos</span>
	</div>
	<div id="sessiontimer-message"></div>
</div>
@endif