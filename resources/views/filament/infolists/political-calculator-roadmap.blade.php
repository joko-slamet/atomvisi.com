@php
    $roadmap = $getState() ?? [];
@endphp

<div class="space-y-3">
    @forelse ($roadmap as $bulan)
        <div class="rounded-lg border border-gray-200 p-3 dark:border-gray-700">
            <p class="text-sm font-semibold text-gray-950 dark:text-white">
                Bulan {{ $bulan['bulan'] ?? '-' }} &middot; {{ $bulan['fokus'] ?? '' }}
            </p>
            <ul class="mt-2 space-y-1">
                @foreach ($bulan['minggu'] ?? [] as $minggu)
                    <li class="flex items-start gap-2 text-sm text-gray-600 dark:text-gray-400">
                        <span class="shrink-0 font-medium text-gray-500 dark:text-gray-400">Minggu {{ $minggu['minggu'] ?? '-' }}:</span>
                        <span>{{ $minggu['aktivitas'] ?? '' }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    @empty
        <p class="text-sm text-gray-500">Belum ada data roadmap.</p>
    @endforelse
</div>
