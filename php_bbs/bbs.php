<?php
$filename = 'review.txt';
$date = date('Y-m-d H:i:s');
$uname = '';
$comment = '';
$err_msg = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['uname']) === true){
        $uname = preg_replace("/( |　)/", "", $_POST['uname']);
        if(mb_strlen($uname) === 0){
            $err_msg[] ='・名前を入力してください';
        }
        if (mb_strlen($uname) > 20){
            $err_msg[] = '・名前は20文字以内で入力してください';
        } 
    }
    if(isset($_POST['comment']) === true){
        $comment = preg_replace("/( |　)/", "", $_POST['comment']);
        if(mb_strlen($comment) === 0){
            $err_msg[] ='・ひとことを入力してください';
        }
        if (mb_strlen($comment) > 100){
            $err_msg[] = '・ひとことは100文字以内で入力してください';
        } 
    }
    if (count($err_msg) === 0){
        $comment = '・' . $uname . ': ' . $comment . ' -' . $date . "\n";
        if (($fp = fopen($filename, 'a')) !== FALSE) {
            if (fwrite($fp, $comment) === FALSE) {
              print 'ファイル書き込み失敗:  ' . $filename;
            }
            fclose($fp);
        }
    }
}
 
$data = array();
 
if (is_readable($filename) === TRUE) {
    if (($fp = fopen($filename, 'r')) !== FALSE) {
        while (($tmp = fgets($fp)) !== FALSE) {
          $data[] = htmlspecialchars($tmp, ENT_QUOTES, 'UTF-8');
        }
        fclose($fp);
    }
} else {
  $data[] = 'ファイルがありません';
}
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
      <meta charset="UTF-8">
      <title>ひとこと掲示板</title>
    </head>
    <body>
    <?php foreach ($err_msg as $read) { ?>
        <p><?php print $read; ?></p>
    <?php } ?>
        <h1>ひとこと掲示板</h1>
        <form method="post">
            名前：<input type="text" name="uname">
            ひとこと：<input type="text" name="comment">
            <input type="submit" name="submit" value="送信"></p>
        </form>
    <?php foreach ($data as $read) { ?>
        <p><?php print $read; ?></p>
    <?php } ?>
    </body>
</html>