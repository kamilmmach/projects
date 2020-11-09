<pre>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('boot.php');

$sq = new KM\SourceQuery\ServerQuery('192.223.27.16', 27015);
$sq->connect();
echo("Informacje o serwerze 192.223.27.16:27015\n");
$server_info = $sq->getServerInfo();
var_dump($server_info);
if($server_info['num_players'] > 0)
{
    echo("Informacje o graczach:\n");
    var_dump($sq->players);
}
?>
</pre>
