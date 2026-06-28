<x-app-layout>

    <div class="py-12">

        <div class="max-w-5xl mx-auto">

            <div class="bg-white p-6 rounded shadow">

                <h1 class="text-3xl font-bold mb-6">
                    History:
                    {{ $document->title }}
                </h1>

                @foreach($versions as $version)

                    <div class="border p-4 mb-4 rounded">

                        <p>
                            <b>User:</b>
                            {{ $version->user->name }}
                        </p>

                        <p>
                            <b>Waktu:</b>
                            {{ $version->created_at }}
                        </p>

                        <hr class="my-3">

                        <h3 class="font-bold">
                            {{ $version->title }}
                        </h3>

                        <div class="prose max-w-none">
    {!! $version->content !!}
</div>

                    </div>

                @endforeach

            </div>

        </div>

    </div>

</x-app-layout>