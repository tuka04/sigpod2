<?php
session_start();
date_default_timezone_set("America/Sao_Paulo");
include_once PATH_SERVER.'kernel/config/defines.php';
//shared memory
require_once PATH_SERVER.'kernel/classes/sharedmem/SharedMemory.class.php';
$sh = new SharedMemory();
//classes comuns
require_once PATH_SERVER.'kernel/classes/common/ArrayObj.class.php';
require_once PATH_SERVER.'kernel/classes/common/Base64.class.php';
require_once PATH_SERVER.'kernel/classes/common/File.class.php';
require_once PATH_SERVER.'kernel/classes/common/FileInfo.class.php';
require_once PATH_SERVER.'kernel/classes/common/CharSet.class.php';
//configuracao
require_once PATH_SERVER.'kernel/classes/config/Config.class.php';
require_once PATH_SERVER.'kernel/classes/config/Server.class.php';
//erros
require_once PATH_SERVER.'kernel/classes/error/Error.class.php';
//bd
require_once PATH_SERVER.'kernel/classes/bd/Queries.class.php';
require_once PATH_SERVER.'kernel/classes/bd/BD.class.php';
require_once PATH_SERVER.'kernel/classes/bd/BDColumns.class.php';
require_once PATH_SERVER.'kernel/classes/dao/GenericObj.class.php';
//interface
require_once PATH_SERVER.'kernel/plugins/smarty/libs/Smarty.class.php';
require_once PATH_SERVER.'kernel/classes/interface/Frontend.class.php';

?>