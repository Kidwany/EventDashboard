<?php


namespace App\Classes;


use App\Models\Image;

class Upload
{

    protected  $request          = null;
    protected  $inputName        = null;
    protected  $path             = null;
    protected  $modelName        = null;
    protected  $imagePathColumn  = 'path';
    protected  $extensions       = null;

    public function __construct($request, $inputName, $path, $extensions, $model)
    {
        $this->request          = $request;
        $this->inputName        = $inputName;
        $this->path             = $path;
        $this->extensions       = $extensions;
        $this->modelName        = $model;
    }

    public function storageUpload()
    {
        if ($uploadedFile = $this->request->file($this->inputName))
        {
            $fileName = time() . $uploadedFile->getClientOriginalName();
            $filePath = $uploadedFile->storeAs($this->path, $fileName);
            $image = $this->modelName::create(['name' => $fileName, $this->imagePathColumn => $filePath]);
            return $image->id;
        }
    }

    /*****************************************************************************************
     **** This Function Used in uploading in Public Directory With Handling dynamic paths ****
     *****************************************************************************************/
    public function publicUpload()
    {
        $this->request->validate([
            $this->inputName  =>  $this->extensions,
        ]);

        if ($uploadedFile = $this->request->file($this->inputName))
        {
            $fileName = time() . $uploadedFile->getClientOriginalName();
            $uploadedFile->move(uploadedImagePath() . DIRECTORY_SEPARATOR . $this->path, $fileName);
            $filePath = uploadedImagePath() . DIRECTORY_SEPARATOR . $this->path . DIRECTORY_SEPARATOR .$fileName;
            $image = $this->modelName::create(['name' => $fileName, 'path' => $filePath]);
            return $image->id;
        }

    }


    public static function singleUpload($request, $inputName, $path,$alt,$extensions,$model){
        $request->validate([
            $inputName  =>  $extensions,
        ]);

        if ($uploadedFile = $request->file($inputName))
        {
                $fileName=time(). $uploadedFile->getClientOriginalName();
                $uploadedFile->move($path, $fileName);
                $filePath = $path.$fileName;
                $image = $model::create(['name' => $fileName,'url'=>assetPath($filePath),'path' => $filePath, 'alt' =>$alt]);
                return $image;
        }
    }

    public static function multipleUpload($request, $inputName, $path,$alt,$extensions,$model,$related_model){
        $request->validate([
            $inputName.'*'  =>  $extensions,
        ]);

        if ($uploadedFiles = $request->file($inputName))
        {
            $imageIds = array();
            foreach ($uploadedFiles as $uploadedFile):
                $fileName=time(). $uploadedFile->getClientOriginalName();
                $uploadedFile->move($path, $fileName);
                $filePath = $path.$fileName;
                $image = $model::create(['name' => $fileName, 'path' => $filePath,'url'=>assetPath($filePath),'alt' =>$alt]);
                array_push($imageIds,$image->id);
            endforeach;
            $related_model->attach($imageIds);
            return true;
        }
        return false;
    }

}
