<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <!-- Site Properties -->
    <title>Fixed Menu Example - Semantic</title>

    <link rel="stylesheet" type="text/css" href={{asset("/dist/components/reset.css")}}>
    <link rel="stylesheet" type="text/css" href={{asset("/dist/components/site.css")}}>

    <link rel="stylesheet" type="text/css" href={{asset("/dist/components/container.css")}}>
    <link rel="stylesheet" type="text/css" href={{asset("/dist/components/grid.css")}}>
    <link rel="stylesheet" type="text/css" href={{asset("/dist/components/header.css")}}>
    <link rel="stylesheet" type="text/css" href={{asset("/dist/components/image.css")}}>
    <link rel="stylesheet" type="text/css" href={{asset("/dist/components/menu.css")}}>

    <link rel="stylesheet" type="text/css" href={{asset("/dist/components/divider.css")}}>
    <link rel="stylesheet" type="text/css" href={{asset("/dist/components/list.css")}}>
    <link rel="stylesheet" type="text/css" href={{asset("/dist/components/segment.css")}}>
    <link rel="stylesheet" type="text/css" href={{asset("/dist/components/dropdown.css")}}>
    <link rel="stylesheet" type="text/css" href={{asset("/dist/components/icon.css")}}>

    <link rel="stylesheet" href="{{asset('/dist/semantic.min.css')}}">
    <link rel="stylesheet" href="{{asset('/dist/components/sidebar.min.css')}}">
    <style type="text/css">
        body {
            background-color: #FFFFFF;
        }
        .ui.menu .item img.logo {
            margin-right: 1.5em;
        }
        .main.container {
            margin-top: 7em;
        }
        .wireframe {
            margin-top: 2em;
        }
        .ui.footer.segment {
            margin: 5em 0em 0em;
            padding: 5em 0em;
        }
    </style>
</head>
<body>
    <div class="ui sidebar inverted vertical menu">
        <a class="item">1</a>
        <a class="item">2</a>
        <a class="item">3</a>
    </div>
    <div class="ui main text container Overlay">
        <button onclick="push()">push</button>
        @yield('content')
    </div>
</body>
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('dist/semantic.min.js')}}"></script>
<script src="{{asset('dist/components/sidebar.min.js')}}"></script>
<script>
    function push() {
        $('.ui.sidebar').sidebar('toggle');
    }
</script>
</html>
