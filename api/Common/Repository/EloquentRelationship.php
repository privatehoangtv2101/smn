<?php

namespace API\Common\Repository;

use API\Common\Exceptions\BadRequestException;

trait EloquentRelationship {

    public function afterQueryFilter($data) {
        $otherArgs = $this->args->getOtherArgs();
        if ($otherArgs['_include'] === null) {
            return $data;
        }

        $include = $otherArgs['_include'];
        $includeArr = explode('.', $include);
        foreach ($includeArr as $includeName) {
            $relationMethod = '_relation_' . $includeName;
            if (!method_exists($this, $relationMethod)) {
                throw new BadRequestException;
            }
            $data = $this->$relationMethod($data);
        }

        return $data;
    }

}
