<?php

namespace API\Common\Repository;

trait EloquentQueryBuilder {

    public function eloquentQuery() {
        $query = $this->filter_query($this);

        $sqlArgs = $this->args->getSQLArgs();
        foreach ($sqlArgs as $key => $value) {
            if ($value == null) {
                continue;
            }
            $methodName = '_query_' . $key;
            $query = $this->$methodName($query, $value);
        }
        return $query;
    }

    private function filter_query($query) {
        $filterArgs = $this->args->getFilterArgs();
        foreach ($filterArgs as $key => $value) {
            $valueArr = explode('|', $value);
            if (sizeof($valueArr) === 1) {
                $sqlMethod = '_filter_' . $key;
                if (method_exists($this, $sqlMethod)) {
                    $query = $this->$sqlMethod($query, $value);
                    continue;
                }
                $query = $query->where($key, $value);
            } else {
                $sqlMethod = '_sql_' . $valueArr[0];
                unset($valueArr[0]);
                array_values($valueArr);
                
                if (method_exists($this, $sqlMethod)) {
                    $query = $this->$sqlMethod($query, $key, $valueArr);
                }
            }
        }

        return $query;
    }

    private function _sql_like($query, $field, $value) {
        $d = implode('', $value);
        return $query->where($field, 'like', $d);
    }
    
    private function _sql_date($query, $field, $value) {
        return $query->whereDate($field, '=', $value);
    }
    
    private function _sql_day($query, $field, $value) {
        return $query->whereDay($field, '=', $value);
    }
    
    private function _sql_month($query, $field, $value) {
        return $query->whereMonth($field, '=', $value);
    }
    
    private function _sql_year($query, $field, $value) {
        return $query->whereYear($field, '=', $value);
    }

    private function _sql_in($query, $field, $value) {  
        $query = $query->whereIn($field, $value);     
        return $query;

    }

    private function _sql_not_in($query, $field, $value) {
        return $query->whereNotIn($field, $value);
    }

    private function _sql_between($query, $field, $value) {
        return $query->whereBetween($field, $value);
    }

    private function _sql_not_between($query, $field, $value) {
        return $query->whereNotBetween($field, $value);
    }

    /*
      ----------------------------------------------------------------------- */

    private function _query_order($query, $order) {
        $listOrder = explode('|', $order);
        $defaultOrder = 'desc';
        foreach ($listOrder as $orderSetting) {
            $orderSettingArr = explode('.', $orderSetting);
            $field = $orderSettingArr[0];
            $order = (isset($orderSettingArr[1])) ? $orderSettingArr[1] : $defaultOrder;
            $query = $query->orderBy($field, $order);
        }

        return $query;
    }

    private function _query_limit($query, $limit) {
        return $query->take($limit);
    }

    private function _query_include($query, $include) {
        return $query;
    }

    private function _query_offset($query, $offset) {
        return $query->skip($offset);
    }

    private function _query_fields($query, $fields) {
        $selectFields = ['id']; //default select field must have
        $selectFields = array_merge($selectFields, explode('.', $fields));
        return $query->select($selectFields);
    }

    private function _query_in($query, $in) {
        return $query->whereIn('id', explode('.', $in));
    }

    private function _query_sort($query, $with) {
        return $query->orderBy('email', 'ASC');
    }

}
