<?php
session_start();
$email = isset($_GET['email']) ? htmlspecialchars($_GET['email']) : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Request OTP</title>
    <style>
        /* Toast styles */
        .toast {
            display: none;
            position: fixed;
            top: 80px;
            right: 20px;
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            z-index: 1000;
            transition: opacity 0.5s, transform 0.5s;
        }
    </style>
</head>
<body class="dark:bg-slate-800 dark:text-white">
    <header class="w-full sticky bg-slate-50 dark:bg-slate-700 top-0 z-10">
        <section class="max-w-4xl mx-auto flex flex-row justify-between items-center p-4">
            <div class="flex flex-row items-center gap-3">
                <img src="img/Haile-Hotel-Wolaita-scaled.jpg" class="w-10 h-10 rounded-3xl" alt="">
                <h1 class="text-3xl font-bold dark:text-white">Haile Hotel Wolaita</h1>
            </div>
            <div>
                <nav class="hidden md:flex flex-row gap-8 text-2xl dark:text-white">
                    <ul class="flex flex-row space-x-8 cursor-pointer">
                        <li class="hover:text-orange-400 transition-colors"><a href="index.html">Home</a></li>
                        <li class="hover:text-orange-400 transition-colors">About</li>
                        <li class="hover:text-orange-400 transition-colors">Gallery</li>
                        <li class="hover:text-orange-400 transition-colors">Contact</li>
                    </ul>
                </nav>
                <button id="hamburger-button" class="text-3xl md:hidden cursor-pointer">
                    &#9776;
                </button>
            </div>
        </section>
    </header>

    <main class="dark:bg-slate-900 max-w-sm m-auto mt-40 min-h-96 border border-green-900 rounded-3xl">
        <div id="otp-request-container">
            <form action="php/resources/send_otp.php" method="post" id="otp-request-form" onsubmit="return validateOtpRequest();">
                <fieldset class="flex flex-col items-center gap-4">
                    <h1 class="text-3xl text-cyan-400 mt-3 text-center underline decoration-white underline-offset-4">Request OTP</h1>
                    <input type="email" id="email" placeholder="Email" name="email" class="rounded bg-slate-800 p-2 placeholder-white placeholder-opacity-100" value="<?php echo htmlspecialchars($_GET['email'] ?? ''); ?>" required>
                    <input type="submit" value="Send OTP" class="text-cyan-500 text-2xl border border-green-700 rounded-xl p-3 hover:text-cyan-400 cursor-pointer">
                </fieldset>
            </form>
        </div>
        <div id="change-password-container" style="display:none;">
            <form action="change_password.php" method="post" id="change-password-form" onsubmit="return validateChangePassword();">
                <fieldset class="flex flex-col items-center gap-12">
                    <h1 class="text-3xl text-cyan-400 mt-3 text-center underline decoration-white underline-offset-4">Change Your Password</h1>
                    <input type="text" id="otp" placeholder="OTP" name="otp" class="rounded bg-slate-800 p-2 placeholder-white placeholder-opacity-100" required>
                    <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email'], ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="password" id="n_pwd" placeholder="New Password" name="n_password" class="rounded bg-slate-800 p-2 placeholder-white placeholder-opacity-100" required>
                    <input type="password" id="c_pwd" name="c_password" placeholder="Confirm Password" class="rounded bg-slate-800 p-2 placeholder-white placeholder-opacity-100" required>
                    <input type="submit" value="Change Password" class="text-cyan-500 text-2xl border border-green-700 rounded-xl p-3 hover:text-cyan-400 cursor-pointer">
                </fieldset>
            </form>
        </div>
    </main>

    <div id="toast" class="toast"></div>

    <script>
        function showToast(message) {
            const toast = document.getElementById('toast');
            toast.innerText = message;
            toast.style.display = 'block';
            toast.style.opacity = 1;
            toast.style.transform = 'translateY(0)';

            setTimeout(() => {
                toast.style.opacity = 0;
                toast.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    toast.style.display = 'none';
                }, 500);
            }, 3000); // Show for 3 seconds
        }

        function validateOtpRequest() {
            const email = document.getElementById('email');
            const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

            if (!email.value) {
                email.placeholder = "Email can't be empty";
                return false;
            } else if (!emailPattern.test(email.value)) {
                email.placeholder = "Email is not valid";
                return false;
            }
            return true; // All validations passed
        }

        function validateChangePassword() {
            const otp = document.getElementById('otp');
            const n_pwd = document.getElementById('n_pwd');
            const c_pwd = document.getElementById('c_pwd');

            if (!otp.value) {
                otp.placeholder = "OTP can't be empty";
                return false;
            } else if (!n_pwd.value) {
                n_pwd.placeholder = "New password can't be empty";
                return false;
            } else if (!c_pwd.value) {
                c_pwd.placeholder = "Confirm password can't be empty";
                return false;
            } else if (n_pwd.value !== c_pwd.value) {
                showToast("Passwords do not match"); // Show toast for password mismatch
                n_pwd.placeholder = "Passwords do not match";
                c_pwd.placeholder = "Passwords do not match";
                return false;
            }
            return true; // All validations passed
        }

        <?php if (isset($_SESSION['otp_sent'])): ?>
            document.getElementById('otp-request-container').style.display = 'none'; // Hide OTP request form
            document.getElementById('change-password-container').style.display = 'block'; // Show change password form
            <?php unset($_SESSION['otp_sent']); // Clear the session variable ?>
        <?php endif; ?>
    </script>
</body>
</html>