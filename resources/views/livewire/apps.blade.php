<div wire:init="loadApps">
    @if(! is_array($apps))
        <div class="flex justify-center items-center h-screen">
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    @else
        <ul class="relative z-0 divide-y divide-gray-200 border-b border-gray-200">
            @foreach($apps as $app)
                <li
                    class="relative pl-4 pr-6 py-5 hover:bg-gray-50 sm:py-6 sm:pl-6 lg:pl-8 xl:pl-6"
                    wire:key="{{ $app['name'] }}"
                >
                    <a
                        href="https://fly.io/apps/{{ $app['name'] }}"
                        wire:click.prevent="openApp('{{ $app['name'] }}')"
                        class="flex items-center justify-between space-x-4"
                    >
                        <div class="min-w-0 space-y-3">
                            <div class="flex items-center space-x-3">
                                <div>
                                    @if($app['status'] != 'deployed')
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-400 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25v13.5m-7.5-13.5v13.5" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"  class="w-6 h-6 text-green-400 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <h2 class="text-sm font-medium text-gray-600">
                                        {{ $app['name'] }}
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col flex-shrink-0 items-end space-y-3">
                            <p class="flex items-center space-x-4">
                        <span class="relative text-sm text-gray-500 font-medium">
                            @if($app['vmSize']['name'] ?? '')
                                {{ $app['vmSize']['name'] }}
                            @else
                                {{ $app['vmSize']['cpuCores'] }} CPU • {{ $app['vmSize']['memoryGb'] }} GB
                            @endif
                        </span>
                            </p>
                            <p class="flex text-gray-500 text-sm space-x-2 items-center">
                                @if(isset($app['currentRelease']))
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                    </svg>
                                    <span title="last release" class="ml-[3px]">
                            {{ (new \Carbon\Carbon($app['currentRelease']['createdAt']))->diffForHumans() }}
                        </span>
                                    <span>·</span>
                                @endif
                                @if(isset($app['machines']))
                                    <span>
                            @if(count($app['machines']['nodes']) == 1)
                                            1 machine
                                        @else
                                            {{ count($app['machines']['nodes']) }} machines
                                        @endif
                        </span>
                                @endif
                            </p>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
