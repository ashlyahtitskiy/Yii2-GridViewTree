<?php

use common\models\Folders;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var common\models\FoldersSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Folders');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="folders-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Folders'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute'=>'isfolder',
                'format' => 'raw',
                'filterOptions' => ['style' => 'width: 1%'],
                'label'=>'',
                'value' =>function($model) use ($currentfolder){ return ( $model->id == $currentfolder )? '<i class="fa-solid fa-folder-open"></i>' : (( $model->isfolder )? '<i class="fa-solid fa-folder"></i>':'<i class="fa-solid fa-file"></i>'); },
            ],
            'id',
            'parent_id',

            'name',
            ['class' => 'yii\grid\ActionColumn',
                'buttons'=>[
                    'enter'=>function ($url, $model) use ($currentfolder) {
                        if (($currentfolder != $model['id']) && ($model['isfolder']) ) {
                            return \yii\helpers\Html::a( '<i class="fa-solid fa-arrow-right-to-bracket"></i>',
                                Yii::$app->getUrlManager()->createUrl(['/folders/index','id'=>$model['id']]),
                                ['title' => Yii::t('yii', 'Enter'), 'data-pjax' => '1']);
                        }
                        if (($currentfolder == $model['id']) && ($model['isfolder']) ) {
                            return \yii\helpers\Html::a( '<i class="fa-solid fa-turn-up"></i>',
                                Yii::$app->getUrlManager()->createUrl(['/folders/index','id'=>$model['parent_id']]),
                                ['title' => Yii::t('yii', 'Back'), 'data-pjax' => '1']);
                        }
                        if (!$model['isfolder']) {
                            return \yii\helpers\Html::a( '<i class="fa-solid fa-eye"></i>',
                                Yii::$app->getUrlManager()->createUrl(['/folders/view','id'=>$model['id']]),
                                ['title' => Yii::t('yii', 'Open'), 'data-pjax' => '1']);
                        }
                    }
                ],
                'template' => '{enter}'
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
