@extends('layouts.admin')

@section('title', 'Управление услугами')
@section('header', 'Управление услугами')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-xl font-medium text-gray-900 dark:text-white">Список услуг</h2>
    <a href="{{ route('admin.services.create') }}" class="bg-admin-600 hover:bg-admin-700 text-white font-medium py-2 px-4 rounded-lg shadow-sm transition-colors duration-300">
        <i class="fas fa-plus mr-2"></i>Добавить услугу
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 dark:bg-green-800 text-green-700 dark:text-green-200 p-4 mb-6 rounded-md">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-6 transition-colors duration-300">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 transition-colors duration-300">
            <thead class="bg-gray-50 dark:bg-gray-700 transition-colors duration-300">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider transition-colors duration-300">ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider transition-colors duration-300">Название</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider transition-colors duration-300">Цена</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider transition-colors duration-300">Статус</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider transition-colors duration-300">Действия</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700 transition-colors duration-300">
                @if(count($services) > 0)
                    @foreach($services as $service)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-300">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white transition-colors duration-300">{{ $service->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white transition-colors duration-300">{{ $service->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white transition-colors duration-300">{{ number_format($service->price, 2) }} ₽</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm transition-colors duration-300">
                                @if($service->available)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                        Доступно
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100">
                                        Недоступно
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.services.edit', $service) }}" class="text-admin-600 hover:text-admin-800 dark:text-admin-400 dark:hover:text-admin-300 transition-colors duration-300" title="Редактировать">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 transition-colors duration-300" title="Удалить">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.services.toggle-availability', $service) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-admin-600 hover:text-admin-800 dark:text-admin-400 dark:hover:text-admin-300 transition-colors duration-300" title="{{ $service->available ? 'Сделать недоступным' : 'Сделать доступным' }}">
                                            <i class="fas {{ $service->available ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center transition-colors duration-300">
                            Услуги не найдены
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

@if(count($services) > 0)
    <div class="mt-4">
        {{ $services->links() }}
    </div>
@endif

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForms = document.querySelectorAll('.delete-form');
        
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (confirm('Вы уверены, что хотите удалить эту услугу? Это действие нельзя отменить.')) {
                    this.submit();
                }
            });
        });
    });
</script>
@endpush
@endsection 