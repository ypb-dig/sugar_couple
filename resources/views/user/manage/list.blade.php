@section('page-title', __tr("Manage Users"))
@section('head-title', __tr("Manage Users"))
@section('keywordName', strip_tags(__tr("Manage Users")))
@section('keyword', strip_tags(__tr("Manage Users")))
@section('description', strip_tags(__tr("Manage Users")))
@section('keywordDescription', strip_tags(__tr("Manage Users")))
@section('page-image', getStoreSettings('logo_image_url'))
@section('twitter-card-image', getStoreSettings('logo_image_url'))
@section('page-url', url()->current())

<?php $userStatus = request()->status; ?>
 <!-- Page Heading -->
 <div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-200"><?= __tr('Gerenciar usuários') ?> <a href="<?= route('manage.user.add') ?>"><i class="fa fa-plus"></i></a></h1>

</div>
<div class="row">
	<div class="col-xl-12">
        <!-- card -->
		<div class="card mb-4">
            <!-- card body -->
			<div class="card-body">                            
                <ul class="nav nav-tabs">
                    <!-- Active Tab -->
                    <li class="nav-item">
                        <a class="nav-link <?= $userStatus == 1 ? 'active' : '' ?>" href="<?= route('manage.user.view_list', ['status' => 1]) ?>">
                            <?= __tr('Active') ?>
                        </a>
                    </li>
                    <!-- /Active Tab -->

                    <!-- Inactive Tab -->
                    <li class="nav-item">
                        <a class="nav-link <?= $userStatus == 2 ? 'active' : '' ?>" href="<?= route('manage.user.view_list', ['status' => 2]) ?>">
                            <?= __tr('Inactive') ?>
                        </a>
                    </li>
                    <!-- /Inactive Tab -->

                    <!-- Deleted Tab -->
                    <li class="nav-item">
                        <a class="nav-link <?= $userStatus == 5 ? 'active' : '' ?>" href="<?= route('manage.user.view_list', ['status' => 5]) ?>">
                            <?= __tr('Removidos') ?>
                        </a>
                    </li>
                    <!-- /Deleted Tab -->

                    <!-- Never Activated Tab -->
                    <li class="nav-item">
                        <a class="nav-link <?= $userStatus == 4 ? 'active' : '' ?>" href="<?= route('manage.user.view_list', ['status' => 4]) ?>">
                            <?= __tr('Never Activated') ?>
                        </a>
                    </li>
                    <!-- /Never Activated Tab -->

                    <!-- Blocked Tab -->
                    <li class="nav-item">
                        <a class="nav-link <?= $userStatus == 3 ? 'active' : '' ?>" href="<?= route('manage.user.view_list', ['status' => 3]) ?>">
                            <?= __tr('Blocked') ?>
                        </a>
                    </li>
                    <!-- /Blocked Tab -->

                    <!-- Aguardando Verificação Tab -->
                    <li class="nav-item">
                        <a class="nav-link <?= $userStatus == 7 ? 'active' : '' ?>" href="<?= route('manage.user.view_list', ['status' => 7]) ?>">
                            <?= __tr('Aguardando Aprovação') ?>
                        </a>
                    </li>
                    <!-- /Aguardando Verificação Tab -->

                     <!-- Reproved User  Tab -->
                    <li class="nav-item">
                        <a class="nav-link <?= $userStatus == 8 ? 'active' : '' ?>" href="<?= route('manage.user.view_list', ['status' => 8]) ?>">
                            <?= __tr('Reprovados') ?>
                        </a>
                    </li>
                    <!-- /Reproved Tab -->

                    
                </ul>
				<!-- table start -->
				<div class="lw-nav-content">
					<table class="table table-hover" id="lwManageUsersTable">
						<!-- table headings -->
						<thead>
							<tr>
								<th class="lw-dt-nosort"><?= __tr('Profile Picture') ?></th>
								<th><?= __tr('Full Name') ?></th>
								<th><?= __tr('Tipo') ?></th>
								<th><?= __tr('Username') ?></th>
								<th><?= __tr('Email') ?></th>
								<th><?= __tr('Created On') ?></th>
								<th><?= __tr('Action') ?></th>
							</tr>
						</thead>
						<!-- /table headings -->
						<tbody class="lw-datatable-photoswipe-gallery"></tbody>
					</table>
				<div>
                <!-- table end -->
			</div>
            <!-- /card body -->
		</div>
        <!-- /card -->        
	</div>
</div>
<!-- User Soft delete Container -->
<div id="lwUserSoftDeleteContainer" style="display: none;">
    <h3><?= __tr('Are You Sure!') ?></h3>
    <strong><?= __tr('You want to delete this user, it will be placed in deleted tab.') ?></strong>
</div>
<!-- User Soft delete Container -->

<!-- User Permanent delete Container -->
<div id="lwUserPermanentDeleteContainer" style="display: none;">
    <h3><?= __tr('Are You Sure!') ?></h3>
    <strong><?= __tr('You want to permanent delete this user.') ?></strong>
</div>
<!-- User Permanent delete Container -->

<!-- User Reactivation eamil Container -->
<div id="lwUserReactivationEmail" style="display: none;">
    <h3><?= __tr('Tem certeza') ?></h3>
    <strong><?= __tr('Deseja re-enviar email de ativação para este usuário?') ?></strong>
</div>
<!-- User Reactivation eamil Container -->

<script type="text/_template" id="usersProfilePictureTemplate">
	<img class="lw-datatable-profile-picture lw-dt-thumbnail lw-photoswipe-gallery-img lw-lazy-img" data-src="<%= __tData.profile_picture %>">
</script>

<script type="text/_template" id="verifiedUserTemplate">
	<div>
		<a target="_blank" href="<%= __tData.profile_url %>"><%= __tData.full_name %></a> 
		<% if(__tData.is_verified == 1) { %> &nbsp;&nbsp;&nbsp;<i class="fas fa-user-check text-info" title="Verified User"></i> <% } %> <% if(__tData.is_fake == 1) { %><i class="fas fa-user-secret" title="Fake User"></i> <% } %>
	</div>
</script>

<!-- Pages Action Column -->
<script type="text/_template" id="usersActionColumnTemplate">
	<% if(__tData.user_roles__id != 1 || true) { %>
		<!-- dropdown -->
		<div class="btn-group">
			<button type="button" class="btn btn-black dropdown-toggle lw-datatable-action-dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fas fa-ellipsis-v"></i>
			</button>
			<div class="dropdown-menu dropdown-menu-right">
				
				<% if(__tData.status != 3  && __tData.status != 7  && __tData.status != 8) { %>
					<!-- Edit Button -->
					<a class="dropdown-item" href="<%= __Utils.apiURL("<?= route('manage.user.edit', ['userUid' => 'userUid']) ?>", {'userUid': __tData._uid}) %>"><i class="far fa-edit"></i> <?= __tr('Edit') ?></a>
					<!-- /Edit Button -->

					<!-- Transaction Detail Button -->
					<a href class="dropdown-item" data-toggle="modal" data-user-uid='<%= __tData._uid %>' data-target="#userTransactionDialog" data-user-name="<%= __tData.full_name %>"><i class="far fa-edit"  id="lwTransactionDetailBtn"></i> <?= __tr('Transactions') ?></a>
					<!-- /Transaction Detail Button -->

					<% if(__tData.is_verified != 1 && __tData.status != 7  && __tData.status != 8 && __tData.user_roles__id != 1) { %>
						<!-- Verify User -->
						<a class="dropdown-item lw-ajax-link-action" data-callback="onSuccessAction" href="<%= __Utils.apiURL("<?= route('manage.user.write.verify', ['userUid' => 'userUid']) ?>", {'userUid': __tData._uid}) %>" data-method="post"><i class="fas fa-user-check"></i> <?= __tr('Verify') ?></a>
						<!-- /Verify User -->
					<% } %>					
				<% } %>
				<% if(__tData.status == 4 || __tData.status == 2) { %>
				
					<!-- Permanent delete button -->
					<a class="dropdown-item lw-ajax-link-action-via-confirm" data-confirm="#lwUserReactivationEmail"  data-method="post" data-action="<%= __Utils.apiURL("<?= route('manage.user.write.resend_activation_email', ['userUid' => 'userUid']) ?>", {'userUid': __tData._uid}) %>" data-callback="onSuccessAction" href data-method="post"><i class="fas fa-envelope"></i> <?= __tr('Reenviar e-mail de ativação') ?></a>
					<!-- /Permanent delete button -->

				<% } %>

				<% if(__tData.status == 4 || __tData.status == 2 || __tData.status == 8) { %>
				
					<!-- Permanent delete button -->
					<a class="dropdown-item lw-ajax-link-action-via-confirm" data-confirm="#lwUserPermanentDeleteContainer"  data-method="post" data-action="<%= __Utils.apiURL("<?= route('manage.user.write.permanent_delete', ['userUid' => 'userUid']) ?>", {'userUid': __tData._uid}) %>" data-callback="onSuccessAction" href data-method="post"><i class="fas fa-trash-alt"></i> <?= __tr('Delete') ?></a>
					<!-- /Permanent delete button -->

				<% } %>

				<% if(__tData.status == 5) { %>
					<!-- Permanent delete button -->
					<a class="dropdown-item lw-ajax-link-action-via-confirm" data-confirm="#lwUserPermanentDeleteContainer"  data-method="post" data-action="<%= __Utils.apiURL("<?= route('manage.user.write.permanent_delete', ['userUid' => 'userUid']) ?>", {'userUid': __tData._uid}) %>" data-callback="onSuccessAction" href data-method="post"><i class="fas fa-trash-alt"></i> <?= __tr('Delete') ?></a>
					<!-- /Permanent delete button -->

					<!-- Restore button -->
					<a class="dropdown-item lw-ajax-link-action" data-callback="onSuccessAction" href="<%= __Utils.apiURL("<?= route('manage.user.write.restore_user', ['userUid' => 'userUid']) ?>", {'userUid': __tData._uid}) %>" data-method="post"><i class="fas fa-trash-restore-alt"></i> <?= __tr('Restore') ?></a>
					<!-- /Restore button -->

					<!-- Block button -->
					<a class="dropdown-item lw-ajax-link-action" data-callback="onSuccessAction" href="<%= __Utils.apiURL("<?= route('manage.user.write.block_user', ['userUid' => 'userUid']) ?>", {'userUid': __tData._uid}) %>" data-method="post"><i class="fas fa-ban"></i> <?= __tr('Block') ?></a>
					<!-- /Block button -->
				<% } %>

				<!-- If status is other than delete -->
				<% if(__tData.status != 5 && __tData.status != 3 && __tData.status != 7  && __tData.status != 8) { %>

					<!-- Soft delete button -->
					<a class="dropdown-item lw-ajax-link-action-via-confirm" data-callback="onSuccessAction" data-confirm="#lwUserSoftDeleteContainer"  data-method="post" data-action="<%= __Utils.apiURL("<?= route('manage.user.write.soft_delete', ['userUid' => 'userUid']) ?>", {'userUid': __tData._uid}) %>" href data-method="post"><i class="fas fa-trash-alt"></i> <?= __tr('Soft Delete') ?></a>
					<!-- /Soft delete button -->

					<!-- Block button -->
					<a class="dropdown-item lw-ajax-link-action" data-callback="onSuccessAction" href="<%= __Utils.apiURL("<?= route('manage.user.write.block_user', ['userUid' => 'userUid']) ?>", {'userUid': __tData._uid}) %>" data-method="post"><i class="fas fa-ban"></i> <?= __tr('Bloquear') ?></a>
					<!-- /Block button -->

				<% } %>

				<% if((__tData.status == 7 || __tData.status == 8) && __tData.user_roles__id != 1) { %>
					<!-- Approve User -->
					<a class="dropdown-item lw-ajax-link-action" data-callback="onSuccessAction" href="<%= __Utils.apiURL("<?= route('manage.user.write.approve', ['userUid' => 'userUid']) ?>", {'userUid': __tData._uid}) %>" data-method="post"><i class="fas fa-user-check"></i> <?= __tr('Aprovar') ?></a>
					<!-- /Approve User -->
				<% } %>

				<% if(__tData.status == 7) { %>
					<!-- Reprove User -->
					<a class="dropdown-item lw-ajax-link-action" data-callback="onSuccessAction" href="<%= __Utils.apiURL("<?= route('manage.user.write.reject', ['userUid' => 'userUid']) ?>", {'userUid': __tData._uid}) %>" data-method="post"><i class="fas fa-user-check"></i> <?= __tr('Rejeitar') ?></a>
					<!-- /Reprove User -->
				<% } %>

				<!-- If status is blocked -->
				<% if(__tData.status == 3) { %>
					<!-- Unblock button -->
					<a class="dropdown-item lw-ajax-link-action" data-callback="onSuccessAction" href="<%= __Utils.apiURL("<?= route('manage.user.write.unblock_user', ['userUid' => 'userUid']) ?>", {'userUid': __tData._uid}) %>" data-method="post"><i class="fas fa-ban"></i> <?= __tr('Desbloquear') ?></a>
					<!-- /Unblock button -->
				<% } %>
			</div>
		</div>
	<% } %>
</script>
<!-- Pages Action Column -->

<!-- user transaction Modal-->
<div class="modal fade" id="userTransactionDialog" tabindex="-1" role="dialog" aria-labelledby="userTransactionModalLabel" aria-hidden="true">
 	<div class="modal-dialog modal-lg" role="document">
 		<div class="modal-content">
			<div id="lwUserTransactionContent"></div>
			<script type="text/_template" 
					id="lwUserTransactionTemplate" 
					data-replace-target="#lwUserTransactionContent"
					data-modal-id="#userTransactionDialog">
					<div class="modal-header">
						<h5 class="modal-title" id="userTransactionModalLabel"><?= __tr('User Transactions') ?> (<%= __tData.userName %>)</h5>
						<button class="close" type="button" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						<!-- user financial transaction table -->
						<table class="table table-hover" id="lwUserTransactionTable">
							<thead>
								<tr>
									<th>Data</th>
									<th>Status</th>
									<th>Valor</th>
									<th>Tipo</th>
									<th>Metodo</th>
									<th>Item</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
						<!-- user financial transaction table -->
					</div>
			</script>
		</div>
	</div>
</div>
<!-- / user transaction Modal-->
</div>
</div>
@push('appScripts')
<script>
	//user transaction dialog details
	__Utils.modalTemplatize('#lwUserTransactionTemplate', function(e, data) {
		return {
			'transactionData' :fetchUserTransactions(data), //fetch user transaction list data
			'userName' : data['userName']
		};
	}, function(e, myData) { });

	//fetch user transaction list data
	function fetchUserTransactions(data) {
		
		//transaction list data table columns data
		var userTransactionDtColumnsData = [
			{
				"name"      : "created_at",
				"orderable" : true
			},
			{
				"name"      : "formattedStatus",
				"orderable" : false
			},
			{
				"name"      : "formattedAmount",
				"orderable" : false
			},
			{
				"name"      : 'formattedCreditType',
				"orderable" : false
			},
			{
				"name"      : 'method',
				"orderable" : false
			},
			{
				"name"      : 'packageName',
				"orderable" : false
			}
		];

		_.defer(function() {
			dataTable('#lwUserTransactionTable', {
				url         : __Utils.apiURL("<?= route('manage.user.read.transaction_list', ['userUid' => 'userUid']) ?>", {'userUid':data['userUid']}),
				dtOptions   : {
					"searching": false,
					"order": [[ 0, 'desc' ]],
					"pageLength" : 10
				},
				columnsData : userTransactionDtColumnsData, 
				scope       : this
			});
		})
	}

	var dtColumnsData = [
        {
            "name"      : "_id",
            "template"  : '#usersProfilePictureTemplate'
        },
        {
            "name"      : "full_name",
            "orderable" : true,
            "template"  : '#verifiedUserTemplate'
        },
        {
            "name"      : "gender",
            "orderable" : true
        },
        {
            "name"      : "username",
            "orderable" : true
        },
        {
            "name"      : "email",
            "orderable" : true
        },
        {
            "name"      : "created_at",
            "orderable" : true
        },
        {
            "name"      : 'action',
            "template"  : '#usersActionColumnTemplate'
        }
    ],
    dataTableInstance;

    // Perform actions after delete / restore / block
	onSuccessAction = function (response) {
		reloadDT(dataTableInstance);
	};

	//for users list
    fetchUsers = function () {
    	dataTableInstance = dataTable('#lwManageUsersTable', {
	        url         : "<?= route('manage.user.read.list', ['status' => $userStatus ]) ?>",
	        dtOptions   : {
	            "searching": true,
	            "order": [[ 0, 'desc' ]],
	            "pageLength" : 10,
	            "drawCallback": function() {
					applyLazyImages();
				}
	        },
	        columnsData : dtColumnsData, 
	        scope       : this
	    });
    };

    fetchUsers();
</script>
@endpush