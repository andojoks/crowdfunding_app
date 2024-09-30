<!DOCTYPE html>

<html>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <style>
        .custom-button {
            border: 1px solid #FDBE34 !important;
            background-color: #FDBE34 !important;
            color: #fff !important;
        }
    </style>
</head>

<body>
    <section class="probootstrap-section"
        style="min-height: 100vh; display: flex; justify-content: center; align-items: center;">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="text-center">
                        <h2 style="display: flex; justify-content: center; align-items: center; margin-bottom: 20px;">
                            <span style="font-size: 5rem; font-weight: bold;">4</span>
                            <i class="glyphicon glyphicon-exclamation-sign text-danger" style="font-size: 3rem;"></i>
                            <span style="font-size: 5rem; font-weight: bold;">4</span>
                        </h2>
                        <h3 class="h2" style="margin-bottom: 10px;">Oops! You're lost.</h3>
                        <p style="margin-bottom: 30px;">{{ $exception->getMessage() ?: 'The page does not exist.' }}</p>
                        <a class="btn btn-primary custom-button" role="button" href="{{ route('dashboard') }}">
                            Back to Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>