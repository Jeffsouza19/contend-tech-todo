<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Listagem') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-medium">{{ __('Suas Tarefas') }}</h3>
                        <a href="{{ route('tasks.create') }}" class="text-sm px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            {{ __('Nova Tarefa') }}
                        </a>
                    </div>

                    @if (session('success'))
                        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition
                            class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($tasks->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border sm:rounded-lg">
                                <thead>
                                    <tr>
                                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Título') }}
                                        </th>
                                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Status') }}
                                        </th>
                                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Criado em') }}
                                        </th>
                                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tasks as $task)
                                        <tr>
                                            <td class="py-2 px-4 border-b border-gray-200 w-full max-w-[90%]">
                                                {{ $task->title }}
                                            </td>
                                            <td class="py-2 px-4 border-b border-gray-200">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $task->status === 'concluída' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ $task->status }}
                                                </span>
                                            </td>
                                            <td class="py-2 px-4 border-b border-gray-200">
                                                {{ $task->created_at->format('d/m/Y') }}
                                            </td>
                                            <td class="py-2 px-4 border-b border-gray-200 text-right">
                                                <div class="flex space-x-2">
                                                    <form action="{{ route('tasks.toggle-status', $task) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="text-green-600 hover:text-green-900"
                                                                title="{{ $task->status === 'concluída' ? 'Marcar como pendente' : 'Marcar como concluída' }}"
                                                                onclick="return confirm('Tem certeza que deseja marcar esta tarefa como \'{{ $task->status === 'concluída' ? 'pendente' : 'concluída' }}\'?')">
                                                            <x-heroicon-o-check-circle class="icon-table"/>
                                                        </button>
                                                    </form>
                                                    <a href="{{ route('tasks.show', $task) }}" class="text-gray-600 hover:text-gray-900">
                                                        <x-heroicon-o-eye class="icon-table"/>
                                                    </a>
                                                    <a href="{{ route('tasks.edit', $task) }}" class="text-gray-600 hover:text-gray-900">
                                                        <x-heroicon-o-pencil-square class="icon-table"/>                                                    </a>
                                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="w-8 h-8">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Tem certeza que deseja excluir esta tarefa?')">
                                                            <x-heroicon-o-trash class="icon-table"/>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $tasks->links() }}
                        </div>
                    @else
                        <p class="text-gray-500">{{ __('No tasks found.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
