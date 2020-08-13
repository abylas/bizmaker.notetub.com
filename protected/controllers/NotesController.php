<?php

class NotesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
//	public $layout='//layouts/column2';
    public $layout='//layouts/lefty';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create', 'tag','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','tag','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Notes;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Notes']))
		{
			$model->attributes=$_POST['Notes'];
			if($model->save())
				$this->redirect(array('create'));
		}


        $notespicmodel = Notespic::model()->find('notes_id=:userID', array(':userID'=>$model->id));


        $criteria=new CDbCriteria(array(
            'order'=>'update_time DESC',
//            'with'=>'commentCount',
        ));
        if(isset($_GET['tag']))
            $criteria->addSearchCondition('tags',$_GET['tag']);

        $dataProvider=new CActiveDataProvider('Notes', array(
            'pagination'=>array(
                'pageSize'=>Yii::app()->params['notesPerPage'],
            ),
            'criteria'=>$criteria,
        ));


		$this->render('create',array(
			'model'=>$model,
            'dataProvider'=>$dataProvider,
//            'notespicmodel'=>$notespicmodel,
		));
	}

    /**
     * Show public notes, created by all people.
     *  Adding this tag action so that only public notes and pages are retrieved for index view...
    since index view wil be viewed by everyone....
    and profile is only for ourselves, so public and private.
     */
    public function actionTag()
    {

        $criteria=new CDbCriteria(array(
//            'condition'=>'status='.Notes::STATUS_PUBLIC,
            'order'=>'update_time DESC',
            //'with'=>'bits',
        ));

        if(isset($_GET['tag']))
            $criteria->addSearchCondition('tags',$_GET['tag']);
        //$criteria->condition = "owner_id=:userID";
        //$criteria->params =  array(':userID'=>Yii::app()->user->id);

        $dataProvider = new CActiveDataProvider('Notes',
            array(
                "pagination" => array(
                    "pageSize" => 15
                ),
                'criteria'=>$criteria,
            ));

        $this->render('index',array(
            "dataProvider" => $dataProvider,
            'myPage'=>true,  // used to say whether this is my page, or someone else's

        ));
    }

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Notes']))
		{
			$model->attributes=$_POST['Notes'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
//		if(Yii::app()->request->isPostRequest)
//		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
//		}
//		else
//			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{

	    // PREVIOUSLY GENERATED CODE Before featuere update for tags
	    //		$dataProvider=new CActiveDataProvider('Notes');
//		$this->render('index',array(
//			'dataProvider'=>$dataProvider,
//		));
        $criteria=new CDbCriteria(array(
            'order'=>'update_time DESC',
//            'with'=>'commentCount',
        ));
        if(isset($_GET['tag']))
            $criteria->addSearchCondition('tags',$_GET['tag']);

        $dataProvider=new CActiveDataProvider('Notes', array(
            'pagination'=>array(
                'pageSize'=>Yii::app()->params['notesPerPage'],
            ),
            'criteria'=>$criteria,
        ));

        $this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Notes('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Notes']))
			$model->attributes=$_GET['Notes'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

    /**
     * Suggests tags based on the current user input.
     * This is called via AJAX when the user is entering the tags input.
     */
    public function actionSuggestTags()
    {
        if(isset($_GET['q']) && ($keyword=trim($_GET['q']))!=='')
        {
            $tags=Tag::model()->suggestTags($keyword);
            if($tags!==array())
                echo implode("\n",$tags);
        }
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Notes::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='notes-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
