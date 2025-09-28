<?php

declare(strict_types=1);

namespace app\components;

use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

class Controller extends \yii\rest\Controller
{
    public function runAction($id, $params = [])
    {
        $result = parent::runAction($id, $params);

        $result['success'] = true;

        return $result;
    }

    protected function formatDataProvider(ActiveDataProvider $activeDataProvider, array $expandFields = []): array
    {
        $pagination = $activeDataProvider->getPagination();
        $data = array_map(
            static fn (ActiveRecord $model) => $model->toArray([], $expandFields),
            $activeDataProvider->getModels()
        );

        return [
            'data' => $data,
            'pagination' => [
                'totalCount' => $pagination->totalCount,
                'page' => $pagination->getPage() + 1,
                'pageSize' => $pagination->getPageSize(),
                'pageCount' => $pagination->getPageCount(),
            ],
        ];
    }
}
