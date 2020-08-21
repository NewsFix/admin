<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<h3>
<?php if (empty($_REQUEST)): ?>
<form action="test.php" method="post">
<label for="name">氏名:</label>
<input type="text" name="detail">
<input type="submit">
</form>
<?php else: ?>
<form action="test.php" method="post">
<label for="name">氏名:</label>
<label>はいw残念っっw</label>
</form>
<?php endif; ?>


<pre>
<?php
/*
    require_once("./phpQuery-onefile.php");
    $html = file_get_contents("https://www.shokabo.co.jp/address/daigaku2.html#tokyo");

    $target = phpQuery::newDocument(mb_convert_encoding($html, "HTML-ENTITIES", "shift-jis"));


    foreach ($target["table:gt(1) tr:gt(1)"] as $row) {
        $value = pq($row)->find("td:eq(3)")->text();

        $bar[] = $value;

        preg_match('/.+[都道府県].u', $value, $data);


        if (isset($data[0])) {
            $foo[] = $data[0];
        }
        //echo $value."\n";
    };

    $url = "https://yaba-blog.com/laravel-call-api/";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_URL);
    curl_setopt($ch, CURL_RETURNTRANSFER, true);
    $exec = curl_exec($url);
    var_dump($ch);
    curl_close($ch);


$text = file_get_contents("php://input");
echo $text;
*/

/*
class Base{
  public $name;
  public static $nickname = "Apple";
};

class Enemy1 extends Base{

  public $vit=100;

  public function __construct($value){
    $this->name = $value;
  }

}

$enemy1 = new Enemy1("ペンギン丸");

class Enemy2 extends Base{

  public $vit=100;

  public function __construct($value){
    $this->name = $value;
  }

}

$enemy2 = new Enemy2("ゾンビ");

$enemyGroup = [$enemy1,$enemy2];

class Hero extends Base{
  public $hp=100;

  public function __construct($value){
    $this->name = $value;
  }

  public function attack($enemyGroup){
    $rand = rand(10,30);
    echo $this->name."\r";
    var_dump($enemyGroup)."\r";
    echo $enemy->name."に".$rand."のダメージを与えた";
  }
}

$hero = new Hero("Hero");
$hero->attack($enemyGroup);
*/
/*
class Base {
    public $name;
    public $vit;

    public function __construct($name, $vit) {
        $this->name = $name;
        $this->vit = $vit;
    }

    public function attack($base) {
        $rand = rand(10, 30);
        $base->vit -= $rand;
        echo "$this->name は $base->name に $rand のダメージを与えた\n";
    }
      public function __toString() {
          return "$this->name : HP $this->vit";
      }
}

class Enemy extends Base {
}

class Hero extends Base {
}

function print_status($bases) {
    foreach($bases as $base) {
        echo $base . "\n";
    }
    echo "\n";
}

$enemy1 = new Enemy("モンスター1", 100);
$enemy2 = new Enemy("モンスター2", 100);
$hero = new Hero("勇者", 10000);
$bases = [$enemy1, $enemy2, $hero];

$hero->attack($enemy1);
print_status($bases);
$hero->attack($enemy2);
print_status($bases);
$hero->attack($enemy1);
print_status($bases);
*/
/*
class Base{
  public $name;
  public $hp;

  public function __construct($name,$hp){
      $this->name = $name;
      $this->hp = $hp;
}

  public function attack($element){
    $rand = rand(200,500);
    $element->hp -= $rand;
    if($element->hp < 0){
      $element->hp = 0;
    }
    echo $element->hp;
    echo "\n";
    echo $this->name."は".$element->name."に".$rand."のダメージを与えた!!";
    echo "\n";
    $element->heal();
  }
}

class Enemy extends Base {

  function heal(){
    $rand = rand(10,100);
    $this->$hp += $rand;
    echo $this->name."はベホマズンを唱えた!!!!!!!!!!\n";
    echo $this->name."のHPが".$rand."回復した\n";
    echo "残りHPは".$this->$hp."です。\n\n";
  }
};
class Hero extends Base {};

$enemy1 = new Enemy("タコ丸",10000);
$enemy2 = new Enemy("ゾンビ",10);
$hero = new Hero($_REQUEST["detail"],500);
$array = [$enemy1,$enemy2,$hero];
*/
/*
if(isset($_REQUEST["detail"])){
 $hero->attack($enemy1);
}
*/

/*
class Base {
  public $name;
  public $hp;
  public $mp;
  public $str;
  public $int;
  public $agi;
  public $luk;

  public function __construct(
    string $name,
    int $hp,
    int $mp,
    int $str,
    int $int,
    int $agi,
    int $luk
    )

    {
      $this->name = $name;
      $this->hp = $hp;
      $this->mp = $mp;
      $this->str = $str;
      $this->int = $int;
      $this->agi = $agi;
      $this->luk = $luk;
    }

}

class Protagonist extends Base {
  public function attack(object $enemy)
  {
    $rand = rand(10,50) * $this->str;
    $speed1 = rand(0,10) - $this->agi;
    $speed2 = rand(0,10) - $enemy->agi;
    $experience = rand(500,10000);

    if($speed1 >= $speed2){
      $enemy->hp -= $rand;
      if($enemy->hp <= 0){
        $enemy->hp = 0;
      }
      echo "$this->name は $enemy->name への攻撃!! $rand のダメージを与えた!!\n";
    } else {
      echo "失敗!!.$enemy->name は $this->name の攻撃をヒラリとかわした。\n";
    }
  }

  public function __toString(){
    return "$this->name HP: $this->hp / MP: $this->mp";
  }
};
class Opponent extends Base {
  public function attack(object $hero)
  {
    $rand = rand(10,50) * $this->str;
    $speed1 = rand(0,10) - $this->agi;
    $speed2 = rand(0,10) - $hero->agi;
    if($speed1 >= $speed2){
      $hero->hp -= $rand;
      if($hero->hp <= 0){
        $hero->hp = 0;
      }
      echo "$this->name は $hero->name への攻撃!! $rand のダメージを与えた!!\n";
    } else {
      echo "失敗!!.$hero->name は $this->name の攻撃をヒラリとかわした。\n";
    }

  }

  public function __toString(){
    return "$this->name HP: $this->hp / MP: $this->mp";
  }
};

$Protagonist = new Protagonist("主人公",5000,100,5,5,10,2);

$Opponent = new Opponent("大魔王",5000,3000,5,5,10,0);

$array = [$Protagonist,$Opponent];

function info($array){
  foreach($array as $value){
    echo $value."\n";
  }
  echo "\n";
}
*/

//以下セッション値増減テスト

class Enemy
{
    public $HP;

    public function __construct($HP)
    {
        $this->HP = $HP;
    }
};

$Enemy = new Enemy(1000);

if (!isset($_SESSION["EnemyHP"])) {
    $_SESSION["EnemyHP"] = $Enemy->HP;
} else {
    $_SESSION["EnemyHP"] += 1000;
}

//var_dump($_SESSION);

/*
if(isset($_REQUEST["detail"])){
  $_SESSION["HP"] += 1000;
  var_dump($_SESSION);
}
*/

$foo = 0;
var_dump($foo);







?>
</pre>
</h3>
</body>
</html>
