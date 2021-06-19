<?php
namespace Modules\Icredit\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Iprofile\Transformers\UserTransformer;

class CreditTransformer extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'description' => $this->description ?? '',
            'customerId' => (int)$this->customer_id,
            'customer' => new UserTransformer($this->whenLoaded('customer')),
            'adminId' => (int)$this->admin_id,
            'date' => $this->date,
            'amount' => $this->amount,
            'relatedId' => (int)$this->related_id,
            'relatedType' => $this->related_type ?? '',
            'createdAt' => $this->when($this->created_at, $this->created_at),
            'updatedAt' => $this->when($this->updated_at, $this->updated_at),
            ];

        $filter = json_decode($request->filter);

        // Return data with available translations
        if (isset($filter->allTranslations) && $filter->allTranslations) {
            // Get langs avaliables
            $languages = \LaravelLocalization::getSupportedLocales();

            foreach ($languages as $lang => $value) {
                $data[$lang]['description'] = $this->hasTranslation($lang) ?
                    $this->translate("$lang")['description'] ?? '' : '';
                }
        }
        return $data;
    }
}
