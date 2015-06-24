<meta charset="UTF-8"  lang="ua">




<?

// Protect entry data
$picture_filename = htmlspecialchars(stripslashes( $_FILES['userfile']['name']));
$picture_fileplace = htmlspecialchars(stripslashes( $_FILES['userfile']['tmp_name']));
$picture_filetype = htmlspecialchars(stripslashes( $_FILES['userfile']['type']));
$picture_filesize = htmlspecialchars(stripslashes( $_FILES['userfile']['size']));



// Check UPLOADED FILES is not empty
if($picture_filesize == 0 ) 
exit ("UPLOADED FILES is empty");


// Check UPLOADED FILE is in English characters, numbers and (_-.) symbols, For more protection
if (!preg_match("`^[-0-9A-Z_\.]+$`i",$picture_filename))  
exit (" Name for UPLOADED FILES must be in English characters, numbers and (_-.) symbols ");

// Check file name not bigger than 100 characters
if (mb_strlen($picture_filename,"UTF-8") > 100) 
exit ("Name for UPLOADED FILES is too big, Name must be shorter than 100 characters");

// Check UPLOADED FILE SIZE is not too big
if($picture_filesize > 1024*1024*1) 
exit ("UPLOADED FILE SIZE is too big. Max size is 1 MB");
           
// Check valid type of UPLOADED FILE
$imageinfo = getimagesize($_FILES['userfile']['tmp_name']);
if($imageinfo['mime'] != 'image/png' && $imageinfo['mime'] != 'image/jpeg') {
  echo "Wrong picture's type \n";
  };

// Check some wrong extension of UPLOADED FILE
$blacklist = array(".php", ".phtml", ".php3", ".php4");
 foreach ($blacklist as $item) {
  if(preg_match("/$item\$/i", $_FILES['userfile']['name'])) {
   echo "We do not allow uploading PHP files\n";
   exit;
   }
  };




// Create new name and save it at server
// picture filename hash 
$str = md5($picture_filename); 

// Create foder for pictures from hash, it consist with 2 letters  
$folder_name=substr($str,0,2);

// Here "folder_for_picture" folder just need to save all pictures in one place
$arr=array($_SERVER["DOCUMENT_ROOT"],'folder_for_picture',$folder_name);
$folder_way=join("/",$arr);



// Check is folder already exist if not exist we create new
if (!is_dir($folder_way))
{
mkdir($folder_way, 0777, true);
};


// Create new name
$arr=array(substr($str,2),'jpg');
$new_file_name_pictures=join(".",$arr);


// Create picture's adress
$arr=array($folder_way,$new_file_name_pictures);
$final_pictures_adress=join("/",$arr);


// Save picture file
if (move_uploaded_file($picture_fileplace, $final_pictures_adress))
{echo '<font color="#32CD32">Pictures file is succesfully uploaded!<br><br></font>';

// Here $way_to_pictures_file must be your own url-way
$way_to_pictures_file='http://bestwebit.biz.ua/folder_for_picture';

$arr=array($way_to_pictures_file,$folder_name,$new_file_name_pictures);

$picture_for_screen=join("/",$arr);
echo '<img src="'.$picture_for_screen.'" width="500px"><br><br>';
  
 }
 else { echo '<font color="#FF4500">Unfourtunatelly, pictures file is not uploaded at the server :( '; };

exit;
?>