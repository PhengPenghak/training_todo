<?php

namespace app\controllers;

use app\models\Todo;
use app\models\TodoSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * TodoController implements the CRUD actions for Todo model.
 */
class TodoController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Todo models.
     *
     * @return string
     */
    public function actionIndex($show = 'all', $datetype = 'this_month')
    {
        $model = new Todo();
        $searchModel = new TodoSearch();

        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->setPagination(['pageSize' => 4]);

        switch ($datetype) {
            case '$this_month':
                $from_date = date("Y-m-d", strtotime("first day of month"));
                $to_date = date("Y-m-d", strtotime("last day of last month"));
                break;
            case 'previous_month':
                $from_date = date("Y-m-d", strtotime("first day of last month"));
                $to_date = date("Y-m-d", strtotime("last day of last month"));
                break;
            case 'last_three_month':
                $from_date = date("Y-m-d", strtotime("first day of -3 month"));
                $to_date = date("Y-m-d", strtotime("last day of -3 month"));
                break;
            default:
                $from_date = date("Y-m-d", strtotime("first day of this month"));
                $to_date = date("Y-m-d", strtotime("last day of this month"));
                break;
        }
        $drowdown = [
            'tihs_month' => 'This month',
            'previous_month' => 'Previous_month',
            'last_three_month' => 'Last 3 month',
        ];
        $datatype = Todo::find()
            ->where(['BETWEEN', 'DATE(date)']);
        $countByDateType = Todo::find()
            ->where(['BETWEEN', 'DATE(date)',   $from_date, $to_date])
            ->count();

        $countByDateType = Todo::find()
            ->where(['BETWEEN', 'DATE(date)',   $from_date, $to_date])
            ->count();

        $lastWeekFrom = date("Y-m-d", strtotime("last week monday"));
        $lastWeekTo = date("Y-m-d", strtotime("last week sunday"));
        $totalLastWeek = Todo::find()
            ->where(['BETWEEN', 'DATE(date)', $lastWeekFrom, $lastWeekTo])
            ->count();

        $totalTodos = $dataProvider->getTotalCount();

        $dataProvider_1 = $searchModel->search($this->request->queryParams);
        $dataProvider_1->query->andWhere(['status' => 1]);
        $totalDoneTodos = $dataProvider_1->getTotalCount();

        $dataProvider_2 = $searchModel->search($this->request->queryParams);
        $dataProvider_2->query->andWhere(['status' => 0]);
        $totalNotDoneTodos = $dataProvider_2->getTotalCount();


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'totalLastWeek' => $totalLastWeek,
            'totalTodos' => $totalTodos,
            'totalDoneTodos' => $totalDoneTodos,
            'totalNotDoneTodos' => $totalNotDoneTodos,
            'countByDateType' => $countByDateType,
            'datetype' => $datetype,
            'drowdown' =>  $drowdown,
            'model' => $model
        ]);
    }
    public function actionChangebtn($id, $status)
    {
        if ($status == 1) {
            $newstatus = 0;
        } else ($newstatus = 1);

        $todo = Todo::findOne($id);
        $todo->status = $newstatus;
        $todo->save();
        return $this->redirect(['index']);
    }

    /**
     * Displays a single Todo model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionCancel()
    {
        return $this->redirect("index");
    }

    /**
     * Creates a new Todo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {

        $model = new Todo();
        $todo = Todo::find()->all();
        $request = Yii::$app->request;
        // $show = $request->get('show');
        // echo $show;
        // exit;
        Yii::$app->session->setFlash('success', "Save Successfully");
        if ($this->request->isPost) {
            if ($this->request->ispost && $model->load($this->request->post())) {
                // $model->create_at = Yii::$app->formatter->asDatetime('now', 'php:Y-m-d H:i:s');
                $model->status = 0;
                $model->save();
                return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }
        return $this->renderAjax('create', [
            'model' => $model,
            'todo' => $todo,

        ]);
    }
    /**
     * Updates an existing Todo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        Yii::$app->session->setFlash('update', "update Successfully");
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Todo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        Yii::$app->session->setFlash('delete', "Delete in Successfully");
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Todo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Todo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Todo::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
