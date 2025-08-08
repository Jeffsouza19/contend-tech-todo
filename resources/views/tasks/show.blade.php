<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Detalhes da Tarefa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-2xl font-semibold">{{ $task->title }}</h3>
                            <div class="mt-2">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $task->status === 'concluída' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($task->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-4">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">{{ __('Descrição') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900 p-8 border rounded">
                                    {{ $task->description ?? __('Nenhuma descrição fornecida.') }}
                                </dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">{{ __('Criado em') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $task->created_at->format('d/m/Y H:i:s') }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">{{ __('Última Atualização') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $task->updated_at->format('d/m/Y H:i:s') }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="mt-8 border-t border-gray-200 pt-6 flex justify-between">
                        <a href="{{ route('tasks.index') }}" class="text-blue-600 hover:text-blue-900">
                            &larr; {{ __('Voltar para a listagem') }}
                        </a>

                        <div class="flex space-x-2">
                            <a href="{{ route('tasks.edit', $task) }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                                {{ __('Editar') }}
                            </a>
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600" onclick="return confirm('Tem certeza que deseja excluir esta tarefa?')">
                                    {{ __('Excluir') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
