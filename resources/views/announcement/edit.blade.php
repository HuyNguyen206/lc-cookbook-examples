<x-app-layout>
    @if($errors->any())
        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
            <span class="font-medium">Danger alert!</span>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>

        </div>
    @endif
    <div class="bg-white rounded-md border my-8 mx-40 p-4">
        <h2 class="mb-2 font-bold text-xl">Edit announcement</h2>
        <form enctype="multipart/form-data" id="formAnnoucement" method="post"
              action="{{route('announcement.update')}}">
            @csrf
            @method('patch')
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-300 mb-2">Is active?</p>
                    <div class="flex items-center mb-1">
                        <input @checked(old('isActive', $announcement->isActive)) id="default-radio-1" type="radio"
                               value="1" name="isActive"
                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="default-radio-1" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Yes</label>
                    </div>
                    <div class="flex items-center">
                        <input @checked(!old('isActive', $announcement->isActive)) id="default-radio-2" type="radio"
                               value="0" name="isActive"
                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="default-radio-2" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">No</label>
                    </div>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="file_input">Upload
                        file</label>
                    <input name="image" accept="image/*"
                           class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                           id="file_image" type="file">
                    @if($announcement->image)
                        <img class="w-40" alt="announcement-image"
                             src="{{\Illuminate\Support\Facades\Storage::url($announcement->image)}}">
                    @endif
                </div>

                <div>
                    <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Banner
                        text</label>
                    <input type="text" value="{{old('bannerText', $announcement->bannerText)}}" name="bannerText"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                           required="">
                </div>

                <div>
                    <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Banner
                        color</label>
                    <input type="color" name="bannerColor" value="{{old('bannerColor', $announcement->bannerColor)}}"
                           required="">
                </div>
                <div>
                    <label for="company" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Title
                        text</label>
                    <input type="text" name="titleText" value="{{old('titleText', $announcement->titleText)}}"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                           required="">
                </div>
                <div>
                    <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Title
                        color</label>
                    <input type="color" name="titleColor" value="{{old('titleColor', $announcement->titleColor)}}"
                           class="bg-gray-50" required="">
                </div>
                <div>
                    <label for="message"
                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Content</label>
                    <textarea id="content" rows="4" name="content"
                              class="hidden block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                    <div id="editor">
                        {!! old('content', $announcement->content) !!}
                    </div>
                </div>
                <div>
                    <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Button
                        link</label>
                    <input type="text" name="buttonLink" value="{{old('buttonLink', $announcement->buttonLink)}}"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                           required="">
                </div>
                <div class="mt-16">
                    <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Button
                        title</label>
                    <input type="text" name="buttonText" value="{{old('buttonText', $announcement->buttonText)}}"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                           required="">
                </div>
                <div>
                    <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Button
                        color</label>
                    <input type="color" name="buttonColor" value="{{old('buttonColor', $announcement->buttonColor)}}"
                           required="">
                </div>
            </div>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 px-4 py-2 rounded-xl">Submit</button>
        </form>
    </div>
    @push('scripts')
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
            <script src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.js"></script>
            <script src="https://unpkg.com/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.js"></script>
        <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
            <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
            <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
        <script>
            var quill = new Quill('#editor', {
                theme: 'snow',
                placeholder: "Enter announcement details"
            });
            const form = document.querySelector('#formAnnoucement')
            form.addEventListener('submit', e => {
                e.preventDefault()
                const quillEditor = document.querySelector('#editor')
                const html = quillEditor.children[0].innerHTML

                document.querySelector('#content').value = html
                form.submit()
            })

            // Register the plugin
            FilePond.registerPlugin(FilePondPluginImagePreview);
            FilePond.registerPlugin(FilePondPluginFileValidateType);
            FilePond.registerPlugin(FilePondPluginImageResize);
            FilePond.registerPlugin(FilePondPluginImageTransform);
            // Get a reference to the file input element
            const inputElement = document.querySelector('#file_image');

            // Create a FilePond instance
            const pond = FilePond.create(inputElement, {
                imageResizeTargetWidth: 800,
                imageResizeMode: 'contain',
                imageResizeUpscale: false,
                server: {
                    url: '{{route('upload-image')}}',
                    headers:{
                        'X-CSRF-TOKEN' : '{{csrf_token()}}'
                    }
                }
            });


        </script>
    @endpush

    @push('styles')
        <!-- Include stylesheet -->
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
        <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet"/>
        <link
            href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
            rel="stylesheet"
        />
    @endpush
</x-app-layout>

