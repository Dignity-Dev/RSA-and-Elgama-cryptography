<?php

// // Generate the public and private keys
// $p = gmp_init('13');
// $g = gmp_init('3');
// $x = gmp_init('5');
// $y = gmp_powm($g, $x, $p);

// // Encrypt the message
// $m = gmp_init('9');
// $k = gmp_init('7');
// $a = gmp_powm($g, $k, $p);
// $b = gmp_mul($m, gmp_powm($y, $k, $p));
// $b = gmp_mod($b, $p);

// // Decrypt the message
// $m = gmp_mul($b, gmp_powm($a, gmp_sub($p, $x), $p));
// $m = gmp_mod($m, $p);


// echo "Encrypted message: " . gmp_strval($b) . "\n";
// echo "Decrypted message: " . gmp_strval($m) . "\n";


// Generate the public and private keys
$p = gmp_init('13');
$g = gmp_init('3');
$x = gmp_init('5');
$y = gmp_powm($g, $x, $p);

// Convert the message to a number
$m = gmp_init(bin2hex('I love you'), 16);

// Encrypt the message
$k = gmp_init('7');
$a = gmp_powm($g, $k, $p);
$b = gmp_mul($m, gmp_powm($y, $k, $p));
$b = gmp_mod($b, $p);

// Decrypt the message
$m = gmp_mul($b, gmp_powm($a, gmp_sub($p, $x), $p));
$m = gmp_mod($m, $p);

// Convert the message back to a string
$plaintext = hex2bin(gmp_strval($m, 16));

echo "Decrypted message: " . $plaintext . "\n";