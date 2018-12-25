
<?php

$connection = ssh2_connect('192.168.1.55', 22);
					ssh2_auth_password($connection, 'gauth', 'Skulblaka24');

					$stream = ssh2_exec($connection, 'mkdir /Users/Gauth/Desktop/test');


?>

