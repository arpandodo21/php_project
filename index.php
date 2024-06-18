<?php require_once ('common.php');
// echo $obj->make_new_table('test',['id'=>'INT AUTO_INCREMENT PRIMARY KEY','name' => 'varchar(255)']);
// echo $obj->drop_table('test');
$object->add_data_to_table('users', [['name' => 'arpan', 'email' => 'abc@abc.com', 'password' => 'password', 'password_original' => 'password'], ['name' => 'arpan2', 'email' => 'abc2@abc.com', 'password' => 'password2', 'password_original' => 'password2']]); die;
// echo "<pre>"; 
// print_r($obj->get_row_from_table('test','name',['age'=>28,'name'=>'Arpan']));
// echo "</pre>";

$html = '';
// if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['cid'] != '') {
//     $url = 'https://equos.sublytics.com/api/campaign/view/'.$_POST['cid'].'?user_id=567&user_password=vI2EZA5qKGYB8D3&with=offers';
//     $curl = curl_init();
//     curl_setopt($curl, CURLOPT_URL, $url);
//     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

//     $res = curl_exec($curl);
//     curl_close($curl);
//     $res = json_decode($res, true);
//     if ($res && $res["success"] == true) {
//         if ($res["data"]) {
//             if ($res["data"]["campaign"]) {
//                 if ($res["data"]["campaign"]["offers"]) {
//                     foreach ($res["data"]["campaign"]["offers"] as $val) {
//                         $html .= "<tr>
//                     <td width='5%' align='center'>
//                         <div class='radio'>
//                             <input type='radio' id='regular' name='optradio'>
//                         </div>
//                     </td>
//                     <td width='16%' align='center'>
//                         <div class='radiotext'>
//                             <label for='regular'>" . $val['id'] . "</label>
//                         </div>
//                     </td>
//                     <td width='43%' align='center'>
//                         <div class='radiotext'>
//                             <label for='regular'>" . $val['offer_name'] . "</label>
//                         </div>
//                     </td>
//                     <td width='20%' align='center'>
//                         <div class='radiotext'>
//                             <label for='regular'>" . $val['offer_price'] . "</label>
//                         </div>
//                     </td>
//                 </tr>";
//                     }
//                 }
//             }
//         }
//     }
// }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="POST" action=""><input type="text" name="cid" /><input type="submit" id="search"></form>
    <table class='table table-responsive'>
        <thead>
            <tr>
                <th width='5%' align='center'></th>
                <th width='16%' align='center'>ID</th>
                <th width='43%' align='center'>Product name</th>
                <th width='20%' align='center'>Price</th>
            </tr>
        </thead>

        <tbody>
            <form>
                <?php if ($html != '') {
                    echo $html;
                } else {
                    echo "<tr width='100%' align='center'></tr>";
                } ?>
            </form>
        </tbody>
    </table>
</body>

</html>