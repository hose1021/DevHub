@extends('layouts.layout')

@section('title'){{ __('devhub.contact') }}@stop

@section('main')
    <div class="lg:container xl:container my-4 mx-4 sm:mx-0 xs:mx-0 lg:mx-auto xl:mx-auto xs:px-4">
        <h1 class="text-xl font-medium">Обратная связь</h1>
        <form action="{{ route('feedback') }}" method="post" class="py-4 space-y-3">
            @csrf
            <div>
                <label for="trans-none">
                    Укажите тему обращения:
                </label>
                <select id="trans-none" name="type" class="input rounded-none h-10 text-sm">
                    <option value="1">Общие вопросы</option>
                    <option value="2">Ошибка в работе сайта</option>
                    <option value="3">Уязвимость на сайте</option>
                    <option value="4">Нарушение правил сайта</option>
                    <option value="5">Блокировка аккаунта</option>
                    <option value="6">Смена данных (имя пользователя или email)</option>
                    <option value="7">Удаление аккаунта</option>
                    <option value="8">Гениальная идея</option>
                    <option value="9">Предложение сотрудничества</option>
                </select>
            </div>
            <div class="flex-col">
                <label for="email" class="block">
                    Укажите тему обращения:
                </label>
                <input type="text" class="input w-full h-10 !rounded-none" name="email" id="email" value="{{ Auth::user()->email ?? '' }}">
                <p class="text-xs text-gray-500">
                    На этот адрес будет отправлен ответ службы поддержки
                </p>
            </div>
            <div>
                <label for="description" class="block">
                    Текст вашего сообщения:
                </label>
                <textarea name="description" class="textarea w-full !rounded-none" id="description" cols="30" rows="10"></textarea>
            </div>
            <button type="submit" class="btn-outline h-7">{{ __('devhub.submit') }}</button>
        </form>
    </div>
@endsection
