<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Cinzel+Decorative:400,900|Roboto:400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>@yield('title')</title>

    <style>
        body {
            font-family: "Roboto", sans-serif;
            font-size: .875rem;
        }
        [role="main"] {
            padding-top: 64px;
        }
        .brand {
            font-family: "Cinzel Decorative", cursive;
        }
        .brand .saga {
            font-weight: 900;
            text-transform: uppercase;
        }
        .full-height .brand {
            font-size: 10vh;
            text-align: center;
        }
        .full-height {
            height: 100vh;
        }
        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }
        /*
         * Sidebar
         */
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100; /* Behind the navbar */
            padding: 64px 0 0; /* Height of navbar */
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        }
        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 64px);
            padding-top: .5rem;
            overflow-x: hidden;
            overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
        }
        @supports ((position: -webkit-sticky) or (position: sticky)) {
            .sidebar-sticky {
                position: -webkit-sticky;
                position: sticky;
            }
        }
        .user-pic {
            margin-right: 8px;
        }
        .entry-body {
            font-size: 1rem;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    @yield('body')
</body>
</html>
