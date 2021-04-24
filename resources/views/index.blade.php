@extends('layout')

@section('title')
	Home
@endsection

@section('header')
	Home
@endsection

@section('content')
    @if ( !empty($news) )
    	@if( strlen($news->sn_context) > 140 )
            <div class="bg-white rounded shadow w-full dark:bg-gray-800">
                <div class="flex rounded-t justify-between items-center py-2 px-3 bg-indigo-600">
                    <span title="{{ $news->sn_created_by }}" class="text-white font-bold dark:text-indigo-100">News</span>
                    <span class="text-white ml-auto dark:text-indigo-100">{{ $news->sn_published_at }}</span>
                </div>
                <div class="text-gray-900 px-3 py-2 dark:text-gray-100 mb-2">
                    {!! $news->sn_context !!}
                    <p class="mt-2"><em>~{{ $news->sn_created_by }}</em></p>
                </div>
            </div>
        @else
            <div class="flex items-center bg-white leading-none rounded-lg p-2 shadow text-sm w-full dark:bg-gray-800">
                <span title="{{ $news->createdBy }}" class="inline-flex bg-indigo-600 text-white rounded-full h-6 px-3 justify-center items-center mr-2 dark:text-indigo-100">News</span>
                <span class="inline-flex text-gray-900 px-2 dark:text-gray-100">{{!! $news->sn_context !!}}</span>
                <span class="inline-flex text-indigo-600 ml-auto dark:text-indigo-300">{{ $news->sn_published_at }}</span>
            </div>
        @endif
    @endif

    <div class="my-4 bg-white rounded shadow p-4 dark:bg-gray-800">
        <h2 class="font-bold text-2xl">Welcome to nibl.</h2>
        <p class="mt-2 mb-4">
            <strong>nibl.co.uk</strong> provides direct access to large number of XDCC IRC Bots. If you know what are you looking for, type your query inside this quick search form.
            If you want to browse our indexes go to <a class="text-indigo-900 underline dark:text-indigo-300" href="/bots">bots</a> tab.
        </p>
        <h3 class="font-bold text-xl">Quick search</h3>
        <form action="/search" class="w-full mt-2 h-10 pl-3 pr-2 bg-white border rounded flex justify-between items-center relative dark:bg-gray-900 dark:border-gray-900" method="GET">
            <label for="search" class="sr-only">Search input</label>
            <input type="search"
                   name="query"
                   id="search"
                   placeholder="Type your text here"
                   minlength="3"
                   maxlength="250"
                   class="appearance-none w-full outline-none focus:outline active:outline-none dark:bg-gray-900"
            />
            <button type="submit" class="ml-1 outline-none focus:outline-none active:outline-none">
                <span class="sr-only">Search button</span>
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     viewBox="0 0 24 24" class="w-6 h-6">
                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </button>
        </form>
    </div>

    <div class="flex flex-wrap justify-between sticky top-0 bg-gray-100 dark:bg-gray-700 pt-2 pb-1 z-10">
        <h2 class="font-bold text-2xl">Latest releases</h2>
        <div>
            <button id="enable-copy-as-batch" class="py-1 px-2 bg-gray-800 hover:bg-gray-700 text-gray-100 dark:bg-gray-900 dark:hover:bg-gray-800">Enable batch mode</button>
            <button id="disable-copy-as-batch" class="hidden py-1 px-2 border border-gray-800 hover:bg-gray-700 text-gray-700 hover:text-gray-100 dark:text-gray-300 dark:hover:text-gray-200">Disable batch mode</button>
            <button id="clear-selected-batch" class="hidden py-1 px-2 border border-gray-800 hover:bg-gray-700 text-gray-700 hover:text-gray-100 dark:text-gray-300 dark:hover:text-gray-200 mr-2">Clear selected</button>
            <button id="copy-as-batch" class="hidden py-1 px-2 bg-gray-800 hover:bg-gray-700 text-gray-100 dark:bg-gray-900 dark:hover:bg-gray-800">Copy selected</button>
        </div>
    </div>

    <div class="my-4 bg-white p-0 dark:bg-gray-800">
        <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative shadow dark:bg-gray-800">
            <thead>
            <tr class="text-left">
                <th class="py-2 px-3 sticky top-11 border-b border-gray-800 bg-gray-800 text-gray-200 rounded-tl dark:bg-gray-900">Bot</th>
                <th class="py-2 px-3 sticky top-11 border-b border-gray-800 bg-gray-800 text-gray-200 dark:bg-gray-900">Pack</th>
                <th class="py-2 px-3 sticky top-11 border-b border-gray-800 bg-gray-800 text-gray-200 dark:bg-gray-900">Size</th>
                <th class="py-2 px-3 sticky top-11 border-b border-gray-800 bg-gray-800 text-gray-200 dark:bg-gray-900">Filename</th>
                <th class="py-2 px-3 sticky top-11 border-b border-gray-800 bg-gray-800 text-gray-200 rounded-tr dark:bg-gray-900">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach( $packs as $pack )
            <tr class="text-left hover:bg-gray-100 dark:hover:bg-gray-700">
                <td class="border-dashed border-t border-gray-200 px-3 py-2 dark:border-gray-700">
                    <a href="/bots/{{ $pack->bot->name }}">{{ $pack->bot->name }}</a>
                </td>
                <td class="border-dashed border-t border-gray-200 px-3 py-2 dark:border-gray-700">{{ $pack->number }}</td>
                <td class="border-dashed border-t border-gray-200 px-3 py-2 dark:border-gray-700">{{ $pack->sizeReadable }}</td>
                <td class="border-dashed border-t border-gray-200 px-3 py-2 dark:border-gray-700">{{ $pack->name }}</td>
                <td class="border-dashed border-t border-gray-200 px-3 py-2 dark:border-gray-700">
                    <button class="copy-data py-1 px-2 bg-gray-300 hover:bg-gray-200 dark:bg-gray-900 dark:hover:bg-gray-800" data-botpack="{{ $pack->number }}" data-botname="{{ $pack->bot->name }}">Copy</button>
                    @if( $pack->bot->batchenable )
                    <label class="batch-copy-checkbox hidden items-center space-x-2">
                        <input type="checkbox"
                               name="batch"
                               value="1"
                               data-botpack="{{ $pack->number }}"
                               data-botname="{{ $pack->bot->name }}"
                               class="form-tick appearance-none h-6 w-6 border border-gray-300 rounded-md checked:bg-blue-600 checked:border-transparent focus:outline-none dark:border-gray-600 dark:bg-gray-600">
                        <span class="text-gray-900 font-medium dark:text-gray-100">Batch</span>
                    </label>
                    @endif
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection

