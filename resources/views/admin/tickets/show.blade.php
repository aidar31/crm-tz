@extends('layouts.admin')

@section('title', 'Просмотр тикета')

@section('content')
<div class="p-10 text-white max-w-4xl">
    <a href="{{ route('admin.tickets.index') }}" class="text-blue-400 underline block mb-5">← К списку тикетов</a>

    <div class="bg-gray-900 p-8 rounded border border-gray-800">
        <div class="flex justify-between items-start mb-10 border-b border-gray-800 pb-5">
            <div>
                <h1 class="text-3xl font-bold mb-2">{{ $ticket->topic }}</h1>
                <p class="text-gray-400">
                    От: <strong>{{ $ticket->customer->name }}</strong> 
                    ({{ $ticket->customer->phone_number }} / {{ $ticket->customer->email }})
                </p>
            </div>

            <form action="{{ route('admin.tickets.update-status', $ticket->id) }}" method="POST" class="flex gap-2">
                @csrf
                @method('PATCH')
                <select name="status" class="bg-gray-800 p-2 rounded border border-gray-700 text-sm">
                    @foreach(\App\Domain\Entity\TicketStatus::cases() as $status)
                        <option value="{{ $status->value }}" {{ $ticket->status->value === $status->value ? 'selected' : '' }}>
                            {{ $status->label() }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="bg-blue-600 px-4 py-2 rounded text-sm font-bold">ОК</button>
            </form>
        </div>

        <div class="mb-10 text-lg leading-relaxed">
            <p class="whitespace-pre-wrap text-gray-300">{{ $ticket->body }}</p>
        </div>

        <div class="border-t border-gray-800 pt-5">
            <h3 class="font-bold mb-4">Прикрепленные файлы:</h3>
            @if(count($ticket->files) > 0)
                <ul class="space-y-2">
                    @foreach($ticket->files as $fileUrl)
                        <li class="bg-gray-800 p-3 rounded flex justify-between items-center border border-gray-700">
                            <span class="text-sm truncate">{{ basename($fileUrl) }}</span>
                            <a href="{{ $fileUrl }}" target="_blank" class="text-blue-400 font-bold ml-4">Открыть/Скачать</a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500 italic text-sm">файлов нет</p>
            @endif
        </div>
    </div>
</div>
@endsection