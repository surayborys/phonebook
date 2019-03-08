<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model frontend\models\Group */
/* @var $contacts[] frontend\models\Abonent */
/* @var $nonGroupContacts[] frontend\models\Abonent */
/* @var $mode - performed action mode*/

$this->title = 'Manage';
$this->params['breadcrumbs'][] = ['label' => 'Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="group-form">

    <?= Html::beginForm('', 'post'); ?>

        <div class="form-group">
            <input type="submit" class="btn btn-default" value=<?= ($mode == 'add') ? 'Add' : 'Remove'?>>
        </div>


        <table class="table table-condensed">
            <tr>
                <th>Contact status</th>
                <th>Contact info</th>
            </tr>
            <?php if(isset($contacts)):?>
            <?php foreach ($contacts as $contact): ?>
                <tr>
                    <td><input type="checkbox" name="abonents[]" value="<?= $contact->id ?>" id=<?= $contact->id ?>></td>
                    <td><label class="text-info" for="<?= $contact->id ?>"><?= $contact->fullname ?></label></td>
                </tr>
            <?php endforeach; ?>
            <?php endif;?>
                
            <?php if(isset($nonGroupContacts)):?>
            <?php foreach ($nonGroupContacts as $contact): ?>
                <tr>
                    <td><input type="checkbox" name="abonents[]" value="<?= $contact->id ?>" id=<?= $contact->id ?>></td>
                    <td><label class="text-info" for="<?= $contact->id ?>"><?= $contact->fullname ?></label></td>
                </tr>
            <?php endforeach; ?>
            <?php endif;?>
        </table>    
<?php Html::endForm(); ?>

</div>

