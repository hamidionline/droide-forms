<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_custom
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
require_once __DIR__ . '/helper.php';

$doc = JFactory::getDocument();

//ler script php
//$doc =& JDocument::getInstance( 'mytype' );
//$renderer =& $doc->loadRenderer( 'myrenderer' );

$doc->addScript(JUri::base() . 'media/mod_droideforms/assets/enviar.js');

$loadJquery = $params->get('loadJquery', 1);

$helper = new modDroideformsHelper();

$idmodule = $helper->Encrypt($module->id);

if($loadJquery){
	$doc->addScript(JUri::base() . 'media/mod_droideforms/assets/jquery-1.12.0.min.js');
}
$id_form = $params->get('id_form');

$js = <<<JS

var j = jQuery.noConflict();

j(document).ready(function(){
   sendNext.init('#$id_form');
});

JS;
$doc->addScriptDeclaration($js);

if(!$params->get('id_form',0)){
	$rand_id = 'form_'.rand(10,99999999);
	$params->set('id_form',$rand_id);
}

$filtros = json_decode($params->get('filtros'));
$validacao = array();
foreach ($filtros->tipo as $k => $tipo) {
	$validacao[] = array($tipo=>$filtros->field_name[$k],'condition'=>$filtros->field_condition[$k],'mensagem'=>$filtros->text_validador[$k]);
}

if($validacao){
 $validacao= json_encode($validacao);
}


require JModuleHelper::getLayoutPath('mod_droideforms', $params->get('layout', 'default'));