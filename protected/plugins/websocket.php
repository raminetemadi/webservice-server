<?php

$host = 'localhost';
$port = '9000';

#Create
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

#Bind socket
socket_bind($socket, $host, $port);

#Listen socket
socket_listen($socket, 20);

#Add more socket connection
$clients = array($socket);

while(true):

    $chenged = $clients;

    socket_select($chenged, $noting, $noting, 0, 10);

    if( in_array($socket, $chenged) ){
        #Accept new socket
        $new_sock = socket_accept($socket);
        #Add to clients
        $clients[] = $new_sock;

        $buf = socket_read($new_sock, 1024);
        perform_handshaking($buf, $new_sock, $host, $port); //perform websocket handshake

        /*
         * Your code here if user connected.
         */

        #Now must be remove socket from clients
        $fSocket = array_search($socket, $chenged);
        unset($chenged[$fSocket]);
    }

    foreach($chenged as $change ){

        while(socket_recv($change, $buf, 1024, 0) >= 1){
            sendMessage($buf);
            break 2;
        }

        $buf = @socket_read($change, 1024, PHP_NORMAL_READ);
        if( $buf === false ){
            //remove from clients
            $fSocket = array_search($change, $clients);
            unset($clients[$fSocket]);

            /*
             * Close a connection
             */
        }
    }
endwhile;
socket_close($socket);

function sendMessage($msg){
    global $clients;
    foreach($clients as $changed_socket)
    {
        @socket_write($changed_socket,$msg,strlen($msg));
    }
    return true;
}

//handshake new client.
function perform_handshaking($receved_header,$client_conn, $host, $port)
{
    $headers = array();
    $lines = preg_split("/\r\n/", $receved_header);
    foreach($lines as $line)
    {
        $line = chop($line);
        if(preg_match('/\A(\S+): (.*)\z/', $line, $matches))
        {
            $headers[$matches[1]] = $matches[2];
        }
    }

    $secKey = $headers['Sec-WebSocket-Key'];
    $secAccept = base64_encode(pack('H*', sha1($secKey . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
    //hand shaking header
    $upgrade  = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
        "Upgrade: websocket\r\n" .
        "Connection: Upgrade\r\n" .
        "WebSocket-Origin: $host\r\n" .
        "WebSocket-Location: ws://$host:$port/demo/shout.php\r\n".
        "Sec-WebSocket-Accept:$secAccept\r\n\r\n";
    socket_write($client_conn,$upgrade,strlen($upgrade));
}

//Encode message for transfer to client.
function mask($text)
{
    $b1 = 0x80 | (0x1 & 0x0f);
    $length = strlen($text);

    $header = '';
    if($length <= 125)
        $header = pack('CC', $b1, $length);
    elseif($length > 125 && $length < 65536)
        $header = pack('CCn', $b1, 126, $length);
    elseif($length >= 65536)
        $header = pack('CCNN', $b1, 127, $length);
    return $header.$text;
}

//Unmask incoming framed message
function unmask($text) {
    $length = ord($text[1]) & 127;
    if($length == 126) {
        $masks = substr($text, 4, 4);
        $data = substr($text, 8);
    }
    elseif($length == 127) {
        $masks = substr($text, 10, 4);
        $data = substr($text, 14);
    }
    else {
        $masks = substr($text, 2, 4);
        $data = substr($text, 6);
    }
    $text = "";
    for ($i = 0; $i < strlen($data); ++$i) {
        $text .= $data[$i] ^ $masks[$i%4];
    }
    return $text;
}
