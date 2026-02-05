@extends('layouts.admin')

@section('title', 'Тикеты')

@section('content')
    <div class="p-10 text-white">
        <h1 class="text-2xl font-bold mb-5">Управление тикетами</h1>

        <form action="{{ route('admin.tickets.index') }}" method="GET" class="flex gap-4 mb-10 bg-gray-900 p-5 rounded border border-gray-800">
            <input type="text" name="search" placeholder="Email или телефон" value="{{ request('search') }}"
                class="bg-gray-800 p-2 rounded border border-gray-700 text-white outline-none focus:border-blue-500">

            <select name="status" class="bg-gray-800 p-2 rounded border border-gray-700 text-white outline-none">
                <option value="">Все статусы</option>
                @foreach(\App\Domain\Entity\TicketStatus::cases() as $status)
                    <option value="{{ $status->value }}" {{ request('status') == $status->value ? 'selected' : '' }}>
                        {{ $status->label() }}
                    </option>
                @endforeach
            </select>
            <input type="date" name="date_from" value="{{ request('date_from') }}"
                class="bg-gray-800 p-2 rounded border border-gray-700 text-white outline-none">

            <button type="submit" class="bg-blue-600 hover:bg-blue-500 px-5 py-2 rounded transition">Найти</button>
            <a href="{{ route('admin.tickets.index') }}" class="bg-gray-700 hover:bg-gray-600 px-5 py-2 rounded transition text-center">Сброс</a>
        </form>

        <div class="bg-gray-900 rounded border border-gray-800 overflow-hidden">
            <table class="w-full border-collapse">
                <thead class="bg-gray-800 text-left text-gray-400">
                    <tr>
                        <th class="p-4 border-b border-gray-700">ID</th>
                        <th class="p-4 border-b border-gray-700">Клиент</th>
                        <th class="p-4 border-b border-gray-700">Тема</th>
                        <th class="p-4 border-b border-gray-700 text-center">Статус</th>
                        <th class="p-4 border-b border-gray-700">Действие</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $ticket)
                        <tr class="border-b border-gray-800 hover:bg-gray-800/30 transition">
                            <td class="p-4 text-gray-400">#{{ $ticket->id }}</td>
                            <td class="p-4">
                                <div class="font-bold">{{ $ticket->customer->name ?? 'Неизвестно' }}</div>
                                <div class="text-xs text-gray-500">{{ $ticket->customer->email ?? '' }}</div>
                            </td>
                            <td class="p-4">{{ $ticket->topic }}</td>
                            <td class="p-4 text-center">
                                <span class="px-2 py-1 text-xs font-bold uppercase rounded border 
                                    {{ $ticket->status->value === 'new' ? 'border-blue-500 text-blue-400' : '' }}
                                    {{ $ticket->status->value === 'in_work' ? 'border-yellow-500 text-yellow-400' : '' }}
                                    {{ $ticket->status->value === 'done' ? 'border-green-500 text-green-400' : '' }}">
                                    {{ $ticket->status->label() }}
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="text-blue-400 hover:text-blue-300 font-medium">Смотреть →</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-10 text-center text-gray-500">Тикетов не найдено</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-8">
            {{ $tickets->links() }}
        </div>
    </div>
@endsection