<?php

require_once("test1.php");


$humanoid_one = new Human("ヒューマノイドくん1号", 0, 0);
$humanoid_two = new Human("ヒューマノイドくん2号", 5, 5);

echo $humanoid_one->drink();
echo $humanoid_one->getHP();
