<?php

/**
 * Form for editing HTML block instances.
 *
 * @package   block_itutor_chat
 * @copyright 2012 onwards Karsten Øster Lundqvist, University of Reading, ITUTOR
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_itutor_chat extends block_base {

    function init() {
        $this->title = get_string('I-TUTOR', 'block_itutor_chat');
    }

    function has_config() {
        return true;
    }

    function get_content() {

        if ($this->content !== NULL) {
            return $this->content;
        }
		
		$this->content         =  new stdClass;
		/*$this->content->text   = '<iframe src="http://localhost/strophejs/itutorbot"></iframe>';*/
		
		$adrs = "karlund@localhost";
		if (! empty($this->config->chataddress)) {
			$adrs = $this->config->chataddress;
		}
		
		$jid = "";
		if (! empty($this->config->jid)) {
			$jid = $this->config->jid;
		}
		$psw = "";
		if (! empty($this->config->password)) {
			$psw = $this->config->password;
		}
		
		
		
		$this->content->text = 
'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>ITUTOR bot</title>
  <script type="text/javascript"
	  src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script>
  <script type="text/javascript"
	  src="./blocks/itutor_chat/strophe.js"></script>
<script type="text/javascript">
var BOSH_SERVICE = "http://ks3299186.kimsufi.com:5280/http-bind";
var connection = null;
var toBot ="'.$adrs.'"
var readyToRecieve = false;

function log(msg) 
{
    $("#log").append("<div>+msg+</div>");
	var objDiv = document.getElementById("log");
	objDiv.scrollTop = objDiv.scrollHeight;
}

function onConnect(status)
{
	
    if (status == Strophe.Status.CONNECTING) {
	//log("Strophe is connecting.");
    } else if (status == Strophe.Status.CONNFAIL) {
		var button = $("#connect").get(0);
	    button.value = "Failed connecting";
		log("ITUTOR failed to connect to bot.");
		$("#connect").get(0).value = "connect";
    } else if (status == Strophe.Status.DISCONNECTING) {
	//log("Strophe is disconnecting.");
    } else if (status == Strophe.Status.AUTHFAIL) {
	log("ITUTOR failed authenticating.");
    }else if (status == Strophe.Status.DISCONNECTED) {
	log("ITUTOR is disconnected.");
	$("#connect").get(0).value = "connect";
    } else if (status == Strophe.Status.CONNECTED) {

		connection.addHandler(onMessage, null, "message", null, null,  null); 
		connection.send($pres().tree());
		
		var connectMes = $msg({to: toBot, from: connection.jid, type: "chat"}).c("body").t("CONNECT");
		connection.send(connectMes.tree());
    }
}

function onMessage(msg) {
	//We must recieve first message before we can talk back!
	if(readyToRecieve == false) {
		readyToRecieve = true;
		var button = $("#connect").get(0);
		button.value = "send";
	}

    var to = msg.getAttribute("to");
    var from = msg.getAttribute("from");
    var type = msg.getAttribute("type");
    var elems = msg.getElementsByTagName("body");

    if (type == "chat" && elems.length > 0) {
		var body = elems[0];
		log("I-TUTOR: " + Strophe.getText(body));

		return true;
	}
}

$(document).ready(function () {

	var button = $("#connect").get(0);
	if (button.value == "test") {
	
		connection = new Strophe.Connection(BOSH_SERVICE);
		button.value ="connecting";
		connection.connect("'.$jid.'","'.$psw.'",onConnect);
	}
	
    $("#connect").bind("click", function () {
		if (readyToRecieve) {
			var reply = $msg({to: toBot, from: connection.jid, type: "chat"}).c("body").t($("#say").get(0).value);
			connection.send(reply.tree());
			log("ME: " + $("#say").get(0).value);
		}
    });
	
	//To avoid re-load of form
	$("#conv").submit(function() {
		if (readyToRecieve) {
			var reply = $msg({to: toBot, from: connection.jid, type: "chat"}).c("body").t($("#say").get(0).value);
			connection.send(reply.tree());
			log("ME: " + $("#say").get(0).value);
			$("#say").get(0).value = "";
		}
		return false;
	});
});
</script>
</head>
<body>
  <div id="log" style="max-height:300px;overflow:auto;"></div>
  <hr />
  <div id="login" style="text-align: center">
    <form id="conv" name="conv">
      <label for="say">Say:</label>
      <input type="text" id="say" />
      <input type="button" id="connect" value="test" />
    </form>
  </div>
</body>
</html>';
        return $this->content;
    }
}
