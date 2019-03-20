<?php
/**
 * Created by PhpStorm.
 * User: iksmtr
 * Date: 20.03.2019
 * Time: 11:01
 */

include_once ROOT_PATH . '/src/ui/app/models/UserModel.php';

class profilController
{
    public static $data;
    public static $userRole;
    public $userModel, $user;
    private $userExtraFilePath,$fileArray;

    public function __construct()
    {
        $this->userModel = new UserModel($GLOBALS['userId']);
        $this->user = $this->userModel->getCustomer();
        $this->userExtraFilePath = $this->user[0]['ExtraFilePath'];
        $this->fileArray = explode("+-+", $this->userExtraFilePath);

        self::userInfo();

        self::footsphereInformation();

        self::showExtraFile();

        self::extraFileUpload();


    }


    /**
     * @return mixed
     */
    public static function getData()
    {
        return self::$data;
    }

    /**
     * @param mixed $data
     */
    public static function setData($data)
    {
        self::$data = $data;
    }

    public function userInfo()
    {

        if (isset($_POST['UpdateButton'])) {
            $this->userModel->updateCustomer(
                array(
                    "email" => $_POST['mail'],
                    "display_name" => $_POST['name'],
                    "lenght" => $_POST['Length'],
                    "age" => $_POST['Age'],
                    "weight" => $_POST['Weight'],
                    "footsize" => $_POST['FootSize'],
                    "ekstrabilgi" => $_POST['ExtraInfo']
                ));

            echo "brda";
        }


        self::$data['name'] = $this->user[1]->getDisplayName();
        self::$data['mail'] = $this->user[1]->getUserEmail();
        self::$data['lenght'] = $this->user[0]['Length'];
        self::$data['age'] = $this->user[0]['Age'];
        self::$data['weight'] = $this->user[0]['Weight'];
        self::$data['footsize'] = $this->user[0]['FootSize'];
        self::$data['ekstrabilgi'] = $this->user[0]['ExtraInfo'];

    }

    public function footsphereInformation()
    {
        self:: $data['image'] = $this->user[0]['FootImage'];
        self:: $data['image2'] = $this->user[0]['FootImage2'];
        self:: $data['image3'] = $this->user[0]['FootImage3'];
        self:: $data['3d'] = $this->user[0]['FootsphereFilePath'];

    }

    public function extraFileUpload()
    {


        self::fileupload_processing("extrafile");

        if (isset($_POST['uploadButton'])) {
            if (isset(self::$data['extrafile']['filename'])) {
                $this->userModel->updateCustomer(
                    array(
                        "ExtraFilePath" => $this->userExtraFilePath . self::$data['extrafile']['filedest']
                    )
                );
            }

        }

    }


    private function fileupload_processing($id)
    {
        $uploadfiles = $_FILES[$id];

        if (is_array($uploadfiles)) {

            // foreach ($uploadfiles['name'] as $key => $value) {

            // look only for uploded files
            if ($uploadfiles['error'] == 0) {

                $filetmp = $uploadfiles['tmp_name'];

                //clean filename and extract extension
                $filename = $uploadfiles['name'];

                // get file info
                // @fixme: wp checks the file extension....
                $filetype = wp_check_filetype(basename($filename), null);
                $filetitle = preg_replace('/\.[^.]+$/', '', basename($filename));
                $filename = $filetitle . '.' . $filetype['ext'];
                $upload_dir = wp_upload_dir();

                /**
                 * Check if the filename already exist in the directory and rename the
                 * file if necessary
                 */
                $i = 0;
                while (file_exists($upload_dir['path'] . '/' . $filename)) {
                    $filename = $filetitle . '_' . $i . '.' . $filetype['ext'];
                    $i++;
                }

                $filedest = $upload_dir['path'] . '/' . $filename;

                self::$data[$id]['filedest'] = $filedest;
                self::$data[$id]['filename'] = $filename;

                /**
                 * Check write permissions
                 */
                if (!is_writeable($upload_dir['path'])) {
                    //  $this->msg_e('Unable to write to directory %s. Is this directory writable by the server?');
                    return;
                }

                /**
                 * Save temporary file to uploads dir
                 */
                if (!@move_uploaded_file($filetmp, $filedest)) {
                    //  $this->msg_e("Error, the file $filetmp could not moved to : $filedest ");
                    //  continue;
                }


                $attachment = array(
                    'post_mime_type' => $filetype['type'],
                    'post_title' => $filetitle,
                    'post_content' => '',
                    'post_status' => 'inherit'
                );

                $attach_id = wp_insert_attachment($attachment, $filedest);
                $attach_data = wp_generate_attachment_metadata($attach_id, $filedest);
                wp_update_attachment_metadata($attach_id, $attach_data);

                //        $this->filedest = $this->filedest . "-+-" . "/wp-content" . $filedest;
                //       $this->fileName = $this->fileName . "-+-" . "" . $fileName;

            }
        }
    }

    public function showExtraFile()
    {
        $result = '';
        if ($this->fileArray) {
            foreach ($this->fileArray as $key => $value) {
                if (count($this->fileArray)-1 != $key) {

                    self::deleteExtraFilePost($key);
                    $filename = explode("/", $value);
                    $filename = $filename[count($filename) - 1];
                    $result = $result . '
<form method="POST"><button class="msg_send_btn" name="deleteButton_' . $key . '" id="deleteButton_' . $key . '" type="submit">
                            ' . $filename . ' <i aria-hidden="true" class="fa fa-remove"></i></button>
</form><br></br> ';


                }
            }
        }

        self::$data['yuklenmisdosyalar'] = $result;
    }

    public function deleteExtraFilePost($key)
    {

        if (isset($_POST['deleteButton_' . $key])) {
            $this->userModel->deleteExtraFileCustomer($this->fileArray[$key]);
        }
    }


}