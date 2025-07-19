<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Weather\Forecast\WeatherForecast;

// Проверяем подключение модуля
if (!Loader::includeModule('weather.forecast')) {
    ShowError('Модуль weather.forecast не установлен');
    return;
}

// Параметры компонента
$apiKey = trim($arParams['API_KEY']);
$city = trim($arParams['CITY'] ?: 'Moscow');
$units = trim($arParams['UNITS'] ?: 'metric');
$cacheTime = 1800; // 30 минут кэширования

// Проверяем обязательный параметр
if (empty($apiKey)) {
    ShowError('Не указан API_KEY');
    return;
}

// Инициализируем кэш
if ($this->StartResultCache($cacheTime)) {
    // Получаем данные о погоде
    $weatherData = WeatherForecast::getCurrentWeather($apiKey, $city, $units);

    if ($weatherData === false) {
        $this->AbortResultCache();
        ShowError('Ошибка получения данных о погоде');
        return;
    }

    // Формируем результат для шаблона
    $arResult = [
        'TEMPERATURE' => round($weatherData['temperature']),
        'HUMIDITY' => $weatherData['humidity'],
        'PRESSURE' => $weatherData['pressure'],
        'CITY' => $weatherData['city'],
        'UNITS' => $weatherData['units'] === 'metric' ? '°C' : '°F'
    ];

    $this->SetResultCacheKeys(['TEMPERATURE', 'HUMIDITY', 'PRESSURE', 'CITY', 'UNITS']);
    $this->IncludeComponentTemplate();
}
?>