<footer class="body-font bg-white dark:bg-dpaper border-t dark:border-gray-700 pt-6 mt-auto w-full">
    <div class="xs:h-auto lg:container mx-auto">
        <div class="mb-8 w-32 xs:mx-auto">
            <a href="{{ route('home') }}"
               class="font-medium text-gray-100 xs:pb-4 w-32">
                <img src="{{ asset('images/DevHub_Chrome_Full_Logo.svg') }}" alt="DevHub Logo"
                     class="h-8 xs:h-9 mb-4 hidden dark:block">
                <img src="{{ asset('images/DevHub_Monochrome_Full_Logo.svg') }}" alt="DevHub Logo"
                     class="h-8 xs:h-9 mb-4 dark:hidden">
            </a>
        </div>
        <div class="flex xs:block">
            <div class="items-start flex w-2/3 justify-between xs:block xs:w-full xs:px-4 xs:space-y-4">
                <div class="flex flex-col">
                    <h3 class="dark:text-gray-300 font-medium mb-2">DevHub</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="#" class="text-gray-500 hover:text-black dark:hover:text-gray-300 cursor-pointer">О
                                проекте</a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-500 hover:text-black dark:hover:text-gray-300 cursor-pointer">Обновления</a>
                        </li>
                    </ul>
                </div>
                <div class="flex flex-col">
                    <h3 class="dark:text-gray-300 font-medium mb-2">Информация</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="#" class="text-gray-500 hover:text-black dark:hover:text-gray-300 cursor-pointer">Как
                                стать автором</a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-500 hover:text-black dark:hover:text-gray-300 cursor-pointer">Правила</a>
                        </li>
                    </ul>
                </div>
                <div class="flex flex-col">
                    <h3 class="dark:text-gray-300 font-medium mb-2">Помощь</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="#" class="text-gray-500 hover:text-black dark:hover:text-gray-300 cursor-pointer">Вопрос
                                & Ответ</a>
                        </li>
                        <li>
                            <a href="{{ url('feedback') }}"
                               class="text-gray-500 hover:text-black dark:hover:text-gray-300 cursor-pointer">Сообщить
                                об ошибке</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div id="footer" class="w-1/5 ml-auto xs:ml-0 xs:w-full xs:px-4 xs:pt-4">
                <h3 class="dark:text-gray-300 font-medium mb-4">Язык & Тема</h3>
                <div class="space-y-4">
                    <select-menu class="xs:w-full"
                                 :menu="[
                    {'name': 'Azərbaycan', 'icon': 'twemoji:flag-for-flag-azerbaijan', 'url': '/lang/az'},
                    {'name': 'Русский', 'icon': 'twemoji:flag-for-flag-russia', 'url': '/lang/ru'},
                    {'name': 'English', 'icon': 'twemoji:flag-for-flag-united-kingdom', 'url': '/lang/en'}
                    ]"
                                 @if (cache('lang') === 'az' || !cache('lang'))
                                 :selected="{'name': 'Azərbaycan', 'icon': 'twemoji:flag-for-flag-azerbaijan', 'url': '/lang/az'}"
                                 @elseif (cache('lang') === 'ru')
                                 :selected="{'name': 'Русский', 'icon': 'twemoji:flag-for-flag-russia', 'url': '/lang/ru'}"
                                 @elseif (cache('lang') === 'en')
                                 :selected="{'name': 'English', 'icon': 'twemoji:flag-for-flag-united-kingdom', 'url': '/lang/en'}"
                        @endif
                    ></select-menu>
                    <switcher class="xs:w-full"
                              :menu="[
                    {'name': 'Dark', 'icon': 'bytesize:moon'},
                    {'name': 'Light', 'icon': 'carbon:sun'},
                    ]"
                    ></switcher>
                </div>
            </div>
        </div>
        <div class="my-6 border-t border-gray-300 dark:border-gray-700 opacity-75 xs:w-full xs:px-4"></div>
        <div class="flex justify-between xs:w-full xs:px-4 pb-4">
            <p class="block text-sm text-gray-500 pb-4 my-auto xs:p-0 xs:text-center">
                &copy; 2019 – {{ date('Y') }} <span class="">«DevHub»</span>
            </p>
            <div class="flex space-x-4 justify-center">
                <a href="#">
                    <span class="iconify text-2xl text-gray-400 hover:text-black dark:hover:text-gray-300"
                          data-icon="ant-design:github-filled" data-inline="false"></span>
                </a>
                <a href="#">
                    <span class="iconify text-2xl text-gray-400 hover:text-black dark:hover:text-gray-300"
                          data-icon="cib:telegram"
                          data-inline="false"></span>
                </a>
            </div>
        </div>
    </div>
</footer>

@push('scripts')
    <script type="text/javascript" src="{{ mix('js/footer.js') }}" defer></script>
@endpush

@section('styles')
    @parent
    <link rel="preload" href="{{ mix('js/footer.js') }}" as="script">
@endsection
