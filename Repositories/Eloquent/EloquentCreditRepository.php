<?php

namespace Modules\Icredit\Repositories\Eloquent;

use Modules\Icredit\Repositories\CreditRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentCreditRepository extends EloquentBaseRepository implements CreditRepository
{
    public function getItemsBy($params)
    {
        // INITIALIZE QUERY
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include ?? [])) {//If Request all relationships
            $query->with([]);
        } else {//Especific relationships
            $includeDefault = ['translations'];//Default relationships
            if (isset($params->include))//merge relations with default relationships
                $includeDefault = array_merge($includeDefault, $params->include);
            $query->with($includeDefault);//Add Relationships to query
        }

        // FILTERS
        if (isset($params->filter)) {
            $filter = $params->filter;

            //add filter by search
            if (isset($filter->search)) {
                //find search in columns
                $query->where(function ($query) use ($filter) {
                    $query->whereHas('translations', function ($query) use ($filter) {
                        $query->where('locale', $filter->locale)
                            ->where('title', 'like', '%' . $filter->search . '%');
                    })->orWhere('icredit__credits.id', 'like', '%' . $filter->search . '%')
                        ->orWhere('updated_at', 'like', '%' . $filter->search . '%')
                        ->orWhere('created_at', 'like', '%' . $filter->search . '%');
                });
            }

            //add filter by ids
            if (isset($filter->ids)) {
                is_array($filter->ids) ? true : $filter->ids = [$filter->ids];
                $query->whereIn('icredit__credits.id', $filter->ids);
            }

            //Filter by date
            if (isset($filter->date)) {
                $date = $filter->date;//Short filter date
                $date->field = $date->field ?? 'created_at';
                if (isset($date->from))//From a date
                    $query->whereDate($date->field, '>=', $date->from);
                if (isset($date->to))//to a date
                    $query->whereDate($date->field, '<=', $date->to);
            }

            //Order by
            if (isset($filter->order)) {
                $orderByField = $filter->order->field ?? 'created_at';//Default field
                $orderWay = $filter->order->way ?? 'desc';//Default way
                $query->orderBy("icredit__credits." . $orderByField, $orderWay);//Add order to query
            }
            //Filter by customer ID
            if (isset($filter->customerId)) {
                if ($filter->customerId == 0) {
                    $query->whereNull("customer_id");
                } else {
                    $query->where("customer_id", $filter->customerId);
                }
            }

            //filter by relatedId
            if(isset($filter->relatedId)){
                $query->where("related_id",$filter->relatedId);
            }

            //filter by relatedId
            if(isset($filter->relatedType)){
                $query->where("related_type",$filter->relatedType);
            }
            //filter by status
            if(isset($filter->status)){
                $query->where("status",$filter->status);
            }
        }
        if (isset($params->setting) && isset($params->setting->fromAdmin) && $params->setting->fromAdmin) {

        } else {

            //pre-filter status
            //$query->where("status", 2);
        }
        // ORDER
        if (isset($params->order) && $params->order) {

            $order = is_array($params->order) ? $params->order : [$params->order];

            foreach ($order as $orderObject) {
                if (isset($orderObject->field) && isset($orderObject->way))
                    $query->orderBy("icredit__credits." . $orderObject->field, $orderObject->way);
            }

        }

        /*== FIELDS ==*/
        if (isset($params->fields) && is_array($params->fields) && count($params->fields) && $params->fields)
            $query->select($params->fields);

            /*== REQUEST ==*/
        if (isset($params->onlyQuery) && $params->onlyQuery) {
          return $query;
        } else
          if (isset($params->page) && $params->page) {
            return $query->paginate($params->take);
          } else {
            isset($params->take) && $params->take ? $query->take($params->take) : false;//Take
            return $query->get();
          }

    }

    public function getItem($criteria, $params = false)
    {
        // INITIALIZE QUERY
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include ?? [])) {//If Request all relationships
            $query->with([]);
        } else {//Especific relationships
            $includeDefault = ['translations'];//Default relationships
            if (isset($params->include))//merge relations with default relationships
                $includeDefault = array_merge($includeDefault, $params->include ?? []);
            $query->with($includeDefault);//Add Relationships to query
        }

        /*== FIELDS ==*/
        if (isset($params->fields) && is_array($params->fields) && count($params->fields))
            $query->select($params->fields);


        /*== FILTER ==*/
        if (isset($params->filter)) {
            $filter = $params->filter;

            //Filter by specific field
            if (isset($filter->field))
                $field = $filter->field;

            // find translatable attributes
            $translatedAttributes = $this->model->translatedAttributes;

            // filter by translatable attributes
            if (isset($field) && in_array($field, $translatedAttributes))//Filter by slug
                $query->whereHas('translations', function ($query) use ($criteria, $filter, $field) {
                    $query->where('locale', $filter->locale)
                        ->where($field, $criteria);
                });
            else {
                // find by specific attribute or by id
                $query->where($field ?? 'id', $criteria);
            }

            //Filter by customer ID
            if (isset($filter->customerId)) {
                if ($filter->customerId == 0) {
                    $query->whereNull("customer_id");
                } else {
                    $query->where("customer_id", $filter->customerId);
                }
            }

            //filter by relatedId
            if(isset($filter->relatedId)){
                $query->where("related_id",$filter->relatedId);
            }

            //filter by relatedId
            if(isset($filter->relatedType)){
                $query->where("related_type",$filter->relatedType);
            }

        }

        if (isset($params->setting) && isset($params->setting->fromAdmin) && $params->setting->fromAdmin) {

        } else {


        }

        /*== REQUEST ==*/
        return $query->first();
    }

    /**
     * Find a resource by the given slug
     *
     * @param string $slug
     * @return object
     */

    public function create($data)
    {

        $credit = $this->model->create($data);

        //Event to ADD media
        return $credit;
    }

    public function updateBy($criteria, $data, $params = false)
    {
        /*== initialize query ==*/
        $query = $this->model->query();

        /*== FILTER ==*/
        if (isset($params->filter)) {
            $filter = $params->filter;

            //Update by field
            if (isset($filter->field))
                $field = $filter->field;
        }

        /*== REQUEST ==*/
        $model = $query->where($field ?? 'id', $criteria)->first();

        return $model ? $model->update((array)$data) : false;
    }

    public function deleteBy($criteria, $params = false)
    {
        /*== initialize query ==*/
        $query = $this->model->query();

        /*== FILTER ==*/
        if (isset($params->filter)) {
            $filter = $params->filter;

            if (isset($filter->field))//Where field
                $field = $filter->field;
        }

        /*== REQUEST ==*/
        $model = $query->where($field ?? 'id', $criteria)->first();
        $model ? $model->delete() : false;
    }

    public function amount($params = false)
    {

        $params->onlyQuery = true;
        
        if(!isset($params->filter)) $params->filter = (object)[];
  
        $params->filter->status = 2;
        $query = $this->getItemsBy($params);

        //custom select
        $query->select(
            'customer_id',
            \DB::raw('SUM(amount) as amount'),
            );

        //group by client Id
        $query->groupBy("customer_id");
        return $query->get();
    }

}