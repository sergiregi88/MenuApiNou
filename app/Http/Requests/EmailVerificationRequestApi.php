<?php

namespace App\Http\Requests;


use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest as BaseEmailVerificationRequest;

class EmailVerificationRequestApi extends  BaseEmailVerificationRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //    dd("ss");
        $user = User::query()->findOrFail($this->route('id'));

        if (! hash_equals((string) $this->route('hash'),
            sha1($user->getEmailForVerification()))) {
            return false;
        }

        $this->setUserResolver(function () use ($user) {
            return $user;
        });

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
