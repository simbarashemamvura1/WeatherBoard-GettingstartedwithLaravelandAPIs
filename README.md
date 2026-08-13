# Weather Board

A small Laravel app that shows real-time current weather and a 5-day forecast for any city, powered by the OpenWeatherMap API. Built as a quick, focused project to practice consuming an external API from Laravel rather than managing your own data with Eloquent.

## What it does

- Search any city and get its current conditions: temperature, "feels like," and a short description with an icon
- See a 5-day forecast strip, one summary per day
- Handles invalid city names gracefully with an error message instead of crashing
- Caches each city's weather data for 10 minutes so repeated searches don't hammer the API

## Tech stack

- **Laravel 13** / PHP 8.5
- **OpenWeatherMap API** (`/weather` and `/forecast` endpoints) via Laravel's `Http` client
- **Tailwind CSS** (via CDN, no build step)
- Laravel's `Cache` facade for per-city response caching

## How it works

`WeatherController@index` takes a `city` query parameter (defaulting to Windsor), calls OpenWeatherMap's current-weather and 5-day-forecast endpoints server-side, and caches the combined result per city for 10 minutes. The forecast API returns data in 3-hour increments, so the controller collapses that down to one entry per day — picking the reading closest to midday — to keep the forecast strip clean.

## Setup

1. Clone the repo and install dependencies:
   ```bash
   composer install
   ```

2. Copy `.env.example` to `.env` and generate an app key:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. Get a free API key from [OpenWeatherMap](https://openweathermap.org/api) and add it to `.env`:
   ```
   OPENWEATHER_API_KEY=your_key_here
   ```

4. Run the app:
   ```bash
   php artisan serve
   ```

   Visit `http://127.0.0.1:8000`. Defaults to Windsor; use the search box to check other cities.

## Project log

Built in a single focused session:
- Scaffolded a fresh Laravel project
- Wired up `WeatherController` with current + forecast lookups and response caching
- Built the Blade view with Tailwind styling
- Debugged a missing view file (`resources/views/weather/index.blade.php`) and a misplaced `use` import in `routes/web.php`
- Verified error handling for invalid city names
- Pushed to GitHub with `.env` correctly excluded via `.gitignore`

## Roadmap

Tracked as issues in this repo:
- [ ] Favorites list for logged-in users (requires auth)
- [ ] Hourly forecast view (3-hour increments instead of daily)
- [ ] Geolocation-based default city on first visit

## License

Personal portfolio project — no license applied.


<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
