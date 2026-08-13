<!DOCTYPE html>
<html>
<head>
    <title>Weather Board</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-white min-h-screen p-6">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-4">Weather Board</h1>

        <form method="GET" action="{{ route('weather.index') }}" class="flex gap-2 mb-6">
            <input type="text" name="city" value="{{ $city }}" placeholder="Enter a city"
                   class="flex-1 rounded px-3 py-2 text-black">
            <button type="submit" class="bg-blue-600 hover:bg-blue-500 px-4 py-2 rounded">Search</button>
        </form>

        @if ($error)
            <p class="text-red-400">{{ $error }}</p>
        @else
            <div class="bg-slate-800 rounded-lg p-6 flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-semibold">{{ $current['name'] }}</h2>
                    <p class="text-slate-400 capitalize">{{ $current['weather'][0]['description'] }}</p>
                    <p class="text-5xl font-bold mt-2">{{ round($current['main']['temp']) }}°C</p>
                    <p class="text-slate-400">Feels like {{ round($current['main']['feels_like']) }}°C</p>
                </div>
                <img src="https://openweathermap.org/img/wn/{{ $current['weather'][0]['icon'] }}@2x.png"
                     alt="{{ $current['weather'][0]['description'] }}" class="w-24 h-24">
            </div>

            <h3 class="text-lg font-semibold mb-2">5-Day Forecast</h3>
            <div class="grid grid-cols-5 gap-2">
                @foreach ($daily as $day)
                    <div class="bg-slate-800 rounded p-3 text-center">
                        <p class="text-sm text-slate-400">{{ \Carbon\Carbon::parse($day['dt_txt'])->format('D') }}</p>
                        <img src="https://openweathermap.org/img/wn/{{ $day['weather'][0]['icon'] }}.png"
                             alt="" class="mx-auto">
                        <p class="font-semibold">{{ round($day['main']['temp']) }}°C</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>