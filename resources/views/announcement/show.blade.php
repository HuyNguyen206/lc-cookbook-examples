<x-app-layout>
    @if($message = session('success_message'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
            <span class="font-medium">Success alert!</span> {{$message}}
        </div>
    @endif

    <div class="bg-white rounded-md border my-8 mx-40">
        @if($announcement)
        <div class="content">
            <h2 class="text-2xl font-semibold w-full bg-purple-400 text-center text-white py-2" style="color: {{$announcement->titleColor}}">{{$announcement->titleText}}</h2>
            @if($announcement->image)
                <img alt="announcement-image" src="{{\Illuminate\Support\Facades\Storage::url($announcement->image)}}">
            @endif
            <div class="text-gray-600 px-5 py-6">
                {!! old('content', $announcement->content) !!}
            </div>
            <a href="{{$announcement->buttonLink}}" class="py-2 px-4 rounded bg-purple-400 text-white" style="background-color: {{$announcement->buttonColor}}">{{$announcement->buttonText}}</a>
        </div>
            @endif
    </div>
</x-app-layout>
