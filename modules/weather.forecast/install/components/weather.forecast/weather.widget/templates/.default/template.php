<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>

<div class="weather-widget">
    <h3>Прогноз погоды в <?= htmlspecialchars($arResult['CITY']) ?></h3>
    <p>🌡 Температура: <?= $arResult['TEMPERATURE'] . $arResult['UNITS'] ?></p>
    <p>💧 Влажность: <?= $arResult['HUMIDITY'] ?>%</p>
    <p>🌀 Давление: <?= $arResult['PRESSURE'] ?> мм рт. ст.</p>
</div>

<style>
.weather-widget {
    border: 1px solid #ccc;
    padding: 15px;
    border-radius: 5px;
    max-width: 300px;
    font-family: Arial, sans-serif;
}
.weather-widget h3 {
    margin: 0 0 10px;
    font-size: 18px;
}
.weather-widget p {
    margin: 5px 0;
}
</style>