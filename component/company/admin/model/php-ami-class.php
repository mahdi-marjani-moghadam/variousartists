<?php 
class AstMan {

	public $socket;
	public $error;
	public $amiHost = "";
	public $amiPort = "";
	public $amiUsername = "";
	public $amiPassword = "";

	function __constructor() {
		$this -> socket = false;
		$this -> error = "";
	}


	function clickToCall($dialphonenumber)
	{
		global $admin_info;

		$timeout = 30;
		$asterisk_ip = ASTERISK_SERVER_IP;
		$extention = $admin_info['extension'];

		//print_r_debug($admin_info);
		$socket = fsockopen($asterisk_ip,"5038", $errno, $errstr, $timeout);
		/*if (!$this -> socket) {
			echo "no";
			die();
		}*/

		fputs($socket, "Action: Login\r\n");
		fputs($socket, "UserName: admin\r\n");
		fputs($socket, "Secret: admin\r\n\r\n");

		$wrets=fgets($socket,128);

		//fputs($socket, "Action: originate\r\n" );
		//fputs($socket, "Channel: SIP/10007\r\n" );
		//fputs($socket, "WaitTime: 30\r\n");
		//fputs($socket, "Exten: 10006\r\n" );
		fputs($socket, "Action: Command\r\nCommand: channel originate SIP/$extention extension $dialphonenumber@clicktocall\r\n\r\n" );

		//$query = "Action: Command\r\nCommand: Reload\r\n\r\n";

		//asterisk -rx "channel originate SIP/10007 extension 10006@clicktocall"

		//fputs($socket, "Context: clicktocall\r\n" ); // very important to change to your outbound context
		//fputs($socket, "Priority: 1\r\n" );
		//fputs($socket, "Async: yes\r\n\r\n" );
		//sleep(2);
		$wrets=fgets($socket,128);
		if(strpos('failed',$wrets))
		{
			echo 'no';
		}else
		{
			echo 'yes';
		}
		fclose($socket);
		die();


		$this -> socket = @fsockopen($this -> amiHost,$this -> amiPort, $errno, $errstr, 1);
		if (!$this -> socket) {
			$this -> error =  "Could not connect: $errstr ($errno)";
			return false;
		}else{
			stream_set_timeout($this -> socket, 1);
			$wrets = $this -> Query("Action: Originate\r\n Channel: SIP/$extension\r\n  Exten: $dialphonenumber\r\n
		Context: dial-outbound\r\n  Priority: 1\r\n Async: yes\r\n\r\n" );
			if (strpos($wrets, "Message: Authentication accepted") !== false) {
				return true;
			}else{
				$this -> error = $wrets;
				fclose($this -> socket);
				$this -> socket = false;
				return false;
			}
		}


	}
	function Login() {

		$this -> socket = @fsockopen($this -> amiHost,$this -> amiPort, $errno, $errstr, 1);
		if (!$this -> socket) {
			$this -> error =  "Could not connect: $errstr ($errno)";
			return false;
		}else{
			stream_set_timeout($this -> socket, 1);
			$amiUsername = $this -> amiUsername;
			$amiPassword = $this -> amiPassword;
			$wrets = $this -> Query("Action: Login\r\nUserName: $amiUsername\r\nSecret: $amiPassword\r\nEvents: off\r\n\r\n");
			if (strpos($wrets, "Message: Authentication accepted") !== false) {
				return true;
			}else{
				$this -> error = "Could not login: Authentication failed.";
				fclose($this -> socket);
				$this -> socket = false;
				return false;
			}
		}
	}

	function Logout() {
		if ($this -> socket) {
			fputs($this -> socket, "Action: Logoff\r\n\r\n");
			while (!feof($this -> socket)) {
				$wrets .= fread($this -> socket, 8192);
			}
			fclose($this -> socket);
			$this -> socket = false;
		}
		return;
	}

	function Query($query) {
		$wrets = "";
		if ($this -> socket === false) {
			$this -> error = "No connection.";
			return false;
		}
		fputs($this -> socket, $query);
		do {
			$line = fgets($this -> socket, 4096);
			$wrets .= "<br>".$line;
			$info = stream_get_meta_data($this -> socket);
		} while ($line != "\r\n" && $info["timed_out"] === false );
		return $wrets;
	}

	function Reload() {
		$query = "Action: Command\r\nCommand: Reload\r\n\r\n";
		$wrets = "";

		if ($this -> socket === false) {
			$this -> error = "No connection.";
			return false;
		}

		fputs($this -> socket, $query);
		do
		{
			$line = fgets($this -> socket, 4096);
			$wrets .= $line;
			$info = stream_get_meta_data($this -> socket);
		}while ($line != "\r\n" && $info["timed_out"] === false );
		return $wrets;
	}

	function GetUsers() {
		$query = "Action: SIPpeers\r\n\r\n";
		$wrets = "";

		if ($this -> socket === false) {
			$this -> error = "No connection.";
			return false;
		}

		fputs($this -> socket, $query);
		do
		{
			$line = fgets($this -> socket, 4096);
			$wrets .= $line;
			$info = stream_get_meta_data($this -> socket);
		} while ($line != "Event: PeerlistComplete\r\n" && $info["timed_out"] === false );
		return $wrets;
	}

	function AddUser($user, $type, $dir) {
		if ($user && $type && $dir) {
			echo $dir;
			if (!file_exists($dir))
			{
				die('nist');
			}
			$file = fopen($dir, "a+");
			switch ($type) {
				case "webrtc":
					$str = "[".$user."]\n type=peer\n username=".$user."\n host=dynamic\n secret=".$user."\n context=default\n hasiax = no\n hassip = yes\n encryption = yes\n avpf = yes\n icesupport = yes\n videosupport=no\n directmedia=no\n nat=yes\n qualify=yes\n\n";
					break;
				case "sip":
					$str = "[".$user."]\n type=peer\n username=".$user."\n host=dynamic\n secret=".$user."\n context=default\n hasiax = no\n hassip = yes\n nat=yes\n\n";
					break;
			}
			fwrite($file, $str);
			fclose($file);
			return true;
		}else{
			$this -> error = "One or more parameters are missing.";
			return false;
		}
	}

	function AddExtension($user, $dir) {
		if ($user && $dir) {
			$file = fopen($dir, "a+");
			$str = "exten => ".$user.",1,Dial(SIP/".$user.")\n";
			fwrite($file, $str);
			fclose($file);
			return true;
		}else{
			$this -> error = "One or more parameters are missing.";
			return false;
		}
	}

	function GetError() {
		return $this -> error;
	}
}