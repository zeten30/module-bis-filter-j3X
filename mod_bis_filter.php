<?php

//no direct access
defined('_JEXEC') or die;

// include the helper file
require_once(dirname(__FILE__) . DS . 'helper.php');

// add jscript and css files for jquery tabs
$document = & JFactory::getDocument();
$base_url = JURI::base() . 'modules/mod_bis_filter/';

$lang = & JFactory::getLanguage();
$lang_code = $lang->getTag();

$document->addStyleSheet($base_url . 'css/mod_bis_filter.css');
$document->addStyleSheet($base_url . 'css/datepicker_dashboard/datepicker_dashboard.css');

if ($lang_code == 'cs-CZ') {
  $document->addScript($base_url . 'js/datepicker/Locale.cs-CZ.DatePicker.js');
  $document->addScript($base_url . 'js/mod_bis_filter.cs-CZ.js');
}

$document->addScript($base_url . 'js/mod_bis_filter.js');
$document->addScript($base_url . 'js/datepicker/Picker.js');
$document->addScript($base_url . 'js/datepicker/Picker.Attach.js');
$document->addScript($base_url . 'js/datepicker/Picker.Date.js');

//Get saved values for filters or set thme from POST
$filter_data = Mod_BisFilterHelper::handleFilterData();

//Make array of enbled filters in display order
$ordered_filters = Mod_BisFilterHelper::getOrderedFilters($params);

//Params
$display_style = $params->get('display-style');
$label_style = $params->get('label-style');
$css_class = $params->get('css-class');


// include the template for display
require(JModuleHelper::getLayoutPath('mod_bis_filter'));
?>
