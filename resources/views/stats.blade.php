<x-app-layout>
    <div class="grid grid-cols-4 gap-10 mt-6">
{{--        <livewire:stats.user-count/>--}}
{{--        <livewire:stats.order-count/>--}}
{{--        <livewire:stats.revenue/>--}}
        <livewire:stats.stat type="User"/>
        <livewire:stats.stat type="Order"/>
        <livewire:stats.stat type="Revenue"/>
    </div>
</x-app-layout>
