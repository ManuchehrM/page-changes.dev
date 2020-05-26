<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log".
 *
 * @property int $id
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property int|null $page_id
 * @property string|null $update_description
 * @property string|null $old_value
 * @property string|null $attr_name
 * @property int|null $status
 *
 * @property Page $page
 */
class Log extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['updated_at'], 'safe'],
            [['update_description'], 'string'],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => Page::className(), 'targetAttribute' => ['page_id' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'user_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'updated_at' => 'Время редактирования',
            'updated_by' => 'Пользователь который их внес',
            'page_id' => 'Страница в которой внесены изменения',
            'update_description' => 'Описание изменений',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Page]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Page::className(), ['id' => 'page_id']);
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'updated_by']);
    }
}
