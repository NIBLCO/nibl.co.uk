<!doctype html>
<html lang="en" class="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <meta name="description"
          content="nibl.co.uk provides direct access to large number of XDCC IRC Bots."/>
    <title>@yield('title')</title>
    <link href="/css/main.css" rel="stylesheet">
    <script>
        if (localStorage.darkMode === 'enabled' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
    @stack('styles')
    @stack('scripts')
</head>
<?php
use Illuminate\Support\Facades\Route;
$uri = Route::getCurrentRoute()->uri();
?>

<body class="text-gray-700 antialiased bg-gray-100 font-sans dark:text-gray-100 dark:bg-gray-700">
<nav class="bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <a href="/"><img width="24" height="24" class="h-12 w-12"
                                     src="/img/penguin.svg" alt="NIBL"></a>
                    <div class="hidden">
                        Icons made by <a href="https://www.flaticon.com/authors/freepik"
                                         title="Freepik">Freepik</a> from <a
                            href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-center space-x-4">
                        <a href="/"
                           class="{{ $uri == 'index' ? 'bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium' : 'text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium' }}">Home</a>
                        <a href="/bots"
                           class="{{ in_array($uri, array('bots','bot')) ? 'bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium' : 'text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium' }}">Bots</a>
                        <a href="/search"
                           class="{{ $uri == 'search' ? 'bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium' : 'text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium' }}">Search</a>
                        <a href="/about"
                           class="{{ $uri == 'about' ? 'bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium' : 'text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium' }}">About
                            us</a>
                        <a href="/faq"
                           class="{{ $uri == 'faq' ? 'bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium' : 'text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium' }}">FAQ</a>
                        <a href="https://discord.gg/bUESsAg"
                           class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-base font-medium flex items-center">
                            <img width="12" height="12" class="w-8 h-8 block items-baseline" src="/img/discord.svg"
                                 alt="Discord">
                        </a>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="ml-4 flex items-center md:ml-6">
                    <button title="Toggle dark mode" id="toggle-dark-mode"
                            class="p-2 rounded mr-3 text-gray-100 hover:bg-gray-700">
                        <svg id="dark-mode-ico" class="pointer-events-none"
                             xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                        </svg>
                        <svg id="light-mode-ico" class="pointer-events-none hidden"
                             xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="5"/>


                            <path
                                d="M12 1v2M12 21v2M4.2 4.2l1.4 1.4M18.4 18.4l1.4 1.4M1 12h2M21 12h2M4.2 19.8l1.4-1.4M18.4 5.6l1.4-1.4"/>
                        </svg>
                    </button>
                    <a
                        class="bg-indigo-700 hover:bg-indigo-600 text-white font-bold p-2 rounded"
                        xmlns="http://www.w3.org/1999/xhtml"
                        href="irc://irc.rizon.net/nibl">#nibl @ irc.rizon.net</a>
                </div>
            </div>
            <div class="-mr-2 flex md:hidden">
                <!-- Mobile menu button -->
                <button
                    class="mobile-menu-toggle bg-gray-800 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                    <span class="sr-only">Open main menu</span>
                    <svg id="menu-open" class="pointer-events-none block h-6 w-6"
                         xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg id="menu-close" class="pointer-events-none hidden h-6 w-6"
                         xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!--
      Mobile menu, toggle classes based on menu state.
    -->
    <div id="mobile-menu" class="hidden md:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="/"
               class="{{ $uri == 'index' ? 'bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium' : 'text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium' }}">Home</a>
            <a href="/bots"
               class="{{ $uri == 'bots' ? 'bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium' : 'text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium' }}">Bots</a>
            <a href="/search"
               class="{{ $uri == 'search' ? 'bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium' : 'text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium' }}">Search</a>
            <a href="/about"
               class="{{ $uri == 'about' ? 'bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium' : 'text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium' }}">About
                us</a> <a href="/faq"
                          class="{{ $uri == 'faq' ? 'bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium' : 'text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium' }}">FAQ</a>
            <a href="https://discord.gg/bUESsAg"
               class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Discord</a>
        </div>
    </div>
</nav>

<header class="bg-white shadow dark:bg-gray-900">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1
            class="text-3xl font-bold leading-tight text-gray-900 dark:text-gray-100">
            @yield('header')</h1>
    </div>
</header>
<main>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">@yield('content')</div>
</main>
<footer class="text-center mt-6">
    <p class="text-sm text-gray-400 dark:text-gray-200">nibl.co.uk © 2020</p>
</footer>
<script src="/js/main.js"></script>
</body>
</html>
