AddEventHandler("sale", "OnBeforeBasketAdd", "OnBeforeBasketAddHandler");
function  OnBeforeBasketAddHandler(&$arFields)
{
	define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"]."/log.txt");
	//AddMessage2Log(print_r($arFields, true));
	global $USER;
	$arGroups = $USER->GetUserGroupArray();
	if(in_array(20, $arGroups)) { // если пользователь принадлежит заданной группе (менеджер)
		$db_res = CCatalogProduct::GetList(array("ID" =>"ASC"), array("ID" => $arFields['PRODUCT_ID']), false, false, array("QUANTITY"));
		$ar_res = $db_res->Fetch();
		//AddMessage2Log("nearest Quantity = ".$ar_res["QUANTITY"]);
		if($ar_res["QUANTITY"] < 2) { //Если кол-во доступного товара меньше двух, то не добавляем в корзину
			return new Main\EventResult(Main\EventResult::ERROR);
		}
	}
}
