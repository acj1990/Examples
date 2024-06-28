<?php
	
	$servername = "localhost";
	$username = "augres6_rpg";
	$password = "archangel1995%";
	$itemArray = [];
	$playerArray = [];
	$invSlotCount = 20;

	// Create connection
	$conn = new mysqli($servername, $username, $password);
	
	$sql = "SELECT * FROM augres6_rpg.items";
	$result = $conn->query($sql);
	
	foreach($result->fetch_all() as $row){
		array_push($itemArray, [trim($row[0]), trim($row[1]), trim($row[2]), trim($row[3]), trim($row[4]), trim($row[5]), trim($row[6]), trim($row[8]), trim($row[9]), trim($row[10]), trim($row[7]), trim($row[11]), trim($row[12])]);
	}
	
	$sqlPlyr = "SELECT * FROM augres6_rpg.players";
	$resultPlyr = $conn->query($sqlPlyr);
	
	foreach($resultPlyr->fetch_all() as $row){
		$percH = round((trim($row[3]) / trim($row[4]))*100, 0);
		$percS = round((trim($row[5]) / trim($row[6]))*100, 0);
		
		$hBar = '<div class="progress progressH">
			<div class="progress-bar progress-bar-danger progress-bar-striped active  perBarH" style="width:'.$percH.'%;" role="progressbar"
				aria-valuemin="0" aria-valuemax="100" aria-valuenow="'.$percH.'">
				<strong><div class="hBar textBig">('.trim($row[3]).' / '.trim($row[4]).') '.$percH.'%</div></strong>
			</div>
		</div>';
		
		$sBar = '<div class="progress progressS">
			<div class="progress-bar progress-bar-success progress-bar-striped active  perBarS" style="width:'.$percS.'%;" role="progressbar"
				aria-valuemin="0" aria-valuemax="100" aria-valuenow="'.$percS.'">
				<strong><div class="sBar textBig">('.trim($row[5]).' / '.trim($row[6]).') '.$percS.'%</div></strong>
			</div>
		</div>';
		
		array_push($playerArray, [trim($row[0]), trim($row[1]), trim($row[2]), $hBar, $sBar]);
	}
	
	// echo '<pre>';
	// var_dump();
	// echo '</pre>';
    
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="buttons.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<script src="bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js"></script>

<html>
    <head>
        <link rel='shortcut icon' href='favicons.ico' type='image/x-icon'/ >
        <style>
            body {
                padding-top: 10px;
                background-image: url('gmbg.jpg');
				background-attachment: fixed;
				background-size: cover;
            }
            .progress {
                border: 1px solid grey;
            }
            .btn {
                border: 1px solid grey;
            }
            .segment {
                border-radius: 5px;
                border: 1px solid grey;
            }
            .table {
                border: 1px solid grey;
            }
            .effD {
                margin-top: 0px;
                padding-top: 0px;
            }
            .pad {
                padding: 5px;
            }
			.textBig {
				font-size: 18px;
			}
			.textBigger {
				font-size: 25px;
			}
			.textSmall {
				font-size: 8px;
			}
			.white {
				color: white;
			}
			.gold {
				color: gold;
				margin-left: 5px;
			}
			.green {
				color: green;
				margin-left: 5px;
			}
			.blue {
				color: lightblue;
				margin-left: 5px;
			}
			.btn-xlarge {
				padding: 15px 25px;
				font-size: 18px;
				line-height: normal;
				-webkit-border-radius: 8px;
				-moz-border-radius: 8px;
				border-radius: 8px;
			}
			.progress {
				height: 35px;
			}
			.sBar {
				font-size: 18px;
				color: black;
				padding-top: 7px;
			}
			.hBar {
				font-size: 18px;
				color: black;
				padding-top: 7px;
			}
            .mright {
                margin-right: 10px;
            }
            .pbot {
                padding-bottom: 10px;
            }
            .wood {
                background-image: url('seamless-wood.jpg');
            }
            .modal-header {
                border-bottom: 1px solid lightgrey;
            }
            .modal-body {
                border-top: 1px solid lightgrey;
            }
            .invSlot {
                border: 1px solid lightgrey;
                min-height: 160px;
                min-width: 140px;
				max-width: 160px;
                background-color: black;
                cursor: pointer;
				padding: 5px;
            }
			.invSlot2 {
                border: 1px solid lightgrey;
                min-height: 160px;
                min-width: 140px;
				max-width: 160px;
                background-color: black;
                cursor: pointer;
				padding: 5px;
            }
			.selected {
				background-color: #CCCCCC !important;
			}
			.dataTables_filter input {
				width: 250px !important;
			}
			.dataTables_filter {
				font-size: 18px !important;
			}
			.datatables_length {
				font-size: 18px !important;
			}
        </style>
        <script>
            $(document).ready(function(){
				var selectedPlayer = '';
				var selectedItem = '';
				var playerDT = '';
				var itemCount = 1;
				
				$('#itemTable').DataTable({
					"aaData": <?php echo json_encode($itemArray); ?>,
					"select": true,
					"pageLength": 10,
					"lengthMenu": [5, 10, 25, 50, 100],
					"aoColumnDefs": [{
						"sTitle": "",
						"aTargets": [0],
						"className": "hidden"
					}, {
						"sTitle": "Quality",
						"aTargets": [1],
						"className": "col-sm-1"
					}, {
						"sTitle": "Material",
						"aTargets": [2],
						"className": "col-sm-1"
					}, {
						"sTitle": "Item",
						"aTargets": [3],
						"className": "col-sm-1"
					}, {
						"sTitle": "Tier",
						"aTargets": [4],
						"className": "col-sm-1 hidden-xs hidden-sm"
					}, {
						"sTitle": "Item Type",
						"aTargets": [5],
						"className": "col-sm-1 hidden-xs hidden-sm hidden-md"
					}, {
						"sTitle": "Speed",
						"aTargets": [6],
						"className": "col-sm-1 hidden-xs hidden-sm"
					}, {
						"sTitle": "Rating",
						"aTargets": [7],
						"className": "col-sm-1"
					}, {
						"sTitle": "Bonus",
						"aTargets": [8],
						"className": "col-sm-1 hidden-xs hidden-sm"
					}, {
						"sTitle": "Price",
						"aTargets": [9],
						"className": "col-sm-1 hidden-xs hidden-sm"
					}]
				});
				
				var itemTable = $('#itemTable').DataTable();
				
				$('#itemTable tbody').on('click', 'tr', function (){
					selectedItem = (itemTable.row(this).data()[0]);
				});
				
				function plrTable(){
					if(playerDT != ''){
						playerDT.destroy();
					}
					playerDT = $('#playerTable').DataTable({
						"processing" : true,
						"ajax" : {
							"type": "GET",
							"url" : "ajaxData.php?action=getplayerstats",
							dataSrc : ''
						},
						"select": true,
						"aoColumnDefs": [{
							"sTitle": "",
							"aTargets": [0],
							"className": "hidden"
						}, {
							"sTitle": "Player",
							"aTargets": [1],
							"className": "col-sm-1"
						}, {
							"sTitle": "Character",
							"aTargets": [2],
							"className": "col-sm-1"
						}, {
							"sTitle": "Health",
							"aTargets": [3],
							"className": "col-sm-2"
						}, {
							"sTitle": "Stamina",
							"aTargets": [4],
							"className": "col-sm-2"
						}]
					});
				}
				
				function commData(send){
					//var send = {key:'value', key:'value', key:'value'}
					
					$.ajax({
						type:"GET",
						cache:false,
						url:"ajaxData.php",
						data : send,
						success: function (html) {
							if(send.action == 'getplayeritemsgm'){
								console.log('Fetching player inventory');
								//Clear contents of all slots
								for(i = 0; i < <?= $invSlotCount ?>; i++){
									$("#invS"+i).html('');
								}
								
								//Assign item to slot
								var results = $.parseJSON(html);
								for(i = 0; i < results.length; i++){
									result = results[i];
									$("#invS"+i).html('Item Name:<br><div class="green">'+result.d+' '+result.e+'<br>'+result.f+'</div><div id="idcontainer" class="hidden">'+result.a+'</div>Item Type:<br><div class="blue">'+result.g+'</div>Value: <span class="gold">'+result.k+'</span><br>Effect: <span class="gold">'+result.j+'</span><br>Mastery: <span class="gold">'+result.l+'</span><br>Count: <span class="gold">'+result.b+'</span>');
								}
							} else if(send.action == 'getplayerhotbar'){
								//Clear contents of all slots
								for(i = 0; i < 4; i++){
									$("#hotB"+i).html('No Item');
								}
								
								//Assign item to slot
								var results = $.parseJSON(html);
								//window.alert(results.length);
								for(i = 0; i < results.length; i++){
									result = results[i];
									$("#hotB"+result.b).html('Item Name:<br><div class="green">'+result.e+' '+result.f+'<br>'+result.g+'</div><div id="idcontainer" class="hidden">'+result.a+'</div>Item Type:<br><div class="blue">'+result.h+'</div><br>Count: <span class="gold">'+result.d+'</span>');
								}
							} else {
								console.log(html);
								$("#AjaxModal").modal();
								$('#retMessage').html(html);
								//return html;
							}
						}
					});
				}
				
				plrTable();
				var playerTable = $('#playerTable').DataTable();
				
				$('#playerTable tbody').on('click', 'tr', function (){
                    selectedPlayer = (playerTable.row(this).data()[0]);
				});
				
				//Generate click functions for every inventory slot
				<?php
					$invSlot = 0;
                    while($invSlot < $invSlotCount){
                        echo '
							$("#invS'.$invSlot.'").on("click", function (e) {
								selectedItem = $("#invS'.$invSlot.' #idcontainer").html();
								if(selectedItem){
									$("#InvModal").modal("toggle");
									$("#ItemActionModal").modal("toggle");
								}
							});
						';
                        $invSlot++;
                    }
				?>
				
				$('#give').on('click', function (e) {
                    if(selectedPlayer != '' && selectedItem != ''){
						commData({action:'giveplayeritem', player:selectedPlayer, item:selectedItem, uses:3, count:itemCount});
					}
                });
				
				$('#giveItemCount').on('change', function () {
                    itemCount = $('#giveItemCount').val();
                });
				
				$('#view').on('click', function (e) {
                    if(selectedPlayer != ''){
						commData({action:'getplayeritemsgm', player:selectedPlayer});
						commData({action:'getplayerhotbar', player:selectedPlayer});
						$("#InvModal").modal();
					}
                });
				
				$('#removeItemSelected').on('click', function (e) {
                    if(selectedPlayer != '' && selectedItem != ''){
						commData({action:'removeplayeritemgm', player:selectedPlayer, item:selectedItem});
					}
					$("#ItemActionModal").modal("toggle");
					selectedItem = '';
                });
				
				$("#ItemActionModal").on("hidden.bs.modal", function () {
					selectedItem = '';
				});
				
				$('#reload').on('click', function (e) {
                    plrTable();
                });
            });
        </script>
    </head>
    <body>
		<br>
		<div class="col-sm-10 col-lg-10 col-sm-offset-1 col-lg-offset-1">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h6 class="panel-title">
                        <span class="glyphicon glyphicon-list"></span>
                        Game Items 
                        // Give Amount:
                        <select id="giveItemCount" class="">
                            <?php
                                $i = 1;
                                while($i < 101){
                                    echo '<option value="'.$i.'">'.$i.'</option>';
                                    $i++;
                                }
                            ?>
                        </select>
					</h6>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="pad">
							<table class="table responsive nowrap table-striped table-bordered col-sm-12" id="itemTable">
								
							</table>
						</div>
						<div class="pad">
							<button type="button" id="viewItem" class="btn btn-info disabled">View Item Sheet</button>
							<button type="button" id="give" class="btn btn-green">Give Item To Player</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-10 col-lg-10 col-sm-offset-1 col-lg-offset-1">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h6 class="panel-title"><span class="glyphicon glyphicon-edit"></span>
						Players
					</h6>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="pad">
							<table class="table responsive nowrap table-striped table-bordered col-sm-12" id="playerTable">
								
							</table>
						</div>
						<div class="pad">
							<button type="button" id="view" class="btn btn-info">View Player Inventory</button>
							<button type="button" id="edit" class="btn btn-warning disabled">Edit Player</button>
							<button type="button" id="reload" class="btn btn-blue">Reload Players</button>
							<button type="button" id="delete" class="btn btn-danger pull-right disabled">Delete Player</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-10 col-lg-10 col-sm-offset-1 col-lg-offset-1">
			<div class="panel panel-danger">
				<div class="panel-heading">
					<h6 class="panel-title"><span class="glyphicon glyphicon-edit"></span>
						Enemies
					</h6>
					Number of enemies: 
					<select id="setS2" class="mright">
						<?php
							$i = 0;
							while($i < 101){
								echo '<option value="'.$i.'">'.$i.'</option>';
								$i++;
							}
						?>
					</select>
					<button type="button" id="genEnemy" class="btn btn-success disabled">Populate Enemies</button>
					<button type="button" id="crtEnemy" class="btn btn-info pull-right disabled">Create New Enemy</button>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="pad">
							
						</div>
						<div class="pad">
							<button type="button" id="vEnemy" class="btn btn-info disabled">View Enemy Sheet</button>
							<button type="button" id="edEnemy" class="btn btn-warning disabled">Edit Enemy</button>
							<button type="button" id="atkEnemy" class="btn btn-danger disabled">Attack</button>
							<button type="button" id="defEnemy" class="btn btn-orange disabled">Defend</button>
							<button type="button" id="rmvEnemy" class="btn btn-danger pull-right disabled">remove Enemy</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<!--Modals-->
		<div id="InvModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content wood">
                    <div class="modal-header">
                        <strong class="textBig" style="opacity: 0.7;color: white;">Inventory</strong>
                        <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 0.6;">&times;</button>
                    </div>
                    <div class="modal-body col-sm-12 white">
						<h3 class=""><u>Hotbar:</u></h3>
						<div class="col-sm-3 pbot">
							<div class="invSlot2 white" id="hotB0">
							
							</div>
							<div class="col-centered">
								Main Hand
							</div>
						</div>
						<div class="col-sm-3 pbot">
							<div class="invSlot2 white" id="hotB1">
							
							</div>
							Off Hand
						</div>
						<div class="col-sm-3 pbot">
							<div class="invSlot2 white" id="hotB2">
							
							</div>
							Heal Item
						</div>
						<div class="col-sm-3 pbot">
							<div class="invSlot2 white" id="hotB3">
							
							</div>
							Stam Item
						</div>
						<br>
						<h3 class=""><u>Inventory:</u></h3>
                        <?php
                            $invSlot = 0;
                            while($invSlot < $invSlotCount){
                                echo '<div class="col-sm-3 pbot"><div class="invSlot textSmall white" id="invS'.$invSlot.'"></div></div>';
                                $invSlot++;
                            }
                        ?>
                    </div>
                    <div class="modal-footer">
                        
                    </div>
                </div>
            </div>
        </div>
		
		<div id="ItemActionModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2>Select Desired Action</h2>
                    </div>
                    <div class="modal-body">
                        <div class="row">
							<div class="col-sm-12">
								*(Remove Item will remove the entire stack)<br><br>
								<div class="col-sm-3">
									<button type="button" id="removeItemSelected" class="btn btn-danger btn-xlarge">Remove Item</button>
								</div>
								<div class="col-sm-3">
									<button type="button" data-dismiss="modal" class="btn btn-warning btn-xlarge">Cancel</button>
								</div>
								<!--<button type="button" id="block" class="btn btn-danger btn-xlarge">Destroy</button>-->
							</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        
                    </div>
                </div>
            </div>
        </div>
		
		<div id="AjaxModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
						Server Message: 
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body col-sm-12">
                        <h3 id="retMessage" class="col-sm-10 col-sm-offset-1"></h3>
                    </div>
                    <div class="modal-footer">
                        
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>