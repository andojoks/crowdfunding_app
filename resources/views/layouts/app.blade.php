<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Charity') }}</title>

    <meta name="description" content="Make donations to causes">
    <meta name="keywords" content="charity , make donations, grants, free grants">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700|Montserrat:300,400,700,900" rel="stylesheet">
    <link rel="stylesheet" href="/css/styles-merged.css">
    <link rel="stylesheet" href="/css/style.min.css">
    <link rel="stylesheet" href="/css/custom.css">

    <link href="/wysiwyg/css/wysiwyg.css" rel="stylesheet">
    <link href="/wysiwyg/css/highlight.min.css" rel="stylesheet">

    <!-- Include Moment.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    @include('layouts.navigation')

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>

    @include('layouts.footer')


    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // Function to update relative time for all elements with class 'relative-time'
            function updateRelativeTimes() {
                var elements = document.querySelectorAll('.relative-time');
                // elements.forEach(function(element) {
                //   var timestamp = element.getAttribute('data-timestamp');
                //  var relativeTime = moment(timestamp).fromNow();
                // element.textContent = relativeTime;
                //});

                elements.forEach(function(element) {
                    var timestamp = element.getAttribute('data-timestamp');

                    // Convert the timestamp to a moment object
                    var targetDate = moment(timestamp);

                    // Check if the date is in the future or past
                    if (targetDate.isAfter(moment())) {
                        // Future date - "Due in X time"
                        element.textContent = "Due in " + targetDate.fromNow(
                        true); // 'fromNow(true)' removes the "in" and "ago"
                    } else {
                        // Past date - "Closed X time ago"
                        element.textContent = "Closed " + targetDate.fromNow();
                    }
                });
            }

            // Initial update
            updateRelativeTimes();

            // Auto update every minute
            setInterval(updateRelativeTimes, 60000); // Update every 60 seconds (60000 ms)
        });
    </script>
</body>

</html>
