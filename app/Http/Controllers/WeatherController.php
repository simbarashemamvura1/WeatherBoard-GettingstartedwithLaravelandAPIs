<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class WeatherController extends Controller
{
    public function index(Request $request)
    {
        $city = $request->input('city', 'Windsor');
        $apiKey = config('services.openweather.key');

        $data = Cache::remember('weather_' . strtolower($city), now()->addMinutes(10), function () use ($city, $apiKey) {
            $current = Http::get('https://api.openweathermap.org/data/2.5/weather', [
                'q' => $city,
                'appid' => $apiKey,
                'units' => 'metric',
            ]);

            $forecast = Http::get('https://api.openweathermap.org/data/2.5/forecast', [
                'q' => $city,
                'appid' => $apiKey,
                'units' => 'metric',
            ]);

            if ($current->failed() || $forecast->failed()) {
                return null;
            }

            return [
                'current' => $current->json(),
                'forecast' => $forecast->json(),
            ];
        });

        if (!$data) {
            return view('weather.index', [
                'city' => $city,
                'error' => 'City not found or weather service unavailable.',
                'current' => null,
                'daily' => [],
            ]);
        }

        // Collapse the 3-hour forecast into one entry per day, closest to midday
        $daily = collect($data['forecast']['list'])
            ->groupBy(fn ($item) => Carbon::parse($item['dt_txt'])->format('Y-m-d'))
            ->map(fn ($group) => $group->sortBy(fn ($item) => abs(Carbon::parse($item['dt_txt'])->hour - 12))->first())
            ->take(5)
            ->values();

        return view('weather.index', [
            'city' => $city,
            'error' => null,
            'current' => $data['current'],
            'daily' => $daily,
        ]);
    }
}