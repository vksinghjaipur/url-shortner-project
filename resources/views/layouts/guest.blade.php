<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
        <body class="font-sans text-gray-900 antialiased">
            <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        
        
        <div class="w-full sm:max-w-md bg-white dark:bg-gray-800 shadow-md rounded overflow-hidden">

           
            <div class="flex items-center bg-white border-b px-4 py-2 shadow-sm rounded-t">
              <button
                  style="
                    color: #fbbf24;  
                    background-color: white;
                    border: 2px solid #fbbf24;
                    padding: 0.25rem 0.75rem; 
                    font-weight: 600;       
                    font-size: 0.875rem;   
                    border-radius: 0.375rem;
                    cursor: pointer;
                    margin-right: 12px;
                  "
                >
                  >URL&lt;
                </button>
              <h1 class="flex-grow text-center font-semibold text-lg text-gray-900">
                Sembark URL Shortner
              </h1>
              <div style="width: 48px;"></div>
            </div>

            
            <div class="px-6 py-4 bg-gray-100 dark:bg-gray-800">
                {{ $slot }}
            </div>
        </div>
    </div>
        </body>


</html>
