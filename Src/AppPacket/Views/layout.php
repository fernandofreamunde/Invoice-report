<!DOCTYPE html>
<html>
    <head>
        <title>Invoice Report App</title>

        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device=width, initial-scale=1" />

        <link rel="stylesheet" href="/css/bootstrap.min.css" >
        <link rel="stylesheet" href="/css/styles.css" >


    </head>
    <body>
    <nav class="navbar navbar-inverse">
        <div class="container">
            <!-- Logo -->
            <div class="navbar-header">
                <a class="navbar-brand" href="/">
                    Invoice Report
                </a>
            </div>

            <div >
                <!-- left menu contents -->


                <!-- right menu contents -->
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="/customer/report">Customer Report</a>
                    </li>
                    <li>
                        <a href="/invoice/report">Transactions Report</a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
    <div class="container">
            <?=$content ?>
    </div>

        <script src="/js/jquery-3.2.1.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
    </body>
</html>
