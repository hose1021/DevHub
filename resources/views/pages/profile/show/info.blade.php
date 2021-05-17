@extends('layouts.layout')

@section('title'){{ ucfirst($author->attributes->username) }} @stop

@section('main')
    <div class="lg:container xl:container my-4 mx-4 sm:mx-0 xs:mx-0 lg:mx-auto xl:mx-auto xs:my-0" id="app">
        @include('pages.profile.include.header')
        <div class="flex space-x-3 xs:space-x-0 xs:space-y-2 xs:block xs:px-4">
            <div class="w-left xs:w-full">
                @include('pages.profile.include.tabs')
                <div class="bg-white border dark:border-gray-700 dark:bg-dpaper overflow-hidden sm:rounded-lg">
                    <div class="px-4 pt-4 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-300">
                            Информация
                        </h3>
                    </div>
                    <div class="dark:bg-dpaper">
                        @if ($author->attributes->description)
                            <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:space-x-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">
                                    О себе
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 dark:text-gray-400">
                                    {{ $author->attributes->description }}
                                </dd>
                            </div>
                        @endif
                        <div class="flex xs:block">
                            <div class="w-1/2">
                                <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:space-x-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">
                                        Почта
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 dark:text-gray-400">
                                        {{ $author->attributes->email }}
                                    </dd>
                                </div>
                                <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:space-x-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">
                                        Авторизован
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 dark:text-gray-400">
                                        {{ \Carbon::createFromTimeStamp(strtotime($author->attributes->created_at))->isoFormat('D MMMM YYYY') }}
                                    </dd>
                                </div>
                            </div>
                            <div class="w-1/2">
                                <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:space-x-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">
                                        Работает в
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 dark:text-gray-400">
                                        {{ $author->attributes->company ?? __('devhub.undefined') }}
                                    </dd>
                                </div>
                                <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:space-x-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">
                                        Откуда
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 dark:text-gray-400">
                                        Баку
                                    </dd>
                                </div>
                            </div>
                        </div>
                        @if ($author->attributes->github || $author->attributes->website || $author->attributes->twitch || $author->attributes->telegram || $author->attributes->youtube || $author->attributes->twitter)
                            <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:space-x-4 sm:px-6">
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 dark:text-gray-400">
                                    @if ($author->attributes->website)
                                        <div class="flex items-center space-x-2">
                                            <span class="iconify" data-icon="akar-icons:link-chain"
                                                  data-inline="false"></span>
                                            <a target="_blank"
                                               href="{{ $author->attributes->website }}">{{ $author->attributes->website }}</a>
                                        </div>
                                    @endif
                                    @if ($author->attributes->github)
                                        <div class="flex items-center space-x-2">
                                            <span class="iconify" data-icon="ant-design:github-filled"
                                                  data-inline="false"></span>
                                            <a target="_blank"
                                               href="https://github.com/{{ $author->attributes->github }}">{{ $author->attributes->github }}</a>
                                        </div>
                                    @endif
                                    @if ($author->attributes->twitter)
                                        <div class="flex items-center space-x-2">
                                            <span class="iconify" data-icon="akar-icons:twitter-fill"
                                                  data-inline="false"></span>
                                            <a target="_blank"
                                               href="https://twitter.com/{{ $author->attributes->twitter }}">{{ $author->attributes->twitter }}</a>
                                        </div>
                                    @endif
                                </dd>
                            </div>
                        @endif
                        @if ($author->relationships->hubs_following->data)
                            <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:space-x-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">
                                    Интересы
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @foreach($author->relationships->hubs_following->data as $hub)
                                        <div class="btn-outline h-7 my-1 xs:w-max">
                                            {{ $hub->name }}
                                        </div>
                                    @endforeach
                                </dd>
                            </div>
                        @endif
                        <div class="dark:bg-dpaper px-4 py-5 sm:grid sm:grid-cols-3 sm:space-x-4 sm:px-6">
                            <dt class="text-sm font-medium mb-2 text-gray-500 dark:text-gray-300">
                                Резюме (CV)
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <ul class="border border-gray-200 dark:border-gray-700 rounded-md divide-y divide-gray-200 dark:divide-gray-700">
                                    <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                        <div class="w-0 flex-1 flex items-center">
                                            <span class="iconify flex-shrink-0 h-5 w-5 text-gray-400"
                                                  data-icon="ion:attach-sharp" data-inline="false"></span>
                                            <span class="ml-2 flex-1 w-0 truncate dark:text-gray-300">
                                                resume_back_end_developer.pdf
                                            </span>
                                        </div>
                                        <div class="ml-4 flex-shrink-0">
                                            <a href="#" class="font-medium text-cerulean-100 hover:text-cerulean-200">
                                                Открыть
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </dd>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-right xs:w-full">
                @include('pages.profile.include.right')
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
