<?php 

$data = [
    'phone' =>	$_POST['phone'], // Receivers phone
    "body"=>	$_POST['msg']
];

$return = array("code"=>0, "msg"=>"Error!");


$json = json_encode($data); // Encode data to JSON
// URL for request POST /message
$url = $_POST['token'];
// Make a POST request
$options = stream_context_create(['http' => [
        'method'  => 'POST',
        'header'  => 'Content-type: application/json',
        'content' => $json
    ]
]);
// Send a request
$result = file_get_contents($url, false, $options);
$r = json_decode($result,1);

if($r["sent"]){
	$return["code"] = 1;
	$return["msg"] = $r["message"];
}
echo json_encode($return);
