<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- Styles -->
    <style></style>
</head>
<body class="antialiased">
    <div id="chat_modal" class="ihsanAi-modal" >
<div class="content">het</div>
<script>
      console.log('yes');
</script>
</div>

<script >
    {!! Vite::content('resources/js/app.js') !!}
</script>



<script>

Echo.channel('comingSMS.17105284360098BtS0ERAKnM')
        .listen('oldSMS', (e) => {
            console.log(e);
    });
</script>
</body>
</html>
