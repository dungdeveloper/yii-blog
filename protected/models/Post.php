<?php

/**
 * This is the model class for table "blog_post".
 *
 * The followings are the available columns in table 'blog_post':
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $status
 * @property string $tags
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property Comment $comment
 * @property User $user
 */
class Post extends CActiveRecord {
    
    const STATUS_DRAFT = 1;
    const STATUS_PUBLISHED = 2;
    const STATUS_ARCHIVED = 3;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Post the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'blog_post';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, content', 'required'),
            array('title, tags', 'length', 'max' => 256),
            array('status', 'safe'),
            array('title, status, create_time', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'comment' => array(self::HAS_ONE, 'Comment', 'post_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'status' => 'Status',
            'tags' => 'Tags',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'user_id' => 'User',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        $criteria = new CDbCriteria;
        
        if($this->create_time)
        {				
            $criteria->addCondition('DATE_FORMAT(FROM_UNIXTIME(create_time), "%b %Y") LIKE :time');
            $criteria->params = array(':time'=>$this->create_time);		
        }        
        
        $criteria->compare('title', $this->title, true);
        $criteria->compare('status', $this->status);
        
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    /**
     * @return array of post's status
     */
    public function getStatusArray() {
        return array(
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_PUBLISHED => 'Published',
            self::STATUS_ARCHIVED => 'Archived',
        );
    }
    
    /**
     * @return the name of a status 
     */
    public function getStatusName() {
        $arrStatus = $this->getStatusArray();
        return $arrStatus[$this->status];
    }
    
    /**
     * Add more attributes 
     */
    protected function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->getIsNewRecord()) {
                $this->create_time = time();
                $this->user_id = Yii::app()->user->id;
            }
            $this->update_time = time();
            return true;
        }
        return false;
    }
    
    /**
     * Create tags 
     */
    protected function afterSave() {
        parent::afterSave();
        if ($this->getIsNewRecord())
            Tag::model()->createTags($this->tags);
    }
    
    public function showCreateTime() {
        return date('M d, Y', $this->create_time);
    }
    
    public function getCreateTimeArray() {
        $posts = $this->findAll(array(
            'select' => 'create_time',
        ));
        
        $arr = array();
        foreach ($posts as $p) {
            $month = date('M Y', $p->create_time);
            $arr[$month] = $month;
        }
        
        return array_unique($arr);
    }    
}