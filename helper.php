<?php

defined('_JEXEC') or die;

//We need content plugin BIS to be installed !!!
require_once (JPATH_BASE . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . 'content' . DIRECTORY_SEPARATOR . 'bis' . DIRECTORY_SEPARATOR . 'myr' . DIRECTORY_SEPARATOR . 'myr.php');

jimport('joomla.html.parameter');

abstract class Mod_BisFilterHelper {

  public function handleFilterData() {

    $mainframe = & JFactory::getApplication();
    $jinput = & JFactory::getApplication()->input;

    //Get/Set vars
    $date_from = self::handleStatePostVariable($mainframe, $jinput, 'state_date_from', 'date');
    $date_to = self::handleStatePostVariable($mainframe, $jinput, 'state_date_to', 'date-to');
    $for = self::handleStatePostVariable($mainframe, $jinput, 'state_for', 'for');
    $program = self::handleStatePostVariable($mainframe, $jinput, 'state_program', 'program');
    $organized = self::handleStatePostVariable($mainframe, $jinput, 'state_organized', 'organized');
    $type = self::handleStatePostVariable($mainframe, $jinput, 'state_type', 'type');

    return array(
        'date_from' => $date_from,
        'date_to' => $date_to,
        'for' => $for,
        'program' => $program,
        'organized' => $organized,
        'type' => $type
    );
  }

  private function handleStatePostVariable($mainframe, $jinput, $name, $post_name) {
    $var = $mainframe->getUserState($name, '');

    if ($var == '') {
      $mainframe->setUserState($name, '');
    }

    $post_var = $jinput->get('filter-by-' . $post_name, '##not set##');

    if ($post_var != '##not set##') {
      $mainframe->setUserState($name, $post_var);
    }

    return $var;
  }

  private function getStateVar($name) {
    $mainframe = & JFactory::getApplication();
    return $mainframe->getUserState($name, '');
  }

  public function getOrderedFilters($params) {
    $filter_count = self::getFilterCount($params);
    $filters = array('labels' => array(),
        'filters' => array());

    for ($i = 1; $i <= $filter_count; $i++) {
      $filter_name = self::getFilterOrder($params, $i);
      $filters['labels']["$i"] = self::getLabel($params, $filter_name);


      switch ($filter_name) {
        case 'date':
          $filters['filters']["$i"] = self::controlDate();
          break;
        case 'for':
          $filters['filters']["$i"] = self::controlFor();
          break;
        case 'program':
          $filters['filters']["$i"] = self::controlProgram();
          break;
        case 'organized':
          $filters['filters']["$i"] = self::controlOrganized();
          break;
        case 'type':
          $filters['filters']["$i"] = self::controlType();
          break;
      }
    }


    return $filters;
  }

  private function getZCList() {
    $myr = new myr();
    $result = $myr->doQuery('query=zc');
    $ret = array();

    foreach ($result->data as $record) {
      $id = (string) $record->id;
      $name = (string) $record->nazev;
      $ret["$id"] = $name;
    }

    return $ret;
  }

  private function buildSelectForm($arr, $name, $selected) {

    $ret = "<select name=\"filter-by-$name\" id=\"filter-by-$name\" size=\"1\">\n";
    $ret.="<option value=\" \"> </option>\n";

    foreach ($arr as $key => $value) {

      if ($selected == $key) {
        $mark_selected = 'selected="selected"';
      } else {
        $mark_selected = '';
      }

      $ret.="<option $mark_selected value=\"$key\">$value</option>\n";
    }

    $ret.="</select>";
    return $ret;
  }

  private function controlOrganized() {
    $zc_arr = self::getZCList();
    $selected=self::getStateVar('state_organized');
    return self::buildSelectForm($zc_arr, 'organized', $selected);
  }

  private function controlProgram() {

    $arr = array('ap' => 'Akce příroda',
        'pamatky' => 'Akce památky',
        'brdo' => 'BRĎ0',
        'ekostan' => 'Ekostan',
        'psb' => 'Prázdniny s Brontosaurem',
        'vzdelavani' => 'Vzdělávání');

    $selected=self::getStateVar('state_program');

    return self::buildSelectForm($arr, 'program', $selected);
  }

  private function controlFor() {

    $arr = array('dospeli' => 'Pro dospělé',
        'deti' => 'Pro děti',
        'detirodice' => 'Pro rodiče s dětmi',
        'prvouc' => 'Jedu poprvé');

    $selected=self::getStateVar('state_for');

    return self::buildSelectForm($arr, 'for', $selected);
  }

  private function controlType() {

    $arr = array('pracovni' => 'Pracovně-prožitkové',
        'prozitkova' => 'Prožitková',
        'sportovni' => 'Sportovní',
        'vzdelavaci' => 'Vzdělávací',
        'prednaska' => 'Přednáška',
        'verejnost' => 'Pro veřejnost');

    $selected=self::getStateVar('state_type');

    return self::buildSelectForm($arr, 'type', $selected);
  }

  private function controlDate() {
    $from=self::getStateVar('state_date_from');
    $to=self::getStateVar('state_date_to');

    $ret = "<input name=\"filter-by-date\"
      id=\"filter-by-date\"
      value=\"$from\" />\n";

    $ret .= "<input name=\"filter-by-date-to\"
      id=\"filter-by-date-to\"
      value=\"$to\" />\n";

    return $ret;
  }

  private function formLabel($name, $label) {
    return "<label for=\"filter-by-$name\">$label</label>\n";
  }

  private function getFilterCount($params) {

    $date = $params->get('show-filter-date');
    $for = $params->get('show-filter-for');
    $program = $params->get('show-filter-program');
    $organized = $params->get('show-filter-organized');
    $type = $params->get('show-filter-type');

    $ret = (int) $date + $for + $program + $organized + $type;
    return $ret;
  }

  private function getFilterOrder($params, $order) {
    $date_order = $params->get('filter-date-order');
    $for_order = $params->get('filter-for-order');
    $program_order = $params->get('filter-program-order');
    $organized_order = $params->get('filter-organized-order');
    $type_order = $params->get('filter-type-order');

    switch ($order) {
      case $date_order:
        $ret = 'date';
        break;
      case $for_order:
        $ret = 'for';
        break;
      case $program_order:
        $ret = 'program';
        break;
      case $organized_order:
        $ret = 'organized';
        break;
      case $type_order:
        $ret = 'type';
        break;
    }

    return $ret;
  }

  private function getLabel($params, $name) {
    $param_label = $params->get("filter-$name-label");

    if ($param_label == '') {
      $param_label = JText::_("MOD_BIS_FILTER_" . strtoupper($name));
    }

    return self::formLabel($name, $param_label);
  }

}

?>
