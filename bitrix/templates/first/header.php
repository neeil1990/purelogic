<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

?>

  
		
		
		<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="ru"> <!--<![endif]-->

<head>

	<meta charset="utf-8">

	<title><?$APPLICATION->ShowTitle();?></title>
	
	 <?$APPLICATION->ShowHead()?>
	
<?
$APPLICATION->SetAdditionalCSS("/libs/font-awesome-4.2.0/css/font-awesome.min.css");
$APPLICATION->SetAdditionalCSS("/libs/bootstrap/css/bootstrap-grid.min.css");
$APPLICATION->SetAdditionalCSS("/libs/popup/magnific-popup.css");
$APPLICATION->SetAdditionalCSS("/libs/owl-carousel/owl.carousel.css");
$APPLICATION->SetAdditionalCSS("/css/fonts.css");
$APPLICATION->SetAdditionalCSS("/css/main.css");
$APPLICATION->SetAdditionalCSS("/css/media.css");
$APPLICATION->AddHeadScript("/libs/modernizr/modernizr.js");

?>
<script src="/libs/jquery/jquery-1.11.3.min.js"></script>
	<script src="/libs/waypoints/waypoints.min.js"></script>
	
	<script src="/libs/plugins-scroll/plugins-scroll.js"></script>
	<script src="/libs/owl-carousel/owl.carousel.min.js"></script>
	<script src="/libs/popup/magnific-popup.js"></script>
	<script src="/js/common.js"></script>
	<script src="/js/accordion.js"></script>
	<script src="/js/wSelect.min.js"></script>

	<script language="javascript">
	$(document).ready(function() {
    $(".topnav").accordion({
        accordion:false,
        speed: 500,
        closedSign: '+',
        openedSign: '-'
    });
});
</script>
	<link rel="shortcut icon" href="/img/favicon/favicon.png" type="image/x-icon">
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	
<link href="https://fonts.googleapis.com/css?family=Ubuntu:400,300,300italic,700,500,500italic,400italic,700italic" rel="stylesheet" type="text/css">
</head>

<body>
<div id="panel">
			<?$APPLICATION->ShowPanel();?>
		</div>
<header>
	<div class="container">
		<div class="row">
			<div class="col-md-5 col-lg-6 col-sm-8 col-xs-6">
				<div class="header_phone">
					<span class="icon_phone_header"><i class="fa fa-phone" aria-hidden="true"></i></span>
				<?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/phone-top.php"), false);?>	
				</div>
				<div class="obrat_zvonok hidden-md hidden-xs">
					<span><img src="/img/icon/obr_zvon.png" alt=""></span>
					<a href="#" class="obr_zvon_a">Обратный звонок</a>
					<div class="zvon_form">
		<?$APPLICATION->IncludeComponent(
	"altasib:feedback.form", 
	"new", 
	array(
		"ACTIVE_ELEMENT" => "Y",
		"ADD_LEAD" => "N",
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"ALX_CHECK_NAME_LINK" => "N",
		"BACKCOLOR_ERROR" => "#ffffff",
		"BBC_MAIL" => "",
		"BORDER_RADIUS" => "3px",
		"CATEGORY_SELECT_NAME" => "Выберите категорию",
		"CHECK_ERROR" => "Y",
		"COLOR_ERROR" => "#8E8E8E",
		"COLOR_ERROR_TITLE" => "#A90000",
		"COLOR_HINT" => "#000000",
		"COLOR_INPUT" => "#727272",
		"COLOR_MESS_OK" => "#963258",
		"COLOR_NAME" => "#000000",
		"EVENT_TYPE" => "ALX_FEEDBACK_FORM",
		"FB_TEXT_NAME" => "",
		"FB_TEXT_SOURCE" => "PREVIEW_TEXT",
		"FORM_ID" => "1",
		"HIDE_FORM" => "N",
		"IBLOCK_ID" => "10",
		"IBLOCK_TYPE" => "altasib_feedback",
		"IMG_ERROR" => "/upload/altasib.feedback.gif",
		"IMG_OK" => "/upload/altasib.feedback.ok.gif",
		"JQUERY_EN" => "N",
		"LOCAL_REDIRECT_ENABLE" => "N",
		"MASKED_INPUT_PHONE" => array(
		),
		"MESSAGE_OK" => "Сообщение отправлено!",
		"NAME_ELEMENT" => "ALX_DATE",
		"PROPERTY_FIELDS" => array(
			0 => "PHONE",
			1 => "FIO",
		),
		"PROPERTY_FIELDS_REQUIRED" => array(
			0 => "PHONE",
			1 => "FIO",
		),
		"PROPS_AUTOCOMPLETE_EMAIL" => array(
		),
		"PROPS_AUTOCOMPLETE_NAME" => array(
		),
		"PROPS_AUTOCOMPLETE_PERSONAL_PHONE" => array(
		),
		"PROPS_AUTOCOMPLETE_VETO" => "N",
		"REWIND_FORM" => "N",
		"SECTION_MAIL_ALL" => "sale@pl.iswin.ru",
		"SEND_MAIL" => "N",
		"SHOW_MESSAGE_LINK" => "Y",
		"SIZE_HINT" => "10px",
		"SIZE_INPUT" => "12px",
		"SIZE_NAME" => "12px",
		"USERMAIL_FROM" => "N",
		"USE_CAPTCHA" => "N",
		"WIDTH_FORM" => "50%",
		"COMPONENT_TEMPLATE" => "new"
	),
	false
);?>
				</div>
				</div>
					
				
			</div>
			<div class="col-md-7 col-lg-6 col-sm-4 col-xs-6 padding_left_xs_0">
				<div class="icon_wr_sm">
					<div class="col-md-4 col-lg-5 hidden-xs hidden-sm">
					<?$APPLICATION->IncludeComponent(
	"bitrix:search.title", 
	"new", 
	array(
		"NUM_CATEGORIES" => "1",
		"TOP_COUNT" => "5",
		"CHECK_DATES" => "N",
		"SHOW_OTHERS" => "N",
		"PAGE" => SITE_DIR."catalog/",
		"CATEGORY_0_TITLE" => GetMessage("SEARCH_GOODS"),
		"CATEGORY_0" => array(
			0 => "iblock_1c_catalog",
		),
		"CATEGORY_0_iblock_catalog" => array(
			0 => "all",
		),
		"CATEGORY_OTHERS_TITLE" => GetMessage("SEARCH_OTHER"),
		"SHOW_INPUT" => "Y",
		"INPUT_ID" => "title-search-input",
		"CONTAINER_ID" => "search",
		"PRICE_CODE" => array(
			0 => "Продажа на сайте",
		),
		"SHOW_PREVIEW" => "Y",
		"PREVIEW_WIDTH" => "75",
		"PREVIEW_HEIGHT" => "75",
		"CONVERT_CURRENCY" => "Y",
		"COMPONENT_TEMPLATE" => "new",
		"ORDER" => "date",
		"USE_LANGUAGE_GUESS" => "Y",
		"PRICE_VAT_INCLUDE" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "",
		"CURRENCY_ID" => "RUB",
		"CATEGORY_0_iblock_1c_catalog" => array(
			0 => "5",
			1 => "18",
		)
	),
	false
);?>
					
						
					</div>
					<div class="hidden-md hidden-lg col-sm-2 col-xs-2">
						<a href="#reg-01" class="search_sm"><i class="fa fa-search" aria-hidden="true"></i></a>
					</div>
					<!-- popup -->

							<div id="reg-01" class="popup-modal reg_popup slider mfp-hide">
	                            <div id="login-form">
		                            
	                            	
	                               <?$APPLICATION->IncludeComponent("bitrix:search.title", "new", Array(
	"NUM_CATEGORIES" => "1",	// Количество категорий поиска
		"TOP_COUNT" => "5",	// Количество результатов в каждой категории
		"CHECK_DATES" => "N",	// Искать только в активных по дате документах
		"SHOW_OTHERS" => "N",	// Показывать категорию "прочее"
		"PAGE" => SITE_DIR."catalog/",	// Страница выдачи результатов поиска (доступен макрос #SITE_DIR#)
		"CATEGORY_0_TITLE" => GetMessage("SEARCH_GOODS"),	// Название категории
		"CATEGORY_0" => array(	// Ограничение области поиска
			0 => "iblock_1c_catalog",
		),
		"CATEGORY_0_iblock_catalog" => array(
			0 => "all",
		),
		"CATEGORY_OTHERS_TITLE" => GetMessage("SEARCH_OTHER"),
		"SHOW_INPUT" => "Y",	// Показывать форму ввода поискового запроса
		"INPUT_ID" => "title-search-input",	// ID строки ввода поискового запроса
		"CONTAINER_ID" => "search",	// ID контейнера, по ширине которого будут выводиться результаты
		"PRICE_CODE" => array(	// Тип цены
			0 => "БИТРИКС ТИПОВОЕ",
		),
		"SHOW_PREVIEW" => "Y",	// Показать картинку
		"PREVIEW_WIDTH" => "75",	// Ширина картинки
		"PREVIEW_HEIGHT" => "75",	// Высота картинки
		"CONVERT_CURRENCY" => "Y",	// Показывать цены в одной валюте
		"COMPONENT_TEMPLATE" => "visual",
		"ORDER" => "date",	// Сортировка результатов
		"USE_LANGUAGE_GUESS" => "Y",	// Включить автоопределение раскладки клавиатуры
		"PRICE_VAT_INCLUDE" => "Y",	// Включать НДС в цену
		"PREVIEW_TRUNCATE_LEN" => "",	// Максимальная длина анонса для вывода
		"CURRENCY_ID" => "RUB",	// Валюта, в которую будут сконвертированы цены
		"CATEGORY_0_iblock_1c_catalog" => array(	// Искать в информационных блоках типа "iblock_1c_catalog"
			0 => "5",
		)
	),
	false
);?>
	                            </div>
	                        </div>


					<div class="col-md-5 col-lg-4 col-sm-2 col-xs-3">
						<div class="korzina">
						<div id="cucuca"><?$APPLICATION->IncludeComponent(
	"bitrix:sale.basket.basket.line", 
	"new", 
	array(
		"PATH_TO_BASKET" => SITE_DIR."cart/",
		"PATH_TO_PERSONAL" => SITE_DIR."personal/",
		"SHOW_PERSONAL_LINK" => "N",
		"SHOW_NUM_PRODUCTS" => "Y",
		"SHOW_TOTAL_PRICE" => "Y",
		"SHOW_PRODUCTS" => "N",
		"POSITION_FIXED" => "N",
		"SHOW_AUTHOR" => "N",
		"PATH_TO_REGISTER" => SITE_DIR."login/",
		"PATH_TO_PROFILE" => SITE_DIR."personal/",
		"COMPONENT_TEMPLATE" => "new",
		"PATH_TO_ORDER" => SITE_DIR."personal/order/make/",
		"SHOW_EMPTY_VALUES" => "Y",
		"HIDE_ON_BASKET_PAGES" => "N"
	),
	false
);?>
</div>
						
							<div class="korzina_podskazka">
								<p>Товар добавлен</p>
								<a class="btn_grey" href="/cart/">Перейти в козину</a>
							</div>		
						</div>
					</div>
					<div class="col-md-3 col-lg-3 col-sm-8 col-xs-6  ">
						<?global $USER;
						global $APPLICATION;
$dir = $APPLICATION->GetCurDir();
			//$languages=array("/en/","/ua/");			
						?>
						<?if(in_array(substr($dir, 0, 4),$languages)){
						$not_rus=true;?>
	
	<?}?>
							<a href="<?/*if ($USER->IsAuthorized()) {?>/personal/<?}else{?>#<?}*/?>#" class="hidden-xs user_head"><i class="fa fa-user" aria-hidden="true"></i></a>
							<div class="select_language">
								<select id="demo" class="lang_choice" tabindex="1">
							        <option <?if(!$not_rus){?>selected<?}?> <?if($not_rus){?>value="<?=str_replace(substr($dir, 0, 4),"/",$dir);?>"<?}?>>ru</option> 
<?foreach($languages as $lng){?>
 <option <?if(substr($dir, 0, 4)==$lng){?>selected<?}else{ if($not_rus){?>value="<?=str_replace(substr($dir, 0, 4),$lng,$dir);?>"<?}else{?>value="<?=substr($lng, 0, 3).$dir;?>"<?}?><?}?>   ><?=str_replace("/","",$lng);?></option>
<?}?>							       
								  
							       
							      
							                   
							    </select>
							</div>
					
					</div>
				</div>	
				
			</div>

		</div>
		
	</div>
</header>
<section class="main_logo">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-lg-6 col-sm-5 сol-xs-12">
				<div class="logo">
					
					<?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/logo.php"), false);?>
					
				</div>
				<a class="menu-toggle_cat hidden-lg hidden-md hidden-sm " href="#"><span>Menu</span></a>
			</div>

			<div class="col-md-6 col-lg-6 col-sm-7  padding-xs-0 col-xs-12">
			
				<div class="main_logo_menu ">
					<ul>
						<li class="hidden-xs"><a href="/" class="glavna">!</a></li>
						<?$APPLICATION->IncludeComponent("bitrix:menu", "new_top", Array(
	"ROOT_MENU_TYPE" => "top",	// Тип меню для первого уровня
		"MENU_CACHE_TYPE" => "A",	// Тип кеширования
		"MENU_CACHE_TIME" => "36000000",	// Время кеширования (сек.)
		"MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
		"MENU_THEME" => "site",
		"CACHE_SELECTED_ITEMS" => "N",
		"MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
		"MAX_LEVEL" => "1",	// Уровень вложенности меню
		"CHILD_MENU_TYPE" => "left",	// Тип меню для остальных уровней
		"USE_EXT" => "N",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
		"DELAY" => "N",	// Откладывать выполнение шаблона меню
		"ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
		"COMPONENT_TEMPLATE" => ".default",
		
	)
);?>
						<li class="hidden-lg hidden-sm hidden-md black_bg "><a href="#reg-05" class="obr_zvon_popop" >Обратный звонок</a></li>
						<li class="hidden-lg hidden-sm hidden-md black_bg"><a href="#reg-03" class="vhod_pop" >Личный кабинет</a></li>
						<!-- Popup kabinet -->
						<div id="reg-03" class="popup-modal reg_popup slider mfp-hide">
	                            <div id="login-form">
		                            <div class="logo_popup">
		                            	<img src="/img/main_logo.png" alt="">
		                            </div>
	                            	
	                                 <?
					$APPLICATION->IncludeComponent(
	"bitrix:system.auth.form",
	"new_sm",
	Array(
"SHOW_ERRORS" => "Y",


	)
);
?> 
	                            </div>
	                        </div> 
	                    <!-- Popup obrat_zvonok -->
						<div id="reg-05" class="popup-modal reg_popup slider mfp-hide">
	                        <div id="login-form">
	                        <h2>Обратный звонок</h2>
		                      <form action="#" id="user_form" >
	                                <input type="text" name="" placeholder="Имя" />
									<input type="text" name="" placeholder="Телефон" />
									<input type="submit" name="" value="Перезвоните мне" class="submit btn" />
	                            </form>
	                        </div>
	                    </div> 


					</ul>
				</div>
			</div>

		</div>
	</div>
</section>
<!-- Форма входа при клике  -->
<section class="main_logo_vhod">
	<div class="container">
		<div class="row">
			<div class="col-md-3 col-lg-4  col-sm-6 col-xs-5 ">
				<div class="logo">
				<?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/logo.php"), false);?>
				</div>
			</div>
			<div class="col-md-9 col-lg-8 col-sm-6 col-xs-7 ">
				<div class="main_vhod">
					<a href="/vhod/registration.php">регистрация</a>
					<?
					$APPLICATION->IncludeComponent(
	"bitrix:system.auth.form",
	"new",
	Array(
"SHOW_ERRORS" => "Y",

	)
);
?> 
					
                    <a href="#reg-03" class="btn hidden-md hidden-lg user_header" >войти</a> 

                    <div id="reg-03" class="popup-modal reg_popup slider mfp-hide">
                            <div id="login-form">
	                            <div class="logo_popup">
	                            	<?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/logo.php"), false);?>
	                            </div>
                            	
                                <?
					$APPLICATION->IncludeComponent(
	"bitrix:system.auth.form",
	"new_for_sm",
	Array(
"SHOW_ERRORS" => "Y",


	)
);
?> 
                            </div>
                        </div>
					<a href="/vhod/?forgot_password=yes" class="vspomnit_parol">вспомнить пароль</a>
				</div>
			</div>
		</div>
	</div>
</section>
<?if($USER->IsAuthorized()): ?>
<div id="auth_yes"></div>
<?endif;?>
<? if ($APPLICATION->GetCurPage(false) !== '/services/'&&$APPLICATION->GetCurPage(false) !== '/'&&$APPLICATION->GetCurPage()!=="/vhod/registration.php"&&!CSite::InDir('/personal/')): ?> 
<?if (!defined('ERROR_404') || ERROR_404 != 'Y') {?>
<section class="main_katalog catalog_categories_wr">
<div class="container">
<?if(!$_GET["q"]){?>
<div class="row">
			<div class="col-md-4 ">
			<div class="togle_wr hidden-lg hidden-md"> 
		<a class="menu-toggle main_menu hidden-lg hidden-md" href="#"><span>Menu</span></a>
		<p>Все категории</p>
	</div>
			<?$APPLICATION->IncludeComponent("bitrix:menu", "new", array(
							"ROOT_MENU_TYPE" => "left",
							"MENU_CACHE_TYPE" => "A",
							"MENU_CACHE_TIME" => "36000000",
							"MENU_CACHE_USE_GROUPS" => "Y",
							"MENU_THEME" => "site",
							
							"MENU_CACHE_GET_VARS" => array(
							),
							"MAX_LEVEL" => "4",
							"CHILD_MENU_TYPE" => "left",
							"USE_EXT" => "Y",
							"DELAY" => "N",
							"ALLOW_MULTI_SELECT" => "N",
						),
						false
					);?>
					<?$APPLICATION->IncludeComponent("bitrix:menu", "new_mob", array(
							"ROOT_MENU_TYPE" => "left",
							"MENU_CACHE_TYPE" => "A",
							"MENU_CACHE_TIME" => "36000000",
							"MENU_CACHE_USE_GROUPS" => "Y",
							"MENU_THEME" => "site",
							
							"MENU_CACHE_GET_VARS" => array(
							),
							"MAX_LEVEL" => "3",
							"CHILD_MENU_TYPE" => "left",
							"USE_EXT" => "Y",
							"DELAY" => "N",
							"ALLOW_MULTI_SELECT" => "N",
						),
						false
					);?>
					</div>
					<div class="col-md-8 "> 
					<div class="col-md-12 padding_0"><?$APPLICATION->IncludeComponent(
	"bitrix:breadcrumb",
	"new",
	Array(
		"PATH" => "",
		"SITE_ID" => "s1",
		"START_FROM" => "0"
	)
);?>
</div>
<?}?>
<?}?>
<? endif; ?> 