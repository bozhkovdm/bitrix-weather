<?php

namespace Weather\Forecast;

use Bitrix\Main\Web\HttpClient;
use Bitrix\Main\Data\Cache;

class WeatherForecast
{
    private static $cacheTime = 1800; // 30 минут кэширования
    private static $cacheKey = 'weather_forecast_';

    /**
     * Получает текущую погоду для указанного города
     * @param string $apiKey Ключ OpenWeatherMap API
     * @param string $city Город (по умолчанию Moscow)
     * @param string $units Единицы измерения (metric/imperial)
     * @return array|bool Результат или false при ошибке
     * @throws SystemException
     */
    public static function getCurrentWeather($apiKey, $city = 'Moscow', $units = 'metric')
    {
        $cacheTime = self::$cacheTime;
        $cacheId = self::$cacheKey . md5($city . $units); // Уникальный ID кэша
        $cacheDir = '/weather/forecast/'; // Директория кэша

        $cache = Cache::createInstance();

        // Если кэш есть и валиден — возвращаем данные из кэша
        if ($cache->initCache($cacheTime, $cacheId, $cacheDir)) {
            return $cache->getVars();
        }
        // Если кэша нет — получаем данные и сохраняем в кэш
        elseif ($cache->startDataCache()) {
            // Формируем URL запроса к API
            $url = "http://api.openweathermap.org/data/2.5/weather?q=" . urlencode($city) . "&units=" . $units . "&appid=" . $apiKey;

            $httpClient = new HttpClient();
            $httpClient->setTimeout(10); // Устанавливаем таймаут запроса

            $response = $httpClient->get($url);

            // Если запрос не удался — отменяем кэш и возвращаем false
            if ($response === false) {
                $cache->abortDataCache();
                return false;
            }

            // Декодируем ответ
            $data = json_decode($response, true);

            // Проверяем корректность данных
            if (!$data || !isset($data['main'])) {
                $cache->abortDataCache();
                return false;
            }

            // Формируем массив с нужными данными
            $result = [
                'temperature' => $data['main']['temp'],
                'humidity' => $data['main']['humidity'],
                'pressure' => $data['main']['pressure'],
                'city' => $data['name'],
                'units' => $units
            ];

            // Сохраняем результат в кэш
            $cache->endDataCache($result);

            return $result;
        }

        // Возвращаем false, если не удалось получить данные
        return false;
    }
}
