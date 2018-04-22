<?php
/**
 * User: Xany <762632258@qq.com>
 * Date: 2017/11/27
 * Time: 16:06
 */

namespace app\modules\mch\models;


use app\models\Card;
use app\modules\api\models\QrcodeForm;
use yii\data\Pagination;

class CardListForm extends Model
{
    public $store_id;

    public $page;
    public $limit;

    public function rules()
    {
        return [
            [['page'],'default','value'=>1],
            [['limit'],'default','value'=>20]
        ];
    }

    public function search()
    {
        if(!$this->validate()){
            return $this->getModelError();
        }

        $query = Card::find()->where(['is_delete'=>0,'store_id'=>$this->store_id]);

        $count = $query->count();

        $p = new Pagination(['totalCount'=>$count,'pageSize'=>$this->limit]);
        $list = $query->offset($p->offset)->limit($p->limit)->orderBy(['addtime'=>SORT_DESC])->asArray()->all();

        return [
            'list'=>$list,
            'row_count'=>$count,
            'pagintion'=>$p
        ];

    }
}