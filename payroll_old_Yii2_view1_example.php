<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->registerAssetBundle('yii\web\JqueryUiAsset');
$this->registerAssetBundle('yii\web\DatatablesAsset');

$this->title = 'Create New Crop/Farm Payrate Association';

?>

<script>
    $(document).ready(function() {
        var selected = -1;
        
        var table = $("#assocTable").DataTable( {
            "columns": [
                { "name": "id",
                  "title": "Id",
                  "type": "string",
                  className: "hidden id",
                  "searchable": false,
                },
                { "name": "farmname",
                  "title": "Farm Name",
                  "type": "html",
                  className: "all col-xs-4",
                  "orderable": true,
                },
				{ "name": "cropname",
                  "title": "Crop Name",
                  "type": "html",
                  className: "all col-xs-4",
                  "orderable": true,
                },
                { "name": "payrate",
                  "title": "Payrate",
                  "type": "numeric",
                  className: "hidden-xs hidden-sm",
                  "orderable": true,
                },
            ],
            "autoWidth": false,
            "order": [[ 1, "desc" ]],
            "paging": true,
            "pagingType": "numbers",
            "serverSide": false,
            "processing": false,
            select: {
                style: 'single',
            },
            responsive: {
                details: {
                    type: 'column'
                }
            },
            "iDisplayLength": 15,
            "oLanguage": {
                "sSearch": "",
                "sProcessing": "<img src='images/loaders/loader7.gif'>",
                "sZeroRecords": "No associations found based on your search criteria",
                "sEmptyTable": "No associations found",
                "sLengthMenu": "<select class='form-control input-sm pull-left'>"+
                    "<option value='15'>15</option>"+
                    "<option value='25'>25</option>"+
                    "<option value='50'>50</option>"+
                    "<option value='100'>100</option>"+
                    "</select>",
            },
			dom: "<'row'<'col-xs-6'l><'col-xs-6'f><'col-xs-12'tr>>" +
				"<'row'<'col-xs-12'p>>",
            "aaData": <?php echo json_encode($assocTable, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>,
        });
        
        //Register plug-in for column header select
        $.fn.dataTable.Api.register( 'column().title()', function () {
            var colheader = this.header();
            return $(colheader).text().trim();
        });
        
        $(".dataTables_filter input").attr("placeholder", "Search by any column here...");
        $(".dataTables_filter").attr("class", "pull-right");
        $("#msgQueueTable_paginate").attr("class", "pull-right");
        $(".field-scheduleform-indexstart").attr("class", "nopadding");
        $(".field-scheduleform-indexend").attr("class", "nopadding");
        $(".field-scheduleform-indexsite").attr("class", "nopadding");
        $(".dataTables_length").attr("class", "col-xs-6");
        $("#msgHistTable_wrapper .col-sm-6").attr("class", "col-xs-6");
        $("tbody .odd").attr("style", "background-color: #f1f1f1");
        $("tbody .odd").mouseenter(function() {
            $(this).attr("style", "background-color: #eaeaea");
        }).mouseleave(function() {
            $(this).attr("style", "background-color: #f1f1f1");
        });
        
        function format (d){
            var string = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
            var i = 0;
            
            table.columns().every( function(){
                var columnName = table.settings().init().columns[i].name;
                
                var hidden = $(".column-"+columnName).hasClass('hidden');
                var all = $(".column-"+columnName).hasClass('all');
                
                if(!hidden && !all){
                    string += '<tr class="tableExpand">'+
                        '<td><strong>'+table.column(i).title()+': </strong></td>'+
                        '<td>'+d[i]+'</td>'+
                    '</tr>';
                }
                i++;
            });
            
            string += '</table>';
            return string;
        }
        
        $("thead tr").attr("class", "info");
        
    });
    
</script>

<div class="row">
	<div class="site-index col-xs-10 col-xs-offset-1">
		<?php if($successMsg != ''){ ?>
			<div class="alert alert-success" role="alert">
				<strong><?= $successMsg ?></strong>
			</div>
		<?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title">
                    <span class="glyphicon glyphicon-share"></span>
                    <?= ($edit) ? 'Edit ' : 'Create New ' ?>Association
                </div>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'id' => 'new-crop-form',
                    'options' => ['class' => 'form-horizontal col-xs-offset-1 col-xs-10'],
                ]); ?>
                
                <div class="row">
					<div class="col-xs-12 input-pad">
						<?= $form->field($model, 'farmid', ['inputOptions' => ['autocomplete' => 'off']])->dropDownList([''=>'Select Farm'] + $farmOptions); ?>
                    </div>
					<div class="col-xs-12 input-pad">
						<?= $form->field($model, 'cropid', ['inputOptions' => ['autocomplete' => 'off']])->dropDownList([''=>'Select Crop'] + $cropOptions); ?>
                    </div>
					<div class="col-xs-12 input-pad">
                        <?= $form->field($model, 'pay', ['inputOptions' => ['autocomplete' => 'off']])->textInput(['type' => 'number', 'step'=>'0.01']) ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success pull-right', 'name' => 'Save']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
	<div class="site-index col-xs-10 col-xs-offset-1">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h6 class="panel-title"><span class="glyphicon glyphicon-briefcase"></span> Existing Associations</h6>
			</div>
			<div class="panel-body">
				<table id="assocTable" cellpadding="0" cellspacing="0" width="100%" class="table responsive table-bordered table-responsive table-striped table-hover"></table>
			</div>
		</div>
    </div>
</div>