<?php
session_start();
// sessionをスタートしてidを再生成しよう．

$old_id = session_id();

session_regenerate_id(true);

$new_id = session_id();

// 旧idと新idを表示しよう．

echo "旧id:" . $old_id . "<br>";
echo "新id:" . $new_id . "<br>";
exit();