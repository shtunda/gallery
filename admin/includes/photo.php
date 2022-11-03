<?php

class Photo extends DbObject {
    protected static $db_table = "photos";
    protected static $db_table_fields = ["title", "description", "file_name", "type", "size"];
    public $id;
    public $title;
    public $description;
    public $file_name;
    public $type;
    public $size;

    public $tmp_path;
    public $upload_directory = "images";
    public $errors = [];
    public $upload_errors_array = [
        UPLOAD_ERR_OK  => "There is no error",
        UPLOAD_ERR_INI_SIZE => "The uploaded file exceeds the upload max_filesize directive",
        UPLOAD_ERR_FORM_SIZE => "The uploaded file exceeds the MAX_FILE_SIZE directive",
        UPLOAD_ERR_PARTIAL => "THe uploaded file was only partially uploaded.",
        UPLOAD_ERR_NO_FILE => "No file was uploaded.",
        UPLOAD_ERR_NO_TMP_DIR => "Missing a temporary folder.",
        UPLOAD_ERR_CANT_WRITE => "Failed to write file to disk.",
        UPLOAD_ERR_EXTENSION => "A PHP extansion stopped the file upload.",
    ];

    public function setFile($file)
    {
        if(empty($file) || !$file || !is_array($file))
        {
            $this->errors[] = "There was no file uploaded";
            return false;
        }elseif($file['error'] != 0){
            $this->errors[] = $this->upload_errors_array[$file['error']];
            return false;
        }else{
        $this->file_name = basename($file['name']);
        $this->tmp_path = $file['tmp_name'];
        $this->type = $file['type'];
        $this->size = $file['size'];
        }
    }

    public function save()
    {
        if($this->id){
            $this->update();
        }else{
            if(!empty($this->errors)){
                return false;
            }
            if(empty($this->file_name) || empty($this->tmp_path)){
                $this->errors[] = "the file was no avalible";
                return false;
            }
            $targetPath = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->file_name;
            if(file_exists($targetPath)){
                $this->errors[] = "The file {$this->file_name} already exists";
                return false;
            }
            if(move_uploaded_file($this->tmp_path, $targetPath)){
                if($this->create()){
                    unset($this->tmp_path);
                    return true;
                }
            }else{
                $this->errors[] = "The file have no premission";
                return false;
            }
        }
    }
   public function imagePath()
   {
        return $this->upload_directory . DS . $this->file_name;
   }
    public function deletePhoto()
    {
        if($this->destroy()){
            $targetPath = SITE_ROOT . DS . 'admin' . DS . $this->imagePath();
            return unlink($targetPath);
        }else{
            return false;
        }
    }
}