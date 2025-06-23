<footer class="bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 text-sm text-gray-600 dark:text-gray-300">

            <!-- Site Info -->
            <div>
                <h3 class="font-semibold text-gray-800 dark:text-gray-100 mb-2">QuickPoll</h3>
                <p class="text-sm">
                    {{ __('poll.footer_info') }}
                </p>
            </div>

            <!-- Navigation -->
            <div>
                <h4 class="font-semibold text-gray-800 dark:text-gray-100 mb-2">{{ __('poll.pages') }}</h4>
                <ul class="space-y-1">
                    <li><a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a></li>
                    <li><a href="{{ route('create.poll') }}" class="hover:underline">{{ __('poll.create_poll') }}</a></li>
                    <li><a href="{{ route('polls.index') }}" class="hover:underline">{{ __('poll.vote') }}</a></li>
                </ul>
            </div>

            <!-- Social -->
            <div>
                <h4 class="font-semibold text-gray-800 dark:text-gray-100 mb-2">{{ __('poll.social_media') }}</h4>
                <ul class="space-y-1">
                    <li><a href="#" class="hover:underline">Twitter</a></li>
                    <li><a href="#" class="hover:underline">GitHub</a></li>
                    <li><a href="#" class="hover:underline">LinkedIn</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h4 class="font-semibold text-gray-800 dark:text-gray-100 mb-2">{{ __('poll.contact') }}</h4>
                <ul class="space-y-1">
                    <li>Email: <a href="mailto:destek@quickpoll.com" class="hover:underline">destek@quickpoll.com</a></li>
                    <li>{{ __('poll.phone_number') }}: <span class="hover:underline">+90 555 555 5555</span></li>
                </ul>
            </div>
        </div>

        <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-4 text-center text-xs text-gray-500 dark:text-gray-400">
            © {{ date('Y') }} QuickPoll. {{ __('poll.rights_reserved') }}
        </div>
    </div>
</footer>
