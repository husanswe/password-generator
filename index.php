<?php

    function generatePassword($length = 8) {
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '0123456789';
        $specialChars = '!@#$%^&*()-_=+[]{}|;:,.<>?';

        $chars = $lowercase . $uppercase . $numbers . $specialChars;
        $charsLength = strlen($chars);
        $password = '';

        $password .= $lowercase[random_int(0, strlen($lowercase) - 1)];
        $password .= $uppercase[random_int(0, strlen($uppercase) - 1)];
        $password .= $numbers[random_int(0, strlen($numbers) - 1)];
        $password .= $specialChars[random_int(0, strlen($specialChars) - 1)];

        for ($i = 0; $i < $length - 4; $i++) {
            $password .= $chars[random_int(0, strlen($chars) - 1)];
        }

        return str_shuffle($password);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $length = 12;
        $password = generatePassword($length);
    }

    if (isset($_GET['password'])) {
        echo '<p><strong>' . htmlspecialchars($_GET['password']) . '</strong></p>';
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="unlock.png">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <title>Password Generator</title>
    </head>

    <body>
        <div class="container text-center mt-5">
            <h1 class="fw-bold">Simple Password Generator</h1>
        </div>

        <div class="container d-flex justify-content-center mt-5 card-shadow">
            <form action="" method="post">
                <label for="password" class="form-label fw-bold fs-4 text-start d-block">Password:</label>
                <input type="text" name="password" id="password" class="form-control form-control-lg" value="<?php echo htmlspecialchars($password); ?>" placeholder="Create Passoword" readonly>
                
                <div class="mt-4 d-flex justify-content-between gap-5">
                    <button type="submit" class="btn btn-primary rounded-3 flex-fill">Generate</button>
                    <button type="button" id="copyBtn" class="btn btn-primary rounded-3 flex-fill">Copy</button>
                </div>
            </form>
        </div>

        <script>
            document.getElementById('copyBtn').addEventListener('click', function() {
                const passwordField = document.getElementById('password');
                passwordField.select();
                passwordField.setSelectionRange(0, 99999);
                navigator.clipboard.writeText(passwordField.value)
                .then(() => alert('Password copied to clipboard!'))
                .catch(() => alert('Failed to copy'));
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>
</html>