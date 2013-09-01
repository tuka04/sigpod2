<?php
session_start();
date_default_timezone_set("America/Sao_Paulo");
include_once 'config/server.php';
include_once 'config/defines.php';
//classes comuns
require_once 'config/defines.php';
require_once 'classes/common/ArrayObj.class.php';
require_once 'classes/common/Base64.class.php';
require_once 'classes/common/File.class.php';
require_once 'classes/common/CharSet.class.php';
//configuracao
require_once 'classes/config/Config.class.php';
$_SERVER[APC_CONF] = serialize(new Config());
//apc_store(APC_CONF, new Config());
//erros
require_once 'classes/error/Error.class.php';
//bd
require_once 'classes/bd/Queries.class.php';
require_once 'classes/bd/BD.class.php';
require_once 'classes/bd/BDColumns.class.php';
//interface
require_once 'plugins/smarty/libs/Smarty.class.php';
require_once 'classes/interface/Frontend.class.php';
$s = new Smarty();
$s->setTemplateDir(PATH_SMARTY_TEMPLATE);
$s->setCompileDir(PATH_SMARTY_TEMPLATE_COMPILE);
$_SERVER[APC_SMARTY] = serialize($s);

?>