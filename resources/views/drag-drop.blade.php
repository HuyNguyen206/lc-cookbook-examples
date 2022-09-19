<x-app-layout>

   <livewire:drag-and-drop-song/>
    @push('styles')
        <style>
            .sortable-drag {
                background: white;
                box-shadow: 0 1px 2px 0 rgb(0 0 0 /0.05);
            }
        </style>
    @endpush
    @push('scripts')
        <script src="https://unpkg.com/@nextapps-be/livewire-sortablejs@0.2.0/dist/livewire-sortable.js"></script>
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
{{--        <script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v0.x.x/dist/livewire-sortable.js"></script>--}}
    @endpush

</x-app-layout>
