<?php
//classes comuns
require_once 'config/defines.php';
require_once 'classes/common/ArrayObj.class.php';
require_once 'classes/common/Base64.class.php';
require_once 'classes/common/File.class.php';
//configuracao
require_once 'classes/config/Config.class.php';
apc_store(APC_CONF, new Config());
//erros
require_once 'classes/error/Error.class.php';
//bd
require_once 'classes/bd/Queries.class.php';
require_once 'classes/bd/BD.class.php';

?>