<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "page".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $preview
 * @property string|null $content
 * @property string|null $created_at
 * @property int|null $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by

 * @property int|null $status
 *
 * @property Log[] $logs
 */
class Page extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'page';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description', 'content'], 'string'],
            [['created_at', 'updated_at', 'old_value', 'attr_name'], 'safe'],
            [['created_by', 'updated_by', 'status'], 'integer'],
            [['name', 'preview'], 'string', 'max' => 255],
            ['preview', 'image',  'extensions' => 'jpg, jpeg, png']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название страницы',
            'description' => 'Описание страницы',
            'preview' => 'Превью страницы (изображение)',
            'content' => 'HTML контент страницы',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Logs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLogs()
    {
        return $this->hasMany(Log::className(), ['page_id' => 'id']);
    }

    public function saveTrigger(){
        $log = new Log();
        $log->page_id=$this->id;
        $log->updated_at = $this->created_at;
        $log->updated_by = $this->created_by;
        $log->update_description = 'Страница успешно создан!';
        $log->attr_name = 'success_created';
        $log->status=1;
        if($log->save()){
            return 1;
        }else{
            return 0;
        }
    }
    public function updateTrigger($model, $description='some changes'){
        $changed_attributes = array_diff_assoc($model->getOldAttributes(), $model->getAttributes());
        $log = new Log();
        $log->page_id=$this->id;
        $log->updated_at = $this->created_at;
        $log->updated_by = $this->created_by;
        $log->update_description = $description;
        $log->attr_name = json_encode($changed_attributes);
        $log->status=1;
        if($log->save()){
            return 1;
        }else{
            return 0;
        }
    }

    public static function getPages(){
        return self::find()->asArray()->all();
    }

}
