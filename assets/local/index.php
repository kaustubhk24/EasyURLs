<?PHP 
$languages = array(
    "English"=>"en",
    "मराठी"=>"mr",
    "हिंदी"=>"hi"
);

























$m="<select onchange='location = this.value;' name='lang'>";
$m.="<option>Language</option>";
foreach($languages as $key => $value):
    $m.= '<option value="?lang='.$value.'">'.$key.'</option>'; //close your tags!!
endforeach;
$m.="</select>";
$lang_widget=$m;
?>
