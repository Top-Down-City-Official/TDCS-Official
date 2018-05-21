<?php
   $url=$_SERVER['REQUEST_URI'];
   header("Refresh: 0; URL=$url");
?>
<?php
	if(isset($_POST['name']) && isset($_POST['host']))
	{
		$port = 80;

		if(!empty($_POST['port'])) $port = $_POST['port'];

		addServer($_POST['name'], $_POST['host'], $port);

		header('Location: index.php');
	}
/*	else if(isset($_GET['del']))
	{
		$index = (int) $_GET['del'];
		if($index >= 0) deleteServer($index);
	}*/
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="robots" content="noindex">
        <meta charset="utf-8">
        <title>Servers Status Checker</title>
        <!--link href="css/bootstrap.css" rel="stylesheet"-->
        <!--link href="css/bootstrap-theme.css" rel="stylesheet"-->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </head>
    <body>
    	<div class="container"><center>
    	    <h1><b><font color="Cyan"><i>Top</font> <font color="blue">Down</font> <font color="Cyan">City</font> <font color="blue">Official</font></i></b></h1>
    		<h3><font color="Yellow">Servers</font> <font color="cyan">Status</font> <font color="Yellow">Checker</font></h3><font color="white">
    		<table class="table table-bordered" bgcolor="white">
				<tr>
					<th class="text-center"><font color="red">Name</th>
					<th class="text-center"><font color="red">Domain</th>
					<th class="text-center"><font color="red">IP</th>
					<th class="text-center"><font color="red">Port</th>
					<th class="text-center"><font color="red">Game</th>
					<th class="text-center"><font color="red">Connect</font></th>
				
					<!--th class="text-center deleteMode" style="width:75px">Delete</th-->
				</tr>
                <?php parser();?>
			</table>
			<!--<input id="editMode" type="button" value="Edit mode" checked="checked" class="btn btn-default pull-right" />
			<form class="form-inline" role="form" action="index.php" method="post">
				<div class="form-group">
					<input type="text" class="form-control" id="name" name="name" placeholder="Name">
				</div>
				<div class="form-group">
					<input type="text" class="form-control" onkeyup="javascript:checkForm(this)" id="host" name="host" placeholder="Domain / IP">
				</div>
				<div class="form-group">
					<input type="text" size="5" class="form-control" id="port" name="port" placeholder="Port">
				</div>
				<button type="submit" class="btn btn-default" id="add-button">Add</button>
			</form>-->
			<br></center>
			<footer>
    			
				<!--<a href="vmp" class="btn btn-info">check v-mp</a>
				<a href="ivmp" class="btn btn-default">check iv-mp</a>
				<a href="lump" class="btn btn-default">check lump (0.1)</a><br><br>
				<a href="vcmp" class="btn btn-success">check vcmp (0.4)</a>
				<a href="samp" class="btn btn-warning">check samp (0.3.7)</a><br><br>
				<a href="vcmpold" class="btn btn-danger">check vcmp (0.3zr-Outdated)</a><br><br>
				<a href="cs" class="btn btn-primary">Counter Strike (1.6)</a>-->
				
				
    		</footer> 
    	</div>
    	<script src="js/jquery.js" type="text/javascript"></script>
        <script src="js/app.js" type="text/javascript"></script>
        <!--script src="js/bootstrap.min.js" type="text/javascript"></script--> 
    </body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){ 
	$('body').find('img[src$="https://cdn.rawgit.com/000webhost/logo/e9bd13f7/footer-powered-by-000webhost-white2.png"]').remove();
    }); 
</script>
<style>
		body {
   background-image: url("image/back.jpg");
   background-color: #cccccc;
    height: 100%;
	position: relative;
  opacity: 0.70;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}</style>
<center>
<h4><b><font color="red">Note:</b><font color="white">If your not able to connect any of the Server's, It might be because the Servers' may be down <font color="yellow">!</font></h4></center>
</html>
<?php
function getStatus($ip, $port)
{
	$socket = @fsockopen($ip, $port, $errorNo, $errorStr, 2);
	if (!$socket) return false;
	else return true;
}

function addServer($name, $host, $port, $game, $connect)
{
	// TODO : rewrite the opening part correctly (better errors management)
	$i = 0;
	$filename = 'servers.xml';

	$servers = file_get_contents("servers.xml");
	if (trim($servers) == '')
	{
		exit();
	}
	else
	{
		$servers = simplexml_load_file("servers.xml");
		foreach ($servers as $server) $i++;
	}

	$servers = simplexml_load_file($filename);
	$server = $servers->addChild('server');
	$server->addAttribute('id', (string) $i);
	if(strlen($name) == 0) $name = $host;
	$server->addChild('name', (string)$name);
	$server->addChild('host', (string)$host);
	$server->addChild('port', (string)$port);
	$server->addChild('game', (string)$game);
	$server->addChild('connect', (string)$connect);
	$servers->asXML($filename);
}

function parser()
{
	//TODO : Fix errors when no valid XML content inside file.
	$file = "servers.xml";
	if(file_exists($file))
	{
		$servers = file_get_contents("servers.xml");
		if (trim($servers) == '') //File exists but empty
		{	
			$content = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><servers></servers>";
			file_put_contents($file, $content, FILE_APPEND | LOCK_EX);
		}
		else
		{
			$servers = simplexml_load_file("servers.xml");
			foreach ($servers as $server)
			{
				echo "<tr>";
				
				echo "<td>".$server->name."</td>";
				if(filter_var($server->host, FILTER_VALIDATE_IP))
				{
					echo "<td class=\"text-center\">N/A</td><td class=\"text-center\">".$server->host."</td>";	
				}
				else
				{
					echo "<td class=\"text-center\">".$server->host."</td><td class=\"text-center\">".gethostbyname($server->host)."</td>";
				}

				echo "<td class=\"text-center\">".$server->port."</td>";
                echo "<td class=\"text-center\">".$server->game."</td>";
				echo "<td class=\"text-center\">".$server->connect."</td>";
				if (getStatus((string)$server->host, (string)$server->port))
				{
					//echo "<td class=\"text-center\"><span class=\"label label-success\">Online</span></td>";
				}
				else 
				{
					//echo "<td class=\"text-center\"><span class=\"label label-danger\">Offline</span></td>";
				}
			//	echo "<td class=\"text-center deleteMode\"><a href=\"index.php?del=".$server->attributes()."\" style=\"text-decoration:none\"><b style=\"color:red;\">X</b></a></td>";
			//	echo "</tr>";
			}
		}
	}
	else
	{
		// TODO : detect creation errors (ex : permissions)
		$content = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><servers></servers>";
		file_put_contents($file, $content, FILE_APPEND | LOCK_EX);
	}
}

function deleteServer($index)
{
	$file = "servers.xml";

	$serverFile = new DOMDocument;
	$serverFile->formatOutput = true;
	$serverFile->load($file);
	$servers = $serverFile->documentElement;
	$list = $servers->getElementsByTagName('server');
	$nodeToRemove = null;

	foreach ($list as $server)
	{
		$attrValue = $server->getAttribute('id');
		if ((int)$attrValue == $index) $nodeToRemove = $server;
	}

	if ($nodeToRemove != null) $servers->removeChild($nodeToRemove);

	$serverFile->save($file);
	header('Location: index.php');
}
