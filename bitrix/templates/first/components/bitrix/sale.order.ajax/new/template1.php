<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if($USER->IsAuthorized() || $arParams["ALLOW_AUTO_REGISTER"] == "Y")
{
	if($arResult["USER_VALS"]["CONFIRM_ORDER"] == "Y" || $arResult["NEED_REDIRECT"] == "Y")
	{
		if(strlen($arResult["REDIRECT_URL"]) > 0)
		{
			$APPLICATION->RestartBuffer();
			?>
			<script type="text/javascript">
				window.top.location.href='<?=CUtil::JSEscape($arResult["REDIRECT_URL"])?>';
			</script>
			<?
			die();
		}

	}
}

$APPLICATION->SetAdditionalCSS($templateFolder."/style_cart.css");
$APPLICATION->SetAdditionalCSS($templateFolder."/style.css");

CJSCore::Init(array('fx', 'popup', 'window', 'ajax'));
?>

<a name="order_form"></a>

<div id="order_form_div" class="order-checkout">
<NOSCRIPT>
	<div class="errortext"><?=GetMessage("SOA_NO_JS")?></div>
</NOSCRIPT>

<?
if (!function_exists("getColumnName"))
{
	function getColumnName($arHeader)
	{
		return (strlen($arHeader["name"]) > 0) ? $arHeader["name"] : GetMessage("SALE_".$arHeader["id"]);
	}
}

if (!function_exists("cmpBySort"))
{
	function cmpBySort($array1, $array2)
	{
		if (!isset($array1["SORT"]) || !isset($array2["SORT"]))
			return -1;

		if ($array1["SORT"] > $array2["SORT"])
			return 1;

		if ($array1["SORT"] < $array2["SORT"])
			return -1;

		if ($array1["SORT"] == $array2["SORT"])
			return 0;
	}
}
?>
<?if($arResult["USER_VALS"]["CONFIRM_ORDER"] == "Y")
{ 
   if(strlen($arResult["REDIRECT_URL"]) > 0)
   {
   ?>
   <script>
   <!--
   window.location.href='<?=CUtil::JSEscape($arResult["REDIRECT_URL"])?>';
   //-->
   </script>
   <?
   }
   
   include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/confirm.php");
}
else
{

   ?>
<?
   if(!empty($arResult["ERROR"]))
   {
     echo "asd";
   }
   ?>
<?$user_prop=3;?>
<?
if($_POST["PERSON_TYPE"]!="")  
$user_prop=$_POST["PERSON_TYPE"];
						
						?>
						<?php
if (CModule::IncludeModule("sale"))
{
   $arBasketItems = array();
   $dbBasketItems = CSaleBasket::GetList(
                  array("NAME" => "ASC","ID" => "ASC"),
                  array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL"),
                  false,
                  false,
                  array("ID","MODULE","PRODUCT_ID","QUANTITY","CAN_BUY","PRICE"));
   while ($arItems=$dbBasketItems->Fetch())
   {
      $arItems=CSaleBasket::GetByID($arItems["ID"]);
      $arBasketItems[]=$arItems;   
      $cart_num+=$arItems['QUANTITY'];
      $cart_sum+=$arItems['PRICE']*$arItems['QUANTITY'];
	 
	 
	  
   }
   if (empty($cart_num))
      $cart_num="0";
   if (empty($cart_sum))
      $cart_sum="0";
   ?>
  
   <?
}
if($cart_num>0){
?>
<section class="card_company">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2>Оформление заказа</h2>
				<div class=" zakaz_table">
				
				<?
$arID = array();

$arBasketItems = array();

$dbBasketItems = CSaleBasket::GetList(
     array(
                "NAME" => "ASC",
                "ID" => "ASC"
             ),
     array(
                "FUSER_ID" => CSaleBasket::GetBasketUserID(),
                "LID" => SITE_ID,
                "ORDER_ID" => "NULL"
             ),
     false,
     false,
     array("ID", "CALLBACK_FUNC", "MODULE", "PRODUCT_ID", "QUANTITY", "PRODUCT_PROVIDER_CLASS")
             );
while ($arItems = $dbBasketItems->Fetch())
{
     if ('' != $arItems['PRODUCT_PROVIDER_CLASS'] || '' != $arItems["CALLBACK_FUNC"])
     {
          CSaleBasket::UpdatePrice($arItems["ID"],
                                 $arItems["CALLBACK_FUNC"],
                                 $arItems["MODULE"],
                                 $arItems["PRODUCT_ID"],
                                 $arItems["QUANTITY"],
                                 "N",
                                 $arItems["PRODUCT_PROVIDER_CLASS"]
                                 );
          $arID[] = $arItems["ID"];
     }
}
if (!empty($arID))
     {
     $dbBasketItems = CSaleBasket::GetList(
     array(
          "NAME" => "ASC",
          "ID" => "ASC"
          ),
     array(
          "ID" => $arID,
        "ORDER_ID" => "NULL"
          ),
        false,
        false,
        array("ID", "CALLBACK_FUNC", "MODULE", "PRODUCT_ID", "QUANTITY", "DELAY", "CAN_BUY", "PRICE", "WEIGHT", "PRODUCT_PROVIDER_CLASS", "NAME")
                );
				$summ=0;
while ($arItems = $dbBasketItems->Fetch())
{
$summ=$summ+$arItems["PRICE"]*$arItems["QUANTITY"];
?>
  
  <div class="zakaz_tovar">
						<div class="col-md-2">
							<p>
							<? $arSelect = Array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM","PROPERTY_CML2_ARTICLE");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
$arFilter = Array("IBLOCK_ID"=>5,"ID"=>$arItems["PRODUCT_ID"], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);
if($prop = $res->Fetch()){ 
 echo $prop["PROPERTY_CML2_ARTICLE_VALUE"];

}
?>
							
							</p>
						</div>
						<div class="col-md-7">
							<p><?=$arItems["NAME"];?></p>
						</div>	
						<div class="col-md-1">
							<p><?=$arItems["QUANTITY"];?></p>
						</div>
						<div class="col-md-2">
							<p class="right"><?=CurrencyFormat($arItems["PRICE"], 'RUB');?></p>
						</div>
					</div>
<?}
}
// Печатаем массив, содержащий актуальную на текущий момент корзину
?>
 

					

					
					<div class="zakaz_itog">
						<div class="col-md-2 col-md-offset-10">
							<p>Итог<span><?=$summ;?></span></p>
						</div>
					</div>
				</div>
				<?
	if(!$USER->IsAuthorized() && $arParams["ALLOW_AUTO_REGISTER"] == "N")
	{
		if(!empty($arResult["ERROR"]))
		{
			foreach($arResult["ERROR"] as $v)
				echo ShowError($v);
		}
		elseif(!empty($arResult["OK_MESSAGE"]))
		{
			foreach($arResult["OK_MESSAGE"] as $v)
				echo ShowNote($v);
		}

		include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/auth.php");
	}
	else
	{
		if($arResult["USER_VALS"]["CONFIRM_ORDER"] == "Y" || $arResult["NEED_REDIRECT"] == "Y")
		{
			if(strlen($arResult["REDIRECT_URL"]) == 0)
			{
				include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/confirm.php");
			}
		}
		else
		{
			?>
			<script type="text/javascript">

			<?if(CSaleLocation::isLocationProEnabled()):?>

				<?
				// spike: for children of cities we place this prompt
				$city = \Bitrix\Sale\Location\TypeTable::getList(array('filter' => array('=CODE' => 'CITY'), 'select' => array('ID')))->fetch();
				?>

				BX.saleOrderAjax.init(<?=CUtil::PhpToJSObject(array(
					'source' => $this->__component->getPath().'/get.php',
					'cityTypeId' => intval($city['ID']),
					'messages' => array(
						'otherLocation' => '--- '.GetMessage('SOA_OTHER_LOCATION'),
						'moreInfoLocation' => '--- '.GetMessage('SOA_NOT_SELECTED_ALT'), // spike: for children of cities we place this prompt
						'notFoundPrompt' => '<div class="-bx-popup-special-prompt">'.GetMessage('SOA_LOCATION_NOT_FOUND').'.<br />'.GetMessage('SOA_LOCATION_NOT_FOUND_PROMPT', array(
							'#ANCHOR#' => '<a href="javascript:void(0)" class="-bx-popup-set-mode-add-loc">',
							'#ANCHOR_END#' => '</a>'
						)).'</div>'
					)
				))?>);

			<?endif?>

			var BXFormPosting = false;
			function submitForm(val)
			{
				if (BXFormPosting === true)
					return true;

				BXFormPosting = true;
				if(val != 'Y')
					BX('confirmorder').value = 'N';

				var orderForm = BX('ORDER_FORM');
				BX.showWait();

				<?if(CSaleLocation::isLocationProEnabled()):?>
					BX.saleOrderAjax.cleanUp();
				<?endif?>

				BX.ajax.submit(orderForm, ajaxResult);

				return true;
			}

			function ajaxResult(res)
			{
				var orderForm = BX('ORDER_FORM');
				try
				{
					// if json came, it obviously a successfull order submit

					var json = JSON.parse(res);
					BX.closeWait();

					if (json.error)
					{
						BXFormPosting = false;
						return;
					}
					else if (json.redirect)
					{
						window.top.location.href = json.redirect;
					}
				}
				catch (e)
				{
					// json parse failed, so it is a simple chunk of html

					BXFormPosting = false;
					BX('order_form_content').innerHTML = res;

					<?if(CSaleLocation::isLocationProEnabled()):?>
						BX.saleOrderAjax.initDeferredControl();
					<?endif?>
				}

				BX.closeWait();
				BX.onCustomEvent(orderForm, 'onAjaxSuccess');
			}

			function SetContact(profileId)
			{
				BX("profile_change").value = "Y";
				submitForm();
			}
			</script>
			<?if($_POST["is_ajax_post"] != "Y")
			{
				?><div id="user_form"><form action="<?=$APPLICATION->GetCurPage();?>" method="POST" name="ORDER_FORM" id="ORDER_FORM" enctype="multipart/form-data">
				<?=bitrix_sessid_post()?>
				<div id="order_form_content">
				<?
			}
			else
			{
				$APPLICATION->RestartBuffer();
			}

			if($_REQUEST['PERMANENT_MODE_STEPS'] == 1)
			{
				?>
				<input type="hidden" name="PERMANENT_MODE_STEPS" value="1" />
				<?
			}

			if(!empty($arResult["ERROR"]) && $arResult["USER_VALS"]["FINAL_STEP"] == "Y")
			{
				foreach($arResult["ERROR"] as $v)
					echo ShowError($v);
				?>
				<script type="text/javascript">
					top.BX.scrollToNode(top.BX('ORDER_FORM'));
				</script>
				<?
			}?>

<input id="ID_PAY_SYSTEM_ID_9" style="display:none" name="PAY_SYSTEM_ID" type="checkbox" class="bx-soa-pp-company-checkbox" checked value="9">
<input type="hidden" name="BUYER_STORE" id="BUYER_STORE" value="<?=$arResult["BUYER_STORE"]?>" />
			
					<div class="col-md-12 padding_0">
					<textarea id="orderDescription" cols="4" class="form-control bx-soa-customer-textarea bx-ios-fix" placeholder="Если это необходимо, напишите, пожалуйста, любую уточняющую информацию к Вашему заказу" name="ORDER_DESCRIPTION"></textarea>
						
						<p>Если Вам нужна обработка винтов и направляющих, приложите все необходимые чертежи.</p>
					</div>
					<div class="div_cherteg chert1">
						<ul class="its_files">
							
						</ul>
					</div>

					<div class="col-md-3 col-sm-4 padding_0">
						<label class="btn input-order"> 	 					
						<input   size="0" type="file" data-id="<?=$user_prop;?>" data-prop="0">
							
						
						<span>Обзор...</span>					</label>

					</div>
					<h3 class="card_setion_name">Личные данные</h3>
					<?if(!$USER->IsAuthorized()){?><div class="col-md-6 col-sm-6">
						<h5>Зарегестрированый пользователь</h5>
						<input type="text" placeholder="E-mail" class="i-email" >
						<input type="text" placeholder="Пароль" class="i-pass" >
						<div class="col-md-6 padding-left_0">
							<a href="javascript:" class="btn go_auth">Войти</a>
						</div>
						<div class="col-md-6 padding_0">
							<a href="/vhod/?forgot_password=yes" class="btn_grey">напомнить пароль</a>
						</div>
					</div>
					<?}?>

					<div <?if(!$USER->IsAuthorized()){?>class="col-md-6 col-sm-6 "<?}else{?> class="col-md-9"<?}?>>
						
						<div class="radio">
						
							<div class="col-md-6 col-sm-6 col-xs-12 padding-left_0">
							<input type="radio" value="3" <?if($user_prop==3){?>checked<?}?> class="go_user_p" name="PERSON_TYPE"> <p>Физичиское лицо</p>

							</div>
							
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="radio" <?if($user_prop==4){?>checked<?}?> class="go_user_p" value="4" name="PERSON_TYPE" > <p>Юридическое лицо</p>
							</div>
						</div>
						<?
						if($user_prop==3)
						$soc=1;
						if($user_prop==4)
						$soc=3;
						?>
						  <?foreach($arResult["JS_DATA"]["ORDER_PROP"]["properties"] as $arProperties){
						  if($arProperties["PROPS_GROUP_ID"]==$soc){
						  ?>
					<div  <?if ($arProperties["TYPE"] == "LOCATION"){?> style="display:none"<?}?>>
						<?
						if ($arProperties["TYPE"] == "CHECKBOX")
						{
							?>
							<div class="bx_block r1x3 pt8">
								<input type="hidden" name="<?=$arProperties["FIELD_NAME"]?>" value="">
								<input type="checkbox" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" value="Y"<?if ($arProperties["CHECKED"]=="Y") echo " checked";?>>
								<?if (strlen(trim($arProperties["DESCRIPTION"])) > 0):?>
									<div class="bx_description"><?=$arProperties["DESCRIPTION"]?></div>
								<?endif?>
							</div>
							<?
						}
						elseif ($arProperties["TYPE"] == "STRING")
						{
						
							?>
							<div class="bx_block r3x1">
								<input type="text" placeholder="<?=$arProperties["NAME"]?>" maxlength="250" size="<?=$arProperties["SIZE"]?>" value="<?=$arProperties["VALUE"][0]?>" name="ORDER_PROP_<?=$arProperties["ID"]?>" id="ORDER_PROP_<?=$arProperties["ID"]?>" />
								<?if (strlen(trim($arProperties["DESCRIPTION"])) > 0):?>
									<div class="bx_description"><?=$arProperties["DESCRIPTION"]?></div>
								<?endif?>
							</div>
							<?
						}
						elseif ($arProperties["TYPE"] == "SELECT")
						{
							?>
							<div class="bx_block r3x1">
								<select name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" size="<?=$arProperties["SIZE1"]?>">
									<?foreach($arProperties["VARIANTS"] as $arVariants):?>
										<option value="<?=$arVariants["VALUE"]?>"<?=$arVariants["SELECTED"] == "Y" ? " selected" : ''?>><?=$arVariants["NAME"]?></option>
									<?endforeach?>
								</select>
								<?if (strlen(trim($arProperties["DESCRIPTION"])) > 0):?>
									<div class="bx_description"><?=$arProperties["DESCRIPTION"]?></div>
								<?endif?>
							</div>
							<?
						}
						elseif ($arProperties["TYPE"] == "MULTISELECT")
						{
							?>
							<div class="bx_block r3x1">
								<select multiple name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" size="<?=$arProperties["SIZE1"]?>">
									<?foreach($arProperties["VARIANTS"] as $arVariants):?>
										<option value="<?=$arVariants["VALUE"]?>"<?=$arVariants["SELECTED"] == "Y" ? " selected" : ''?>><?=$arVariants["NAME"]?></option>
									<?endforeach?>
								</select>
								<?if (strlen(trim($arProperties["DESCRIPTION"])) > 0):?>
									<div class="bx_description"><?=$arProperties["DESCRIPTION"]?></div>
								<?endif?>
							</div>
							<?
						}
						elseif ($arProperties["TYPE"] == "TEXTAREA")
						{
							$rows = ($arProperties["SIZE2"] > 10) ? 4 : $arProperties["SIZE2"];
							?>
							<div class="bx_block r3x1">
								<textarea rows="<?=$rows?>" cols="<?=$arProperties["SIZE1"]?>" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>"><?=$arProperties["VALUE"]?></textarea>
								<?if (strlen(trim($arProperties["DESCRIPTION"])) > 0):?>
									<div class="bx_description"><?=$arProperties["DESCRIPTION"]?></div>
								<?endif?>
							</div>
							<?
						}
						elseif ($arProperties["TYPE"] == "LOCATION")
						{
							?>
							<div  style="display:none">
								<?
								$value = 0;
								if (is_array($arProperties["VARIANTS"]) && count($arProperties["VARIANTS"]) > 0)
								{
									foreach ($arProperties["VARIANTS"] as $arVariant)
									{
										if ($arVariant["SELECTED"] == "Y")
										{
											$value = $arVariant["ID"];
											break;
										}
									}
								}

								// here we can get '' or 'popup'
								// map them, if needed
								if(CSaleLocation::isLocationProMigrated())
								{
									$locationTemplateP = $locationTemplate == 'popup' ? 'search' : 'steps';
									$locationTemplateP = $_REQUEST['PERMANENT_MODE_STEPS'] == 1 ? 'steps' : $locationTemplateP; // force to "steps"
								}
								?>

								<?if($locationTemplateP == 'steps'):?>
									<input type="hidden" id="LOCATION_ALT_PROP_DISPLAY_MANUAL[<?=intval($arProperties["ID"])?>]" name="LOCATION_ALT_PROP_DISPLAY_MANUAL[<?=intval($arProperties["ID"])?>]" value="<?=($_REQUEST['LOCATION_ALT_PROP_DISPLAY_MANUAL'][intval($arProperties["ID"])] ? '1' : '0')?>" />
								<?endif?>

								<?CSaleLocation::proxySaleAjaxLocationsComponent(array(
									"AJAX_CALL" => "N",
									"COUNTRY_INPUT_NAME" => "COUNTRY",
									"REGION_INPUT_NAME" => "REGION",
									"CITY_INPUT_NAME" => $arProperties["FIELD_NAME"],
									"CITY_OUT_LOCATION" => "Y",
									"LOCATION_VALUE" => $value,
									"ORDER_PROPS_ID" => $arProperties["ID"],
									"ONCITYCHANGE" => ($arProperties["IS_LOCATION"] == "Y" || $arProperties["IS_LOCATION4TAX"] == "Y") ? "submitForm()" : "",
									"SIZE1" => $arProperties["SIZE1"],
								),
									array(
										"ID" => $value,
										"CODE" => "",
										"SHOW_DEFAULT_LOCATIONS" => "Y",

										// function called on each location change caused by user or by program
										// it may be replaced with global component dispatch mechanism coming soon
										"JS_CALLBACK" => "submitFormProxy",

										// function window.BX.locationsDeferred['X'] will be created and lately called on each form re-draw.
										// it may be removed when sale.order.ajax will use real ajax form posting with BX.ProcessHTML() and other stuff instead of just simple iframe transfer
										"JS_CONTROL_DEFERRED_INIT" => intval($arProperties["ID"]),

										// an instance of this control will be placed to window.BX.locationSelectors['X'] and lately will be available from everywhere
										// it may be replaced with global component dispatch mechanism coming soon
										"JS_CONTROL_GLOBAL_ID" => intval($arProperties["ID"]),

										"DISABLE_KEYBOARD_INPUT" => "Y",
										"PRECACHE_LAST_LEVEL" => "Y",
										"PRESELECT_TREE_TRUNK" => "Y",
										"SUPPRESS_ERRORS" => "Y"
									),
									$locationTemplateP,
									true,
									'location-block-wrapper'
								)?>

								<?if (strlen(trim($arProperties["DESCRIPTION"])) > 0):?>
									<div class="bx_description"><?=$arProperties["DESCRIPTION"]?></div>
								<?endif?>
							</div>
							<?
						}
						elseif ($arProperties["TYPE"] == "RADIO")
						{
							?>
							<div class="bx_block r3x1">
								<?
								if (is_array($arProperties["VARIANTS"]))
								{
									foreach($arProperties["VARIANTS"] as $arVariants):
									?>
										<input
											type="radio"
											name="<?=$arProperties["FIELD_NAME"]?>"
											id="<?=$arProperties["FIELD_NAME"]?>_<?=$arVariants["VALUE"]?>"
											value="<?=$arVariants["VALUE"]?>" <?if($arVariants["CHECKED"] == "Y") echo " checked";?> />

										<label for="<?=$arProperties["FIELD_NAME"]?>_<?=$arVariants["VALUE"]?>"><?=$arVariants["NAME"]?></label></br>
									<?
									endforeach;
								}
								?>
								<?if (strlen(trim($arProperties["DESCRIPTION"])) > 0):?>
									<div class="bx_description"><?=$arProperties["DESCRIPTION"]?></div>
								<?endif?>
							</div>
							<?
						}
						
						elseif ($arProperties["TYPE"] == "DATE")
						{
							?>
							<div>
								<?
								global $APPLICATION;

								$APPLICATION->IncludeComponent('bitrix:main.calendar', '', array(
									'SHOW_INPUT' => 'Y',
									'INPUT_NAME' => "ORDER_PROP_".$arProperties["ID"],
									'INPUT_VALUE' => $arProperties["VALUE"],
									'SHOW_TIME' => 'N'
								), null, array('HIDE_ICONS' => 'N'));
								?>
								<?if (strlen(trim($arProperties["DESCRIPTION"])) > 0):?>
									<div class="bx_description"><?=$arProperties["DESCRIPTION"]?></div>
								<?endif?>
							</div>
							<?
						}
						?>
						</div>
						<?}}?>
				<?if($user_prop==4){?>		<h5>Реквизиты организации</h5>
						<p>Вы можете заполнить форму или загрузить документ с реквизитами.</p>

						<div class="div_cherteg chert2">
						<ul class="its_files">
							
						</ul>
					</div>

					<div class="col-md-3 col-sm-4 padding_0">
						<label class="btn input-order-ino"> 	 					
						<input   size="0" type="file" data-id="<?=$user_prop;?>" data-prop="0">
							
						
						<span>Обзор...</span>					</label>

					</div>
						<textarea name="#" placeholder="Реквизиты юридического лица" name="ORDER_PROP_23"></textarea>
						<?}?>
					</div>
					<div style="clear:both"></div>
					<h3 class="card_setion_name">Доставка</h3>
					<p class="margin_top_40">Выберите удобный для Вас способ доставки. Поля, отмеченные звездочкой, обязательны для заполнения.
					<br/>Со стоимостью доставки можете ознакомиться на сайте транспортной компании.</p>
						<div class="radio">
							<?foreach ($arResult["DELIVERY"] as $delivery_id => $arDelivery)
		{
							?>
							
							<div class="col-md-3 col-sm-6 col-xs-12">
							
<input type="radio"
						id="ID_DELIVERY_ID_<?= $arDelivery["ID"] ?>"
						name="DELIVERY_ID"
						value="<?= $arDelivery["ID"] ?>"<?if ($arDelivery["CHECKED"]=="Y") echo " checked";?>
						
						/> <p><?=$arDelivery["NAME"];?></p>
							</div>
							<?}?>
							
							
						</div>
						<?
						if($user_prop==3)
						$soc=2;
						if($user_prop==4)
						$soc=4;
						?>
						  <?foreach($arResult["JS_DATA"]["ORDER_PROP"]["properties"] as $arProperties){
						  if($arProperties["PROPS_GROUP_ID"]==$soc){
						 
						  ?>
					<div class="col-md-6 col-sm-6 padding-left_0" <?if ($arProperties["TYPE"] == "LOCATION"){?> style="display:none"<?}?>>
						<?
						if ($arProperties["TYPE"] == "CHECKBOX")
						{
						
							?>
							<div class="bx_block r1x3 pt8">
								<input type="hidden" name="<?=$arProperties["FIELD_NAME"]?>" value="">
								<input type="checkbox" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" value="Y"<?if ($arProperties["CHECKED"]=="Y") echo " checked";?>>
								<?if (strlen(trim($arProperties["DESCRIPTION"])) > 0):?>
									<div class="bx_description"><?=$arProperties["DESCRIPTION"]?></div>
								<?endif?>
							</div>
							<?
						}
						elseif ($arProperties["TYPE"] == "STRING")
						{
						
							?>
							<div class="bx_block r3x1">
								<input type="text" placeholder="<?=$arProperties["NAME"]?><?if($arProperties["REQUIRED"]=="Y"){?>*<?}?>" maxlength="250" size="<?=$arProperties["SIZE"]?>" value="<?=$arProperties["VALUE"][0]?>" name="ORDER_PROP_<?=$arProperties["ID"]?>" id="ORDER_PROP_<?=$arProperties["ID"]?>" />
								<?if (strlen(trim($arProperties["DESCRIPTION"])) > 0):?>
									<div class="bx_description"><?=$arProperties["DESCRIPTION"]?></div>
								<?endif?>
							</div>
							<?
						}
						elseif ($arProperties["TYPE"] == "SELECT")
						{
							?>
							<div class="bx_block r3x1">
								<select name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" size="<?=$arProperties["SIZE1"]?>">
									<?foreach($arProperties["VARIANTS"] as $arVariants):?>
										<option value="<?=$arVariants["VALUE"]?>"<?=$arVariants["SELECTED"] == "Y" ? " selected" : ''?>><?=$arVariants["NAME"]?></option>
									<?endforeach?>
								</select>
								<?if (strlen(trim($arProperties["DESCRIPTION"])) > 0):?>
									<div class="bx_description"><?=$arProperties["DESCRIPTION"]?></div>
								<?endif?>
							</div>
							<?
						}
						elseif ($arProperties["TYPE"] == "MULTISELECT")
						{
							?>
							<div class="bx_block r3x1">
								<select multiple name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" size="<?=$arProperties["SIZE1"]?>">
									<?foreach($arProperties["VARIANTS"] as $arVariants):?>
										<option value="<?=$arVariants["VALUE"]?>"<?=$arVariants["SELECTED"] == "Y" ? " selected" : ''?>><?=$arVariants["NAME"]?></option>
									<?endforeach?>
								</select>
								<?if (strlen(trim($arProperties["DESCRIPTION"])) > 0):?>
									<div class="bx_description"><?=$arProperties["DESCRIPTION"]?></div>
								<?endif?>
							</div>
							<?
						}
						elseif ($arProperties["TYPE"] == "TEXTAREA")
						{
							$rows = ($arProperties["SIZE2"] > 10) ? 4 : $arProperties["SIZE2"];
							?>
							<div class="bx_block r3x1">
								<textarea rows="<?=$rows?>" cols="<?=$arProperties["SIZE1"]?>" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>"><?=$arProperties["VALUE"]?></textarea>
								<?if (strlen(trim($arProperties["DESCRIPTION"])) > 0):?>
									<div class="bx_description"><?=$arProperties["DESCRIPTION"]?></div>
								<?endif?>
							</div>
							<?
						}
						elseif ($arProperties["TYPE"] == "LOCATION")
						{
							?>
							<div  style="display:none">
								<?
								$value = 0;
								if (is_array($arProperties["VARIANTS"]) && count($arProperties["VARIANTS"]) > 0)
								{
									foreach ($arProperties["VARIANTS"] as $arVariant)
									{
										if ($arVariant["SELECTED"] == "Y")
										{
											$value = $arVariant["ID"];
											break;
										}
									}
								}

								// here we can get '' or 'popup'
								// map them, if needed
								if(CSaleLocation::isLocationProMigrated())
								{
									$locationTemplateP = $locationTemplate == 'popup' ? 'search' : 'steps';
									$locationTemplateP = $_REQUEST['PERMANENT_MODE_STEPS'] == 1 ? 'steps' : $locationTemplateP; // force to "steps"
								}
								?>

								<?if($locationTemplateP == 'steps'):?>
									<input type="hidden" id="LOCATION_ALT_PROP_DISPLAY_MANUAL[<?=intval($arProperties["ID"])?>]" name="LOCATION_ALT_PROP_DISPLAY_MANUAL[<?=intval($arProperties["ID"])?>]" value="<?=($_REQUEST['LOCATION_ALT_PROP_DISPLAY_MANUAL'][intval($arProperties["ID"])] ? '1' : '0')?>" />
								<?endif?>

								<?CSaleLocation::proxySaleAjaxLocationsComponent(array(
									"AJAX_CALL" => "N",
									"COUNTRY_INPUT_NAME" => "COUNTRY",
									"REGION_INPUT_NAME" => "REGION",
									"CITY_INPUT_NAME" => $arProperties["FIELD_NAME"],
									"CITY_OUT_LOCATION" => "Y",
									"LOCATION_VALUE" => $value,
									"ORDER_PROPS_ID" => $arProperties["ID"],
									"ONCITYCHANGE" => ($arProperties["IS_LOCATION"] == "Y" || $arProperties["IS_LOCATION4TAX"] == "Y") ? "submitForm()" : "",
									"SIZE1" => $arProperties["SIZE1"],
								),
									array(
										"ID" => $value,
										"CODE" => "",
										"SHOW_DEFAULT_LOCATIONS" => "Y",

										// function called on each location change caused by user or by program
										// it may be replaced with global component dispatch mechanism coming soon
										"JS_CALLBACK" => "submitFormProxy",

										// function window.BX.locationsDeferred['X'] will be created and lately called on each form re-draw.
										// it may be removed when sale.order.ajax will use real ajax form posting with BX.ProcessHTML() and other stuff instead of just simple iframe transfer
										"JS_CONTROL_DEFERRED_INIT" => intval($arProperties["ID"]),

										// an instance of this control will be placed to window.BX.locationSelectors['X'] and lately will be available from everywhere
										// it may be replaced with global component dispatch mechanism coming soon
										"JS_CONTROL_GLOBAL_ID" => intval($arProperties["ID"]),

										"DISABLE_KEYBOARD_INPUT" => "Y",
										"PRECACHE_LAST_LEVEL" => "Y",
										"PRESELECT_TREE_TRUNK" => "Y",
										"SUPPRESS_ERRORS" => "Y"
									),
									$locationTemplateP,
									true,
									'location-block-wrapper'
								)?>

								<?if (strlen(trim($arProperties["DESCRIPTION"])) > 0):?>
									<div class="bx_description"><?=$arProperties["DESCRIPTION"]?></div>
								<?endif?>
							</div>
							<?
						}
						elseif ($arProperties["TYPE"] == "RADIO")
						{
							?>
							<div class="bx_block r3x1">
								<?
								if (is_array($arProperties["VARIANTS"]))
								{
									foreach($arProperties["VARIANTS"] as $arVariants):
									?>
										<input
											type="radio"
											name="<?=$arProperties["FIELD_NAME"]?>"
											id="<?=$arProperties["FIELD_NAME"]?>_<?=$arVariants["VALUE"]?>"
											value="<?=$arVariants["VALUE"]?>" <?if($arVariants["CHECKED"] == "Y") echo " checked";?> />

										<label for="<?=$arProperties["FIELD_NAME"]?>_<?=$arVariants["VALUE"]?>"><?=$arVariants["NAME"]?></label></br>
									<?
									endforeach;
								}
								?>
								<?if (strlen(trim($arProperties["DESCRIPTION"])) > 0):?>
									<div class="bx_description"><?=$arProperties["DESCRIPTION"]?></div>
								<?endif?>
							</div>
							<?
						}
						
						elseif ($arProperties["TYPE"] == "DATE")
						{
							?>
							<div>
								<?
								global $APPLICATION;

								$APPLICATION->IncludeComponent('bitrix:main.calendar', '', array(
									'SHOW_INPUT' => 'Y',
									'INPUT_NAME' => "ORDER_PROP_".$arProperties["ID"],
									'INPUT_VALUE' => $arProperties["VALUE"],
									'SHOW_TIME' => 'N'
								), null, array('HIDE_ICONS' => 'N'));
								?>
								<?if (strlen(trim($arProperties["DESCRIPTION"])) > 0):?>
									<div class="bx_description"><?=$arProperties["DESCRIPTION"]?></div>
								<?endif?>
							</div>
							<?
						}
						?>
						</div>
						<?}}?>
						
					<div class="col-md-12 col-xs-12 padding_0">
						<p>После того, как заказ будет подтвержден, с Вами свяжется менеджер и уточнит информацию по заказу. Если ответа от Вас не будет в течение двух рабочих дней, то заказ будет
						аннулирован.</p>
					</div>
					<div class="col-md-6 col-md-offset-6">
						<div class="col-md-6 col-sm-6 padding-left_0"> 
							<a href="/cart/" class="btn_grey">Вернуться в козину</a>
							
						</div>
						<div class="col-md-6 col-sm-6 padding-left_0">
							
							<input type="submit" onclick="submitForm('Y'); return false;" class="btn" required value="отправить" >
						</div>
					</div>
				<?if($_POST["is_ajax_post"] != "Y")
			{
				?>
					</div>
					<input type="hidden" name="confirmorder" id="confirmorder" value="Y">
					<input type="hidden" name="profile_change" id="profile_change" value="N">
					<input type="hidden" name="is_ajax_post" id="is_ajax_post" value="Y">
					<input type="hidden" name="json" value="Y">
					<div class="bx_ordercart_order_pay_center"><a href="javascript:void();" onclick="submitForm('Y'); return false;" id="ORDER_CONFIRM_BUTTON" class="checkout"><?=GetMessage("SOA_TEMPL_BUTTON")?></a></div>
				</form>
				</div>
				<?
				if($arParams["DELIVERY_NO_AJAX"] == "N")
				{
					?>
					<div style="display:none;"><?$APPLICATION->IncludeComponent("bitrix:sale.ajax.delivery.calculator", "", array(), null, array('HIDE_ICONS' => 'Y')); ?></div>
					<?
				}
			}
			else
			{
				?>
				<script type="text/javascript">
					top.BX('confirmorder').value = 'Y';
					top.BX('profile_change').value = 'N';
				</script>
				<?
				die();
			}
		}
	}?>


			</div>
		</div>
	</div>
</section>

<?if(CSaleLocation::isLocationProEnabled()):?>

	<div style="display: none">
		<?// we need to have all styles for sale.location.selector.steps, but RestartBuffer() cuts off document head with styles in it?>
		<?$APPLICATION->IncludeComponent(
			"bitrix:sale.location.selector.steps", 
			".default", 
			array(
			),
			false
		);?>
		<?$APPLICATION->IncludeComponent(
			"bitrix:sale.location.selector.search", 
			".default", 
			array(
			),
			false
		);?>
	</div>

<?endif?>
<form method="post" action="" style="display:none">
<input type="text" class="inp_th_prs" name="PERSON_TYPE" value="<?=$user_prop;?>">
</form>
<?}else{?>
Добавьте товары в корзину
<?}?>
<?}?> 
</div>