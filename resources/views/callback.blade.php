<!DOCTYPE html>
<html>
<head>
    <!-- Your head content here -->
</head>
<body>
    <script>
        // Assuming you have embedded the JSON data and redirect URL in the view
        var responseData = {!! json_encode($data) !!};
        var redirectUrl = '{!! $redirectUrl !!}';

        // Perform any processing with responseData as needed
        // Then redirect the user to the specified URL
        window.location.href = redirectUrl;
    </script>
</body>
</html>
