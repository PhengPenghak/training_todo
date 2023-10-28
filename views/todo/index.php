<?php

use app\models\Todo;
use app\widgets\Alert;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\ButtonGroup;
use yii\bootstrap5\LinkPager;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\base\Theme;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\bootstrap5\ButtonDropdown;
use yii\widgets\Pjax;
use yii\base\Widget;

/** @var yii\web\View $this */
/** @var app\models\TodoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Todos';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if (Yii::$app->session->hasFlash('success')) :

    $session = Yii::$app->session;

    if ($session->hasFlash('success')) {
        $alert = Alert::widget([
            'options' => [
                'title' => $session->getFlash('success'),
                'icon' => 'success',
                'toast' => true,
                'position' => 'top-end',
                'showConfirmButton' => false,
                'animation' => true,
                'customClass' => 'animated fadeInRight',
                'padding' => 15,
                'timer' => 1500,
            ]
        ]);
    }
?>

<?php endif; ?>
<?php if (Yii::$app->session->hasFlash('update')) :

    $session = Yii::$app->session;

    if ($session->hasFlash('update')) {
        $alert = Alert::widget([
            'options' => [
                'title' => $session->getFlash('update'),
                'icon' => 'success',
                'toast' => true,
                'position' => 'top-end',
                'showConfirmButton' => false,
                'animation' => true,
                'customClass' => 'animated fadeInRight',
                'padding' => 15,
                'timer' => 1500,

                //'type' => SweetAlert2Asset::TYPESUCCESS,
            ]
        ]);
    }
?>

<?php endif; ?>
<?php
$session = Yii::$app->session;

if ($session->hasFlash('delete')) {
    $alert = Alert::widget([
        'options' => [
            'title' => $session->getFlash('delete'),
            'icon' => 'success',
            'toast' => true,
            'position' => 'top-end',
            'showConfirmButton' => false,
            'animation' => true,
            'customClass' => 'animated fadeInRight',
            'padding' => 15,
            'timer' => 1500,

            //'type' => SweetAlert2Asset::TYPESUCCESS,
        ]
    ]);
}
?>
<div class="todo-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="container">
        <div class="row my-5 body">
            <div class="col-lg col-6 ">
                <div class="card border-success mt-2">
                    <div class="card-body" id="countByDateType">
                        <h5 class="card-title ">Previous month tasks </h5>
                        <?= Html::dropDownList(
                            'dateFilter',
                            $datetype,
                            $drowdown,
                            ['class' => 'form-control dateFilter']
                        )
                        ?>
                        <h1 class="countingNumber"><?= $countByDateType ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-lg col-6">
                <div class="card border-danger mt-2">
                    <div class="card-body" id="totalLastWeek">
                        <h5 class="card-title">Previous week tasks </h5>
                        <div id="blankheight"></div>

                        <h1 class="countingNumber"><?= $totalLastWeek ?></h1>

                    </div>
                </div>
            </div>
            <div class="col-lg col-4">
                <div class="card border-secondary mt-2">
                    <div class="card-body">
                        <small class="float-end text-muted query_title">Query task result</small>
                        <div class="clearfix"></div>
                        <h1 class="countingNumber"> <?= $totalTodos ?>
                            <span class="ml-2 fs-5 query_task">All</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="col-lg col-4">
                <div class="card border-primary mt-2">
                    <div class="card-body">
                        <small class="float-end text-muted query_title">Query task result</small>
                        <div class="clearfix"></div>
                        <h1 class="countingNumber"><?= $totalDoneTodos ?> <span class="ml-2 fs-5 query_task">Done</span></h1>
                    </div>
                </div>
            </div>
            <div class="col-lg col-4">
                <div class="card border-warning mt-2">
                    <div class="card-body">
                        <small class="float-end text-muted query_task query_title">Query task result</small>
                        <div class="clearfix"></div>
                        <h1 class="countingNumber"><?= $totalNotDoneTodos ?> <span class="ml-2 fs-5 query_task">Not done</span></h1>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php Pjax::begin(['id' => 'data-pjax']); ?>
    <?php
    Modal::begin([
        'id' => 'modal',
        'size' => 'modal-md',
        'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    ]);
    echo "<div id='modalContent' ></div>";
    Modal::end();
    ?>
    <?php echo $this->render('_search', ['model' => $searchModel]);
    ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-striped',
        ],
        'pager' => [
            // 'firstPageLabel' => 'First',
            // 'lastPageLabel' => 'Last',
            'class' => LinkPager::class,

        ],
        'layout' => '
        {items}
        <div class="row ">
            <div class="col col-md-6">
                {pager}
            </div>
            
            <div class="col col-md-6">
            <div class="d-flex justify-content-end button ">
                <label>
                    <a href="' . Url::to(['todo/index',]) . '" class="btn btn-sm footer_size">All</a>
                </label>
                <label>
                    <a href="' . Url::to(['todo/index', 'status' => 1]) . ' " class="btn btn-sm footer_size">Done</a>
                </label>
                <label>
                    <a href="' . Url::to(['todo/index', 'status' => 0]) . '" class="btn btn-sm footer_size">Not Done</a>
                </label>
            </div>
        </div>
            
        </div>
        ',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [

                'attribute' => 'title',
                'contentOptions' => ['class' => 'title_size'],
            ],

            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->status == 1) {
                        return Html::a('Done', ['todo/changebtn', 'id' => $model->id, 'status' => $model->status], ['class' => 'btn btn-outline-info btn-sm btn-xs title_size button_size']);
                    } else {
                        return Html::a('Not Done', ['todo/changebtn', 'id' => $model->id, 'status' => $model->status], ['class' => 'btn btn-outline-warning btn-sm  btn-xs title_size button_size']);
                    }
                }
            ],
            [
                'attribute' => 'date',
                'format' => 'datetime',
                'contentOptions' => ['class' => 'title_size'],

            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Action',
                'template' => '{view} {update} {delete} {dropdown} {offcanvas}',
                'options' => ['class' => 'text-primary '],
                'buttons' => [

                    'view' => function ($url, $model) {
                        $label = '<span class="d-none d-lg-inline-block">View &nbsp;</span>';
                        return Html::a($label . '<i class="fas fa-eye"></i>', "#", [
                            'class' => 'btn btn-outline-secondary btn-sm btn-xs size_icon d-none d-lg-inline-block triggerModal',
                            'value' => Url::to(['todo/view', 'id' => $model->id]),
                        ]);
                    },

                    'update' => function ($url, $model) {
                        $label = '<span class="d-none d-lg-inline-block">Edit &nbsp;</span>';
                        return Html::a($label . ' <i class="fas fa-pen"></i>', "#", [
                            'class' => 'btn btn-outline-info btn-sm btn-xs triggerModal size_icon d-none d-lg-inline-block',
                            'value' => Url::to(['todo/update', 'id' => $model->id]),
                        ]);
                    },

                    'delete' => function ($url, $model,) {
                        $label = '<span class="d-none d-lg-inline-block">Delete &nbsp;</span>';
                        return '<button href="' . Url::to(['todo/delete', 'id' => $model->id]) . '" class="btn btn-outline-dark btn-sm btn-xs size_icon d-none d-lg-inline-block btn-remove-item">' . $label . '<i class="fas fa-eye"></i>' . '</button>';
                        // return Html::a($label . ' <i class="fas fa-trash"></i>', $url, [
                        //     'data-method' => 'post', 'data-pjax' => '0',
                        //     'class' => 'btn btn-outline-dark btn-sm btn-xs size_icon d-none d-lg-inline-block btn-remove-item',
                        // ]);
                    },

                    'dropdown' => function ($url, $model) {

                        $urlView = Url::toRoute(['todo/view', 'id' => $model->id]);
                        $urlUpdate = Url::to(['todo/update', 'id' => $model->id]);
                        $urlDelete = Url::toRoute(['todo/delete', 'id' => $model->id]);
                        return "<div class='dropdown d-lg-none w-75%' >
                        <button class='btn btn-danger-sm dropdown-toggle ' type='button' id='dropdownMenuButton' data-bs-toggle='dropdown' aria-expanded='false'>
                        </button>
                        <ul class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                            <li><a class='dropdown-item title_size' data-pjax='0' href='{$urlView}'>View</a></li>
                            <li><a class='dropdown-item title_size triggerModal' data-pajx='0' value ='{$urlUpdate}',>Edit
                            </a></li>
                            <li><a class='dropdown-item title_size btn-remove-item' href='{$urlDelete}'>Delete</a></li>
                        </ul>
                    </div>";
                    },

                ],

            ],
        ],
    ]); ?>

</div>

<?php
$script = <<<JS
    $("select[name='dateFilter']").change(function(){
        var value = $(this).val();
        var url = new URL(window.location.href);
        url.searchParams.set('datetype',value);
        window.location.href = url.href;
    });

    $('.btn-remove-item').click(function(e){
        e.preventDefault();
        var  href = $(this).attr('href');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                
            if (result.isConfirmed) {    
                $.post(href)
            }
            })      
    });
        
JS;
$this->registerJS($script);
?>