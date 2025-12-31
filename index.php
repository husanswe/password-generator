<?php
    session_start();
    $password = '';

    // Faqat Generate bosilganda password yaratish
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $password = generatePassword(12);
        $_SESSION['temp_password'] = $password;
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }

    if (isset($_SESSION['temp_password'])) {
        $password = $_SESSION['temp_password'];
        unset($_SESSION['temp_password']);  // 1 marta ko'rsatgandan keyin o'chirish
    }

    function generatePassword($length = 12) {
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '0123456789';
        $specialChars = '!@#$%^&*()-_=+[]{}|;:,.<>?';

        $allChars = $lowercase . $uppercase . $numbers . $specialChars;
        $password = '';

        // Har bir turdan kamida 1 ta (strong password)
        $password .= $lowercase[random_int(0, strlen($lowercase) - 1)];
        $password .= $uppercase[random_int(0, strlen($uppercase) - 1)];
        $password .= $numbers[random_int(0, strlen($numbers) - 1)];
        $password .= $specialChars[random_int(0, strlen($specialChars) - 1)];

        // Qolgan belgilar
        for ($i = 4; $i < $length; $i++) {
            $password .= $allChars[random_int(0, strlen($allChars) - 1)];
        }

        return str_shuffle($password);
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="padlock.png">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <title>Password Generator</title>
    </head>

    <body>
        <div class="container text-center mt-5">
            <h1 class="fw-bold">Simple Password Generator</h1>
        </div>

        <div class="container d-flex justify-content-center mt-5 py-5 shadow">
            <form action="" method="post">
                <label for="password" class="form-label fw-bold fs-4 text-start d-block">Password:</label>
                <input type="text" name="password" id="password" class="form-control form-control-lg" value="<?php echo htmlspecialchars($password); ?>" placeholder="Click Generate to create password" readonly>
                
                <div class="mt-4 d-flex justify-content-between gap-5">
                    <button type="submit" class="btn btn-primary rounded-3 flex-fill">Generate</button>
                    <button type="button" id="copyBtn" class="btn btn-outline-secondary rounded-3 flex-fill" 
                    <?=  empty($password) ? 'disabled' : '' ?>>Copy</button>
                </div>
            </form>
        </div>

        <script>
            document.getElementById('copyBtn').addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            
                if (passwordField.value) {
                    navigator.clipboard.writeText(passwordField.value)
                        .then(() => {
                            // Success feedback
                            const btn = this;
                            const originalText = btn.textContent;
                            btn.textContent = 'Copied!';
                            btn.classList.remove('btn-outline-secondary');
                            btn.classList.add('btn-success');
                            
                            setTimeout(() => {
                                btn.textContent = originalText;
                                btn.classList.remove('btn-success');
                                btn.classList.add('btn-outline-secondary');
                            }, 2000);
                        })
                        .catch(() => alert('Failed to copy password'));
                }
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>
</html>