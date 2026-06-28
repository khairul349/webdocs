<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $document->title }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>

        .ql-font-arial {
            font-family: Arial, sans-serif;
        }

        .ql-font-calibri {
            font-family: Calibri, sans-serif;
        }

        .ql-font-times-new-roman {
            font-family: "Times New Roman", serif;
        }

        .ql-font-courier-new {
            font-family: "Courier New", monospace;
        }

        .ql-font-georgia {
            font-family: Georgia, serif;
        }

        .ql-font-verdana {
            font-family: Verdana, sans-serif;
        }

    </style>

</head>

<body class="bg-gray-100">

    <div class="py-12 min-h-screen">

        <div class="max-w-5xl mx-auto">

            <div class="bg-white shadow-lg rounded-lg p-8">

                <h1 class="text-4xl font-bold mb-8">
                    {{ $document->title }}
                </h1>

                <div class="text-lg">
                    {!! $document->content !!}
                </div>

            </div>

        </div>

    </div>

</body>
</html>