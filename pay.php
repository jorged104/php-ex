<?php 
$randomNumber = rand(); 
 //$ch = curl_init("https://foodsdnd.co:8183/External/crearCuenta");
 $url = "https://foodsdnd.co:8183/External/crearCuenta";
 $payload =  array( "uid"=> "y8hp834zdKXfCSo6buSSvP1ZoPm2" , "label"=>$randomNumber , "moneda" => "BTC" );

 $postdata = http_build_query($payload);
 $opts = array('http' =>
 array(
     'method'  => 'POST',
     'header'  => 'Content-type: application/x-www-form-urlencoded',
     'content' => $postdata
 )
);
$context = stream_context_create($opts);

//curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
 //curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
 //curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
 //$result = curl_exec($ch);
 //curl_close($ch);
// print_r($result);
$result = file_get_contents($url, false, $context);
$res = json_decode($result);
?>

<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
<!------ Include the above in your HEAD tag ---------->
<script>
     function parseJwt (token) {
    var base64Url = token.split('.')[1];
    var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
    var jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(''));

    return JSON.parse(jsonPayload);
};

    var addr =  <?php 
                                    if($res->code == 200)
                                    {
                                        echo "'".$res->address."'";
                                    }else{
                                        echo "0";
                                    }
                ?>;
    let searchParams = new URLSearchParams(window.location.search)
    const token = searchParams.get('token');
    var decode = parseJwt(token);
    var url = "https://blockchain.info/tobtc?currency=USD&value="+decode.price; 
  $.get(url, function(data){
    $('#btc').val(data);
    var urlcom = '/on/jwt.php?price='+data+'&address='+addr+'&preuser_id='+decode.preuser_id+'&packag_id='+decode.packag_id;
     $.get(urlcom,function(data){
         console.log(urlcom);
     });
  });
    
</script>
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Realiza el pago a 
                    </h3>
                </div>
                <div class="panel-body">
                    <form role="form">
                    <div class="form-group">
                        <label for="cardNumber">
                            BTC QR</label>
                        <div class="input-group">
                            <canvas id="qr-code"></canvas>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-7 col-md-7">
                            <div class="form-group">
                                <label>
                                    Envia <input type="text" id="btc"></input> btc a 
                                    <?php 
                                    if($res->code == 200)
                                    {
                                        echo $res->address;
                                    }
                                    ?>
                                </label>
                            </div>
                        </div>
                        <div class="col-xs-5 col-md-5 pull-right">
                        </div>
                    </div>
                    </form>
                </div>
            </div>
            <br/>
            <button class="btn btn-success btn-lg btn-block"  onclick="close();">Confirmar Pago</button>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
<script>
    /* JS comes here */
    var qr;
    (function() {
            qr = new QRious({
            element: document.getElementById('qr-code'),
            size: 200,
            value: 'bitcoin:'+<?php 
                                    if($res->code == 200)
                                    {
                                        echo "'".$res->address."'";
                                    }else{
                                        echo "0";
                                    }
                            ?>
        });
    })();
</script>