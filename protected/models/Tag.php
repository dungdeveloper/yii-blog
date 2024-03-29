<?php

/**
 * This is the model class for table "blog_tag".
 *
 * The followings are the available columns in table 'blog_tag':
 * @property integer $id
 * @property string $name
 * @property integer $frequency
 */
class Tag extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Tag the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'blog_tag';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('frequency', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 256),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, frequency', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'frequency' => 'Frequency',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('frequency', $this->frequency);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    /**
     * Create tag
     * @param string $names
     */
    public function createTags($names) {
        $arrName = explode(',', $names);
        foreach ($arrName as $name) {
            $tag = $this->findByAttributes(array('name' => $name));
            if (is_null($tag)) {
                $tag = new Tag;
                $tag->name = $name;
                $tag->frequency = 1;
            } else {
                $tag->frequency++;
            }
            $tag->save();
        }
    }
    
    /**
     * Delete tag
     * @param string $names 
     */
    public function deleteTags($names) {
        $arrName = explode(',', $names);
        foreach ($arrName as $name) {
            $tag = $this->findByAttributes(array('name'=>$name));
            if ($tag->frequency == 1)
                $tag->delete();
            else {
                $tag->frequency--;
                $tag->update(array('frequency'));
            }
        }        
    }
    
    /**
     * Update tag
     * @param string $names 
     */
    public function updateTags($old, $new) {        
        $lengthOld = strlen($old);
        $lengthNew = strlen($new);
        
        if ($lengthOld == $lengthNew)
            return;    
        
        if ($lengthNew == 0) {
            $this->deleteTags($old);
            return;
        }
        
        if ($lengthOld == 0 && $lengthNew > 0) {
            $this->createTags($new);
            return;
        }

        $arrOld = explode(',', $old);
        $arrNew = explode(',', $new);        
        if ($lengthNew > $lengthOld) {
            $this->createTags(implode(',', array_diff($arrNew, $arrOld)));
            return;
        }
        if ($lengthNew < $lengthOld) {
            $this->deleteTags(implode(',', array_diff($arrOld, $arrNew)));
            return;            
        }
    }

}