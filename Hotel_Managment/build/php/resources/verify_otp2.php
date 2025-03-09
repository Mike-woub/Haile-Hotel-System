<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css"> 
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Verify OTP</title>
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
                <img src="../../img/Haile-Hotel-Wolaita-scaled.jpg" class="w-10 h-10 rounded-3xl" alt="">
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
        <div id="otp-form">
            <form id="otpVerificationForm">
                <fieldset class="flex flex-col items-center gap-12">
                    <h1 class="text-3xl text-cyan-400 mt-3 text-center underline decoration-white underline-offset-4">Enter OTP</h1>
                    <p class="text-xl">
                        <input type="email" id="email" placeholder="Email" name="email" class="rounded bg-slate-800 p-2 placeholder-white placeholder-opacity-100" value="<?php echo htmlspecialchars($_GET['email'] ?? ''); ?>" readonly>
                    </p>
                    <p class="text-xl">
                        <input type="text" id="otp" name="otp" placeholder="OTP" class="rounded bg-slate-800 p-2 placeholder-white placeholder-opacity-100">
                    </p>
                    <p class="flex flex-col items-center gap-4 mb-4">
                        <input type="submit" value="Verify OTP" class="text-cyan-500 text-2xl border border-green-700 rounded-xl p-3 hover:text-cyan-400 cursor-pointer">
                    </p>
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

        async function handleOtpVerification(event) {
            event.preventDefault(); // Prevent form submission

            const formData = new FormData(document.getElementById('otpVerificationForm'));
            const response = await fetch('verify_otp.php', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();
            showToast(data.message); // Show the response message

            if (data.success) {
                setTimeout(() => {
                    window.location.href = '../../login.html'; // Redirect to login page
                }, 2000); // Redirect after 2 seconds
            }
        }

        document.getElementById('otpVerificationForm').addEventListener('submit', handleOtpVerification);
    </script>
</body>
</html>