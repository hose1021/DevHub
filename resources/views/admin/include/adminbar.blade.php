<div class="w-full bg-green-700 card p-1 rounded-0 d-flex border-bottom border-primary bg-primary text-white px-4 xs:hidden">
    <?php $admin = Numeric::admin() ?>
    <div class="flex items-center justify-between lg:container mx-auto">
        <div class="flex items-center space-x-4">
            <a class="flex items-center space-x-0.5"
               href="http://git.php.net/?p=php-src.git;a=shortlog;h=refs/heads/PHP-{{ phpversion() }}" target="_blank" rel="noreferrer">
                <span class="iconify" data-icon="bx:bx-code-alt" data-inline="false"></span>
                <p class="text-sm">PHP v{{ phpversion() }}</p>
            </a>
            <div class="flex items-center space-x-0.5" title="Users">
                <span class="iconify" data-icon="line-md:account" data-inline="false"></span>
                <p class="text-sm">{{ $admin['users'] }}</p>
            </div>
            <div class="flex items-center space-x-0.5" title="Users rating">
                <span class="iconify" data-icon="gg:trending" data-inline="false"></span>
                <p class="text-sm">{{ $admin['ratings'] }}</p>
            </div>
        </div>
        <div class="flex items-center space-x-4">
            <div class="flex items-center space-x-0.5">
                <span class="iconify" data-icon="bx:bx-chip" data-inline="false"></span>
                <p class="text-sm">Laravel v{{ App::VERSION() }}</p>
            </div>
            {{--            <div class="flex items-center space-x-0.5">--}}
            {{--                <span class="iconify" data-icon="uil:folder-open" data-inline="false"></span>--}}
            {{--                <p class="text-sm">{{ $admin['cache'] }}</p>--}}
            {{--            </div>--}}
{{--            <div class="flex items-center space-x-0.5" title="DevHub page speed">--}}
{{--                <span class="iconify" data-icon="ant-design:field-time-outlined" data-inline="false"></span>--}}
{{--                <p class="text-sm">{{ bcmul((microtime(true) - LARAVEL_START), '1000', 0) }}ms</p>--}}
{{--            </div>--}}
            <div class="flex items-center space-x-0.5" title="Memory usage">
                <span class="iconify" data-icon="bx:bx-cog" data-inline="false"></span>
                <p class="text-sm">{{ Numeric::convert(memory_get_usage(true)) }}</p>
            </div>
            <div class="flex items-center space-x-0.5">
                <a href="{{ route('admin') }}" class="btn h-6 px-1">
                    <span class="iconify" data-icon="mdi:account-cowboy-hat" data-inline="false"></span>
                </a>
            </div>
        </div>
    </div>
</div>
