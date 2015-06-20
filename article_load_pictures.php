
<!DOCTYPE HTML >
<html>


<head>
<meta charset="UTF-8"  lang="ua">
<meta name="description" content="На сторінці розглядаються основні елементи кодування, що необхідні для завантаження файлу зображення на сервер. Html-форма, php-обробник форми, перевірка безпечного завантаження файлу на сервер та внесення даних до бази даних" />
<meta name="keywords" content="Завантаження зображення, безпечне завантаження зображення, обробка форми зображень, відправка файлу на сервер, завантаження на сервер, безпечне завантаження зображення, php-обробник форми зображення, безпека при завантаженні зображень, приклад кодування php-обробника форми, алгоритм завантаження файлу зображення" />

<TITLE>Завантаження зображень на сервер</TITLE>

<link rel="stylesheet" type="text/css" href="http://bestwebit.biz.ua/style/style_02.css" >
<link href='http://fonts.googleapis.com/css?family=Marck+Script|Lobster&subset=cyrillic' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
</head>

<style type="text/css">
table {background-color:#ffffff;border: 1px;border-style:solid;border-color: #000000;}
td {border: 1px;border-style:solid;border-color: #dcdcdc; }
.td_top {background-color:#dcdcdc;font-weight: bold;text-align:center;border: 1px;border-style:solid;border-color: #000000;}



</style >





<body>




<div class="all_page">





<div class="block_menu">
<div class="menu">
<a class="article_link" href="http://bestwebit.biz.ua/" > Головна    </a> 
<a class="article_link" href="http://bestwebit.biz.ua/pages/article.html" > Статті   </a>
<a class="article_link" href="http://bestwebit.biz.ua/pages/map.html" >Карта сайту   </a>
<a class="article_link" href="http://bestwebit.biz.ua/pages/best_1_1_chat.php" > Зв&#39;язок   </a>
</div>
</div>







 
<div class="content_info">
 

<img src="http://bestwebit.biz.ua/article/art_picture.jpg" alt=" " width="90%" >



<h1 >Завантаження зображень на сервер</h2>
<p><em>травень 2015</em></p>

<h4> Зміст </h4>
 
<p>
<strong>Вступ<br>
1. Оптимізація завантаження зображення на сервер.<br> 
2. Алгоритм завантаженння зображення.<br>
3. Html-форма відправлення зображення.<br>
4. Php-обробник форми.<br>
5. Організація оригінального імені файлу зображення. Безпечне збереження файлу забраження на сервері.<br>
5.1. Реалізація кодування файлу зображення за допомогою функції md5-хешування від файлу.<br>
5.2. Створення папки для збереження файлу зображень із md5-хеш від файлу завантаженого зображення.<br>
5.3. Обрізаємо хеш на 2 символи, та створюємо з нього нове імя файлу зображення <br>
5.4. Зберігаємо файл з новим іменем на сервері<br>
6. Застосування Бази Даних.<br>
7. Вибір зображення з серверу.<br>
8. Щодо кодування завантаження файлу в базу даних.<br>
Додаток</strong> <a href="#" class="art_link" target="_blank">GitHub</a>
</p>





<h2>Вступ</h2>
<p> Досить часто є необхідність завантажити зображення на сервер, напевно ж є багато варіантів/методик реалізації цього задуму.</p>
<p> Я розгляну два з варіантів кодування, щоб можна було виконати завантаження та набір мінімальних перевірок коректного завантаження малюнку користувачем. Якщо виникнуть питання, що так ніхто вже не робить, це вже не актуально, є краща функція і т.п. і т.д., то варто зважити на те, що це моя перша версія, є шанс що при нагоді розгяну альтернативну версію завантаження зображення...</p>
<p>Завантаження малюнку відбувається за допомогою html-форми, php-обробника форми з перевірками та застосування бази даних, для збереження як службової інформації про файл малюнку так і сам малюнок.</p>





<h2>1. Оптимізація завантаження на сервер</h2>
<p><strong> - Як краще завантажити малюнок на сервер? - А чому краще саме так, не інакше?... </strong></p>
<p><strong>Варіант 1.</strong> Варіант, через html-форму завантажуємо файл зображення в відведену для малюнків папку на сервер,- файловий спосіб.  </p>
<p><strong>Варіант 2.</strong> Завантажити малюнок в базу даних (детальніше п.8). В базі даних теж можна зберігати малюнок, створити таблицю та заносити файл,- тип даних BLOB (Binary Large OBject).<br>
зваживши, який об&#39;єм комірки таблиці варто надати<br>
TINYBLOB - може зберігати до 255 байт<br>
BLOB - може зберігати до 64 кБайт інформації<br>
MEDIUMBLOB - до 16 МБайт<br>
LONGBLOB - до 4 ГБайт
</p>


<p> Однозначної відповіді що краще - немає, більш детальніше можна переглянути інформацію, наприклад на <a href="http://www.phpro.org/tutorials/Storing-Images-in-MySQL-with-PHP.html" class="art_link" target="_blank">цьому ресурсі</a></p>
<p>Дехто стверджує, що краще застосовувати файловий спосіб збереження малюнку, а в деяких випадках краще зберігати зображення як обєкт в базі даних, в кожному конкретному випадку необхідно аналізувати ситуацію.</p>
<p>За даними дещо вище поданого ресурсу, Microsoft Terraserver зберігає понад 3 ТерраБайти зображень в базі даних як BLOB.</p>





<h2>2. Алгоритм завантаження зображення на сервер 
</h2>
<p>
1. Побудова форми з html- тегом input type="file" та тегом enctype="multipart/form-data" <br>
1.1. Перевірка на стороні клієнту коректності введених даних. <br>
2. Перевірка коректності введеного файла зображення на стороні серверу. <br>
2.1. Перевірка, що файл зображення не пустий.                  <br>
2.2. Перевіряємо, що ім&#39;я файлу зображення складається з англійських символів та цифер, для  забезпечення більшої безпеки.<br>
2.3. Перевіряємо, що ім&#39;я файлу зображенняне не більше ніж 100 символів.<br>
2.4. Перевірка об&#39;єму зображення.<br>
2.5. Перевірка mime-типу розширення файлу зображення (gif|jpg|jpeg|jpe|png)<br>
2.6. Заборона виконання деяких розширень файлів (".php", ".phtml", ".php3", ".php4")<br>
2.7. Організація оригінального імені файлу зображення.<br>
</p>













<h2>3. Зразок форми завантаження зображення на сервер 
</h2>


<p>
&nbsp;&nbsp;&nbsp; Завантажити файл зображення на сервер користувачем веб-сторінки можна використовуючи html-форму.
</p>
<div class="example_block" >
   &lt;form action="upload.php" method="post"  enctype="multipart/form-data" &gt; <br>
   &lt;p&gt;Вкажіть малюнок в форматі JPEG, PNG чи GIF&lt;/p&gt;<br>
   &lt;p&gt;&lt;input type="file" name="userfile" accept="image/jpeg,image/png,image/gif"&gt;  <br>
   &lt;input type="submit" value="Відправити"&gt;&lt;/p&gt;   <br>
   &lt;/form&gt;  <br>
</div>  <br><br>

<p id="link_picture_form"></p>
<p></p>
<h4 >Зразок тестової робочої html-форми</h4>
<p><em><font color="red">! Щоб розумно використовувати обєм памяті мого сервера, розмір обєм малюнку я обмежив в 200 кБ. </font></em></p>
<form action="http://bestwebit.biz.ua/pages/executors/exe_pictures_upload.php"  method="post"  enctype="multipart/form-data" style="background-color:#FFFACD;border-color:#000000;border-width: 1px;   border-style: dashed;padding:10px">
   <p>Вкажіть малюнок в форматі JPEG, PNG чи GIF</p>
   <p><input type="file" name="userfile" accept="image/jpeg,image/png,image/gif">
   <input type="submit" value="Відправити"></p>
</form>

<p>Переглянути всі завантажені зображення,  <a href="http://bestwebit.biz.ua/pages/article_load_pictures_show.php" class="art_link" target="_blank">тиц</a> .</p>

<br><br>
<div align="center">
<img src="http://bestwebit.biz.ua/pictures_02/art_picture_03.jpg" alt=" " width="592 px" >
</div>
<br><br>







<h2 id="link_pictures_form"  >4. Зразок php-обробника форми завантаження зображення на сервер 
</h2>

<div class="example_block" >
&lt;?php<br><br>

<font color="green">&#47;&#47;  Дані, що описують завантажений файл зображення: оригінальне імя, тимчасове місце утримання файлу зображення, тип файлу, обєм файлу</font> <br>
$picture_filename = $_FILES['userfile']['name'];<br>
$picture_fileplace = $_FILES['userfile']['tmp_name'];<br>
$picture_filetype = $_FILES['userfile']['type'];<br>
$picture_filesize = $_FILES['userfile']['size'];<br><br>

<font color="green">&#47;&#47;  Перевіряємо чи завантажений файл не пустий</font> <br>
if($picture_filesize == 0 ) <br>
exit ("Завантажений файл є пустим");<br><br>

<font color="green">&#47;&#47;  Перевіряємо що назва файлу складається з латинських літер та цифр</font> <br>
if (!preg_match("`^[-0-9A-Z_\.]+$`i",$picture_filename))<br>  
exit (" Імя файлу повинне складатись з латинських літер");<br><br>

<font color="green">&#47;&#47;  Перевіряємо, що назва файлу менше ніж 100 символів</font> <br>
if (mb_strlen($picture_filename,"UTF-8") > 100) <br>
exit ("Імя файлу завелике, дозволяється не більше 100 символів");<br><br>

<font color="green">&#47;&#47;  Перевіряється, що обєм файлу не занадто великий</font> <br>
if($picture_filesize > 200*1024) <br>
exit ("Дозволений обєм файлу 200 кБ");<br><br>
           
<font color="green">&#47;&#47;  Перевірка розширень файлу</font> <br>
$imageinfo = getimagesize($_FILES['userfile']['tmp_name']);<br>
if($imageinfo['mime'] != 'image/png' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/jpg'  )<br> 
exit ("Розширення зображення повинно бути jpg, jpeg, png ");<br><br>
  
<font color="green">&#47;&#47;  Заборона виконання деяких розширень файлів</font> <br>
$blacklist = array(".php", ".phtml", ".php3", ".php4");<br>
 foreach ($blacklist as $item) {<br>
  if(preg_match("/$item\$/i", $_FILES['userfile']['name'])) {<br>
   echo "Заборонено завантаження php файлів";<br>
   exit;<br>
   }<br>
  };<br><br>

move_uploaded_file($_FILES["userfile"]["tmp_name"], $_SERVER["DOCUMENT_ROOT"]."/picture_upload/".$_FILES["userfile"]["name"]);<br>

<font color="green">&#47;&#47;  Повертаємось попередню сторінку</font> <br>
header('Location:http:......pictures.php');<br>
exit;<br>
?&gt;
</div>  <br><br>






<h2>5. Організація оригінального імені файлу зображення. Безпечне збереження файлу забраження на сервері.
</h2>


<p>
&nbsp;&nbsp;&nbsp;
<strong>Реалізуємо такий алгоритм збереження зображень:<br>
1. Кодуємо назву файлу зображень. md5-хеш від файлу.<br>
2. Беремо перші 2 символи з хешу і створюємо папку де назвою є ці символи. (Перевірка наявності схожої папки)<br>
3. Обрізаємо хеш на 2 символи, та створюємо з нього нове імя файлу зображення.<br>
4. Зберігаємо сам файл з іменем, яке зосталось після п3.<br>
5. Заносимо дані в таблицю.<br><br>
</strong>

<strong>5.1. Реалізація кодування файлу зображення за допомогою функції md5-хешування від файлу</strong><br>
<br>
<img src="http://bestwebit.biz.ua/pictures_02/hash.png" alt="цифрові відбитки " width="50%" align="left" hspace="15" vspace="15">

P.S.<br>
&nbsp;&nbsp;&nbsp;Хеші — це щось типу відбитків пальців для даних.<br>
&nbsp;&nbsp;&nbsp;Кожний хеш точно відповідає певному файлу, або певній послідовності даних. Хоча б теоретично. На тому малюнку — 128-бітний MD5 хеш, він дає 2^128 унікальних значень, це 340 трилліонів трилліонів трилліонів. Реально простір значень дещо менший — коллізії почнуть з’являтися, якщо використати половину значень. Втім, половина неймовірно великого числа все ще залишається неймовірно великим числом. <br>

&nbsp;&nbsp;&nbsp;MD5 (Message Digest 5) — 128-бітний алгоритм хешування, розроблений професором Рональдом Л. Рівестом в 1991 році. Призначений для створення «відбитків» або «дайджестів» повідомлень довільної довжини. 
<br>
&nbsp;&nbsp;&nbsp;Хеш-функція або Геш-функція  — функція, що перетворює вхідні дані будь-якого (як правило, великого) розміру в дані фіксованого розміру. Хешування (іноді гешування, англ. hashing) — перетворення вхідного масиву даних довільної довжини у вихідний бітовий рядок фіксованої довжини. Такі перетворення також називаються хеш-функціями або функціями згортки, а їх результати називають хешем, хеш-кодом або дайджестом повідомлення (англ. message digest).

<br><br>
<div class="clear"></div>



<div class="example_block" >
&lt;?php<br><br>
$picture_filename='avatar.jpg';<br>
$str = md5($picture_filename);<font color="green"> &#47;&#47; хеш код буде ad7bc863acc50ad3b747c51c2f85b431</font><br><br>
$picture_filename='my_picture.jpg';<br>
$str = md5($picture_filename);<font color="green"> &#47;&#47; хеш код буде 14a2cee57b3f3aede510f9fcf6b630e4</font><br><br>
?&gt;
</div> 
<br><br><br>





<strong>5.2. Створення папки для збереження файлу зображень із md5-хеш від файлу завантаженого зображення.<br>
(Перевірка наявності схожої папки)</strong><br>

&nbsp;&nbsp;&nbsp;
Створити папку на сервері можна застосовуючи функцію php mkdir(), але
для того, щоб виключити повторне створення папки, що можливо вже існує, виконаємо додаткову перевірку.<br>
&nbsp;&nbsp;&nbsp;  Функція, за допомогою якої можна перевірити існування папки  is_dir ( $filename )<br>
 як зразок, частина кодування для завантаження файлу малюнку в папку .../folder_for_upload/:
<br>
<div class="example_block" >
&lt;?php<br><br>
$picture_filename='avatar.jpg'; <font color="green"> &#47;&#47; імя файлу</font><br>
$str = md5($picture_filename); <font color="green"> &#47;&#47; хеш код буде ad7bc863acc50ad3b747c51c2f85b431</font><br>
$folder_name=substr($str,0,2);<font color="green">&#47;&#47; Вибираємо перші дві літери - ad </font><br><br>
<font color="green">&#47;&#47; Створюємо шлях для завантаження малюнків -.../public_html/folder_for_upload/ad</font><br>
$arr=array($_SERVER["DOCUMENT_ROOT"],'folder_for_upload',$folder_name);<br>
$folder_way=join("/",$arr);<br><br>
<font color="green"> &#47;&#47;якщо схожої папки не існує створити папку</font><br>
if (!is_dir($folder_way))<br>
{mkdir($folder, 0777, true)}<br>
<br>
?&gt;<br>
</div><br><br>





<strong>5.3. Обрізаємо хеш на 2 символи, та створюємо з нього нове імя файлу зображення.</strong><br>
Цю частину кодування можна виконати слідуючим чином:<br>

<div class="example_block" >
&lt;?php<br><br>
$picture_filename='avatar.jpg'; <font color="green"> &#47;&#47; імя файлу</font><br>
$str = md5($picture_filename); <font color="green"> &#47;&#47; хеш код буде ad7bc863acc50ad3b747c51c2f85b431</font><br><br>
<font color="green">&#47;&#47; створюємо нове імя файлу - 7bc863acc50ad3b747c51c2f85b431.jpg </font><br>
$arr=array(substr($str,2),'jpg');<br>
$new_file_name_pictures=join(".",$arr);<br><br>
?&gt;<br>
</div> 
<br><br><br>





<strong>5.4. Зберігаємо файл з новим іменем на сервері.</strong><br>
Частина коду, що реалізує збереження файлу зображення на сервері:
<br>
<div class="example_block" >
&lt;?php<br><br>

$picture_filename='avatar.jpg'; <font color="green"> &#47;&#47; імя файлу</font><br>
$str = md5($picture_filename); <font color="green"> &#47;&#47; хеш код буде ad7bc863acc50ad3b747c51c2f85b431</font><br>
$folder_name=substr($str,0,2);<font color="green">&#47;&#47; Вибираємо перші дві літери - ad </font><br>
<br>
<font color="green">&#47;&#47; Створюємо шлях для завантаження малюнків -.../public_html/folder_for_upload/ad</font><br>
$arr=array($_SERVER["DOCUMENT_ROOT"],'folder_for_upload',$folder_name);<br>
$folder_way=join("/",$arr);<br><br>
<font color="green"> &#47;&#47;якщо схожої папки не існує створити папку</font><br>
if (!is_dir($folder_way))<br>
{mkdir($folder_way, 0777, true);}<br>
<br>
<font color="green">&#47;&#47; створюємо нове імя файлу - 7bc863acc50ad3b747c51c2f85b431.jpg </font><br>
$arr=array(substr($str,2),'jpg');<br>
$new_file_name_pictures=join(".",$arr);<br><br>
<font color="green"> &#47;&#47; створення кінцевої адреси з іменем файлу малюнку</font><br>
$arr=array($folder_way,$new_file_name_pictures); <br>
$final_pictures_adress=join("/",$arr);<br><br>
<font color="green">&#47;&#47; Зберігаємо завантажений тимчасовий файл $picture_fileplace на сервер </font><br>
$picture_fileplace = $_FILES['userfile']['tmp_name'];<br>
move_uploaded_file($picture_fileplace, $final_pictures_adress); <br><br>

<font color="green">/*** Give praise and thanks to the php gods :) ***/</font><br><br>

?&gt;<br>
</div><br><br>













<h2>6. Застосування Бази Даних </h2>

<p>Які дані варто обробляти для скрипту перегляду зображень? <br>
Це може бути:</p>
<ol>
<li> ім&#39;я файлу зображення</li>
<li> нове ім&#39;я файлу зображення</li>
<li> папку в якій зберігається файл зображення</li> 
<li> тип зображення</li>
при необхідності можна організувати і додаткові відомості,<br> 
<li> коли був завантажений малюнок </li>
<li> хто завантажував</li>
 </ol>
та інше на власний розсуд...<br>
<p> Що ж давайте переглянемо організацію простої таблиці <strong>user_pictures</strong>, що були завантажені в <a href="http://bestwebit.biz.ua/pages/article_load_pictures.php#link_picture_form" class="art_link" >тестовій формі вище</a>.
</p>


<p>- Яким чином переглянути завантажені зображення на сервер?<br>
Як памятаєте при завантаженні на сервер ми залишали службові дані про зображення в таблиці <strong>user_pictures</strong>, відповідно нам потрібно всього лиш прочитати дані з таблиці і побудувати веб-сторінку з малюнками, що були завантажені.</p>

SQL-запит на створення таблиці <strong>user_pictures</strong><br>
<div class="example_block" >
CREATE TABLE user_pictures (<br> 
id INT(6) AUTO_INCREMENT PRIMARY KEY,<br>
img_name VARCHAR(50),<br>
new_img_name VARCHAR(50),<br>
img_folder VARCHAR(50),<br>
img_type VARCHAR(20),<br>
upload_date  DATETIME <br>
)<br>
</div>

<p>Внесення даних в таблицю бази даних може відбуватись за таким скриптом</p>
<div class="example_block" ><br>
<font color="green">// Заносимо дані в базу даних</font><br>
<font color="green">// Зєднуємось з сервером бази даних</font><br>
$mysqli = new mysqli("localhost","my_user","my_password","my_db");<br>
<font color="green">// Кодування даних - utf8</font><br>
$mysqli->set_charset("utf8");<br>
<font color="green">// Змінна для внесення часу та дати завантаження малюнку</font><br> 
$upload_time=date("Y-m-d H-i");<br>
$mysqli->query("INSERT INTO `user_pictures`(`img_name`, `new_img_name`, `img_folder`, `img_type`, `upload_date`)<br> 
                VALUES ('$picture_filename','$new_file_name_pictures','$folder_name','$picture_filetype','$upload_time')");<br>
$mysqli->close(); <br>
)<br>
</div>

<p>
гадаю, зрозуміло, дані, що вносимо в таблицю БД:<br>
$picture_filename - імя файлу зображень, що прийшло від клієнту,<br>
$new_file_name_pictures - нове, змінене задля безпеки, імя файлу,<br>
$folder_name - назва папки, де зберігається малюнок,
$picture_filetype - тип малюнку, <br>
$upload_time - дата та час завантаження
</p><br><br>




<h2>7. Вибір файлу зображення з папки серверу </h2>




<p>Вибір даних та виведення на екран файлу зображення може бути організовано за таким скриптом:</p>

<div class="example_block" >
&#60;?
<font color="green">// Виводимо дані з бази даних</font><br>
<font color="green">// Зєднуємось з сервером бази даних</font><br>
$mysqli = new mysqli("localhost","my_user","my_password","my_db");<br><br>

<font color="green">// Кодування даних - utf8</font><br>
$mysqli->set_charset("utf8");<br><br>


<font color="green">// Отримуємо обєкт з бази даних</font><br>
$result = $mysqli-&#62;query("SELECT img_name,new_img_name,img_folder,upload_date FROM user_pictures ");<br><br>
while ($row = $result-&#62;fetch_assoc()) {<br><br>

<font color="green">// Створимо url-адресу для малюнку, обєднавши url-адреса вашого сайту + імя папки + імя малюнку</font><br>
$arr=array('url-адреса вашого сайту',$row['img_folder'],$row['new_img_name']);<br>
$picture_for_screen=join("/",$arr);<br><br>

<font color="green">// виводимо малюнок та неохідні дані</font><br>
echo '<br>
&#60;div style="width:250px;float:left"&#62;<br>
&#60;p&#62;завантажено:&#60;br&#62;'.$row['upload_date'].'<br>
Ім&#39;я файлу: ' .$row['img_name']. '&#60;/p&#62;<br>
&#60;img src="'.$picture_for_screen.'" width="90%"&#62;&#60;/div&#62;<br>
';<br>
};<br>
$mysqli->close();<br> 
 
?&#62;<br>
</div>




<p>Переглянути всі завантажені зображення,  <a href="http://bestwebit.biz.ua/pages/article_load_pictures_show.php" class="art_link" target="_blank">окрема сторінка з малюнками</a>.</p>
<br><br>

















<h2>8. Щодо кодування завантаження файлу в базу даних 
</h2>
<br>
<img src="http://bestwebit.biz.ua/pictures_02/art_picture_05.jpg" alt="двійковий код" width="60%"  hspace="15" vspace="15">

<p>

Все ж давайте переглянемо як виглядає код, якщо необхідно завантажити малюнок саме в базу даних. В таблиці бази даних він буде зберігатись як обєкт, 
що має дані на зразок "....0C7AF413E97A4EBD631C3733DC4106A171044.....", за відповідним обємом картинки. </p>

<p>Для збереження малюнку створимо таблицю <strong>images</strong>, що має три поля:<br>
id - унікальний ID зображення,<br>
content - поле для збереження малюнку, щодо цього поля то врахуємо обєм даних який будемо завантажувати,<br>
img_type - тип малюнку, пізніше необхідно буде щоб вказати браузеру що наш обєкт саме малюнок<br><br>

&nbsp;&nbsp;&nbsp; Файл зображення буде зберігатись як буде
TINYBLOB - може зберігати до 255 байт<br>
BLOB - може зберігати до 64 кБайт інформації<br>
MEDIUMBLOB - до 16 МБайт<br>
LONGBLOB - до 4 ГБайт<br>
</p>

SQL-запит на створення таблиці
<div class="example_block" ><br>
CREATE TABLE images (<br> 
id INT(6) AUTO_INCREMENT PRIMARY KEY,<br>
content MEDIUMBLOB,<br>  
img_type VARCHAR(30) <br>
)<br>
</div>


<p> Якщо застосувати частину коду, що була подана вище: html-форма, та дещо змінивши php-обробник форми, то зможемо завантажити файл зображення в поле таблиці бази даних</p>

php-скрипт завантаження малюнку
<div class="example_block" ><br>
&lt;?php<br><br>
<font color="green"> &#47;&#47;якщо відправлені дані малюнку з html-форми</font><br>
if (isset($_POST['submit'])) {<br><br>

<font color="green"> &#47;&#47;зберігаємо файл зображеня в тимчасовому файлі та зчитуємо дані</font><br>
$image = file_get_contents( $_FILES['userfile']['tmp_name']; );<br><br>

<font color="green"> &#47;&#47;зберігаємо тип файлу</font><br>
$image_type = $_FILES['userfile']['type'];<br><br>

<font color="green"># зєднуємось з базою даних</font><br>
$mysqli = new mysqli("localhost", "DB_User", "Password", "DB");<br><br>

<font color="green"> &#47;&#47;екрануємо спеціальні символи для застосування в SQL-виразі</font> <br>
$image = $mysqli->real_escape_string($image);<br><br>

<font color="green"> &#47;&#47;вносимо дані малюнку та тип малюнку в таблицю <strong>images</strong>  бази даних</font><br>
$sql = "INSERT INTO images (content,img_type) VALUES ('".$image."','$image_type')"; <br>
$mysqli->query($sql);<br><br>

<font color="green">/*** Give praise and thanks to the php gods :) ***/</font><br><br>

$mysqli->close();<br><br>
}

?&gt;<br>
</div><br><br>

<p>Частина коду, що виводить зображення</p>



<div class="example_block" ><br>
&lt;?php<br><br>

<font color="green"># зєднуємось з базою даних</font><br>
$mysqli = new mysqli("localhost", "DB_User", "Password", "DB");<br><br>

<font color="green">// Отримуємо об'єкт $result </font><br>
$result = $mysqli->query("SELECT content,img_type FROM images ");<br><br>

<font color="green">//Отримуємо масив даних </font><br>
while ($row = $result->fetch_assoc()) {<br>
header("Content-type: ".$row['img_type']);<br>
echo $row['content'];<br>
};<br>
$mysqli->close();<br>


?&gt;<br>
</div>





</div>

 








</div>
</body>
</html>