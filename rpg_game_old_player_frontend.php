<?php
    
    $invSlotCount = 20;
    
?>
<link rel="stylesheet" href="buttons.css">
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<script src="jquery/js/jquery-3.1.1.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>

<html>
    <head>
        <link rel='shortcut icon' href='favicons.ico' type='image/x-icon'/ >
        <style>
            body {
                padding-top: 10px;
                background-image: url('bg2.jpg');
				background-attachment: fixed;
            }
            .progressPulseOn {
                transition: box-shadow 1000ms;
                box-shadow: 0px 0px 20px red;
            }
            .progressPulseOff {
                transition: box-shadow 1000ms;
                box-shadow: 0px 0px 0px red;
            }
            .hotPulseOn {
                transition: box-shadow 1000ms;
                box-shadow: 0px 0px 0px 5px darkgreen;
            }
            .hotPulseOff {
                transition: box-shadow 1000ms;
                box-shadow: 0px 0px 0px 0px darkgreen;
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
			.noM {
				margin: 0px;
				padding: 0px;
				padding-bottom: 2px;
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
			.textXs {
				font-size: 6px;
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
				font-size: 25px;
				padding-top: 6px;
			}
			.hBar {
				font-size: 25px;
				padding-top: 6px;
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
			th {
				background-color: #9DEBE9;
			}
            .invSlot {
                border: 1px solid lightgrey;
                min-height: 120px;
                min-width: 90px;
				max-width: 100px;
                background-color: black;
                cursor: pointer;
				padding: 5px;
            }
			.invSlot2 {
                border: 1px solid lightgrey;
                min-height: 100px;
                min-width: 90px;
				max-width: 100px;
                background-color: black;
                cursor: pointer;
				padding: 5px;
            }
        </style>
        <script>
            $(document).ready(function() {
                //Set previous PIN for loading data
                var pin = getStrCookie('pin');
                
                //Define globals
                var totH = 0;
                var totS = 0;
                var curH = 0;
                var curS = 0;
                var wepStam = 0;
				var wepStam2 = 0;
				var skillSearchDie = 'd4';
                var skillHitDie = 'd4';
                var skillStrDie = 'd4';
                var skillDexDie = 'd4';
                var skillHealDie = 'd4';
                var accBon = 1;
                var dmgBon = 1;
				var wepBon = 0;
				var wepBon2 = 0;
                var dodgBon = 1;
                var parrBon = 1;
                var blckBon = 1;
				var ambiBon = 1;
				var searchBon = 1;
                var sBon = 1;
                var speedBon = 1;
                var sItemBon = 0.1;
                var hItemBon = 0.1;
                var curAP = 0;
                var tileMov = 0;
                var listEffects = ['Well Rested', 'Fatigued (-1 AP)', 'Tired (-2 AP)', 'Exhausted (-3 AP)'];
                var activeEffects = [];
                var pulserIntervalH = '';
                var pulserIntervalS = '';
                var pulserIntervalHotb0 = '';
                var pulserIntervalHotb1 = '';
                var pulserIntervalHotb2 = '';
                var pulserIntervalHotb3 = '';
				var selectedItem = '';
				var selectedSlot = '';
				var spentArrows = 0;
				var arrowType = '';
				var playerName = '';
				var charName = '';
                var hasLoaded = false;
                
				function setupVals(){
					//Set-up previous configuration values
                    $("#pin").val(pin);
					$("#setH").val(curH);
					$("#setS").val(curS);
					$("#maxH").val(totH);
					$("#maxS").val(totS);
					$("#setH2").val(curH);
					$("#setS2").val(curS);
					$("#maxH2").val(totH);
					$("#maxS2").val(totS);
					$("#setSearchDie option[value='"+skillSearchDie+"']").prop('selected', true);
					$("#setHitDie option[value='"+skillHitDie+"']").prop('selected', true);
					$("#setStrDie option[value='"+skillStrDie+"']").prop('selected', true);
					$("#setDexDie option[value='"+skillDexDie+"']").prop('selected', true);
					$("#setHealDie option[value='"+skillHealDie+"']").prop('selected', true);
					$("#accBon option[value='"+accBon+"']").prop('selected', true);
					$("#dmgBon option[value='"+dmgBon+"']").prop('selected', true);
					$("#dodgBon option[value='"+dodgBon+"']").prop('selected', true);
					$("#parrBon option[value='"+parrBon+"']").prop('selected', true);
					$("#blckBon option[value='"+blckBon+"']").prop('selected', true);
					$("#searchBon option[value='"+searchBon+"']").prop('selected', true);
					$("#ambiBon").val(ambiBon);
					$("#sBon option[value='"+sBon+"']").prop('selected', true);
                    $("#speedBon option[value='"+speedBon+"']").prop('selected', true);
					$("#sItemBon").val(sItemBon);
					$("#hItemBon").val(hItemBon);
					$("#playerName").val(playerName);
					$("#charName").val(charName);
				}
                
				//Instantiate audio files
				var bandageShort = new Audio('audio/bandage/short.wav');
	//PLACEHOLDER SECOND AUDIO
				var bandageLong = new Audio('audio/bandage/short.wav');
				//Stamina Audio
				var inhaleMuffled = new Audio('audio/inhale/muffled.wav');
				var inhaleLoud = new Audio('audio/inhale/loud.wav');
				//Trade Audio
				var coinsLong = new Audio('audio/coins/long.wav');
				var coinsShort = new Audio('audio/coins/short.wav');
				//Inventory Audio
				var inventorySack = new Audio('audio/inventory/sack.wav');
				var inventoryPaper = new Audio('audio/inventory/paper.wav');
				var itemEquip = new Audio('audio/inventory/itemequip.wav');
				//Dice Audio
				var diceSingle = new Audio('audio/dice/single.mp3');
				var diceMany = new Audio('audio/dice/many.mp3');
				var diceMany2 = new Audio('audio/dice/many2.wav');
				//Combat Audio
				var swordDraw = new Audio('audio/sword/draw.wav');
				var swordSheath = new Audio('audio/sword/sheath.wav');
				var swordArmor = new Audio('audio/sword/armorhit.wav');
				var swordShield = new Audio('audio/sword/shieldhit.wav');
				var swordChop = new Audio('audio/sword/chop.wav');
				var swordChop2 = new Audio('audio/sword/chop2.wav');
				var swordClash = new Audio('audio/sword/swordclash.wav');
				var swordSwingHit = new Audio('audio/sword/swinghit.wav');
				var swordDodge = new Audio('audio/sword/swordDodge.wav');
				//Movement Audio
				var footStep = new Audio('audio/movement/footStep.wav');
				var footStep2 = new Audio('audio/movement/footStep2.wav');
				var footStep3 = new Audio('audio/movement/footStep3.wav');
				//Magic Cast Audio
				var mageAttack = new Audio('audio/magic/magicattack.wav');
				var mageAttack2 = new Audio('audio/magic/magicattack2.wav');
				//Archer Audio
				var bowDraw = new Audio('audio/archery/bowdraw.wav');
				var bowShot = new Audio('audio/archery/bowshot.wav');
				
                function updateH(){
                    var perc = Math.round(((curH/totH)*100));
                    var perWidth = perc+'%';
                    $(".hBar").text('('+curH+'/'+totH+') '+perc+'%');
                    $(".perBarH").attr('aria-valuenow', perc);
                    $(".perBarH").width(perWidth);
                    $(".ht").text(curH);
                    $(".th").text(totH);
                    
                    if(perc <= 33){
                        if(pulserIntervalH == ''){
                            pulserIntervalH = setInterval(pulseH, 1000);
                        }
                    } else {
                        clearInterval(pulserIntervalH);
                        $(".progressH").removeClass('progressPulseOn');
                        $(".progressH").addClass('progressPulseOff');
                        pulserIntervalH = '';
                    }
                    setCookie('curH',curH,9);
                    setCookie('totH',totH,9);
					if(hasLoaded == true){
						saveChar();
					}
				}
                
                function pulseH(){
                    if($(".progressH").hasClass('progressPulseOn')){
                        $(".progressH").addClass('progressPulseOff');
                        $(".progressH").removeClass('progressPulseOn');
                    } else {
                        $(".progressH").addClass('progressPulseOn');
                        $(".progressH").removeClass('progressPulseOff');
                    }
                }
                
                function updateS(){
                    var perc = Math.round(((curS/totS)*100));
                    var perWidth = perc+'%';
                    $(".sBar").text('('+curS+'/'+totS+') '+perc+'%');
                    $(".perBarS").attr('aria-valuenow', perc);
                    $(".perBarS").width(perWidth);
                    $(".st").text(curS);
                    $(".ts").text(totS);
                    $(".effects").removeClass('text-danger');
					$(".effectsPanel").removeClass('text-danger');
                    $(".effects").removeClass('text-warning');
					$(".effectsPanel").removeClass('text-warning');
                    $(".effects").removeClass('text-info');
					$(".effectsPanel").removeClass('text-info');
                    $(".effects").removeClass('text-success');
					$(".effectsPanel").removeClass('text-success');
                    var current = $("#effects").text();
                    switch(true){
                        case ((curS < 35) && (curS >= 15)):
                            activeEffects[0] = listEffects[1];
                            $(".effects").addClass('text-info');
							$(".effectsPanel").addClass('text-info');
                            updateEffects();
                            break;
                        case ((curS < 15) && (curS >= 5)):
                            activeEffects[0] = listEffects[2];
                            $(".effects").addClass('text-warning');
							$(".effectsPanel").addClass('text-warning');
                            updateEffects();
                            break;
                        case (curS < 5):
                            activeEffects[0] = listEffects[3];
                            $(".effects").addClass('text-danger');
							$(".effectsPanel").addClass('text-danger');
                            updateEffects();
                            break;
                        case (curS >= 35):
                            activeEffects[0] = listEffects[0];
                            $(".effects").addClass('text-success');
							$(".effectsPanel").addClass('text-success');
                            updateEffects();
                            break;
                    }
                    
                    if(perc <= 25){
                        if(pulserIntervalS == ''){
                            pulserIntervalS = setInterval(pulseS, 1000);
                        }
                    } else {
                        clearInterval(pulserIntervalS);
                        $(".progressS").removeClass('progressPulseOn');
                        $(".progressS").addClass('progressPulseOff');
                        pulserIntervalS = '';
                    }
                    setCookie('curS',curS,9);
                    setCookie('totS',totS,9);
					if(hasLoaded == true){
						saveChar();
					}
                    console.log($("#setS").val());
				}
                
                function pulseS(){
                    if($(".progressS").hasClass('progressPulseOn')){
                        $(".progressS").addClass('progressPulseOff');
                        $(".progressS").removeClass('progressPulseOn');
                    } else {
                        $(".progressS").addClass('progressPulseOn');
                        $(".progressS").removeClass('progressPulseOff');
                    }
                }
                
                function updateEffects(){
                    var effects = '';
                    var i = 1;
                    activeEffects.forEach(function(effect){
                        effects = effects+effect;
                        if(i > 1){
                            effects = effects+' | ';
                        }
                        i++;
                    });
                    $(".effects").html(effects.replace(' ', '<br>'));
					$(".effectsPanel").html(effects);
                }
                
                function pulseHotb0(){
                    if($("#hotB0").hasClass('hotPulseOn')){
                        $("#hotB0").addClass('hotPulseOff');
                        $("#hotB0").removeClass('hotPulseOn');
                    } else {
                        $("#hotB0").addClass('hotPulseOn');
                        $("#hotB0").removeClass('hotPulseOff');
                    }
                }
                function pulseHotb1(){
                    if($("#hotB1").hasClass('hotPulseOn')){
                        $("#hotB1").addClass('hotPulseOff');
                        $("#hotB1").removeClass('hotPulseOn');
                    } else {
                        $("#hotB1").addClass('hotPulseOn');
                        $("#hotB1").removeClass('hotPulseOff');
                    }
                }
                function pulseHotb2(){
                    if($("#hotB2").hasClass('hotPulseOn')){
                        $("#hotB2").addClass('hotPulseOff');
                        $("#hotB2").removeClass('hotPulseOn');
                    } else {
                        $("#hotB2").addClass('hotPulseOn');
                        $("#hotB2").removeClass('hotPulseOff');
                    }
                }
                function pulseHotb3(){
                    if($("#hotB3").hasClass('hotPulseOn')){
                        $("#hotB3").addClass('hotPulseOff');
                        $("#hotB3").removeClass('hotPulseOn');
                    } else {
                        $("#hotB3").addClass('hotPulseOn');
                        $("#hotB3").removeClass('hotPulseOff');
                    }
                }
                
                function setCookie(cname, cvalue, exdays) {
                    var d = new Date();
                    d.setTime(d.getTime() + (exdays*24*60*60*1000));
                    var expires = "expires="+ d.toUTCString();
                    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
                }
				
				function getStrCookie(cname) {
                    var name = cname + "=";
                    var ca = document.cookie.split(';');
                    for(var i = 0; i <ca.length; i++) {
                        var c = ca[i];
                        while (c.charAt(0)==' ') {
                            c = c.substring(1);
                        }
                        if (c.indexOf(name) == 0) {
                            return c.substring(name.length,c.length);
                        }
                    }
                    return '';
                }
                
                //Rolling functions
                function rollPerc(){
                    return Math.ceil(Math.random() * 100);
                }
                function roll20(){
                    return Math.ceil(Math.random() * 20);
                }
                function roll12(){
                    return Math.ceil(Math.random() * 12);
                }
                function roll10(){
                    return Math.ceil(Math.random() * 10);
                }
                function roll8(){
                    return Math.ceil(Math.random() * 8);
                }
                function roll6(){
                    return Math.ceil(Math.random() * 6);
                }
                function roll4(){
                    return Math.ceil(Math.random() * 4);
                }
                
                $('#setH2').on('change', function () {
                    $("#setH").val($('#setH2').val());
                    curH = $('#setH2').val();
                    updateH();
                });
                $('#setS2').on('change', function () {
					$("#setS").val($('#setS2').val());
                    curS = $('#setS2').val();
                    updateS();
                });
                $('#maxH2').on('change', function () {
					$("#maxH").val($('#maxH2').val());
                    totH = $('#maxH2').val();
                    updateH();
                });
                $('#maxS2').on('change', function () {
					$("#maxS").val($('#maxS2').val());
                    totS = $('#maxS2').val();
                    updateS();
                });
				$('#setSearchDie').on('change', function () {
                    skillSearchDie = $('#setSearchDie').val();
                });
                $('#setHitDie').on('change', function () {
                    skillHitDie = $('#setHitDie').val();
                });
                $('#setStrDie').on('change', function () {
                    skillStrDie = $('#setStrDie').val();
                });
                $('#setDexDie').on('change', function () {
                    skillDexDie = $('#setDexDie').val();
                });
                $('#setHealDie').on('change', function () {
                    skillHealDie = $('#setHealDie').val();
                });
                $('#accBon').on('change', function () {
                    accBon = $('#accBon').val();
                });
                $('#dmgBon').on('change', function () {
                    dmgBon = $('#dmgBon').val();
                });
                $('#dodgBon').on('change', function () {
                    dodgBon = $('#dodgBon').val();
                });
                $('#parrBon').on('change', function () {
                    parrBon = $('#parrBon').val();
                });
                $('#blckBon').on('change', function () {
                    blckBon = $('#blckBon').val();
                });
				$('#ambiBon').on('change', function () {
                    ambiBon = $('#ambiBon').val();
                });
                $('#speedBon').on('change', function () {
                    speedBon = $('#speedBon').val();
                });
				$('#searchBon').on('change', function () {
                    searchBon = $('#searchBon').val();
                });
                $('#sBon').on('change', function () {
                    sBon = $('#sBon').val();
                });
                $('#sItemBon').on('change', function () {
                    sItemBon = $('#sItemBon').val();
                });
                $('#hItemBon').on('change', function () {
                    hItemBon = $('#hItemBon').val();
                });
				$('#playerName').on('change', function () {
                    playerName = $('#playerName').val();
                });
				$('#charName').on('change', function () {
                    charName = $('#charName').val();
                });
                $('#pin').on('change', function () {
                    pin = $('#pin').val();
                    setCookie('pin',pin,30);
                });
                
                $('#setH').on('change', function () {
                    curH = $('#setH').val();
                    updateH();
                });
                $('#setS').on('change', function () {
                    curS = $('#setS').val();
                    updateS();
                });
                
                $('#maxH').on('change', function () {
                    totH = $('#maxH').val();
                    updateH();
                });
                $('#maxS').on('change', function () {
                    totS = $('#maxS').val();
                    updateS();
                });
				
				$('#equipItemSelected').on('click', function () {
                    $('#ItemActionModal').modal('toggle');
                    if(pulserIntervalHotb0 == ''){
                        pulserIntervalHotb0 = setInterval(pulseHotb0, 1000);
                    }
                    if(pulserIntervalHotb1 == ''){
                        pulserIntervalHotb1 = setInterval(pulseHotb1, 1000);
                    }
                    /* if(pulserIntervalHotb2 == ''){
                        pulserIntervalHotb2 = setInterval(pulseHotb2, 1000);
                    }
                    if(pulserIntervalHotb3 == ''){
                        pulserIntervalHotb3 = setInterval(pulseHotb3, 1000);
                    } */
                });
				
				//Hotbar Item click actions
				//Mainhand Weapon Slot
				$('#hotB0').on('click', function () {
					if((selectedItem) && selectedItem != ''){
						setHotbar0();
						selectedItem = '';
						itemEquip.play();
                        clearInterval(pulserIntervalHotb0);
                        clearInterval(pulserIntervalHotb1);
                        //clearInterval(pulserIntervalHotb2);
                        //clearInterval(pulserIntervalHotb3);
					} else {
						//Remove assigned equipment
						selectedItem = $("#hotB0 #idcontainer").html();
						if(selectedItem && selectedItem != ''){
							selectedSlot = 0;
							$("#RemoveItemModal").modal();
						}
					}
                });
				//Offhand Weapon Slot
				$('#hotB1').on('click', function () {
					if((selectedItem) && selectedItem != ''){
						setHotbar1();
						selectedItem = '';
						itemEquip.play();
                        clearInterval(pulserIntervalHotb0);
                        clearInterval(pulserIntervalHotb1);
                        //clearInterval(pulserIntervalHotb2);
                        //clearInterval(pulserIntervalHotb3);
					} else {
						//Remove assigned equipment
						selectedItem = $("#hotB1 #idcontainer").html();
						if(selectedItem && selectedItem != ''){
							selectedSlot = 1;
							$("#RemoveItemModal").modal();
						}
					}
                });
				//Healing Item Weapon Slot
				$('#hotB2').on('click', function () {
					if((selectedItem) && selectedItem != ''){
						setHotbar2();
						selectedItem = '';
						itemEquip.play();
                        clearInterval(pulserIntervalHotb0);
                        clearInterval(pulserIntervalHotb1);
                        //clearInterval(pulserIntervalHotb2);
                        //clearInterval(pulserIntervalHotb3);
					} else {
						//Remove assigned equipment
						selectedItem = $("#hotB2 #idcontainer").html();
						if(selectedItem && selectedItem != ''){
							selectedSlot = 2;
							$("#RemoveItemModal").modal();
						}
					}
                });
				//Stamina Item Weapon Slot
				$('#hotB3').on('click', function () {
					if((selectedItem) && selectedItem != ''){
						setHotbar3();
						selectedItem = '';
						itemEquip.play();
                        clearInterval(pulserIntervalHotb0);
                        clearInterval(pulserIntervalHotb1);
                        //clearInterval(pulserIntervalHotb2);
                        //clearInterval(pulserIntervalHotb3);
					} else {
						//Remove assigned equipment
						selectedItem = $("#hotB3 #idcontainer").html();
						if(selectedItem && selectedItem != ''){
							selectedSlot = 3;
							$("#RemoveItemModal").modal();
						}
					}
                });
				
				$("#RemoveItemModal").on("hidden.bs.modal", function () {
					selectedItem = '';
					selectedSlot = '';
				});
                
                $('#move').on('click', function () {
                    if(curAP > 0){
                        $('#atk').removeClass('disabled');
						$('#atkOffhand').removeClass('disabled');
						$('#atkDual').removeClass('disabled');
						$('#atkArcher').removeClass('disabled');
                        $('#move').removeClass('disabled');
                        $('#restSIC').removeClass('disabled');
                        $('#restHIC').removeClass('disabled');
                        curAP = curAP - 1;
                        tileMov = strDieRoll() * speedBon;
                        $("#modAP").text(curAP);
                        $("#tileMov").text(tileMov);
                        if(curAP <= 0){
                            $('#atk').addClass('disabled');
							$('#atkOffhand').addClass('disabled');
							$('#atkDual').addClass('disabled');
							$('#atkArcher').addClass('disabled');
                            $('#move').addClass('disabled');
                            $('#restSIC').addClass('disabled');
                            $('#restHIC').addClass('disabled');
                        }
						var moveSound = roll6();
						if(moveSound > 4){
							footStep.play();
						}
						if(moveSound <= 4 && moveSound > 2){
							footStep2.play();
						}
						if(moveSound <= 2){
							footStep3.play();
						}
                    } else {
						$('#atk').addClass('disabled');
                        $('#atkOffhand').addClass('disabled');
                        $('#atkDual').addClass('disabled');
                        $('#atkArcher').addClass('disabled');
                        $('#move').addClass('disabled');
                        $('#restSIC').addClass('disabled');
                        $('#restHIC').addClass('disabled');
                    }
                });
                
                //Modal functions
                $('#toggleAPModal').on('click', function (e) {
                    $("#atkRoll").text('--');
                    $("#atkRollQ").text('N/A');
					$("#atkRoll2").text('--');
                    $("#atkRoll2Q").text('N/A');
                    $("#strRoll").text('--');
                    $("#strRollQ").text('N/A');
					$("#strRoll2").text('--');
                    $("#strRoll2Q").text('N/A');
                    $(".quickness").addClass('hidden');
                    curAP = roll6();
                    switch(true){
                        case ((curS < 35) && (curS >= 15)):
                            curAP = curAP - 1;
                            break;
                        case ((curS < 15) && (curS >= 5)):
                            curAP = curAP - 2;
                            break;
                        case (curS < 5):
                            curAP = curAP - 3;
                            break;
                        case (curS >= 20):
                            
                            break;
                    }
                    if(curAP < 0){
                        curAP = 0;
                    }
                    
                    if(curAP != 0){
                        var mainH = $('#hotB0').html();
						var offH = $('#hotB1').html();
                        
                        if(mainH.search('Knife') >= 0 || offH.search('Knife') >= 0){
                            $(".quickness").removeClass('hidden');
                        }
						
						//Detect which hands can attack with weapons
						if(mainH.search('2 Hand') >= 0){
							//Detect bow versus standard weapon
							if(mainH.search('Bow') >= 0){
								//Detect if arrows are in slot 2
								if(offH.search('Arrow') >= 0){
									$('#atkArcher').removeClass('hidden');
									$('#noArrows').addClass('hidden');
								} else {
									$('#atkArcher').addClass('hidden');
									$('#noArrows').removeClass('hidden');
								}
								$('#atk').addClass('hidden');
								$('#atkDual').addClass('hidden');
								$('#atkOffhand').addClass('hidden');
								$('#noAp').addClass('hidden');
								bowDraw.play();
							} else {
								$('#atk').removeClass('hidden');
								$('#atkDual').addClass('hidden');
								$('#atkOffhand').addClass('hidden');
								$('#atkArcher').addClass('hidden');
								$('#noArrows').addClass('hidden');
								$('#noAp').addClass('hidden');
								swordDraw.play();
							}
						//Detect dual wield
						} else if((mainH.search('1 Hand') >= 0 || mainH.search('Elemental') >= 0) && (offH.search('1 Hand') >= 0 || offH.search('Elemental') >= 0)){
							$('#atk').removeClass('hidden');
							$('#atkDual').removeClass('hidden');
							$('#atkOffhand').removeClass('hidden');
							$('#atkArcher').addClass('hidden');
							$('#noArrows').addClass('hidden');
							$('#noAp').addClass('hidden');
							swordDraw.play();
						//Detect 1-handed mainhand weapon
						} else if((mainH.search('1 Hand') >= 0 || mainH.search('Elemental') >= 0) && (offH.search('1 Hand') == -1 && offH.search('Elemental') == -1)){
							$('#atk').removeClass('hidden');
							$('#atkDual').addClass('hidden');
							$('#atkOffhand').addClass('hidden');
							$('#atkArcher').addClass('hidden');
							$('#noArrows').addClass('hidden');
							$('#noAp').addClass('hidden');
							swordDraw.play();
						//Detect 1-handed offhand weapon only, what the heck are you doing?
						} else if((mainH.search('1 Hand') == -1 && mainH.search('Elemental') == -1) && (offH.search('1 Hand') >= 0 || offH.search('Elemental') >= 0 || offH.search('2 Hand') >= 0)){
							$('#atk').addClass('hidden');
							$('#atkDual').addClass('hidden');
							$('#atkOffhand').removeClass('hidden');
							$('#atkArcher').addClass('hidden');
							$('#noArrows').addClass('hidden');
							$('#noAp').addClass('hidden');
							swordDraw.play();
						}
						$('#atk').removeClass('disabled');
						$('#atkDual').removeClass('disabled');
						$('#atkOffhand').removeClass('disabled');
						$('#atkArcher').removeClass('disabled');
                        $('#move').removeClass('disabled');
                        $('#restSIC').removeClass('disabled');
                        $('#restHIC').removeClass('disabled');
                    } else {
						$('#atkArcher').addClass('hidden');
						$('#atk').addClass('disabled');
						$('#atkDual').addClass('disabled');
						$('#atkOffhand').addClass('disabled');
						$('#atkArcher').addClass('disabled');
						$('#noArrows').addClass('hidden');
                        $('#noAp').removeClass('hidden');
						$('#drunk').text(rollPerc());
                        $('#move').addClass('disabled');
                        $('#restSIC').addClass('disabled');
                        $('#restHIC').addClass('disabled');
                    }
                    
                    $("#modAP").text(curAP);
                    $("#tileMov").text('--');
                    tileMov = 0;
                    $("#APModal").modal();
                });
                
                $('#toggleDefModal').on('click', function (e) {
                    $("#defRoll").text('--');
                    $("#defBonus").text('--');
					$("#DefModal").modal();
					swordSheath.play();
                });
				
				function searchRoll(){
					switch(skillSearchDie){
						case'd20':
							return roll20();
							break;
						case'd12':
							return roll12();
							break;
						case'd10':
							return roll10();
							break;
						case'd8':
							return roll8();
							break;
						case'd6':
							return roll6();
							break;
						case'd4':
							return roll4();
							break;
					}
				}
				
				function strDieRoll(){
					switch(skillStrDie){
						case'd20':
							return roll20();
							break;
						case'd12':
							return roll12();
							break;
						case'd10':
							return roll10();
							break;
						case'd8':
							return roll8();
							break;
						case'd6':
							return roll6();
							break;
						case'd4':
							return roll4();
							break;
					}
				}
				
				function atkDieRoll(){
					switch(skillHitDie){
						case'd20':
							return roll20();
							break;
						case'd12':
							return roll12();
							break;
						case'd10':
							return roll10();
							break;
						case'd8':
							return roll8();
							break;
						case'd6':
							return roll6();
							break;
						case'd4':
							return roll4();
							break;
					}
				}
                
                function dexRoll(){
                    switch(skillDexDie){
                        case'd20':
                            return roll20();
                            break;
                        case'd12':
                            return roll12();
                            break;
                        case'd10':
                            return roll10();
                            break;
                        case'd8':
                            return roll8();
                            break;
                        case'd6':
                            return roll6();
                            break;
                        case'd4':
                            return roll4();
                            break;
                    }
                }
                
                function medicalRoll(){
                    switch(skillHealDie){
                        case'd20':
                            return roll20();
                            break;
                        case'd12':
                            return roll12();
                            break;
                        case'd10':
                            return roll10();
                            break;
                        case'd8':
                            return roll8();
                            break;
                        case'd6':
                            return roll6();
                            break;
                        case'd4':
                            return roll4();
                            break;
                    }
                }
				
				function swordSound(){
					var swordSound = roll20();
					if(swordSound <= 20 && swordSound > 15){
						swordChop.play();
					}
					if(swordSound <= 15 && swordSound > 10){
						swordSwingHit.play();
					}
					if(swordSound <= 10 && swordSound > 5){
						swordChop2.play();
					}
					if(swordSound <= 5 && swordSound > 0){
						swordArmor.play();
					}
				}
				
				//Archer's Attack
				$('#atkArcher').on('click', function (e) {
                    console.log(curAP);
					var offH = $('#hotB1').html();
					if(offH.search('Arrow') >= 0){
						if(curAP > 0){
							$('#atk').removeClass('disabled');
							$('#atkOffhand').removeClass('disabled');
							$('#atkDual').removeClass('disabled');
							$('#atkArcher').removeClass('disabled');
							$('#move').removeClass('disabled');
							$('#restSIC').removeClass('disabled');
							$('#restHIC').removeClass('disabled');
							curAP = curAP - 1;
							var prevS = curS;
							if((curS - wepStam) >= 0){
								curS = curS - wepStam;
							} else {
								curS = 0;
							}
                            $("#setS").val(curS);
							$("#modAP").text(curAP);
							updateS();
							selectedItem = $("#hotB1 #idcontainer").html();
							expendArrow();
							spentArrows++;
							arrowType = selectedItem;
							var atkRoll = atkDieRoll();
							atkRoll = +atkRoll * +accBon;
							atkRoll = atkRoll.toFixed(0);
							var strRoll = strDieRoll();
							strRoll = +strRoll * (+dmgBon + (+dmgBon * (+wepBon + +wepBon2)));
							strRoll = strRoll.toFixed(0);
							$("#atkRoll").text(atkRoll);
							$("#strRoll").text(strRoll);
							$("#APModal").modal();
							if(curAP <= 0){
								$('#atk').addClass('disabled');
								$('#atkOffhand').addClass('disabled');
								$('#atkDual').addClass('disabled');
								$('#atkArcher').addClass('disabled');
								$('#move').addClass('disabled');
								$('#restSIC').addClass('disabled');
								$('#restHIC').addClass('disabled');
							}
							bowShot.play();
							selectedItem = '';
						} else {
							$('#move').addClass('disabled');
							$('#restSIC').addClass('disabled');
							$('#restHIC').addClass('disabled');
						}
					}
                });
				
				//Dual Wielder's Attack
				$('#atkDual').on('click', function (e) {
                    var mainH = $('#hotB0').html();
                    var offH = $('#hotB1').html();
                    if(curAP > 0){
						$('#atk').removeClass('disabled');
						$('#atkOffhand').removeClass('disabled');
						$('#atkDual').removeClass('disabled');
                        $('#move').removeClass('disabled');
                        $('#restSIC').removeClass('disabled');
                        $('#restHIC').removeClass('disabled');
                        curAP = curAP - 1;
                        var prevS = curS;
                        if((curS - wepStam) >= 0){
                            curS = curS - wepStam;
                        } else {
                            curS = 0;
                        }
                        $("#setS").val(curS);
                        $("#modAP").text(curAP);
                        updateS();
						var atkRoll = atkDieRoll();
                        atkRoll = +atkRoll * +accBon;
						atkRoll = atkRoll.toFixed(0);
                        var strRoll = strDieRoll();
                        strRoll = +strRoll * (+dmgBon + (+dmgBon * +wepBon));
						strRoll = strRoll.toFixed(0);
						
						//Values for offhand wep calc
						var strRoll2 = strDieRoll();
                        strRoll2 = +strRoll2 * (+dmgBon + (+dmgBon * +wepBon2));
						strRoll2 = strRoll2.toFixed(0);
						
                        $("#atkRoll").text(atkRoll);
						$("#atkRoll2").text(Math.round(+atkRoll * +ambiBon));														//Switch to Ambidexterity Skill!
                        $("#strRoll").text(strRoll);
						$("#strRoll2").text(Math.round(+strRoll2 * +ambiBon));
                        
                        //Quickness Check for mainhand
                        if(mainH.search('Knife') >= 0){
                            var atkRollQ = atkDieRoll();
                            atkRollQ = ((+atkRollQ * +accBon) * .8);
                            atkRollQ = atkRollQ.toFixed(0);
                            var strRollQ = strDieRoll();
                            strRollQ = +strRollQ * (+dmgBon + (+dmgBon * +wepBon));
                            strRollQ = strRollQ.toFixed(0);
                            $(".quickness").removeClass('hidden');
                            $("#atkRollQ").text(atkRollQ);
                            $("#strRollQ").text(strRollQ);
                        }
                        
                        //Quickness Check for offhand
                        if(offH.search('Knife') >= 0){
                            var atkRoll2Q = atkDieRoll();
                            atkRoll2Q = ((+atkRoll2Q * +accBon) * .6);
                            atkRoll2Q = atkRoll2Q.toFixed(0);
                            var strRoll2Q = strDieRoll();
                            strRoll2Q = +strRoll2Q * (+dmgBon + (+dmgBon * +wepBon));
                            strRoll2Q = strRoll2Q.toFixed(0);
                            $(".quickness").removeClass('hidden');
                            $("#atkRoll2Q").text(Math.round(atkRoll2Q * +ambiBon));
                            $("#strRoll2Q").text(Math.round(strRoll2Q * +ambiBon));
                        }
                        
                        $("#APModal").modal();
                        if(curAP <= 0){
                            $('#atk').addClass('disabled');
							$('#atkOffhand').addClass('disabled');
							$('#atkDual').addClass('disabled');
							$('#atkArcher').addClass('disabled');
                            $('#move').addClass('disabled');
                            $('#restSIC').addClass('disabled');
                            $('#restHIC').addClass('disabled');
                        }
						swordSound();
                    } else {
                        $('#move').addClass('disabled');
                        $('#restSIC').addClass('disabled');
                        $('#restHIC').addClass('disabled');
                    }
                });
				
				//Offhand Only Attack
                $('#atkOffhand').on('click', function (e) {
                    var mainH = $('#hotB0').html();
                    var offH = $('#hotB1').html();
					if(curAP > 0){
						$('#atk').removeClass('disabled');
						$('#atkOffhand').removeClass('disabled');
						$('#atkDual').removeClass('disabled');
                        $('#move').removeClass('disabled');
                        $('#restSIC').removeClass('disabled');
                        $('#restHIC').removeClass('disabled');
                        curAP = curAP - 1;
                        var prevS = curS;
                        if((curS - wepStam2) >= 0){
                            curS = curS - wepStam2;
                        } else {
                            curS = 0;
                        }
                        $("#setS").val(curS);
                        $("#modAP").text(curAP);
                        updateS();
						var atkRoll2 = atkDieRoll();
                        atkRoll2 = +atkRoll2 * +accBon;
						atkRoll2 = atkRoll2.toFixed(0);
						
						//Values for offhand wep calc
						var strRoll2 = strDieRoll();
                        strRoll2 = +strRoll2 * (+dmgBon + (+dmgBon * +wepBon2));
						strRoll2 = strRoll2.toFixed(0);
                        if((typeof(mainH) != "undefined") && (mainH.search('1 Hand') >= 0 || mainH.search('Elemental') >= 0)){
							//Allow full accuracy for offhand magic etc
							$("#atkRoll2").text(atkRoll2);
							$("#strRoll2").text(strRoll2);
                            
                            //Quickness Check
                            if(offH.search('Knife') >= 0){
                                var atkRoll2Q = atkDieRoll();
                                atkRoll2Q = ((+atkRoll2Q * +accBon) * .6);
                                atkRoll2Q = atkRoll2Q.toFixed(0);
                                var strRoll2Q = strDieRoll();
                                strRoll2Q = +strRoll2Q * (+dmgBon + (+dmgBon * +wepBon));
                                strRoll2Q = strRoll2Q.toFixed(0);
                                $(".quickness").removeClass('hidden');
                                $("#atkRoll2Q").text(atkRoll2Q);
                                $("#strRoll2Q").text(strRoll2Q);
                            }
						} else {
							//Fallback to nerfed offhand
							$("#atkRoll2").text(Math.round(+atkRoll2 * +ambiBon));														//Switch to Ambidexterity Skill!
							$("#strRoll2").text(Math.round(+strRoll2 * +ambiBon));
                            
                            //Quickness Check
                            if(offH.search('Knife') >= 0){
                                var atkRoll2Q = atkDieRoll();
                                atkRoll2Q = ((+atkRoll2Q * +accBon) * .6);
                                atkRoll2Q = atkRoll2Q.toFixed(0);
                                var strRoll2Q = strDieRoll();
                                strRoll2Q = +strRoll2Q * (+dmgBon + (+dmgBon * +wepBon));
                                strRoll2Q = strRoll2Q.toFixed(0);
                                $(".quickness").removeClass('hidden');
                                $("#atkRoll2Q").text(Math.round(atkRoll2Q * +ambiBon));
                                $("#strRoll2Q").text(Math.round(strRoll2Q * +ambiBon));
                            }
						}
                        $("#APModal").modal();
                        if(curAP <= 0){
                            $('#atk').addClass('disabled');
							$('#atkOffhand').addClass('disabled');
							$('#atkDual').addClass('disabled');
							$('#atkArcher').addClass('disabled');
                            $('#move').addClass('disabled');
                            $('#restSIC').addClass('disabled');
                            $('#restHIC').addClass('disabled');
                        }
						swordSound();
                    } else {
                        $('#move').addClass('disabled');
                        $('#restSIC').addClass('disabled');
                        $('#restHIC').addClass('disabled');
                    }
                });
				
				//Mainhand Attack
                $('#atk').on('click', function (e) {
                    var mainH = $('#hotB0').html();
                    console.log(curAP);
					if(curAP > 0){
						$('#atk').removeClass('disabled');
						$('#atkOffhand').removeClass('disabled');
						$('#atkDual').removeClass('disabled');
						$('#atkArcher').removeClass('disabled');
                        $('#move').removeClass('disabled');
                        $('#restSIC').removeClass('disabled');
                        $('#restHIC').removeClass('disabled');
                        curAP = curAP - 1;
                        var prevS = curS;
                        if((curS - wepStam) >= 0){
                            curS = curS - wepStam;
                        } else {
                            curS = 0;
                        }
                        $("#setS").val(curS);
                        $("#modAP").text(curAP);
                        updateS();
                        var atkRoll = atkDieRoll();
                        atkRoll = +atkRoll * +accBon;
						atkRoll = atkRoll.toFixed(0);
                        var strRoll = strDieRoll();
                        strRoll = +strRoll * (+dmgBon + (+dmgBon * +wepBon));
						strRoll = strRoll.toFixed(0);
                        $("#atkRoll").text(atkRoll);
                        $("#strRoll").text(strRoll);
                        //Quickness Check
                        if(mainH.search('Knife') >= 0){
                            var atkRollQ = atkDieRoll();
                            atkRollQ = ((+atkRollQ * +accBon) * .8);
                            atkRollQ = atkRollQ.toFixed(0);
                            var strRollQ = strDieRoll();
                            strRollQ = +strRollQ * (+dmgBon + (+dmgBon * +wepBon));
                            strRollQ = strRollQ.toFixed(0);
                            $(".quickness").removeClass('hidden');
                            $("#atkRollQ").text(atkRollQ);
                            $("#strRollQ").text(strRollQ);
                        }
                        $("#APModal").modal();
                        if(curAP <= 0){
                            $('#atk').addClass('disabled');
							$('#atkOffhand').addClass('disabled');
							$('#atkDual').addClass('disabled');
							$('#atkArcher').addClass('disabled');
                            $('#move').addClass('disabled');
                            $('#restSIC').addClass('disabled');
                            $('#restHIC').addClass('disabled');
                        }
						swordSound();
                    } else {
                        $('#move').addClass('disabled');
                        $('#restSIC').addClass('disabled');
                        $('#restHIC').addClass('disabled');
                    }
                });
                
                $('#block').on('click', function (e) {
                    dexRoll = dexRoll();
                    dexRoll = (+dexRoll * +blckBon);
					$("#defBonus").text('N/A');
                    $("#defRoll").text(dexRoll);
					swordShield.play();
                });
                
                $('#parry').on('click', function (e) {
                    dexRoll = dexRoll();
                    dexRoll = (+dexRoll * +parrBon);
					$("#defBonus").text('N/A');
                    $("#defRoll").text(dexRoll);
					swordClash.play();
                });
                
                $('#dodge').on('click', function (e) {
                    dexRoll = dexRoll();
                    bonusRoll = dexRoll();
                    dexRoll = (+dexRoll * +dodgBon);
                    bonusRoll = (+bonusRoll * +dodgBon);
                    $("#defRoll").text(dexRoll);
                    $("#defBonus").text(bonusRoll);
					swordDodge.play();
                });
                
                $('#restS').on('click', function (e) {
                    newS = medicalRoll();
                    curS = +curS + Math.round((+sBon + (+sBon*+sItemBon)) * +newS);
                    
                    $("#setS").val(curS);
                    $("#setS2").val(curS);
                    updateS();
					var stamSound = roll4();
					if(stamSound > 2){
						inhaleLoud.play();
					} else {
						inhaleMuffled.play();
					}
                });
                
                $('#restH').on('click', function (e) {
                    newH = medicalRoll();
                    curH = +curH + Math.round((+sBon + (+sBon * +hItemBon)) * +newH);
                    
                    $("#setH").val(curH);
                    $("#setH2").val(curH);
                    updateH();
					var healSound = roll4();
					if(healSound > 2){
						bandageShort.play();
					} else {
						bandageLong.play();
					}
                });
                
                $('#restSIC').on('click', function (e) {
                    if(curAP > 0){
                        curAP = curAP - 1;
                        $('#atk').removeClass('disabled');
						$('#atkOffhand').removeClass('disabled');
						$('#atkDual').removeClass('disabled');
						$('#atkArcher').removeClass('disabled');
                        $('#move').removeClass('disabled');
                        $('#restSIC').removeClass('disabled');
                        $('#restHIC').removeClass('disabled');
                        newS = medicalRoll();
                        curS = +curS + Math.round((+sBon + (+sBon*+sItemBon)) * +newS);
                        $("#setS").val(curS);
                        $("#setS2").val(curS);
                        updateS();
                        $("#modAP").text(curAP);
                        if(curAP <= 0){
                            $('#atk').addClass('disabled');
							$('#atkOffhand').addClass('disabled');
							$('#atkDual').addClass('disabled');
							$('#atkArcher').addClass('disabled');
                            $('#move').addClass('disabled');
                            $('#restSIC').addClass('disabled');
                            $('#restHIC').addClass('disabled');
                        }
						var stamSound = roll4();
						if(stamSound > 2){
							inhaleLoud.play();
						} else {
							inhaleMuffled.play();
						}
                    } else {
                        $('#atk').addClass('disabled');
						$('#atkOffhand').addClass('disabled');
						$('#atkDual').addClass('disabled');
						$('#atkArcher').addClass('disabled');
                        $('#move').addClass('disabled');
                        $('#restSIC').addClass('disabled');
                        $('#restHIC').addClass('disabled');
                    }
                });
                
                $('#restHIC').on('click', function (e) {
                    if(curAP > 0){
                        $('#atk').removeClass('disabled');
						$('#atkOffhand').removeClass('disabled');
						$('#atkDual').removeClass('disabled');
						$('#atkArcher').removeClass('disabled');
                        $('#move').removeClass('disabled');
                        $('#restSIC').removeClass('disabled');
                        $('#restHIC').removeClass('disabled');
                        curAP = curAP - 1;
                        newH = medicalRoll();
                        curH = +curH + Math.round((+sBon + (+sBon * +hItemBon)) * +newH);
                        $("#setH").val(curH);
                        $("#setH2").val(curH);
                        updateH();
                        $("#modAP").text(curAP);
                        if(curAP <= 0){
                            $('#atk').addClass('disabled');
							$('#atkOffhand').addClass('disabled');
							$('#atkDual').addClass('disabled');
							$('#atkArcher').addClass('disabled');
                            $('#move').addClass('disabled');
                            $('#restSIC').addClass('disabled');
                            $('#restHIC').addClass('disabled');
                        }
						var healSound = roll4();
						if(healSound > 2){
							bandageShort.play();
						} else {
							bandageLong.play();
						}
                    } else {
                        $('#atk').addClass('disabled');
						$('#atkOffhand').addClass('disabled');
						$('#atkDual').addClass('disabled');
						$('#atkArcher').addClass('disabled');
                        $('#move').addClass('disabled');
                        $('#restSIC').addClass('disabled');
                        $('#restHIC').addClass('disabled');
                    }
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
				
				function commData(send){
					//var send = {key:'value', key:'value', key:'value'}
					
					$.ajax({
						type:"GET",
						cache:false,
						url:"ajaxData.php",
						data : send,
						success: function (html) {
							if(send.action == 'getplayeritems'){
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
									
									if(result.b == 0){
										wepBon = ((+((result.k).replace('%', ''))/100) * +dmgBon);
										wepStam = result.i;
									} else if(result.b == 1){
										wepBon2 = ((+((result.k).replace('%', ''))/100) * +dmgBon);
										wepStam2 = result.i;
									}
								}
							} else if(send.action == 'loadplayer'){
								var results = $.parseJSON(html);
                                playerName = results.b;
                                charName = results.c;
								totH = results.e;
								totS = results.g;
								curH = results.d;
								curS = results.f;
								skillHitDie = results.h;
								skillStrDie = results.i;
								skillDexDie = results.j;
								skillHealDie = results.k;
								accBon = results.l;
								dmgBon = results.m;
								dodgBon = results.n;
								parrBon = results.o;
								blckBon = results.p;
								sBon = results.q;
								skillSearchDie = results.r;
								ambiBon = results.s;
								searchBon = results.t;
								sBon = results.u;
                                speedBon = results.w;
								setupVals();
                                loadHotbar();
								updateH();
								updateS();
								hasLoaded = true;
							} else if(send.action == 'saveplayer'){
								console.log(html);
							} else if(send.action == 'expendarrow'){
								if(html <= 0){
									$('#atkArcher').addClass('disabled');
									$('#atkArcher').addClass('hidden');
									$('#noArrows').removeClass('hidden');
								}
								loadHotbar();
							} else if(send.action == 'recoverarrows'){
								console.log(html);
								loadHotbar();
							} else {
								$("#AjaxModal").modal();
								$('#retMessage').html(html);
								loadHotbar();
							}
						}
					});
				}
                
                $('#reconfig').on('click', function (e) {
                    $("#SetupModal").modal();
                });
                
                $('#openInv').on('click', function (e) {
                    loadItems();
					loadHotbar();
					$("#InvModal").modal();
					inventorySack.play();
                });
				$('#unEquipSelected').on('click', function (e) {
					unequipHotbar();
					loadHotbar();
					$("#RemoveItemModal").modal("toggle");
					itemEquip.play();
                });
				$('#openTrade').on('click', function (e) {
                    loadItems();
					$("#TradeModal").modal();
					inventoryPaper.play();
                });
				$('#recoverArrows').on('click', function (e) {
					if(arrowType != '' && spentArrows > 0){
						var recoverRoll = (+rollPerc() + (+searchRoll() * +searchBon));
						if(recoverRoll < 70){
							spentArrows = (Math.round(+spentArrows / 2));
						}
						recoverArrows();
					}
					spentArrows = 0;
					arrowType = '';
                });
				$('#save').on('click', function (e) {
                    saveChar();
				});
				$('#load').on('click', function (e) {
                    loadChar();
					loadItems();
					loadHotbar();
				});
                
                //Centralized async functions here
                function saveChar(){
					commData({action:'saveplayer', pin:pin, player:playerName, character:charName, toth:totH, tots:totS, curh:curH, curs:curS, searchdie:skillSearchDie, hitdie:skillHitDie, strdie:skillStrDie, dexdie:skillDexDie, healdie:skillHealDie, accbon:accBon, dmgbon:dmgBon, dodgebon:dodgBon, parrybon:parrBon, blockbon:blckBon, ambidexterity:ambiBon, searchbon:searchBon, healbon:sBon, speedbon:speedBon});
				}
                function loadChar(){
                    commData({action:'loadplayer', pin:pin});
                }
                function loadItems(){
                    commData({action:'getplayeritems', pin:pin});
                }
                function loadHotbar(){
                    commData({action:'getplayerhotbar', pin:pin});
                }
                function unequipHotbar(){
                    commData({action:'unequiphotbaritem', pin:pin, item:selectedItem, hotbslot:selectedSlot});
                }
                function expendArrow(){
                    commData({action:'expendarrow', pin:pin, item:selectedItem, slot:1});
                }
                function recoverArrows(){
                    commData({action:'recoverarrows', pin:pin, count:spentArrows, arrowtype:arrowType});
                }
                function setHotbar0(){
                    commData({action:'setHotbar0', pin:pin, item:selectedItem});
                }
                function setHotbar1(){
                    commData({action:'setHotbar1', pin:pin, item:selectedItem});
                }
                function setHotbar2(){
                    commData({action:'setHotbar2', pin:pin, item:selectedItem});
                }
                function setHotbar3(){
                    commData({action:'setHotbar3', pin:pin, item:selectedItem});
                }
                //End of centralized async functions
                
				//Determine if loading or creating character
				if(pin != ''){
					loadChar();
				} else {
					$("#SetupModal").modal();
				}
            });
        </script>
    </head>
    <body>
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <h3 class="effD">Vitals:</h3>
                <div class="progress progressH progressPulseOff">
                    <div class="progress-bar progress-bar-danger progress-bar-striped active perBarH" role="progressbar"
                        aria-valuemin="0" aria-valuemax="100">
                        <strong><div class="hBar textBig"></div></strong>
                    </div>
                </div>
                <div class="progress progressS progressPulseOff">
                    <div class="progress-bar progress-bar-success progS progress-bar-striped active perBarS" role="progressbar"
                        aria-valuemin="0" aria-valuemax="100">
                        <strong><div class="sBar textBig"></div></strong>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1 textBig">
                <div class="col-md-12 well well-sm">
                    <strong>
						<div class="row">
							<div class="col-sm-12">
								<div class="col-sm-7 pad">
									Current HP:
									<!--<select id="setH" class="mright">
										<?php
											$i = 0;
											while($i < 101){
												echo '<option value="'.$i.'">'.$i.'</option>';
												$i++;
											}
										?>
									</select>-->
									<input type="text" id="setH" class="" size="3" />
									Max HP:
									<!--<select id="maxH" class="">
										<?php
											$i = 0;
											while($i < 101){
												echo '<option value="'.$i.'">'.$i.'</option>';
												$i++;
											}
										?>
									</select>-->
									<input type="text" id="maxH" class="" size="3" />
								</div>
								<div class="col-sm-7 pad">
									Current Stam:
									<!--<select id="setS" class="mright">
										<?php
											$i = 0;
											while($i < 101){
												echo '<option value="'.$i.'">'.$i.'</option>';
												$i++;
											}
										?>
									</select>-->
									<input type="text" id="setS" class="" size="3" />
									Max Stam:
									<!--<select id="maxS" class="">
										<?php
											$i = 0;
											while($i < 101){
												echo '<option value="'.$i.'">'.$i.'</option>';
												$i++;
											}
										?>
									</select>-->
									<input type="text" id="maxS" class="" size="3" />
								</div>
							</div>
						</div>
					</strong>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-sm-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h6 class="panel-title"><span class="glyphicon glyphicon-edit"></span>
                        Effects:
                    </h6>
                </div>
                <div class="panel-body">
                    <div class="textBigger">
                        <span class="effectsPanel"></span>
                    </div>
                </div>
            </div>
			<h5 class="noM"><strong><u>Item Actions:</u></strong></h5>
			<button type="button" id="openInv" class="btn btn-brown">Inventory</button>
			<button type="button" id="openTrade" class="btn btn-blue-gray">Trade</button>
			<button type="button" id="recoverArrows" class="btn btn-indigo">Recover Arrows</button>
        </div>
		<div class="col-sm-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h6 class="panel-title"><span class="glyphicon glyphicon-edit"></span>
                        Active Item Hotbar
                    </h6>
                </div>
                <div class="panel-body">
                    <div class="row">
						<div class="col-sm-12 textSmall">
							<div class="col-sm-3">
								<div class="invSlot2 white" id="hotB0">
								
								</div>
								<div class="col-centered">
									Main Hand
								</div>
							</div>
							<div class="col-sm-3">
								<div class="invSlot2 white" id="hotB1">
								
								</div>
								Off Hand
							</div>
							<div class="col-sm-3">
								<div class="invSlot2 white" id="hotB2">
								
								</div>
								Heal Item
							</div>
							<div class="col-sm-3">
								<div class="invSlot2 white" id="hotB3">
								
								</div>
								Stam Item
							</div>
						</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!--<div class="row">
            <div class=" col-sm-12">
                <div class="col-sm-10 btn-group col-sm-offset-1">
						<button type="button" id="r20" class="btn btn-secondary btn-light-green btn-xlarge">Roll 20</button>
                        <button type="button" id="r12" class="btn btn-secondary btn-green btn-xlarge">Roll 12</button>
                        <button type="button" id="r10" class="btn btn-secondary btn-teal btn-xlarge">Roll 10</button>
                        <button type="button" id="r8" class="btn btn-secondary btn-cyan btn-xlarge">Roll 8</button>
                        <button type="button" id="r6" class="btn btn-secondary btn-light-blue btn-xlarge">Roll 6</button>
                        <button type="button" id="r4" class="btn btn-secondary btn-blue btn-xlarge">Roll 4</button>
                        <button type="button" id="rPerc" class="btn btn-secondary btn-orange btn-xlarge hidden-xs">Roll Percent</button>
                </div>
            </div>
        </div>
        <br>-->
        <div class="row">
            <div class=" col-sm-12">
                <div class="col-sm-10 col-sm-offset-1">
                    <button type="button" id="toggleAPModal" class="btn btn-danger">Roll AP</button>
                    <button type="button" id="toggleDefModal" class="btn btn-warning">Roll Def</button>
                    <button type="button" id="restH" class="btn btn-red">Restore HP</button>
                    <button type="button" id="restS" class="btn btn-green">Restore Stam</button>
					<button type="button" id="reconfig" class="btn btn-ldeep-orange pull-right">Reconfigure</button>
					<button type="button" id="save" class="btn btn-lgreen pull-right mright">Save</button>
                    <button type="button" id="load" class="btn btn-lblue pull-right mright">Load</button>
                </div>
            </div>
        </div>
        
        <!-- Modals -->
        <!--Modals-->
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
		
		<div id="APModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title col-sm-2">AP Roll: <span id="modAP"></span></h4>
						<h4 class="modal-title col-sm-2">Stam: <span class="st">--</span></h4>
						<h4 class="modal-title col-sm-4">Effect: <span class="effects"></span></h4>
                        <h4 class="modal-title">Tiles Moved: <span id="tileMov">--</span></h4>
                        
                    </div>
                    <div class="modal-body">
                        <div class="row pbot">
                            <div class="col-sm-10">
								<p>Attack Options:</p>
                                <div id="atkOptions">
									<button type="button" id="atkArcher" class="btn btn-danger">Archery Attack</button><div class="col-sm-4"><button type="button" id="atkDual" class="btn btn-danger">Dual Wield Attack</button></div><div class="col-sm-4"><button type="button" id="atk" class="btn btn-danger">Mainhand Attack</button></div><div class="col-sm-2"><button type="button" id="atkOffhand" class="btn btn-danger">Offhand Attack</button></div>
									<br><span id="noArrows">It seems you do not have any arrows readily available. <br>You could panic, but instead you simply stand there looking confused and sad. <br>Perhaps you should carry some arrows in your offhand slot?</span>
									<br><span id="noAp">You feel too fatigued to do anything about this situation. <br>Perhaps a nice ale will help? You are now <span id="drunk"></span>% drunk.</span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<table class="table responsive nowrap table-striped table-bordered">
									<tr>
										<th>
											Weapon:
										</th>
										<th>
											Accuracy:
										</th>
										<th>
											Damage:
										</th>
									</tr>
									<tr>
										<td>
											Main Hand:
										</td>
										<td>
											<span id="atkRoll">--</span>
										</td>
										<td>
											<span id="strRoll">--</span>
										</td>
									</tr>
                                    <tr class="quickness hidden">
										<td>
											Main Hand Quickness:
										</td>
										<td>
											<span id="atkRollQ">N/A</span>
										</td>
										<td>
											<span id="strRollQ">N/A</span>
										</td>
									</tr>
									<tr>
										<td>
											Off Hand:
										</td>
										<td>
											<span id="atkRoll2">--</span>
										</td>
										<td>
											<span id="strRoll2">--</span>
										</td>
									</tr>
                                    <tr class="quickness hidden">
										<td>
											Off Hand Quickness:
										</td>
										<td>
											<span id="atkRoll2Q">N/A</span>
										</td>
										<td>
											<span id="strRoll2Q">N/A</span>
										</td>
									</tr>
								</table>
							</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-10">
                                <div class="col-sm-2">
                                    <button type="button" id="move" class="btn btn-warning">Move</button>
                                </div>
                                <div class="col-sm-4 col-sm-offset-1">
                                    <button type="button" id="restSIC" class="btn btn-success">Recover Stamina</button>
                                </div>
                                <div class="col-sm-3">
                                    <button type="button" id="restHIC" class="btn btn-success">Recover Health</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        
                    </div>
                </div>
            </div>
        </div>
        
        <div id="DefModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2>Defensive Roll</h2>
                    </div>
                    <div class="modal-body">
                        <div class="row pad">
							<table class="table responsive nowrap table-striped table-bordered">
								<tr>
									<th class="col-sm-3">
										Effectiveness:
									</th>
									<td class="col-sm-3">
										<span id="defRoll">0</span>
									</td>
								</tr>
								<tr>
									<th class="col-sm-3">
										Bonus Effectiveness:
									</th>
									<td class="col-sm-3">
										<span id="defBonus">--</span>
									</td>
								</tr>
							</table>
                        </div>
                        <div class="row pad">
                            <button type="button" id="dodge" class="btn btn-info btn-xlarge">Dodge</button>
                            <button type="button" id="parry" class="btn btn-warning btn-xlarge">Parry</button>
                            <button type="button" id="block" class="btn btn-danger btn-xlarge">Block</button>
                        </div>
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
								<div class="col-sm-3">
									<button type="button" id="equipItemSelected" class="btn btn-info btn-xlarge">Equip</button>
								</div>
								<div class="col-sm-3">
									<button type="button" id="tradeItemSelected" class="btn btn-warning btn-xlarge">Trade</button>
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
		
		<div id="RemoveItemModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2>Would you like to remove this weapon from its slot?</h2>
                    </div>
                    <div class="modal-body">
                        <div class="row">
							<div class="col-sm-12">
								<div class="col-sm-5">
									<button type="button" id="unEquipSelected" class="btn btn-danger btn-xlarge">Move to Inventory</button>
								</div>
								<div class="col-sm-3">
									<button type="button" id="" data-dismiss="modal" class="btn btn-warning btn-xlarge">Cancel</button>
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
        
        <div id="InvModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content wood">
                    <div class="modal-header">
                        <strong class="textBig" style="opacity: 0.7;color: white;">Inventory</strong>
                        <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 0.6;">&times;</button>
                    </div>
                    <div class="modal-body col-sm-12">
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
		
		<div id="TradeModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content wood">
                    <div class="modal-header">
                        <strong class="textBig" style="opacity: 0.7;color: white;">Player Trade</strong>
						<select id="players" class="mright">
							<?php
								//Move to db query when ready
								$players = ['testPlayer1','testPlayer2','testPlayer3'];
								$playerCount = count($players) - 1;
								while($playerCount >= 0){
									echo '<option value="'.$players[$playerCount].'">'.$playerCount[$playerCount].'</option>';
									$playerCount = $playerCount - 1;
								}
							?>
						</select>
                        <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 0.6;">&times;</button>
                    </div>
                    <div class="modal-body col-sm-12">
						<div class="col-sm-6 white textBig">
							Your Items:
						</div>
						<div class="col-sm-6 white textBig">
							(Placeholder) Other Player:
						</div>
						<div class="bright col-sm-6">
							
							<?php
								$trdSlot = 6;
								while($trdSlot > 0){
									echo '<div class="col-sm-6 pbot"><div class="invSlot" id="invS'.$trdSlot.'"></div></div>';
									$trdSlot = $trdSlot-1;
								}
							?>
						</div>
						<div class="col-sm-6">
							
							<?php
								$trdSlot = 6;
								while($trdSlot > 0){
									echo '<div class="col-sm-6 pbot"><div class="invSlot" id="invS'.$trdSlot.'"></div></div>';
									$trdSlot = $trdSlot-1;
								}
							?>
						</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="cancel" data-dismiss="modal" class="btn btn-warning btn-xlarge">Cancel Trade</button>
                        <button type="button" id="accept" class="btn btn-success btn-xlarge pull-right">Accept Trade</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="RollModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body col-sm-12">
                        <h1 id="rResult" class="col-sm-1 col-sm-offset-5"></h1>
                    </div>
                    <div class="modal-footer">
                        
                    </div>
                </div>
            </div>
        </div>
        
        <div id="SetupModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>Configuration</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body col-md-12 textBig">
                        <div class="col-md-12">
                            <div class="col-md-4 pad">
								<strong><u>Your Access PIN (Max 15 alphanumeric):</u></strong><br>
                                <input type="text" id="pin" class="" size="15" placeholder="unique id" /><br>
                                <strong><u>Your Name:</u></strong><br>
                                <input type="text" id="playerName" class="" size="30" placeholder="" /><br>
								<strong><u>Character Name:</u></strong><br>
                                <input type="text" id="charName" class="" size="30" placeholder="" />
                            </div>
                        </div>
						<div class="pad">
							<table class="table responsive nowrap table-striped table-bordered">
								<tr>
									<td>
										Status
									</td>
									<th>
										Current:
									</th>
									<th>
										Maximum:
									</th>
								</tr>
								<tr>
									<th>
										Health:
									</th>
									<td>
										<!--<select id="setH2" class="mright">
											<?php
												$i = 0;
												while($i < 101){
													echo '<option value="'.$i.'">'.$i.'</option>';
													$i++;
												}
											?>
										</select>-->
										<input type="text" id="setH2" class="" size="3" />
									</td>
									<td>
										<!--<select id="maxH2" class="">
											<?php
												$i = 0;
												while($i < 101){
													echo '<option value="'.$i.'">'.$i.'</option>';
													$i++;
												}
											?>
										</select>-->
										<input type="text" id="maxH2" class="" size="3" />
									</td>
								</tr>
								<tr>
									<th>
										Stamina:
									</th>
									<td>
										<!--<select id="setS2" class="mright">
											<?php
												$i = 0;
												while($i < 101){
													echo '<option value="'.$i.'">'.$i.'</option>';
													$i++;
												}
											?>
										</select>-->
										<input type="text" id="setS2" class="" size="3" />
									</td>
									<td>
										<!--<select id="maxS2" class="">
											<?php
												$i = 0;
												while($i < 101){
													echo '<option value="'.$i.'">'.$i.'</option>';
													$i++;
												}
											?>
										</select>-->
										<input type="text" id="maxS2" class="" size="3" />
									</td>
								</tr>
							</table>
						</div>
						
						<div class="pad">
							<table class="table responsive nowrap table-striped table-bordered">
								<tr>
									<td>
										Skills
									</td>
									<th>
										Dice:
									</th>
									<th>
										Skill Multiplier:
									</th>
									<th>
										Decimal Number:
									</th>
								</tr>
								<tr>
									<th>
										Accuracy Skill:
									</th>
									<td>
										<select id="setHitDie" class="mright">
											<option value="d4">d4</option>
											<option value="d6">d6</option>
											<option value="d8">d8</option>
											<option value="d10">d10</option>
											<option value="d12">d12</option>
											<option value="d20">d20</option>
										</select>
									</td>
									<td>
										<select id="accBon" class="">
											<?php
												$i = 1;
												while($i < 31){
													echo '<option value="'.$i.'">'.$i.'</option>';
													$i++;
												}
											?>
										</select>
									</td>
									<td>
										
									</td>
								</tr>
								<tr>
									<th>
										Dex Skill:
									</th>
									<td>
										<select id="setDexDie" class="mright">
											<option value="d4">d4</option>
											<option value="d6">d6</option>
											<option value="d8">d8</option>
											<option value="d10">d10</option>
											<option value="d12">d12</option>
											<option value="d20">d20</option>
										</select>
									</td>
									<td>
										<select id="accBon" class="">
											<?php
												$i = 1;
												while($i < 31){
													echo '<option value="'.$i.'">'.$i.'</option>';
													$i++;
												}
											?>
										</select>
									</td>
									<td>
                                        
									</td>
								</tr>
								<tr>
									<th>
										Damage Skill:
									</th>
									<td>
										<select id="setStrDie" class="mright">
											<option value="d4">d4</option>
											<option value="d6">d6</option>
											<option value="d8">d8</option>
											<option value="d10">d10</option>
											<option value="d12">d12</option>
											<option value="d20">d20</option>
										</select>
									</td>
									<td>
										<select id="dmgBon" class="">
											<?php
												$i = 1;
												while($i < 31){
													echo '<option value="'.$i.'">'.$i.'</option>';
													$i++;
												}
											?>
										</select>
									</td>
									<td>
										
									</td>
								</tr>
								<tr>
									<th>
										Search Skill:
									</th>
									<td>
										<select id="setSearchDie" class="mright">
											<option value="d4">d4</option>
											<option value="d6">d6</option>
											<option value="d8">d8</option>
											<option value="d10">d10</option>
											<option value="d12">d12</option>
											<option value="d20">d20</option>
										</select>
									</td>
									<td>
										<select id="searchBon" class="">
											<?php
												$i = 1;
												while($i < 31){
													echo '<option value="'.$i.'">'.$i.'</option>';
													$i++;
												}
											?>
										</select>
									</td>
									<td>
										
									</td>
								</tr>
								<tr>
									<th>
										Healing Skill:
									</th>
									<td>
										<select id="setHealDie" class="mright">
											<option value="d4">d4</option>
											<option value="d6">d6</option>
											<option value="d8">d8</option>
											<option value="d10">d10</option>
											<option value="d12">d12</option>
											<option value="d20">d20</option>
										</select>
									</td>
									<td>
										<select id="sBon" class="">
											<?php
												$i = 1;
												while($i < 31){
													echo '<option value="'.$i.'">'.$i.'</option>';
													$i++;
												}
											?>
										</select>
									</td>
									<td>
										
									</td>
								</tr>
                                <tr>
									<th>
										Ambidexterity:
									</th>
									<td>
										
									</td>
									<td>
										
									</td>
									<td>
										<input type="text" id="ambiBon" class="" size="3" placeholder="decimal" value="0.6" />
									</td>
								</tr>
                                <tr>
									<th>
										Movement:
									</th>
									<td>
										
									</td>
									<td>
										<select id="speedBon" class="">
											<?php
												$i = 1;
												while($i < 31){
													echo '<option value="'.$i.'">'.$i.'</option>';
													$i++;
												}
											?>
										</select>
									</td>
									<td>
										
									</td>
								</tr>
							</table>
						</div>
                        
                        <!--<div class="col-md-12">
                            <strong>Defense Config:</strong>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-10 pad">
                                Dodge Bonus: 
                                <select id="dodgBon" class="">
                                    <?php
                                        $i = 1;
                                        while($i < 31){
                                            echo '<option value="'.$i.'">'.$i.'</option>';
                                            $i++;
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-10 pad">
                                Block Bonus: 
                                <select id="blckBon" class="">
                                    <?php
                                        $i = 1;
                                        while($i < 31){
                                            echo '<option value="'.$i.'">'.$i.'</option>';
                                            $i++;
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-10 pad">
                                Parry Bonus: 
                                <select id="parrBon" class="">
                                    <?php
                                        $i = 1;
                                        while($i < 31){
                                            echo '<option value="'.$i.'">'.$i.'</option>';
                                            $i++;
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>-->
						
						<div class="pad">
							<table class="table responsive nowrap table-striped table-bordered">
								<tr>
									<td>
										Defense
									</td>
									<th>
										Dodge:
									</th>
									<th>
										Block:
									</th>
									<th>
										Parry:
									</th>
								</tr>
								<tr>
									<th>
										Multiplier:
									</th>
									<td>
										<select id="dodgBon" class="">
											<?php
												$i = 1;
												while($i < 31){
													echo '<option value="'.$i.'">'.$i.'</option>';
													$i++;
												}
											?>
										</select>
									</td>
									<td>
										<select id="blckBon" class="">
											<?php
												$i = 1;
												while($i < 31){
													echo '<option value="'.$i.'">'.$i.'</option>';
													$i++;
												}
											?>
										</select>
									</td>
									<td>
										<select id="parrBon" class="">
											<?php
												$i = 1;
												while($i < 31){
													echo '<option value="'.$i.'">'.$i.'</option>';
													$i++;
												}
											?>
										</select>
									</td>
								</tr>
							</table>
						</div>
                        
						<div class="col-md-12">
                            <strong>Equipment Config (Temporary):</strong>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-10">
                                <div class="col-md-5 pad">
                                    Stam Equip. Bonus:
                                    <input type="text" id="sItemBon" class="mright" size="3" placeholder="decimal" value="0.1" />
                                </div>
                                <div class="col-md-5 pad">
                                    Health Equip. Bonus:
                                    <input type="text" id="hItemBon" class="" size="3" placeholder="decimal" value="0.1" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-sm-12 pad">
                            <button type="button" id="" class="btn btn-success pull-right" data-dismiss="modal">Done</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </body>
</html>