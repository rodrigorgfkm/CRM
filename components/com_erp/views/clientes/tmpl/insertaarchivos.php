<? defined('_JEXEC') or die;
//var_dump($_FILES['archivo']);
$id = JRequest::getVar('id','','post');
echo $id.'....pdf';
$folder = 'media/com_erp/archivos/'.$id;
if (!file_exists($folder)) {
    mkdir($folder, 0777, true);
}
$nombre = $id.'_'.time().rand(1,100).'.pdf';
$nombre_archivo = $_FILES['archivo']['name'];
copy($_FILES['archivo']['tmp_name'], $folder.'/'.$nombre);
newPDF($nombre,$nombre_archivo);
?>