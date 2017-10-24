<?php

namespace API\Common\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use API\APIQL;
use API\Common\Repository\EloquentQueryBuilder;
use API\Common\Repository\EloquentRelationship;
use API\Common\Exceptions\BadRequestException;
use API\Common\Exceptions\ResourceNotFoundException;

class RepositoryEloquent extends Model {

    use EloquentQueryBuilder;

    use EloquentRelationship;

    /**
     * Disable laravel default guard
     */
    protected $guarded = array();

    /**
     * Disable laravel default timestamps
     */
    public $timestamps = false;

    /**
     * @var APIQL
     */
    protected $args;

    public function setArgs(APIQL $apiQL = null) {
        $this->args = $apiQL;
    }

    public function getArgs() {
        return $this->args;
    }

    public function getAll() {
        try {
            $query = $this->eloquentQuery();

            $resource = [];
            $resource['_paging'] = null;
            $args = $this->args->getAllArgs();
            $otherArgs = $this->args->getOtherArgs();
            $return = $this->args->getOtherArg('_return');
            /*bad*/
            if($return == 'count'){
                return [
                    'data' =>[
                        'count' => $query->count()
                    ],
                    '_paging' => null
                ];
            }

            if ($otherArgs['_paging'] != null) {
                $totalItem = $query->count();
                if ($totalItem === 0) {
                    throw new ResourceNotFoundException();
                }
                $maxPerPage = 100;
                $perPage = (isset($args['limit'])) ? (int) $args['limit'] : 6;
                $perPage = max(1, $perPage);
                $perPage = min($maxPerPage, $perPage);
                $lastPage = ceil($totalItem / $perPage);
                $currentPage = (isset($args['_page'])) ? (int) $args['_page'] : 1;
                $currentPage = min($lastPage, $currentPage);
                $currentPage = max(1, $currentPage);
                $offset = ($currentPage - 1) * $perPage;
                $this->args->setSQLArg('offset', $offset);
                $this->args->setSQLArg('limit', $perPage);
                $from = ($totalItem > 0) ? $offset + 1 : 0;


                $resource['_paging']['total_item'] = $totalItem;
                $resource['_paging']['limit'] = $perPage;
                $resource['_paging']['from'] = $from;
                $resource['_paging']['to'] = 0;
                $resource['_paging']['current_page'] = $currentPage;
                $resource['_paging']['last_page'] = $lastPage;
                if (isset($args['_page'])) {
                    unset($args['_page']);
                }
                if (isset($args['_service_token'])) {
                    unset($args['_service_token']);
                }

                $query = '_page={page}';
                if (sizeof($args) > 0) {
                    $query = http_build_query($args) . '&_page={page}';
                }
                $resource['_paging']['query'] = $query;
                $query = $this->eloquentQuery();
                $data = $query->get();

                $to = min(($currentPage - 1) * $perPage + $data->count(), $totalItem);
                $resource['_paging']['to'] = $to;
            } else {

                $query = $this->eloquentQuery();
                $data = $query->get();
            }

            if (!$data->count()) {
                throw new ResourceNotFoundException();
            }

            $resource['data'] = $this->afterQueryFilter($data->toArray());
            return $resource;
        } catch (QueryException $e) {
            throw new BadRequestException();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getOne() {
        try {
            $query = $this->eloquentQuery();
            $data = $query->first();
            if (!$data) {
                throw new ResourceNotFoundException();
            }

            $data = $this->afterQueryFilter($data->toArray());
            if (!$data) {
                throw new ResourceNotFoundException();
            }

            return $data;
        } catch (QueryException $e) {
            throw new BadRequestException();
        } catch (\Exception $e) {
            throw $e;
        }
    }

}
