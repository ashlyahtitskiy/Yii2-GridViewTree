# Yii2-GridViewTree

Based on GridView.

A simple solution for managing a tree with standard tools. Functions:

A tree management solution that provides the ability to manage hierarchical data stored using nested sets.

Does not use the yii2-nested-sets extension to manage the tree structure of your database.

A tree view built from scratch without any third party plugins. TreeView is developed by Yii2 PHP.
Styled with fontawesome.

# Usage:

1. Create table with fields:

[ id ] <br>
[ parent_id ]<br>
[ isfolder ]<br>
[ name ]<br>
[ ..... ]

2. In project genarate Model, CRUD with Gii.

3. In ModelSearch add: 

```php
    public function search($params)
    {
            if (!isset($params['id']){
                $query = Folders::find()->Where(['parent_id' => NULL]);
            } else {
                $query = Folders::find()->Where(['or','parent_id='.$params['id'],'id='.$params['id']]);
     }  
```
        
4. In Controller modify:

```php
    public function actionIndex($id=null)
    {
        $searchModel = new FoldersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'currentfolder' => $id
        ]);
    }
```

5. GreedView modify:

```php
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
```


# Enjoy!
