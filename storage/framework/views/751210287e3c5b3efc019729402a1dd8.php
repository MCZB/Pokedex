<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        /* Adicione seu CSS aqui */
    </style>
</head>
<body>
    <div id="app">
        <?php echo $__env->yieldContent('content'); ?>
    </div>

    <!-- Scripts -->
    <script>
        // Adicione seu JavaScript aqui
    </script>
</body>
</html>
<?php /**PATH E:\pokemon\resources\views/layouts/app.blade.php ENDPATH**/ ?>