<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Twitter</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
        <link rel="stylesheet" href="/assets/css/style.css">
    </head>
    <body>
        <div class="wrapper">
            <header>
                <h1>
                    <i class="fa fa-user-circle-o fa-2x"></i>
                    <input type="text" placeholder="Search Twitter">
                </h1>
            </header>
            <nav>
                <ul>
                    <li><a href="#"><i class="fa fa-home fa-2x"></i></a></li>
                    <li><a href="#" class="active"><i class="fa fa-search fa-2x"></i></a></li>
                    <li><a href="#"><i class="fa fa-user fa-2x"></i></a></li>
                    <li><a href="#"><i class="fa fa-info-circle fa-2x"></i></a></li>
                </ul>
            </nav>
            <main>
                <ul class="results">
                    <li>Something</li>
                    <li>Else</li>
                    <li>And</li>
                    <li>More</li>
                </ul>
            </main>
            <a href="#" class="new-tweet">
                <i class="fa fa-twitter fa-2x"></i>
            </a>
        </div>
        <script>
            fetch('/api/v1/users/1', {
                method: 'PUT',
                body: JSON.stringify({
                    username: 'dj-josef'
                })
            })
            .then(res => res.text())
            .then(console.log)
        </script>
    </body>
</html>