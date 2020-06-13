<?php


class BlogController extends Controller
{
    public $layout ='blog';

    public function actionIndex(){
        $model = new Posts();
        $this->render("index",['model'=>$model]);
    }

    public function actionWrite(){
        $model = new Posts();
        if(isset($_POST["Posts"])){
            $file = CUploadedFile::getInstance($model,'file');
            $model->attributes = $_POST['Posts'];
            if($file){
                $result = $this->uploadFile($file);
                $model->featuredImage = $result["url"];
            }
            $model->save();
            $this->setAlert("success","Post created");
            $this->redirect('/blog/');
        }
        $this->render("write",['model'=>$model]);
    }

    public function actionPosts(){
        $model = new Posts();
        $this->render("posts",['model'=>$model]);
    }

    public function actionUnpublished(){
        $model = new Posts();
        $this->render("unpublished",['model'=>$model]);
    }

    public function actionPost($id){
        $model = Posts::model()->findByPk($id);
        if($model == null){
            throw new Exception("Post not found");
        }
        $this->render("post",['model'=>$model]);

    }

    public function actionComments(){
        $this->render("comments");
    }

    public function actionPostEdit($id){
        $model = Posts::model()->findByPk($id);
        if($model === null){
            throw new CHttpException("Post does not exists");
        }
        if(isset($_POST['Posts'])){
            $model->attributes = $_POST['Posts'];
            $file = CUploadedFile::getInstance($model,'file');
            if($file){
                $result = $this->uploadFile($file);
                $model->featuredImage = $result["url"];
            }
            $model->update();
            $this->setAlert("success","Post successfully updated");
        }
        $this->render("edit",['model'=>$model]);
    }

    public function actionPostComment($id){
        $post = Posts::model()->findByPk($id);
        $model = new PostComment();
        $model->post_id = $post->id;
        if(isset($_POST["PostComment"])){
            $model->attributes = $_POST["PostComment"];
            $model->save();
            $this->setAlert("success","Comment saved");
            $this->redirect($this->createurl("/blog/post",['id'=>$id]));
        }
        $this->render("postcomment",['model'=>$model,'post'=>$post]);
    }

    private function uploadFile(CUploadedFile $file){
        $randname = $this->randName();
        $name = $file->getName();
        $ext = $file->getextensionName();
        $fileSize = $file->getSize();
        $finalName = $randname . "." . $ext;
        $url = Yii::app()->getBaseUrl(true) .'/uploads/' . $finalName;
        $fullPath =	Yii::app()->basePath."/../uploads/"  . $finalName;
        $file->saveAs($fullPath);
        $mimeType = mime_content_type($fullPath);
        try{
            return [
                "name"=>$name,
                "mimetype"=>$mimeType,"url"=> $url,
                "filesize"=>$fileSize, "fullpath"=>$fullPath
            ];
        }catch (Exception $e){
            Yii::log($e->getMessage(), CLogger::LEVEL_ERROR, "files");
            return null;
        }
    }


}