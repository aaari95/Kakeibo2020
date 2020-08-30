<?php
//var_dump($_POST);
//最初に変数を定義しておかないとエラーになる
$err_msg1 = "";
$err_msg2 = "";
$err_msg3 = "";
$err_msg4 = "";
$message ="";
//issetは変数がセットされているか確認、値があればTRUEを返す
$day = ( isset( $_POST["day"]) === true ) ?$_POST["day"]: ""; //使用日時
$koumoku = ( isset( $_POST["koumoku"]) === true ) ?$_POST["koumoku"]: "";　//項目
$kingaku = ( isset( $_POST["kingaku"]) === true ) ?$_POST["kingaku"]: "";　//金額
$naiyo = ( isset( $_POST["naiyo"] === true )? trim($_POST["naiyo"]) : "";　//内容

//項目が空白であればエラーメッセージ
if ( isset($_POST["send"]) === true ){
        if ( $day === "") $err_msg1 = "Plese insert your day";

        if ( $koumoku === "")) $err_msg2 = "Plese insert koumoku";
        
        if ( $kingaku === "")) $err_msg3 = "Plese insert kingaku";

        if ( $naiyo === "")) $err_msg4 = "Plese insert naiyo";

        if ( $err_msg1 === "" && $err_msg2 === "" && $err_msg3 === "" && $err_msg4 === "" ){
                $fp = fopen ( "data.txt" ,"a" ); //fopenでdata.txtをファイルを、modeはaで書き出し用のみで開く
                fwrite( $fp , $day."\t", $koumoku."\t", $kingaku."\t".$naiyo."\n");　//入力内容を書き込み、tでタブ、nで改行
                $message = "Success!";
        }
}


/* テキストファイルからの読み込み */

$fp = fopen("data.txt","r");  //modeはrで読み込み

$dataArr = array();　//配列作成
//data.txtに入っている内容をファイルを1行ずつ出力
while($res = fgets( $fp )){
        $tmp = explode("\t",$res);
        $arr = array(
                "day" => $tmp[0],
                "koumoku" => $tmp[1],
                "kingaku" => $tmp[2],
                "naiyo" => $tmp[3]
        );
        $dataArr[] = $arr;
}
?>

/*　HTMLへの表示　*/
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ja">
        <head>
                <meta http-equiv="content-type" content="text/html; charset=utf-8" />
                <title>kakeibo2020</title>
        </head>
        <body>
        		<?php echo "kakeibo2020"; ?>
                <?php echo $message; ?>
                <form method = "post" action = "">
                //使用日時
                DAY : <input type = "text" name = "day" value="<?php echo $day; ?>">
                        <?php echo $err_msg1; ?><br>
                //項目
                KOUMOKU : <input type = "text" name = "koumoku" value="<?php echo $koumoku; ?>">
                        <?php echo $err_msg2; ?><br>
                //金額
                KINGAKU : <input type = "text" name = "kingaku" value="<?php echo $kingaku; ?>">
                        <?php echo $err_msg3; ?><br>                
                //内容
                NAIYO : <textarea name = "naiyo" rows="4" cols="40"><?php echo $naiyo; ?></textarea>
                <?php echo $err_msg4; ?><br>
<br>
                <input type="submit" name= "send" value = "click">
                </form>
        <dl>
        //foreachでデータを取り出す（$dataArrに入っている値を$dataに代入）
         <?php foreach( $dataArr as $data ): ?>
         <p><span><?php echo $data["day"]; ?></span>:<span><?php echo $data["koumoku"]; ?></span>:<span><?php echo $data["kingaku"]; ?></span>:<span><?php echo $data["naiyo"]; ?></span></p>
        <?php endforeach;?>
        </dl>
        </body>
</html>
