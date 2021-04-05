<?php

use Bitrix\Main\ModuleManager;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Loader;

IncludeModuleLangFile(__FILE__);

class manao_linking extends CModule
{
    var $MODULE_ID = 'manao.linking';

    function __construct()
    {
        $arModuleVersion = array();

        include(__DIR__ . '/version.php');

        if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion))
        {
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }

        $this->MODULE_NAME = 'Перелинковка ссылок';
        $this->MODULE_DESCRIPTION = 'Перелинковка старых ссылок при переезде на новый движок';
        $this->PARTNER_NAME = "Manao";
        $this->PARTNER_URI = 'https://manao-team.com';
    }

    public function DoInstall()
    {
        global $DB;

        $DB->RunSQLBatch(__DIR__ . '/install.sql');
        ModuleManager::registerModule($this->MODULE_ID);
        Loader::includeModule($this->MODULE_ID);
    }

    public function DoUninstall()
    {
        global $DB;
        
        Loader::includeModule($this->MODULE_ID);

        $DB->RunSQLBatch(__DIR__ . '/uninstall.sql');
        ModuleManager::unRegisterModule($this->MODULE_ID);
    }
}