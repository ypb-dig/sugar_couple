<!-- Page Heading -->
<h4><?= __tr('Gerenciar Cupons') ?></h4>
<!-- /Page Heading -->
<hr>
<form class="lw-ajax-form lw-form"  name="add_cupom_form" data-callback="onNewCupomCallback" method="post" action="<?= route('manage.configuration.write', ['pageType' => request()->pageType]) ?>">    
 	<div class="form-group">
		<label for="lwCupomName"><?= __tr('Nome') ?></label>
        <input type="text" class="form-control form-control-user" name="cupom_name" id="lwCupomName">
    </div>
 	<div class="form-group">
		<label for="lwPercentage"><?= __tr('Porcentagem de Desconto') ?></label>
        <input type="number" class="form-control form-control-user" name="cupom_percentage" id="lwPercentage">
    </div>
    <div class="form-group">
        <label for="lw_Plan"><?= __tr('Plano') ?></label>
        <select name="cupom_plan" class="form-control">
            <option value="">Selecione um plano</option>
            @foreach($plans as $planKey => $plan)
            <option value="{{$planKey}}"><?= $plan['title'] ?></option>
            @endforeach
        </select>
    </div>
	<!-- Update Button -->
    <a href class="lw-ajax-form-submit-action btn btn-primary btn-user lw-btn-block-mobile">
        <?= __tr('Adicionar') ?>
    </a>
    <!-- /Update Button -->
</form>
 <!-- Start of Page Wrapper -->
 <div class="row">
    <div class="col-xl-12 mb-4">
        <div class="card mb-4">
            <div class="card-body table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th><?= __tr('Nome') ?></th>
                            <th><?= __tr('Porcentagem') ?></th>   
                            <th><?= __tr('Plano') ?></th>                                                    
                            <th><?= __tr('Action') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!__isEmpty($cupons))
                            @foreach($cupons as $cupom)
                                <tr id="lw-cupom-row-<?= $cupom['_uid'] ?>">                                    
                                    <td><?= $cupom['name'] ?></td>
                                    <td><?= $cupom['percentage'] ?> %</td>
                                    <td><?= $plans[$cupom['plan']]['title'] ?></td>

                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-black dropdown-toggle lw-datatable-action-dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a data-callback="onDelete" data-method="post" class="dropdown-item lw-ajax-link-action" href="<?= route('manage.configuration.delete', ['pageType' => 'cupom','cupom' => $cupom['name']]) ?>"><i class="fas fa-trash-alt"></i> <?= __tr('Delete') ?></a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        @if(__isEmpty($cupons))
                            <tr>
                                <td colspan="7" class="text-center">
                                    <?= __tr('Não há cupons cadastrado.') ?>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- End of Page Wrapper -->
@push('appScripts')
<script>
    function onDelete(response) {
        //check reaction code is 1
        if (response.reaction == 1) {
            //apply class row fade in
            $("#lw-cupom-row-"+response.data.cupom_uid).addClass("lw-deleted-row");
        }
    }
</script>
@endpush
<script>
	function onNewCupomCallback(){
		$("form[name=add_cupom_form]").trigger("reset");
        setTimeout(function(){
            window.location.reload();
        }, 1000)
	}
</script>