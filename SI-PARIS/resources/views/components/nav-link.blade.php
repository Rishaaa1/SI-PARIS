@props(['href', 'active' => false, 'badge' => null])
<a href="{{ $href }}"
   class="flex items-center justify-between gap-3 px-4 py-3.5 rounded-lg text-sm font-medium transition
          {{ $active ? 'bg-blue-600 text-white shadow' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800' }}">
    <span class="flex items-center gap-3">
        {{ $slot }}
    </span>
    @if($badge)
        <span class="text-[11px] font-bold px-2 py-0.5 rounded-full {{ $active ? 'bg-white/20 text-white' : 'bg-red-100 text-red-600' }}">{{ $badge }}</span>
    @endif
</a>