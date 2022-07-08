<?php
declare(strict_types =1);

namespace App\Http\Requests;

use App\Rules\InterArray;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title'     => 'string|required',
            'body'      => ['string','required'],
            'user_ids'  => [
                'array',
                'required',
                    new InterArray(),
                /** Custom validation based on closure*/
//                function($attribute, $value ,$fail){
//                    $integerOnly = collect($value)->every(fn($element) => is_int($element));
//                        /**One of element isn't Integer*/
//                    if (!$integerOnly){
//                        $fail($attribute . ' Can only be integers');
//                    }
//                }
            ],
        ];
    }

    public function messages()
    {
         return [
             'body.required' => 'Please enter a value for body',
             'title.string'  => 'Heyy use a string'
         ];
    }
}
