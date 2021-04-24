@extends('layout')

@section('title')
    About Us
@endsection

@section('header')
    About Us
@endsection

@section('content')
<h2 class="font-bold text-2xl">Staff</h2>
<article class="grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 gap-4 mt-4">
    <div class="border border-gray-300 rounded p-4 bg-white dark:bg-gray-800 dark:border-gray-800">
        <div class="text-lg font-bold w-full">Sirus</div>
        <div class="font-medium text-gray-500">Founder of #nibl.</div>
    </div>

    <div class="border border-gray-300 rounded p-4 bg-white dark:bg-gray-800 dark:border-gray-800">
        <div class="text-lg font-bold w-full">Jenga</div>
        <div class="font-medium text-gray-500">Co-Founder of #nibl. Writes the databits.</div>
    </div>

    <div class="border border-gray-300 rounded p-4 bg-white dark:bg-gray-800 dark:border-gray-800">
        <div class="text-lg font-bold w-full">dark_hero_magus</div>
        <div class="font-medium text-gray-500">Admin, request filler, takes "all you can eat" as a personal challenge.</div>
    </div>

    <div class="border border-gray-300 rounded p-4 bg-white dark:bg-gray-800 dark:border-gray-800">
        <div class="text-lg font-bold w-full">Anonymous</div>
        <div class="font-medium text-gray-500">Admin, Tech Guru, Maple syrup connoisseur.</div>
    </div>

    <div class="border border-gray-300 rounded p-4 bg-white dark:bg-gray-800 dark:border-gray-800">
        <div class="text-lg font-bold w-full">Rand</div>
        <div class="font-medium text-gray-500">Admin, creator of NIBL IRC Plugin/Addons.</div>
    </div>

    <div class="border border-gray-300 rounded p-4 bg-white dark:bg-gray-800 dark:border-gray-800">
        <div class="text-lg font-bold w-full">_Maru_</div>
        <div class="font-medium text-gray-500">Ooinuza framework creator.</div>
    </div>

    <div class="border border-gray-300 rounded p-4 bg-white dark:bg-gray-800 dark:border-gray-800">
        <div class="text-lg font-bold w-full">Upa|Kun</div>
        <div class="font-medium text-gray-500">Ooinuza plugin coder.</div>
    </div>

    <div class="border border-gray-300 rounded p-4 bg-white dark:bg-gray-800 dark:border-gray-800">
        <div class="text-lg font-bold w-full">[M]-V</div>
        <div class="font-medium text-gray-500">Yo, this guy hosts everything! He's got more bots than cocks. Some people call him the Arutha Master.</div>
    </div>

    <div class="border border-gray-300 rounded p-4 bg-white dark:bg-gray-800 dark:border-gray-800">
        <div class="text-lg font-bold w-full">kamo</div>
        <div class="font-medium text-gray-500">Website creator.</div>
    </div>
</article>

<h2 class="font-bold mt-4 text-2xl">Code</h2>
<p>Our code is hosted at <a class="underline" href="https://github.com/NIBLCO">github.com/NIBLCO</a>. Most popular packages are linked below:</p>
<article class="grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 gap-4 mt-4">
    <a href="https://github.com/NIBLCO/ircBot" target="_blank" rel="noopener" class="border border-gray-300 rounded p-4 bg-white hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-800 dark:hover:bg-gray-900">
        <div class="text-lg font-medium w-full">ircBot</div>
        <div class="font-medium text-gray-500">#nibl@irc.rizon.com</div>
    </a>

    <a href="https://github.com/NIBLCO/niblscripts" target="_blank" rel="noopener" class="border border-gray-300 rounded p-4 bg-white hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-800 dark:hover:bg-gray-900">
        <div class="text-lg font-medium w-full">niblscripts</div>
        <div class="font-medium text-gray-500">mIRC and HexChat IRC Scripts to use on #NIBL.</div>
    </a>

    <a href="https://github.com/NIBLCO/NIBLoffer" target="_blank" rel="noopener" class="border border-gray-300 rounded p-4 bg-white hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-800 dark:hover:bg-gray-900">
        <div class="text-lg font-medium w-full">NIBLoffer</div>
        <div class="font-medium text-gray-500">DCC file transfer bot based on pircbotx.</div>
    </a>

    <a href="https://github.com/NIBLCO/iroffer" target="_blank" rel="noopener" class="border border-gray-300 rounded p-4 bg-white hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-800 dark:hover:bg-gray-900">
        <div class="text-lg font-medium w-full">iroffer</div>
        <div class="font-medium text-gray-500">iroffer-dinoex config and autoinstall script.</div>
    </a>
</article>

@endsection
