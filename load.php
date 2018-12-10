<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>load demo</title>
        <style>
            body {
                font-size: 12px;
                font-family: Arial;
            }
        </style>
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    </head>
    <body>

        <b>Successful Response (should be blank): </b>
        <div id="success"></div>
        <b>Error Response:</b>
        <div id="error"></div>
    <script type="text/javascript" src="https://www.google.com/jsapi" async></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js" async></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script>
            $( "#success" ).load( "/projeto-crashfix/construindo.php", function( response, status, xhr ) {
                
                if ( status == "error" ) {
                    var msg = "Sorry but there was an error2: ";
                    $( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
                }
            });

        </script>

    </body>
</html>