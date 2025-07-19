<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arComponentParameters = [
    "GROUPS" => [],
    "PARAMETERS" => [
        "API_KEY" => [
            "PARENT" => "BASE",
            "NAME" => "API ключ OpenWeatherMap",
            "TYPE" => "STRING",
            "DEFAULT" => "",
        ],
        "CITY" => [
            "PARENT" => "BASE",
            "NAME" => "Город",
            "TYPE" => "STRING",
            "DEFAULT" => "Moscow",
        ],
        "UNITS" => [
            "PARENT" => "BASE",
            "NAME" => "Единицы измерения",
            "TYPE" => "LIST",
            "VALUES" => [
                "metric" => "Цельсий (°C)",
                "imperial" => "Фаренгейт (°F)"
            ],
            "DEFAULT" => "metric",
        ],
        "CACHE_TIME" => ["DEFAULT" => 1800],
    ],
];
?>