<?php

namespace frontend\components;

use yii\i18n\Formatter;

/**
 * adds custom methods to Yii::$app->formatter extending yii\i18n\Formatter 
 * usage Yii::$app->formatter->methodName();
 *
 * @author suray
 */
class PhoneFormatter extends Formatter{
   
    /**
     * formats 38099999999 to 38(093)999-99-99
     * usage Yii::$app->formatter->asPhone(0677777777)
     * 
     * @param string $value
     * @return string
     */
   public function asPhone($value) {
        return $this->prepareStandardNumber($value);
   }
   
   /**
    * takes off the input mask +38(093)999-99-99 and lefts only number values
    * 
    * @param string $value
    * @return string
    */
   public function asUnmaskedNumber($value) {
        $search = ['~\(~', '~\)~', '~-~', '~\+~'];
        $replacement = [''];
        return strval(preg_replace($search, $replacement, $value));
   } 
   
   /**
    * performs formatting string to phone number format 38(093)999-99-99
    * 
    * @param type $phoneNumber
    * @return type
    */
   protected function prepareStandardNumber($phoneNumber) {
        
        $length = strlen($phoneNumber);
        
        switch ($length) {
            case ($length < 7):
                return $phoneNumber;
            case 7:
                $phoneNumber = substr_replace($phoneNumber, '-', -2, 0); //now length is 8
                $phoneNumber = substr_replace($phoneNumber, '-', -5, 0); //now length is 9
                return $phoneNumber;
            
            case ($length == 8 || $length == 9) :
                $phoneNumber = substr_replace($phoneNumber, '-', -2, 0); //now length is 8
                $phoneNumber = substr_replace($phoneNumber, '-', -5, 0); //now length is 9
                $phoneNumber = substr_replace($phoneNumber, ')', -9, 0); //now length is 10
                return $phoneNumber;
            case ( $length > 9) :
                $phoneNumber = substr_replace($phoneNumber, '-', -2, 0); //now length is 8
                $phoneNumber = substr_replace($phoneNumber, '-', -5, 0); //now length is 9
                $phoneNumber = substr_replace($phoneNumber, ')', -9, 0); //now length is 10
                $phoneNumber = substr_replace($phoneNumber, '(', -12, 0); //now length is 10
                return $phoneNumber;
        }   
    }
}
