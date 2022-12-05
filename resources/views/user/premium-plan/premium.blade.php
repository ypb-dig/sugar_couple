 <!-- Page Heading -->
 <div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-200"><?= __tr('Premium') ?></h1>
</div>

<!-- payment successfully message -->
@if(session('success'))
<!--  success message when email sent  -->
<div class="alert alert-success alert-dismissible">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<?= session('message') ?>
</div>
<!--  /success message when email sent  -->
@endif
<!-- / payment successfully message -->
 
<!-- payment failed message -->
@if(session('error'))
<!--  danger message when email sent  -->
<div class="alert alert-danger alert-dismissible">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<?= session('message') ?>
</div>
<!--  /danger message when email sent  -->
@endif 
<!-- / payment failed message -->

<!--  success messages  -->
<div class="alert alert-success alert-dismissible fade show" id="lwSuccessMessage" style="display:none;"></div>
<!--  /success messages  -->

<!--  error messages  -->
<div class="alert alert-danger alert-dismissible fade show" id="lwErrorMessage" style="display:none;"></div>


<!-- card -->
<div class="card">
	<!-- card body -->
	<div class="card-body">
		@if($premiumPlanData['isPremiumUser'])
 			<div class="card-header text-center">
				<i class="fa fa-smile" aria-hidden="true"></i>
				<?= __tr('You have already purchased the premium plan') ?>
			</div>
 			<ul class="list-group list-group-flush">
				<li class="list-group-item">
					<?= __tr('Plan') ?>
					<span class="float-right"><?= $premiumPlanData['userSubscriptionData']['planTitle'] ?></span>
				</li>
				<li class="list-group-item">
					<?= __tr('Created On') ?>
					<span class="float-right"><?= $premiumPlanData['userSubscriptionData']['created_at'] ?></span>
				</li>
				<li class="list-group-item">
					<?= __tr('Expiry') ?>
					<span class="float-right"><?= $premiumPlanData['userSubscriptionData']['expiry_at'] ?></span>
				</li>
				<li class="list-group-item">
					<?= __tr('Price') ?>
					<span class="float-right"><?= $premiumPlanData['userSubscriptionData']['planPrice'].' '.__tr('Price') ?></span>
				</li>
				<li class="list-group-item">
					<?= __tr('Debited Credits') ?>
					<span class="float-right"><?= $premiumPlanData['userSubscriptionData']['debitedCredits'].' '.__tr('Credits') ?></span>
				</li>
			</ul>
		@else
		<div class="row">
			<div class="col-md-12">				
				<form class="lw-ajax-form lw-form float-md-right" method="post" action="<?= route('api.user.credit_wallet.apply.payment_cupom') ?>" data-callback="onCupomApplied" data-show-if="newChangeEmailRequestForm" data-show-processing="true" id="lwChangeEmailForm">
					<div class="form-inline">
						<input type="text" placeholder="Cupom de desconto" class="form-control" name="cupom"/>
						<button type="submit" class="btn btn-primary"> Aplicar </button>
					</div>
				</form>
			</div>
		</div>
		<script>
			function onCupomApplied(result){
				if(result.reaction == 1){
				  	//redirect to intendedUrl location
			        _.defer(function() {
			            window.location.reload();
			        })
				} else {
					console.info(result);
		            window.location.reload();

				}
			}
		</script>
 		<div class="row">
			<!-- premium plans block -->
 			<div class="col-md-12 lw-premium-plan-right-border_">
				<h4><?= __tr('Choose Duration Plan for Premium') ?></h4>
				@if(!__isEmpty($premiumPlanData['premiumPlans']))
				@include("user.premium-plan.premium-plans")
					<!-- show premium plan radio options -->
					<div class="btn-group-toggle mt-3 hide" data-toggle="buttons">
						@foreach($premiumPlanData['premiumPlans'] as $planKey => $plan)
 							@if($plan['enable'])
							<span class="btn lw-premium-plan-radio-option mt-2">
								<span class="float-left"><?= $plan['title'] ?></span>
								<input type="radio" name="select_plan" value="<?= $planKey ?>" class="lw-selected-plan" id="lwSelectedPlan_<?= $planKey ?>" data-plan-title="<?= $plan['title'] ?>" data-plan-price="<?= $plan['price'] ?>"/>
								<div  class="float-right">
									<?= __trn('__creditPrice__ Credit', '__creditPrice__ Credits', $plan['price'], [
										'__creditPrice__' => $plan['price']
									]) ?> 
								</div>
							</span>
							@endif
						@endforeach
					</div>
					<!-- / show premium plan radio options -->
					
					<!-- buy plan button -->
					<button  type="button" id="lwBuyPremiumPlanBtn" class="btn btn-lg btn-block btn-primary mt-5 hide"><?= __tr('Be Premium Now') ?></button>
					<!-- /buy plan button -->
				@else
 					<!-- info message -->
					<div class="alert alert-info">
						<?= __tr('There are no premium plans.') ?>
					</div>
					<!-- / info message -->
				@endif
			</div>
			<!-- /premium plans block -->
			 
			<!-- premium features block -->
			<div class="col-md-8 d-hide" style="display: none;">
				<?= __tr('Premium Features') ?>
				@if(!__isEmpty($premiumPlanData['premiumFeature']))
 					<!-- show premium plan features -->
					<div class="row mt-3 ml-2">
                        <!-- Discounts -->
                        <div class="col-sm-5 lw-premium-feature-item">
                            <div class="lw-premium-feature-item-icon">
                                <i class="fas fa-percent text-success fa-3x"></i>
                            </div>
                            <h6><?= __tr('Discounts on Gifts, Stickers & Profile Booster') ?></h6>
                        </div>
                        <!-- /Discounts -->
                        <!-- Discounts -->
                        <div class="col-sm-5 lw-premium-feature-item">
                            <div class="lw-premium-feature-item-icon">
                                <i class="fas fa-award text-primary fa-4x"></i>
                            </div>
                            <h6><?= __tr('Premium Badge') ?></h6>
                        </div>
                        <!-- /Discounts -->
                        <div class="col-sm-5 lw-premium-feature-item">
                            <div class="lw-premium-feature-item-icon">
                                <i class="fas fa-star fa-3x text-warning"></i>
                            </div>
                            <h6><?= __tr('Priority In Search Result & Random Users') ?></h6>
                        </div>
						@foreach($premiumPlanData['premiumFeature'] as $featureKey => $feature)
							@if(isset($feature['enable']) and $feature['enable'])
								<div class="col-sm-5 lw-premium-feature-item">
									<div class="lw-premium-feature-item-icon">
										<?= $feature['icon'] ?>
									</div>
									<h6><?= $feature['title'] ?></h6>
								</div>
							@endif
						@endforeach
					</div>
					<!-- / show premium plan features -->
				@else
				<!-- info message -->
				<div class="alert alert-info">
					<?= __tr('There are no premium features.') ?>
				</div>
				<!-- / info message -->
				@endif
			</div>
			<!-- /premium features block -->
		</div>
		@endif
	</div>
	<!-- /card body -->
</div>
<!-- /card -->

@if(getStoreSettings('enable_paypal'))
	<?php $appDebug =  config('app.debug'); ?>
	@if(getStoreSettings('use_test_paypal_checkout'))
		<script src="https://www.paypal.com/sdk/js?client-id=<?= getStoreSettings('paypal_checkout_testing_client_id') ?>&currency=<?= getStoreSettings('currency') ?>&debug=<?= (isset($appDebug) and $appDebug == 1) ? 'true' : 'false' ?>"></script>
	@else
		<script src="https://www.paypal.com/sdk/js?client-id=<?= getStoreSettings('paypal_checkout_live_client_id') ?>&currency=<?= getStoreSettings('currency') ?>&debug=<?= (isset($appDebug) and $appDebug == 1) ? 'true' : 'false' ?>"></script>
	@endif
@endif

@if(env('PAGSEGURO_AMBIENTE') == 'sandbox')
<script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js">
@else
<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js">
@endif
</script>

<!-- hidden select payment option input field -->
<input type="hidden" name="select_payment_method" id="lwSelectPaymentMethod"/>
<!-- / hidden select payment option input field -->

<!-- payment buttons -->
<div id="lwPaymentOptionModal">
	@if(getStoreSettings('enable_paypal'))
	<div id="paypal-button-container" style="width:286px"></div>
	@endif

	@if(getStoreSettings('enable_stripe'))
	<button class="lw-ajax-form-submit-action btn btn-user lw-btn-block-mobile lw-stripe-checkout-btn lw-stripe-payment-btn lw-payment-checkout-btn" title="<?= __tr('Stripe Payment') ?>"><i class="fab fa-stripe-s"></i> <?= __tr('Stripe') ?></button>
	@endif

	@if(getStoreSettings('enable_razorpay'))
	<button class="btn btn-light btn-user lw-payment-checkout-btn" id="lwRazorPayBtn" title="<?= __tr('Razorpay Payment') ?>"><i class="fas fa-registered"></i> <?= __tr('Razorpay') ?></button>
	@endif
</div>
<!-- / payment buttons -->


<!-- User Permanent delete Container -->
<div id="lwMsgContent"  style="display: none;"></div>
<script type="text/_template" id="lwBuyPremiumPlanContainer">
	<h3><?= __tr('Are You Sure!') ?></h3>
    <strong><?= __tr('You want to buy __selectedPlanTitle__ plan.', [
    '__selectedPlanTitle__' => '<%- __tData.selectedPlanTitle %>'
    ]) ?></strong>
</script>
<!-- User Permanent delete Container -->

<div class="modal" id="paymentModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h5 class="modal-title">Plano selecionado: <b class="selected-plan"></b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-footer text-center">
        <button type="button" class="btn btn-primary paypal" data-dismiss="modal">Paypal</button>
        <button type="button" class="btn btn-primary pagseguro" data-dismiss="modal">PagSeguro</button>
      </div>
    </div>
  </div>
</div>

<style>
	#paymentModal .modal-footer, #paymentModal modal-header{
		display: inline-block;
	}
</style>

@push('appScripts')
<script>
	//user transaction dialog details
	__Utils.modalTemplatize('#lwTransactionDetailTemplate', function(e, data) {
		return { 
            'financialTransactionData': data['financialTransaction']
        };
	}, function(e, myData) { });
	$(document).ready(function() {
		var enablePaypalCheckout = '<?= getStoreSettings('enable_paypal') ?>',
			enableRazorpayCheckout = '<?= getStoreSettings('enable_razorpay') ?>',
			useTestRazorpayCheckout = '<?= getStoreSettings('use_test_razorpay') ?>';

		//set on click select payment option
		$(".lw-stripe-checkout-btn").on('click', function() {
			$("#lwSelectPaymentMethod").val('stripe');
		});

		//by default hide payment options
		function showPaymentButton(selectedPlanTitle, selectedPlanPrice, selectedPlan, type){
			var packageUid = selectedPlan,
				packageName = selectedPlanTitle,
				packagePrice = selectedPlanPrice;

			sessionStorage.setItem('packageUid', packageUid);

			//on change show payment button options
			$("#paymentModal").hide();
				
			// showConfirmation($('#lwPaymentOptionModal').html(), null, {
			// 	buttons: [
			// 		Noty.button('Cancelar', 'btn btn-secondary btn-sm', function () {
			// 			//__Utils.viewReload();
			// 			return;
			// 		})
			// 	]
			// });

			/*************************************************************************************************************
			 RazorPay Payment on Click
			**************************************************************************************************************/
			if (enableRazorpayCheckout) {
				var razorpayKey =  null;
				if (useTestRazorpayCheckout) {
					razorpayKey = '<?= getStoreSettings('razorpay_testing_key') ?>';
				} else {
					razorpayKey = '<?= getStoreSettings('razorpay_live_key') ?>';
				}
					
				$("#lwRazorPayBtn").on('click', function() {
					try {
						var options = {
							"key": razorpayKey,
							"amount": getRazorPayAmount(packagePrice).toFixed(2), // 2000 paise = INR 20
							"currency": "<?= getStoreSettings('currency'); ?>",
							"name": packageName,
							handler: function (response) {
								if (!_.isEmpty(response.razorpay_payment_id)) {
									//before process on server disabled payment button block
									$("#lwPaymentOption").addClass('lw-disabled-block-content');
									//show loader before ajax request
									$(".lw-show-till-loading").show();
									var razorPayRequestUrl = __Utils.apiURL("<?= route('user.credit_wallet.write.razorpay.checkout') ?>");
									//post ajax request
									__DataRequest.post(razorPayRequestUrl, {
										'packageUid' : packageUid,
										'razorpayPaymentId' : response.razorpay_payment_id          
									}, function(response) {
										//handle callback event data
										handlePaymentCallbackEvent(response);
									});
								} else {
									// Show a cancel page, or return to cart
									//bind error message on div
									$("#lwErrorMessage").text('<?= __tr("Payment Failed") ?>');
									//show hide div
									$("#lwErrorMessage").toggle();
									_.delay(function() {
										//hide div
										$("#lwErrorMessage").toggle();
									}, 10000);
								}
							},
							"prefill": {
								"name": '<?= getUserAuthInfo('profile.full_name') ?>',
								"email": '<?= getUserAuthInfo('profile.email') ?>'
							},
							"theme": {
								"color": "#050505"
							},
							"modal": {
								ondismiss: function(e){}
							}
						};
						var rzp1 = new Razorpay(options); // will inherit key and image from above.
						rzp1.open();
					} catch (error) {
						//bind error message on div
						alert(error.message);
					}
				});
			}

			//if paypal button instance available then remove from dom else create instance
			if (!_.isEmpty($("#paypal-button-container").html())) {
				$("#paypal-button-container").empty();
			}

			//paypal payment button script js
			/*************************************************************************************************************
			 Paypal Payment on Click
			**************************************************************************************************************/
			if (enablePaypalCheckout && type == "paypal") {
				try {
					paypal.Buttons({
						style: {
							color:  'blue',
			                shape:  'pill',
			                label:  'pay',
			                height: 40
						},
						createOrder: function(data, actions) {
							// This function sets up the details of the transaction, including the amount and line item details.
							return actions.order.create({
								purchase_units: [{
									amount: {
										value: packagePrice
									}
								}]
							});
						}, 
						onApprove: function(data, actions) {
							//before process on server disabled payment button block
							$("#lwPaymentOption").addClass('lw-disabled-block-content');
							//show loader before ajax request
							$(".lw-show-till-loading").show();
							// This function captures the funds from the transaction.
							return actions.order.capture().then(function(details) {
								var requestUrl = __Utils.apiURL("<?= route('user.credit_wallet.write.paypal_plan_transaction_complete', ['planId' => 'planId']) ?>", {'planId': packageUid});

								//post ajax request
								__DataRequest.post(requestUrl, details, function(response) {
									console.log(response);
									//handle callback event data
									handlePaymentCallbackEvent(response);
								});
							});
						},onError: function (err) {
							// Show an error page here, when an error occurs
							alert(err.message);
						},onCancel: function (data) {
							// Show a cancel page, or return to cart
							//bind error message on div
							$("#lwErrorMessage").text('<?= __tr("Payment Canceled by User") ?>');
							//show hide div
							$("#lwErrorMessage").toggle();
							_.delay(function() {
								//hide div
								$("#lwErrorMessage").toggle();
							}, 10000);
						}
					}).render('#paypal-button-container');
				} catch (error) {
				 	/****Add Stuff error.message ****/
					if ('<?= getStoreSettings('enable_paypal') ?>') {
						__Utils.error('<?= __tr('Something went wrong with paypal checkout, please contact to administrator.') ?>');
					}
				}
				if(packagePrice == 0){
					var requestUrl = __Utils.apiURL("<?= route('user.credit_wallet.write.paypal_plan_transaction_complete', ['planId' => 'planId']) ?>", {'planId': packageUid});

						//post ajax request
						__DataRequest.post(requestUrl, {id: "free"}, function(response) {
							//handle callback event data
							handlePaymentCallbackEvent(response);
						});
				} else {
					$("iframe").contents().find(".paypal-button[data-funding-source=card]").click();
				}
			}

			if(type == "pagseguro"){
				var requestUrl = '<?= route('pagseguro.checkout') ?>',
					formData = {
						itemId1: packageUid,
					    itemDescription1: selectedPlanTitle,
					    itemAmount1: '1',
					    itemPrice1: packagePrice
					};


				if(packagePrice == 0){
					var requestUrl = __Utils.apiURL("<?= route('user.credit_wallet.write.paypal_plan_transaction_complete', ['planId' => 'planId']) ?>", {'planId': packageUid});

						//post ajax request
						__DataRequest.post(requestUrl, {id: "free"}, function(response) {
							//handle callback event data
							handlePaymentCallbackEvent(response);
						});
						return;
				}

				//post ajax request
				__DataRequest.post(requestUrl, formData, function(response) {

					console.log("Pagseguro", response);

				  	PagSeguroLightbox(response, {
				        success: function(result){
				        	console.log("Sucess:", result);
							var details = {id: result};				        	
				        	var requestUrl = __Utils.apiURL("<?= route('user.credit_wallet.write.pagseguro_plan_transaction_complete', ['planId' => 'planId']) ?>", {'planId': packageUid});

							//post ajax request
							__DataRequest.post(requestUrl, details, function(response) {
								//handle callback event data
								console.log("Aqui bobão:", response);
								handlePaymentCallbackEvent(response);
							});
				        },
				        abort: function(result){
				        	console.log("Abort", result);
			        		$("#lwErrorMessage").text('<?= __tr("Payment Canceled by User") ?>');
							//show hide div
							$("#lwErrorMessage").toggle();
							_.delay(function() {
								//hide div
								$("#lwErrorMessage").toggle();
							}, 10000);
				        }
				    });
				});
			}

		};

	//on success callback
	function onSuccessCallback(responseData) {
		var reactionCode = responseData.reaction,
			selectPaymentMethod = $("#lwSelectPaymentMethod").val(),
			enableStripe = "<?= getStoreSettings('enable_stripe'); ?>";
		//check reaction code
		if (reactionCode == 1 && enableStripe && selectPaymentMethod == 'stripe') {
			var requestData = responseData.data.stripeSessionData,
				useTestStripe = "<?= getStoreSettings('use_test_stripe'); ?>",
				stripePublishKey = '';
			
			//check is testing or live
			if (useTestStripe) {
				stripePublishKey = "<?= getStoreSettings('stripe_testing_publishable_key'); ?>";
			} else {
				stripePublishKey = "<?= getStoreSettings('stripe_live_publishable_key'); ?>";
			}

			//create stripe instance
			var stripe = Stripe(stripePublishKey);

			//check request id is not undefined
			if (typeof requestData.id !== "undefined") {
				stripe.redirectToCheckout({
					// Make the id field from the Checkout Session creation API response
					// available to this file, so you can provide it as parameter here
					sessionId: requestData.id
					}).then(function (result) {
					// If `redirectToCheckout` fails due to a browser or network
					// error, display the localized error message to your customer
					// using `result.error.message`.
					//bind error message on div
					$("#lwErrorMessage").text(result);
					//show hide div
					$("#lwErrorMessage").toggle();
					_.delay(function() {
						//hide div
						$("#lwErrorMessage").toggle();
					}, 10000);
				});
			}
		} else {
			//bind error message on div
			$("#lwErrorMessage").text(responseData.data.errorMessage);
			//show hide div
			$("#lwErrorMessage").toggle();
			_.delay(function() {
				//hide div
				$("#lwErrorMessage").toggle();
			}, 10000);
		}
	}

	//transaction list data table columns data
	var dtColumnsData = [
		{
			"name"      : "created_at",
			"orderable" : true
		},
		{
			"name"      : "formattedTransactionType",
			"orderable" : false
		},
		{
			"name"      : 'credits',
			"orderable" : true
		},
        {
            "name"      : 'action',
            "template"  : '#transactionDetailsActionColumnTemplate'
        }
	],
	transactionListDataTable = '';

	//fetch transaction list data
	function fetchTransactionList() {
		transactionListDataTable = dataTable('#lwUserTransactionTable', {
			url         : "<?= route('user.credit_wallet.read.wallet_transaction_list') ?>",
			dtOptions   : {
				"searching": false,
				"order": [[ 0, 'desc' ]],
				"pageLength" : 10,
				rowCallback : function(row, data, index) {
					$('td:eq(2)', row).css("text-align", "right")
				}
			},
			columnsData : dtColumnsData, 
			scope       : this
		});
	}

	//load transaction list data function
	fetchTransactionList();

	/**
	 * reload data table
	 *
	 *-------------------------------------------------------- */
	reloadTransactionTable = function () {
		reloadDT(transactionListDataTable);
	};

	/**
	 * get razor pay amount
	 *
	 *-------------------------------------------------------- */
	function getRazorPayAmount(amount)
    {
        return amount * 100;
	}
	
	/**
	 * handle callback event data hide/show data
	 *
	 *-------------------------------------------------------- */
	function handlePaymentCallbackEvent(response) {
		//hide payment options
		$("#lwPaymentOption").hide();
		//hide loader after ajax request complete
		$(".lw-show-till-loading").hide();
		//after process on server enable payment button block
		$("#lwPaymentOption").removeClass('lw-disabled-block-content');
		//check reaction code is 1
		if (response.reaction == 1) {
			//show confirmation 
			showConfirmation('Pagamento realizado com sucesso', null, {
				buttons: [
					Noty.button('<?= __tr('Reload to Update') ?>', 'btn btn-secondary btn-sm', function () {
						__Utils.viewReload();
						return;
					})
				]
			});
			//load transaction list data function
			_.defer(function() {
				reloadTransactionTable();
			});
			//bind error message on div
			$("#lwSuccessMessage").text(response.data.message);
			//show div
			$("#lwSuccessMessage").toggle();
			_.delay(function() {
				//hide div
				$("#lwSuccessMessage").toggle();
			}, 10000);
		} else {
			//bind error message on div
			$("#lwErrorMessage").text(response.data.errorMessage);
			//show hide div
			$("#lwErrorMessage").toggle();
			_.delay(function() {
				//hide div
				$("#lwErrorMessage").toggle();
			}, 10000);
		}
	}

		//getPremium plan data
		var premiumPlan = JSON.parse('<?= json_encode($premiumPlanData['premiumPlans']) ?>'),
			isPlanSelected = false,
			selectedPlanPrice = selectedPlan = selectedPlanTitle = null;

		//premium plan array on change bind value and disable input price filed start
		_.forEach(premiumPlan, function(value, key) {
			var isPlanSelected = $("#lwSelectedPlan_"+key).is(':checked');
			//check if plan not selected then disable true buy button
			if (!isPlanSelected) {
				$("#lwBuyPremiumPlanBtn").attr("disabled", true);
			}

			//on change select plan radio option
			$("#lwSelectedPlan_"+key).on('change', function() {
				
				//on change show payment button options
				$("#lwPaymentOption").show();

				selectedPlan = $(this).val();
				selectedPlanTitle = $(this).attr('data-plan-title').replace("(SDD / SMM)", "").replace("(SBB)", "");
				selectedPlanPrice = Number($(this).attr('data-plan-price'));
				isPlanSelected = $("#lwSelectedPlan_"+key).is(':checked');
				
				//check if plan selected then disable false buy button
				if (isPlanSelected) {
					$("#lwBuyPremiumPlanBtn").attr("disabled", false);
				}
			});
		});

		//buy premium plan on click
		$("#lwBuyPremiumPlanBtn").on('click', function() {
			//get Selected Plan
			var totalUserCredits = '<?= totalUserCredits() ?>';
				lwMsgContentDiv = $("#lwMsgContent"),
				compiled = _.template($('#lwBuyPremiumPlanContainer').html());
				//append value on div
				lwMsgContentDiv.html(compiled({'selectedPlanTitle': selectedPlanTitle}));
			
				// if (selectedPlanPrice > totalUserCredits) {
				// 	//show confirmation text
				// 	var errorText = '<?= __tr('Your credit balance is too low, please purchase credits') ?>';
				// 	showConfirmation(errorText, function() {
				// 		//redirect to buy credits package view
				// 		window.location.href = '<?= route('user.credit_wallet.read.view') ?>';
				// 	});
				// } else {
				//check is plan selected
				if (!_.isEmpty(selectedPlan)) {

					if(selectedPlanPrice == 0) {
						var requestUrl = __Utils.apiURL("<?= route('user.credit_wallet.write.paypal_plan_transaction_complete', ['planId' => 'planId']) ?>", {'planId': selectedPlan});

						//post ajax request
						__DataRequest.post(requestUrl, {id: "free"}, function(response) {
							console.log(response);
							//handle callback event data
							handlePaymentCallbackEvent(response);
						});

						return;
					}
					//show confirmation 
					//showConfirmation($("#lwMsgContent"), function() {
					$("#paymentModal .selected-plan").html(selectedPlanTitle);

					$("#paymentModal").modal("show");

					$("#paymentModal button.paypal").off("click").click(function(){
						showPaymentButton(selectedPlanTitle, selectedPlanPrice, selectedPlan, "paypal");
					});

					$("#paymentModal button.pagseguro").off("click").click(function(){
						showPaymentButton(selectedPlanTitle, selectedPlanPrice, selectedPlan, "pagseguro");
					});

						
						// var requestUrl = '<?= route('user.premium_plan.write.buy_premium_plan') ?>',
						// 	formData = {
						// 		'select_plan' : selectedPlan
						// 	};					
						// //post ajax request
						// __DataRequest.post(requestUrl, formData, function(response) {
						// });
					//});
				}
			// }
		});
	});
	
</script>
@endpush