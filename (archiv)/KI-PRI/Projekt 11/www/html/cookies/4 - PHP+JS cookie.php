<?php
$cookieName = 'views';

// posláno klientem
$views = @$_COOKIE[$cookieName] + 1;
// if(isset($_COOKIE[$cookieName])) {
//     $views = (int)$_COOKIE[$cookieName] + 1;
// } else {
//     $views=1;
// }

setcookie($cookieName, $views, time() + 10);
?>
<!DOCTYPE html>
<html>

<head>
    <script>
        function getCookieValue(cookieName) {
            let keyValPairs = document.cookie.split("; ")
            for (let keyVal of keyValPairs) {
                let [key,val] = keyVal.split('=');
                if (key == cookieName)
                    return decodeURIComponent(val);
            }

            return null;
        }

        let views = getCookieValue('views')
    </script>
</head>

<body>
    Views: <script>document.write(views)</script>

    <!-- <pre>< ?php print_r($_COOKIE); ?></pre> -->
</body>

</html>
