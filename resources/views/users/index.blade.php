<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-90 0 dark:text-gray-100">

                    <div class="pb-6">
                        <button id="export-button" class="bg-blue-600 text-white rounded px-4 py-3 mr-4" type="button">
                            Export PDF
                        </button>
                        <span id="export-status" class="font-bold"></span>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Name
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Email
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $user->name }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $user->email }}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        window.addEventListener('DOMContentLoaded', function() {
            var channel = window.Echo.private('App.Models.User.' + {{ auth()->id() }});

            channel.listen('ExportPdfStatusUpdated', function(e) {
                var span = document.getElementById('export-status');

                if (e.link !== null) {
                    var link_template =
                        `<a href="${e.link}" target="_blank" class="text-blue-600 underline">${e.link}</a>`;

                    span.innerHTML = e.message + ' ' + link_template;

                    return
                }

                span.innerHTML = e.message;
            });

            var button = document.getElementById('export-button');

            button.addEventListener('click', function() {
                axios.post('/export-pdf');
            });
        })
    </script>
</x-app-layout>
