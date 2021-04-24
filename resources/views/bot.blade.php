@extends('layout')

@section('title')
    Bot
@endsection

@section('header')
    Bot {{ $bot->name }}
@endsection

@push('styles')
    <link href="/fontawesome/css/all.css" rel="stylesheet">
    <link href="/css/selectables.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="/js/selectables.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectableClass = 'text-red-600';
            new Selectables({
                elements: 'tr',
                zone: '#selectable',
                onSelect: function (e) {
                    e.querySelector("#batch").checked = true;
                },
                onDeselect: function (e) {
                    e.querySelector("#batch").checked = false;
                },
            });
        });
    </script>
@endpush

@section('content')
    <div class="flex justify-between">
        <div>
            <span class="font-bold text-lg">{{ $bot->packs_count }}</span>&nbsp;<span class="text-sm">packs</span>
        </div>
        <div>
            <span class="text-sm">Last processed</span>&nbsp;<span
                class="text-md font-bold">{{ $bot->last_processed|date('Y-m-d H:i:s') }}</span>
        </div>
    </div>

    <div class="my-4 bg-white rounded shadow p-4 dark:bg-gray-800">
        <h3 class="font-bold text-xl">Search in selected bot packs</h3>
        <form action=""
              class="w-full mt-2 h-10 pl-3 pr-2 bg-white border rounded flex justify-between items-center relative dark:bg-gray-900 dark:border-gray-900"
              method="GET">
            <label for="search" class="sr-only">Search input</label>
            <input type="search"
                   name="search"
                   id="search"
                   placeholder="Type your text here"
                   minlength="3"
                   maxlength="250"
                   class="appearance-none w-full outline-none focus:outline active:outline-none dark:bg-gray-900"
                   value="{{ $search }}"
            />
            <button type="submit" class="ml-1 outline-none focus:outline-none active:outline-none">
                <span class="sr-only">Search button</span>
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>

    @if( empty($packs) )
        <div class="my-4 bg-white rounded shadow p-4 text-center dark:bg-gray-800">
            <h3 class="text-2xl">No results</h3>
        </div>
    @else
        <div class="flex justify-between sticky top-0 bg-gray-100 dark:bg-gray-700 pt-2 pb-1 z-10">
            <h3 class="font-bold text-2xl"></h3>
            @if( $bot->batchenable )
                <div>
                    {{--                    <button id="enable-copy-as-batch"--}}
                    {{--                            class="py-1 px-2 bg-gray-800 hover:bg-gray-700 text-gray-100 dark:bg-gray-900 dark:hover:bg-gray-800">--}}
                    {{--                        Enable batch mode--}}
                    {{--                    </button>--}}
                    {{--                    <button id="disable-copy-as-batch"--}}
                    {{--                            class="hidden py-1 px-2 border border-gray-800 hover:bg-gray-700 text-gray-700 hover:text-gray-100 dark:text-gray-300 dark:hover:text-gray-200">--}}
                    {{--                        Disable batch mode--}}
                    {{--                    </button>--}}
                    <button id="clear-selected-batch"
                            class="py-1 px-2 border border-gray-800 hover:bg-gray-700 text-gray-700 hover:text-gray-100 dark:text-gray-300 dark:hover:text-gray-200 mr-2">
                        Clear selected
                    </button>
                    <button id="copy-as-batch"
                            class="py-1 px-2 bg-gray-800 hover:bg-gray-700 text-gray-100 dark:bg-gray-900 dark:hover:bg-gray-800">
                        Copy selected
                    </button>
                </div>
            @endif
        </div>
        <div class="my-4 bg-white p-0 dark:bg-gray-800">
            <table
                class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative shadow dark:bg-gray-800">
                <thead>
                <tr class="text-left">
                    <th class="py-2 px-3 sticky top-11 border-b border-gray-800 bg-gray-800 text-gray-200 rounded-tl dark:bg-gray-900">
                        @sortablelink('number', 'Pack', ['page' => $packs->currentPage() ])
                    </th>
                    <th class="py-2 px-3 sticky top-11 border-b border-gray-800 bg-gray-800 text-gray-200 dark:bg-gray-900">
                        @sortablelink('sizekbits', 'Size', ['page' => $packs->currentPage() ])
                    </th>
                    <th class="py-2 px-3 sticky top-11 border-b border-gray-800 bg-gray-800 text-gray-200 dark:bg-gray-900">
                        @sortablelink('name', 'Name', ['page' => $packs->currentPage() ])
                    </th>
                    <th class="py-2 px-3 sticky top-11 border-b border-gray-800 bg-gray-800 text-gray-200 rounded-tr dark:bg-gray-900">
                        Selected
                    </th>
                </tr>
                </thead>
                <tbody id="selectable">
                @foreach( $packs as $pack )
                    <tr class="text-left hover:bg-gray-100 dark:hover:bg-gray-700">
                        <td class="border-dashed border-t border-gray-200 px-3 py-2 dark:border-gray-700">{{ $pack->number }}</td>
                        <td class="border-dashed border-t border-gray-200 px-3 py-2 dark:border-gray-700">{{ $pack->size }}</td>
                        <td class="border-dashed border-t border-gray-200 px-3 py-2 dark:border-gray-700">{{ $pack->name }}</td>
                        <td class="border-dashed border-t border-gray-200 px-3 py-2 dark:border-gray-700">
                            {{--                            <button--}}
                            {{--                                class="copy-data py-1 px-2 bg-gray-300 hover:bg-gray-200 dark:bg-gray-900 dark:hover:bg-gray-800"--}}
                            {{--                                data-botpack="{{ $pack->number }}" data-botname="{{ $bot->name }}">Copy--}}
                            {{--                            </button>--}}
                            <label class="batch-copy-checkbox items-center space-x-2">
                                <input type="checkbox"
                                       id="batch"
                                       name="batch"
                                       value="1"
                                       data-botpack="{{ $pack->number }}"
                                       data-botname="{{ $bot->name }}"
                                       class="form-tick appearance-none h-6 w-6 border border-gray-300 rounded-md checked:bg-blue-600 checked:border-transparent focus:outline-none dark:border-gray-600 dark:bg-gray-600">
                                {{--                                <span class="text-gray-900 font-medium dark:text-gray-100">Batch</span>--}}
                            </label>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex justify-between">

            <a href="{{ $packs->toArray()['first_page_url'] }}"
               class="p-2 bg-gray-800 hover:bg-gray-700 text-gray-100 dark:bg-gray-900 dark:hover:bg-gray-800 flex items-center">
                <i class="fas fa-fast-backward"></i>&nbsp;&nbsp;First
            </a>

            @if( !empty($packs->previousPageUrl()) )
                <a href="{{ $packs->previousPageUrl() }}"
                   class="p-2 bg-gray-800 hover:bg-gray-700 text-gray-100 dark:bg-gray-900 dark:hover:bg-gray-800 flex items-center">
                    <i class="fas fa-step-backward"></i>&nbsp;&nbsp;Previous
                </a>
            @else
                <button
                    disabled=""
                    class="p-2 bg-gray-400 hover:bg-gray-500 text-gray-100 dark:bg-gray-600 dark:hover:bg-gray-500 flex items-center cursor-not-allowed">
                    Previous
                </button>
            @endif

            <form action=""
                  class="p-2 bg-gray-800 hover:bg-gray-700 text-gray-100 dark:bg-gray-900 dark:hover:bg-gray-800 flex items-center"
                  method="GET">
                <input type="search"
                       name="page"
                       id="page"
                       placeholder="Page"
                       minlength="1"
                       maxlength="100"
                       size="1"
                       class="appearance-none w-full outline-none focus:outline active:outline-none dark:bg-gray-900"
                       value="{{ $packs->currentPage() }}"
                />
                <button type="submit" class="ml-1 outline-none focus:outline-none active:outline-none">
                    <i class="fas fa-location-arrow"></i>
                </button>
            </form>


            @if( !empty($packs->nextPageUrl()) )
                <a href="{{ $packs->nextPageUrl() }}"
                   class="p-2 bg-gray-800 hover:bg-gray-700 text-gray-100 dark:bg-gray-900 dark:hover:bg-gray-800 flex items-center">
                    Next&nbsp;&nbsp;<i class="fas fa-step-forward"></i>
                </a>
            @else
                <button
                    disabled=""
                    class="p-2 bg-gray-400 hover:bg-gray-500 text-gray-100 dark:bg-gray-600 dark:hover:bg-gray-500 flex items-center cursor-not-allowed">
                    Next
                </button>
            @endif

            <a href="{{ $packs->toArray()['last_page_url'] }}"
               class="p-2 bg-gray-800 hover:bg-gray-700 text-gray-100 dark:bg-gray-900 dark:hover:bg-gray-800 flex items-center">
                Last&nbsp;&nbsp;<i class="fas fa-fast-forward"></i>
            </a>


        </div>

    @endif
@endsection

