<?php

namespace Cloudteam\BaseCore\Utils;

trait ModelDetailable
{
    public function saveDetail($detailDatas, $detailModel, $detailRelation, $extraDatas)
    {
        $detailRelations       = $this->$detailRelation;
        $currentModelDetailIds = $deletedIds = $detailRelations->pluck('id');

        if ($detailDatas) {
            $deletedIds = $currentModelDetailIds->diff(collect($detailDatas)->pluck('id')->toArray());

            foreach ($detailDatas as $detailData) {
                $modelDetailid = $detailData['id'];
                if ( ! $modelDetailid) {
                    $modelDetail = array_merge($detailData, $extraDatas);
                    $detailModel::create($modelDetail);
                } else {
                    $detailModel::query()->whereKey($modelDetailid)->update($detailData);
                }
            }
        }

        if ($deletedIds) {
            $detailModel::destroy($deletedIds);
        }

        return $this;
    }
}
