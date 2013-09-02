<?php /* Smarty version Smarty-3.1.14, created on 2013-09-01 23:07:05
         compiled from "/var/www/html/sigpod2/templates/teste.html" */ ?>
<?php /*%%SmartyHeaderCode:20211581135223c98c12d8f8-79001032%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6cece6ad1e1bb492c77808cf56f5393fc446e53f' => 
    array (
      0 => '/var/www/html/sigpod2/templates/teste.html',
      1 => 1378087625,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20211581135223c98c12d8f8-79001032',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_5223c98c163604_24331112',
  'variables' => 
  array (
    'EJS' => 0,
    'ECSS' => 0,
    'server' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5223c98c163604_24331112')) {function content_5223c98c163604_24331112($_smarty_tpl) {?><?php  $_config = new Smarty_Internal_Config("env.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars(null, 'local'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate, max-age=0" />
<meta http-equiv="Pragma-directive" content="no-cache" />
<meta http-equiv="Cache-Directive" content="no-cache" />
<meta http-equiv="Expires" content="-1" />
<?php echo $_smarty_tpl->getConfigVariable('basicjs');?>

<?php echo $_smarty_tpl->getConfigVariable('basiccss');?>

<?php echo $_smarty_tpl->tpl_vars['EJS']->value;?>

<?php echo $_smarty_tpl->tpl_vars['ECSS']->value;?>

<title><?php echo $_smarty_tpl->tpl_vars['server']->value->getTitulo();?>
</title>
</head>
<body>
<?php echo $_smarty_tpl->tpl_vars['server']->value->getName();?>
 : <?php echo $_smarty_tpl->tpl_vars['server']->value->getApp();?>

</body>
</html><?php }} ?>