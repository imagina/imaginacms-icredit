<?php

namespace Modules\Icredit\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Icommerce\Entities\PaymentMethod;

class IcreditDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $name = config('asgard.icredit.config.name');
        $result = PaymentMethod::where('name',$name)->first();

        if(!$result){
            $options['init'] = "Modules\Icredit\Http\Controllers\Api\IcreditApiController";

            $titleTrans = 'icredit::credits.title.credits';
            $descriptionTrans = 'icredit::credits.description';

            foreach (['en', 'es'] as $locale) {

                if($locale=='en'){
                    $params = array(
                        'title' => trans($titleTrans),
                        'description' => trans($descriptionTrans),
                        'name' => $name,
                        'status' => 1,
                        'options' => $options
                    );

                    $paymentMethod = PaymentMethod::create($params);

                }else{

                    $title = trans($titleTrans,[],$locale);
                    $description = trans($descriptionTrans,[],$locale);

                    $paymentMethod->translateOrNew($locale)->title = $title;
                    $paymentMethod->translateOrNew($locale)->description = $description;

                    $paymentMethod->save();
                }

            }// Foreach
        }else{
            $this->command->alert("This method has already been installed !!");
        }

    }
}
