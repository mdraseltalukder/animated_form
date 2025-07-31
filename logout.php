<?php 
session_start();

// সব session unset ও destroy করো
session_unset();
session_destroy();

// যদি 'user' নামে cookie সেট করা থাকে, সেটা unset করো
if (isset($_COOKIE['user'])) {
    unset($_COOKIE['user']);
    setcookie('user', '', time() - 3600, '/'); // আগের সময় দিয়ে cookie মুছে ফেলো
}

// লগআউট হওয়ার পর সাইন ইন পেজে নিয়ে যাও
header("Location: signin.php");
exit();
?>
