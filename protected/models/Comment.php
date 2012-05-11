<?php

/**
 * This is the model class for table "blog_comment".
 *
 * The followings are the available columns in table 'blog_comment':
 * @property integer $id
 * @property string $author_name
 * @property string $author_email
 * @property string $author_url
 * @property string $content
 * @property integer $status
 * @property integer $create_time
 * @property integer $post_id
 *
 * The followings are the available model relations:
 * @property Post $post
 */
class Comment extends CActiveRecord {
    
    const STATUS_PENDING = 1;
    const STATUS_ACCEPTED = 2;
    
    public $post_title;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Comment the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'blog_comment';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('author_name, author_email, content', 'required'),            
            array('author_name, author_email, author_url', 'length', 'max' => 256),
            array('author_email', 'email'),
            array('author_url', 'url'),
            array('status', 'safe'),
            array('create_time, post_title', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'post' => array(self::BELONGS_TO, 'Post', 'post_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'author_name' => 'Name',
            'author_email' => 'Email',
            'author_url' => 'Website',
            'content' => 'Comment',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'post_title' => 'Post',            
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        $criteria = new CDbCriteria;
        if ($this->post_title) {
            $criteria->addCondition('post_id IN (SELECT id FROM blog_post WHERE title LIKE :title)');
            $criteria->params = array(':title'=>'%'.$this->post_title.'%');
        }
        
        $criteria->compare('author_name', $this->author_name, true);
        $criteria->compare('author_email', $this->author_email, true);
        $criteria->compare('author_url', $this->author_url, true);
        $criteria->compare('t.content', $this->content, true);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('DATE_FORMAT(FROM_UNIXTIME(t.create_time), "%b %Y")', $this->create_time);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    
    protected function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->getIsNewRecord()) {
                $this->create_time = time();
                $this->status = self::STATUS_PENDING;
            }
            return TRUE;
        }
        return FALSE;
    }
    
    /**
     * Get array of status 
     */
    public function getStatusArray() {
        return array(
            self::STATUS_PENDING => 'Pending',
            self::STATUS_ACCEPTED => 'Accepted',
        );
    }
    
    /**
     * Get status name 
     */
    public function getStatusName() {
        $arrStatus = $this->getStatusArray();
        return $arrStatus[$this->status];
    }
    
    /**
     * Show create time
     */
    public function showCreateTime() {
        return date('M d, Y', $this->create_time);
    }
    
    /**
     * Get create time array 
     */
    public function getCreateTimeArray() {
        $comments = $this->findAll(array(
            'select' => 'create_time',
        ));
        $arr = array();
        foreach ($comments as $c) {
            $t = date('M Y', $c->create_time);
            $arr[$t] = $t;
        }        
        return array_unique($arr);
    }
    
    /**
     * Get post link 
     */
    public function getPostLink() {
        return CHtml::link($this->post->title, array('post/view', 'id'=>$this->post_id));
    }
}