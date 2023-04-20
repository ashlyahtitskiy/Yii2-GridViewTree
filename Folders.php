<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "folders".
 *
 * @property int $id
 * @property int|null $parent_id
 * @property int|null $isfolder
 * @property string $name
 *
 * @property Folders[] $folders
 * @property Folders $parent
 */
class Folders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'folders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'isfolder'], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Folders::class, 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'isfolder' => Yii::t('app', 'Isfolder'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * Gets query for [[Folders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFolders()
    {
        return $this->hasMany(Folders::class, ['parent_id' => 'id']);
    }

    /**
     * Gets query for [[Parent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Folders::class, ['id' => 'parent_id']);
    }
}
