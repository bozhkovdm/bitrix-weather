<?php

class weather_forecast extends CModule
{
    var $MODULE_ID = 'weather.forecast';
    var $MODULE_VERSION = '1.0.0';
    var $MODULE_VERSION_DATE = '2025-07-17 00:00:00';
    var $MODULE_NAME = 'Прогноз погоды';
    var $MODULE_DESCRIPTION = 'Модуль для получения данных о погоде через OpenWeatherMap API';
    var $PARTNER_NAME = 'Дмитрий Божков';
    var $PARTNER_URI = '';

    function __construct()
    {
        $this->MODULE_NAME = getMessage('WEATHER_FORECAST_MODULE_NAME');
        $this->MODULE_DESCRIPTION = getMessage('WEATHER_FORECAST_MODULE_DESCRIPTION');
    }

    // Установка модуля
    function DoInstall()
    {
        registerModule($this->MODULE_ID);
        $this->InstallFiles();
        return true;
    }

    // Удаление модуля
    function DoUninstall()
    {
        $this->UnInstallFiles();
        unRegisterModule($this->MODULE_ID);
        return true;
    }

    function InstallFiles()
    {
        // Копирование компонентов
        CopyDirFiles(
            __DIR__ . '/components/',
            $_SERVER['DOCUMENT_ROOT'] . '/bitrix/components/',
            true,
            true
        );
        return true;
    }

    function UnInstallFiles()
    {
        // Удаление компонентов при деинсталляции
        DeleteDirFilesEx('/bitrix/components/weather.forecast/');
        return true;
    }
}
?>