<?php

$this->title = 'Job Creation';
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;

$this->registerAssetBundle('yii\web\JqueryUiAsset');
$this->registerJsFile(\Yii::getAlias('@web').'/js/build/jquery.datetimepicker.full.min.js');
$this->registerCssFile(\Yii::getAlias('@web').'/css/jquery.datetimepicker.css');

$this->registerAssetBundle('yii\web\DatatablesAsset');

$this->registerJs(
    '$("textarea[id=clockinform-description]").keyup(function() {
        var curLength = $("textarea[id=clockinform-description]").val().length;
        var remLength = 500-curLength;
        $("#oCounter").text(remLength);
    });
	
	$("input[id=clockedtform-clockin]").datetimepicker({
        minuteStep: 30,
        formatTime: "g:i a",
		useCurrent: true
    });
	
	$("input[id=clockedtform-clockout]").datetimepicker({
        minuteStep: 30,
        formatTime: "g:i a",
		useCurrent: true
    });
');

?>

<script>
	$(document).ready(function() {
        var selected = -1;
		
        var oTable = $("#emplOTable").DataTable( {
            "columns": [
                { "name": "id",
                  "title": "Id",
                  "type": "string",
                  className: "hidden id",
                  "searchable": false,
                },
                { "name": "emplname",
                  "title": "Name",
                  "type": "html",
                  className: "all details-control column-name",
                  "orderable": true,
                },
                { "name": "manager",
                  "title": "Manager",
                  "type": "string",
                  className: "hidden-xs",
                  "orderable": true,
                },
            ],
            "autoWidth": false,
            "order": [[ 0, "asc" ]],
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
            "iDisplayLength": 5,
            "oLanguage": {
                "sSearch": "",
                "sProcessing": "<img src='images/loaders/loader7.gif'>",
                "sZeroRecords": "No employees found based on your search criteria",
                "sEmptyTable": "No employees found",
                "sLengthMenu": "<select class='form-control input-sm'>"+
                    "<option value='5'>5</option>"+
                    "<option value='10'>10</option>"+
                    "<option value='20'>25</option>"+
                    "<option value='50'>50</option>"+
                    "<option value='100'>100</option>"+
                    "</select>",
            },
            "aaData": <?php echo json_encode($emplOTable, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>,
        });
		
		var iTable = $("#emplITable").DataTable( {
            "columns": [
                { "name": "id",
                  "title": "Id",
                  "type": "string",
                  className: "hidden id",
                  "searchable": false,
                },
                { "name": "emplname",
                  "title": "Name",
                  "type": "html",
                  className: "all details-control column-name",
                  "orderable": true,
                },
				{ "name": "farm",
                  "title": "Farm",
                  "type": "string",
                  className: "hidden-xs",
                  "orderable": true,
                },
				{ "name": "crop",
                  "title": "Crop",
                  "type": "string",
                  className: "hidden-xs",
                  "orderable": true,
                },
				{ "name": "clockin",
                  "title": "Clock-In Time",
                  "type": "string",
                  className: "",
                  "orderable": true,
                },
            ],
            "autoWidth": false,
            "order": [[ 0, "asc" ]],
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
            "iDisplayLength": 5,
            "oLanguage": {
                "sSearch": "",
                "sProcessing": "<img src='images/loaders/loader7.gif'>",
                "sZeroRecords": "No employees found based on your search criteria",
                "sEmptyTable": "No employees found",
                "sLengthMenu": "<select class='form-control input-sm'>"+
                    "<option value='5'>5</option>"+
                    "<option value='10'>10</option>"+
                    "<option value='20'>25</option>"+
                    "<option value='50'>50</option>"+
                    "<option value='100'>100</option>"+
                    "</select>",
            },
            "aaData": <?php echo json_encode($emplITable, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>,
        });
		
		var rTable = $("#emplRTable").DataTable( {
            "columns": [
                { "name": "id",
                  "title": "Id",
                  "type": "string",
                  className: "hidden id",
                  "searchable": false,
                },
                { "name": "emplname",
                  "title": "Name",
                  "type": "html",
                  className: "all details-control column-name",
                  "orderable": true,
                },
				{ "name": "farm",
                  "title": "Farm",
                  "type": "string",
                  className: "hidden-xs",
                  "orderable": true,
                },
				{ "name": "crop",
                  "title": "Crop",
                  "type": "string",
                  className: "hidden",
                  "orderable": false,
                  "searchable": false,
                },
				{ "name": "cin",
                  "title": "Clock-In Time",
                  "type": "string",
                  className: "",
                  "orderable": true,
                },
				{ "name": "cout",
                  "title": "Clock-Out Time",
                  "type": "string",
                  className: "",
                  "orderable": true,
                },
				{ "name": "payrate",
                  "title": "Payrate",
                  "type": "string",
                  className: "hidden",
                  "orderable": false,
                  "searchable": false,
                },
				{ "name": "desc",
                  "title": "Description",
                  "type": "string",
                  className: "hidden",
                  "orderable": false,
                  "searchable": false,
                },
            ],
            "autoWidth": false,
            "order": [[ 0, "asc" ]],
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
            "iDisplayLength": 5,
            "oLanguage": {
                "sSearch": "",
                "sProcessing": "<img src='images/loaders/loader7.gif'>",
                "sZeroRecords": "No employees found based on your search criteria",
                "sEmptyTable": "No employees found",
                "sLengthMenu": "<select class='form-control input-sm'>"+
                    "<option value='5'>5</option>"+
                    "<option value='10'>10</option>"+
                    "<option value='20'>25</option>"+
                    "<option value='50'>50</option>"+
                    "<option value='100'>100</option>"+
                    "</select>",
            },
            "aaData": <?php echo json_encode($emplRTable, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>,
        });
        
        //Register plug-in for column header select
        $.fn.dataTable.Api.register( 'column().title()', function () {
            var colheader = this.header();
            return $(colheader).text().trim();
        });
        
        $(".dataTables_filter input").attr("placeholder", "Search by any column here...");
        $(".dataTables_filter").attr("class", "pull-right");
        $("#emplTable_paginate").attr("class", "pull-right");
        $(".field-scheduleform-indexstart").attr("class", "nopadding");
        $(".field-scheduleform-indexend").attr("class", "nopadding");
        $(".field-scheduleform-indexsite").attr("class", "nopadding");
        $(".dataTables_length").attr("class", "col-xs-6");
        $("#emplTable_wrapper .col-sm-6").attr("class", "col-xs-6");
        $("tbody .odd").attr("style", "background-color: #f1f1f1");
        $("tbody .odd").mouseenter(function() {
            $(this).attr("style", "background-color: #eaeaea");
        }).mouseleave(function() {
            $(this).attr("style", "background-color: #f1f1f1");
        });
        
        function format (d){
            var string = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
            var i = 0;
            
            oTable.columns().every( function(){
                var columnName = oTable.settings().init().columns[i].name;
                
                var hidden = $(".column-"+columnName).hasClass('hidden');
                var all = $(".column-"+columnName).hasClass('all');
                
                if(!hidden && !all){
                    string += '<tr class="tableExpand">'+
                        '<td><strong>'+oTable.column(i).title()+': </strong></td>'+
                        '<td>'+d[i]+'</td>'+
                    '</tr>';
                }
                i++;
            });
            
            string += '</table>';
            return string;
        }
        
        $('#emplTable').on('click', 'tbody', 'td.details-control', function(){
            var tr = $(this).closest('tr');
            var row = oTable.row( tr );
            var rowNum = row.index();
            
            if($(".expand-icon-"+rowNum).is(':visible')){
                if(row.child.isShown()){
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    row.child(format(row.data())).show();
                    tr.addClass('shown');
                }
                
                if($(".expand-icon-"+rowNum).hasClass('glyphicon-plus')){
                    $(".expand-icon-"+rowNum).removeClass('glyphicon-plus');
                    $(".expand-icon-"+rowNum).addClass('glyphicon-minus');
                } else {
                    $(".expand-icon-"+rowNum).removeClass('glyphicon-minus');
                    $(".expand-icon-"+rowNum).addClass('glyphicon-plus');
                }
            }
        });
        
        $("thead tr").attr("class", "info");
        var prevId = [];
        
		$('#emplOTable').on('mouseup', 'tbody tr td', function (e) {
			var numRecords = oTable.page.info().recordsTotal;
            
            if(($(this).hasClass('details-control')) || (!$(this).hasClass('details-control'))){
                if (numRecords > 0) {
                    var selectedId = oTable.cell(this, 'id:name').data();
                    
                    var selectedMsg = oTable.cell(this, 'message:name').data();
                    var canAlter = oTable.cell(this, 'canAlter:name').data();
                    $(this).parent().toggleClass('selected');
                    
					if ($('.selected').length > 0) {
                        $('#addOSelected').removeAttr('disabled');
                        
                        if($(this).parent().hasClass('selected')){
                            $('#clockinform-employees').val($('#clockinform-employees').val()+selectedId+'[,]');
                            prevId.push(selectedId);
                        } else {
                            var value = selectedId+'[,]';
                            $('#clockinform-employees').val($('#clockinform-employees').val().replace(value, ""));
                            prevId.splice($.inArray(selectedId, prevId),1);
                        }
                    } else {
                        // Disable "Display ..." buttons
                        $('#addOSelected').attr('disabled','disabled');
                        var value = selectedId+'[,]';
                        $('#clockinform-employees').val($('#clockinform-employees').val().replace(value, ""));
                        prevId.splice($.inArray(selectedId, prevId),1);
                    }
					
					var counting = $('#clockinform-employees').val().split("[,]").filter(function(v){return v !== ""}).length;
					$('#countOSelected').html(counting);
                    
                    e.stopPropagation();
                }
            }
        });
		
		$('#emplITable').on('mouseup', 'tbody tr td', function (e) {
			var numRecords = iTable.page.info().recordsTotal;
            
            if(($(this).hasClass('details-control')) || (!$(this).hasClass('details-control'))){
                if (numRecords > 0) {
                    var selectedId = iTable.cell(this, 'id:name').data();
                    
                    var selectedMsg = iTable.cell(this, 'message:name').data();
                    var canAlter = iTable.cell(this, 'canAlter:name').data();
                    $(this).parent().toggleClass('selected');
                    
					if ($('.selected').length > 0) {
                        $('#addISelected').removeAttr('disabled');
                        
                        if($(this).parent().hasClass('selected')){
                            $('#clockoutform-employees').val($('#clockoutform-employees').val()+selectedId+'[,]');
                            prevId.push(selectedId);
                        } else {
                            var value = selectedId+'[,]';
                            $('#clockoutform-employees').val($('#clockoutform-employees').val().replace(value, ""));
                            prevId.splice($.inArray(selectedId, prevId),1);
                        }
                    } else {
                        // Disable "Display ..." buttons
                        $('#addISelected').attr('disabled','disabled');
                        var value = selectedId+'[,]';
                        $('#clockoutform-employees').val($('#clockoutform-employees').val().replace(value, ""));
                        prevId.splice($.inArray(selectedId, prevId),1);
                    }
					
					var counting = $('#clockoutform-employees').val().split("[,]").filter(function(v){return v !== ""}).length;
					$('#countISelected').html(counting);
                    
                    e.stopPropagation();
                }
            }
        });
		
		$('#emplRTable').on('mouseup', 'tbody tr td', function (e) {
			var numRecords = rTable.page.info().recordsTotal;
            
            if(($(this).hasClass('details-control')) || (!$(this).hasClass('details-control'))){
                if (numRecords > 0) {
                    var selectedId = rTable.cell(this, 'id:name').data();
                    
                    var selectedMsg = rTable.cell(this, 'message:name').data();
                    var canAlter = rTable.cell(this, 'canAlter:name').data();
                    $(this).parent().toggleClass('selected');
                    
					if ($('.selected').length > 0) {
                        $('#editSelected').removeAttr('disabled');
                        $('#delRecordBtn').removeAttr('disabled');
						
						//Set edit records to last value clicked, flag for incompatible values
						var oldFarm = $("#clockedtform-farm").val();
						var oldCrop = $("#clockedtform-crop").val();
						var oldPayrate = $("#clockedtform-payrate").val();
						var oldDesc = $("#clockedtform-description").val();
						var oldCIn = $("#clockedtform-clockin").val().replace(/\-/g, "/").replace(/\:00/g, "");
						var oldCOut = $("#clockedtform-clockout").val().replace(/\-/g, "/").replace(/\:00/g, "");
						
						var newFarm = rTable.cell(this, 'farm:name').data();
						var newCrop = rTable.cell(this, 'crop:name').data();
						var newPayrate = rTable.cell(this, 'payrate:name').data();
						var newDesc = rTable.cell(this, 'desc:name').data();
						var newCIn = rTable.cell(this, 'cin:name').data().replace(/\-/g, "/").replace(/\:00/g, "");
						var newCOut = rTable.cell(this, 'cout:name').data().replace(/\-/g, "/").replace(/\:00/g, "");
						
						var farmConf = 'false';
						var cropConf = 'false';
						var payrateConf = 'false';
						var cInConf = 'false';
						var cOutConf = 'false';
						var descConf = 'false';
						
						if(oldFarm != '' && $("#clockedtform-farm").val().indexOf(newFarm) < 0 && $('.selected').length > 1){ farmConf = 'true'; }
						if(oldCrop != '' && $("#clockedtform-crop").val().indexOf(newCrop) < 0 && $('.selected').length > 1){ cropConf = 'true'; }
						if(oldPayrate != '' && oldPayrate != newPayrate && $('.selected').length > 1){ payrateConf = 'true'; }
						if(oldCIn != '' && oldCIn != newCIn && $('.selected').length > 1){ cInConf = 'true'; }
						if(oldCOut != '' && oldCOut != newCOut && $('.selected').length > 1){ cOutConf = 'true'; }
						if(oldDesc != '' && oldDesc != newDesc && $('.selected').length > 1){ descConf = 'true'; }
						
						$('#clockedtform-farm').val(newFarm+'[,]'+farmConf);
						$('#clockedtform-crop').val(newCrop+'[,]'+cropConf);
						$("#clockedtform-payrate").val(newPayrate+'[,]'+payrateConf);
						$("#clockedtform-clockin").val(newCIn+'[,]'+cInConf);
						$("#clockedtform-clockout").val(newCOut+'[,]'+cOutConf);
						$("#clockedtform-description").val(newDesc+'[,]'+descConf);
                        
                        if($(this).parent().hasClass('selected')){
                            $('#clockedtform-employees').val($('#clockedtform-employees').val()+selectedId+'[,]');
                            prevId.push(selectedId);
                        } else {
                            var value = selectedId+'[,]';
                            $('#clockedtform-employees').val($('#clockedtform-employees').val().replace(value, ""));
                            prevId.splice($.inArray(selectedId, prevId),1);
                        }
                    } else {
                        // Disable "Display ..." buttons
                        $('#editSelected').attr('disabled','disabled');
                        $('#delRecordBtn').attr('disabled','disabled');
                        var value = selectedId+'[,]';
                        $('#clockedtform-employees').val($('#clockedtform-employees').val().replace(value, ""));
                        prevId.splice($.inArray(selectedId, prevId),1);
                    }
					
					var counting = $('#clockedtform-employees').val().split("[,]").filter(function(v){return v !== ""}).length;
					$('#countRSelected').html(counting);
                    
                    e.stopPropagation();
                }
            }
        });
		
		$("#createjobform-start_time").on('change paste keyup', function(){
			if($("#createjobform-start_time").val() != '' && $("#createjobform-end_time").val() != ''){
				var hours = (Math.abs(Date.parse($("#createjobform-end_time").val().toString()) - Date.parse($("#createjobform-start_time").val().toString()))/1000/60/60).toFixed(2);
				$("#createjobform-hours").val(hours);
			}
		});
		
		$("#createjobform-end_time").on('change paste keyup', function(){
			if($("#createjobform-start_time").val() != '' && $("#createjobform-end_time").val() != ''){
				var hours = (Math.abs(Date.parse($("#createjobform-end_time").val().toString()) - Date.parse($("#createjobform-start_time").val().toString()))/1000/60/60).toFixed(2);
				$("#createjobform-hours").val(hours);
			}
		});
		
		$("#ssnModalBtn").on("click", function (e) {
			e.preventDefault();
			$("#ssnsearchform-ssn4").val('');
			$("#ajaxResponse").html('');
			$("#modalssn").modal("show");
			setTimeout(function(){
				$("#ssnsearchform-ssn4").focus();
			}, 500);
		});
		
		$("#ssnSearchBtn").on("click", function (e) {
			$('#ajaxResponse').html('');
			
			var form = $("#ssnSearchForm");

			$.ajax({
			   type: "POST",
			   url: "<?= Yii::$app->urlManager->createUrl('site/ssnsearch') ?>",
			   data: form.serialize(),
			   success: function(data)
			   {
				   var obj = jQuery.parseJSON(data);
				   
				   if(typeof obj['error'] !== 'undefined'){
					   $('#ajaxResponse').html('<p class="text-danger">'+obj['error']+'</p>');
					   $('#addOAjaxBtn').attr('disabled','disabled');
				   } else if(typeof obj['success'] !== 'undefined') {
					   $('#ajaxResponse').html('<p class="text-success">'+obj['info']+'</p>');
					   foundEmployee = obj['id'];
					   $('#addOAjaxBtn').removeAttr('disabled');
				   }
			   }
			});
		});
		
		$("#ssnsearchform-ssn4").on("keyup", function (e) {
			$('#ajaxResponse').html('');
			$("#addOAjaxBtn").attr('disabled','disabled');
		});
		
		$("#addOSelected").on("click", function (e) {
			e.preventDefault();
			
			//Reset Modal Inputs
			$("#clockinform-farm").val('');
			$("#clockinform-crop").val('');
			$("#clockinform-payrate").val('');
			$("#clockinform-description").val('');
			$("#ajaxResponse").html('');
			
			var timeToReturn = new Date();

			timeToReturn.setMilliseconds(Math.round(timeToReturn.getMilliseconds() / 1000) * 1000);
			timeToReturn.setSeconds(Math.round(timeToReturn.getSeconds() / 60) * 60);
			timeToReturn.setMinutes(Math.round(timeToReturn.getMinutes() / 15) * 15);
			var hours = timeToReturn.getHours();
			var minutes = timeToReturn.getMinutes();
			var ampm = hours >= 12 ? 'pm' : 'am';
			var dspHours = hours % 12;
			dspHours = dspHours ? dspHours : 12;
			minutes = minutes < 10 ? '0'+minutes : minutes;
			var strTime = dspHours + ':' + minutes + ampm;
			
			$("#roundedCurrTime").html(strTime);
			
			$("#modalO").modal("show");
			setTimeout(function(){
				$("#clockinform-farm").focus();
			}, 500);
		});
		
		$("#editSelected").on("click", function (e) {
			e.preventDefault();
			$('#clockedtform-action').val('edit');
			
			$('#edt-form').submit();
		});
		
		$("#delRecordBtn").on("click", function (e) {
			e.preventDefault();
			$('#clockedtform-action').val('delete');
			
			$('#edt-form').submit();
		});
		
		$("#addOAjaxBtn").on("click", function (e) {
			if(foundEmployee !== ""){
				var empls = $(".employees").val().split("[,]").filter(function(v){return v !== ""});
				var emplids = [];
				var cont = true;
				
				if(empls.length != 0){
					$.each(empls, function(key, value) {
						value = value.split("|").filter(function(v){return v !== ""});
						emplids.push(value[0]);
					});
					
					if($.inArray(foundEmployee, emplids) != -1){
						alert('Employee Selection conflicts with employee already added!');
						cont = false;
					}
				}
				
				if(cont == true){
					$("#createemassocform-addemployee").val(foundEmployee);
					$('#clockinform-employees').val(foundEmployee+'[,]');
					$("#addOAjaxBtn").attr('disabled','disabled');
					$("#modalssn").modal("hide");
					$("#addOSelected").click();
				}
			} else {
				alert("Error occurred while adding employee. Please try again.");
			}
		});
		
		
    });
    
</script>

<div class="row">
	<?php if($modelIn->hasErrors() || $modelOut->hasErrors() || $modelEdt->hasErrors()){ ?>
		<div class="col-xs-12 alert alert-danger">
			<ul>
				<?php
					if(count($modelIn->getErrors()) > 0){
						echo '<strong>Errors Clocking In Employees:</strong><br>';
						foreach($modelIn->getErrors() as $error){
							echo '<li>'.$error[0].'</li>';
						}
					}
					if(count($modelOut->getErrors()) > 0){
						echo '<strong>Errors Clocking Out Employees:</strong><br>';
						foreach($modelOut->getErrors() as $error){
							echo '<li>'.$error[0].'</li>';
						}
					}
					if(count($modelEdt->getErrors()) > 0){
						echo '<strong>Errors Editing Records:</strong><br>';
						foreach($modelEdt->getErrors() as $error){
							echo '<li>'.$error[0].'</li>';
						}
					}
				?>
			</ul>
		</div>
	<?php } elseif($successMsg != ''){ ?>
		<div class="alert alert-success" role="alert">
			<strong><?= $successMsg ?></strong>
		</div>
	<?php } ?>
	<div class="col-xs-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h6 class="panel-title"><span class="glyphicon glyphicon-edit"></span>
				Clock Employees In
				</h6>
			</div>
			<div class="panel-body">
				<div class="col-sm-12">
					<table id="emplOTable" cellpadding="0" cellspacing="0" width="100%" class="table responsive table-bordered table-responsive table-striped table-hover">
					</table>
					<div class="row">
						<div class="col-xs-12">
							<p>Employees Selected: <strong><span id="countOSelected">0</span></strong></p>
						</div>
					</div>
					<button class="btn btn-success pull-left" id="addOSelected" disabled="disabled">Clock In Selected</button>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h6 class="panel-title"><span class="glyphicon glyphicon-edit"></span>
				Clock Employees Out
				</h6>
			</div>
			<div class="panel-body">
				<div class="col-sm-12">
					<table id="emplITable" cellpadding="0" cellspacing="0" width="100%" class="table responsive table-bordered table-responsive table-striped table-hover">
					</table>
					
					<div class="row">
						<div class="col-xs-12">
							<p>Employees Selected: <strong><span id="countISelected">0</span></strong></p>
						</div>
					</div>
					<?php
						$form = ActiveForm::begin([
							'id' => 'out-form',
							'enableClientValidation'=>false,
							'options' => ['class' => ''],
						]);
						
						echo '<div class="hide">';
							echo $form->field($modelOut, 'employees')->hiddenInput(['class'=>'employees'])->label(false);
						echo '</div>';
						echo Html::submitButton('Clock Out Selected', ['class' => 'btn btn-success pull-left', 'id' => 'addISelected', 'name' => 'Save', 'disabled' => 'disabled']);
						
						ActiveForm::end();
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h6 class="panel-title"><span class="glyphicon glyphicon-edit"></span>
				Existing Records
				</h6>
			</div>
			<div class="panel-body">
				<div class="col-sm-12">
					<table id="emplRTable" cellpadding="0" cellspacing="0" width="100%" class="table responsive table-bordered table-responsive table-striped table-hover">
					</table>
					<div class="row">
						<div class="col-xs-12">
							<p>Employees Selected: <strong><span id="countRSelected">0</span></strong></p>
						</div>
					</div>
					<?php
					$form = ActiveForm::begin([
						'id' => 'edt-form',
						'enableClientValidation'=>false,
						'options' => ['class' => 'form-horizontal col-md-offset-2 col-md-8'],
					]);
					echo '<div class="hide">';
						echo $form->field($modelEdt, 'action')->hiddenInput(['class'=>'action'])->label(false);
						echo $form->field($modelEdt, 'employees')->hiddenInput(['class'=>'employees'])->label(false);
						echo $form->field($modelEdt, 'farm')->hiddenInput(['class'=>'farm'])->label(false);
						echo $form->field($modelEdt, 'crop')->hiddenInput(['class'=>'crop'])->label(false);
						echo $form->field($modelEdt, 'payrate')->hiddenInput(['class'=>'payrate'])->label(false);
						echo $form->field($modelEdt, 'clockin')->hiddenInput(['class'=>'clockin'])->label(false);
						echo $form->field($modelEdt, 'clockout')->hiddenInput(['class'=>'clockout'])->label(false);
						echo $form->field($modelEdt, 'description')->hiddenInput(['class'=>'description'])->label(false);
					echo '</div>';
					ActiveForm::end();
					?>
					<div class="btn-group">
						<button class="btn btn-success pull-left" id="editSelected" disabled="disabled">Edit Selected Records</button>
						<button class='btn btn-danger pull-left' id='delRecordBtn' disabled="disabled">Delete</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php 

Modal::begin([
	'header'=>'<h4>Clock Employees In</h4>',
	'id'=>'modalO',
	'size'=>'modal-md',
]);
	
	$form = ActiveForm::begin([
		'id' => 'in-form',
		'enableClientValidation'=>false,
		'options' => ['class' => 'form-horizontal col-md-offset-2 col-md-8'],
	]);
	
	echo '<div class="hide">';
		echo $form->field($modelIn, 'employees')->hiddenInput(['class'=>'employees'])->label(false);
	echo '</div>';
	
	echo $form->field($modelIn, 'farm', ['inputOptions' => ['autocomplete' => 'off']])->dropDownList([''=>'Select Farm'] + $farmOptions);
	echo $form->field($modelIn, 'crop', ['inputOptions' => ['autocomplete' => 'off']])->dropDownList([''=>'Select Crop'] + $cropOptions);
	echo $form->field($modelIn, 'payrate', ['inputOptions' => ['autocomplete' => 'off']])->textInput(['type' => 'number', 'step'=>'0.01']);
	echo $form->field($modelIn, 'description')->textArea();
	
	echo '<p><span id="oCounter">500</span> Description Characters Remaining</p>
		<p>Clock-In Time (rounded): <strong><span id="roundedCurrTime"></span></strong></p>
		<br><div class="form-group">';
		echo Html::submitButton('Clock Employees In', ['class' => 'btn btn-success', 'name' => 'Save']);
	echo '</div>';
	
	ActiveForm::end();

Modal::end();

?>