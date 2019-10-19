<?php

namespace Cloudteam\BaseCore\Utils;

trait ModelDetailable
{
    public function saveDetail($detailDatas, $detailModel, $detailRelation, $extraDatas)
    {
        $detailRelations       = $this->$detailRelation;
        $currentModelDetailIds = $deletedIds = $detailRelations->pluck('id');

        if ($detailDatas) {
            $modelDetails = [];

            $deletedIds = $currentModelDetailIds->diff(collect($detailDatas)->pluck('id')->toArray());

            foreach ($detailDatas as $detailData) {
                $modelDetailid = $detailData['id'];
                if ( ! $modelDetailid) {
                    $modelDetails[] = array_merge($detailData, $extraDatas);
                } else {
                    $detailModel::query()->whereKey($modelDetailid)->update($detailData);
                }
            }

            if ($modelDetails) {
                $detailModel::insert($modelDetails);
            }
        }

        if ($deletedIds) {
            $detailModel::destroy($deletedIds);
        }

        return $this;
    }
}
