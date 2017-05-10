<?php

namespace App\Repositories;

use App\Models\BillingInfo;
use App\Common\Common;
use App\Models\User;
use Auth;

use Illuminate\Support\Facades\DB;
use Mail;

class BillingInfoRepository implements BillingInfoRepositoryInterface {

    protected $billing;
    protected $common;

    public function __construct(BillingInfo $billing) {
        $this->billing = $billing;
        \Stripe\Stripe::setApiKey(env('SECRET_STRIPE'));
        $this->common = app('App\Common\Common');
    }

    public function getBillingInfo($user_id) {
        $billing = $this->billing->find($user_id);
        if ($billing) {
            $billing->zipcode = $billing->zipcode[0];
        } else {
            $common = new Common;
            $billing = $common->getDefaultEloquentAttibutes($this->billing);
        }
        return $billing;
    }

    public function updateBillingInfo($user_id, array $array) {
        $result = false;
        $code = 200;
        $message = "update billing info error";
        try{
            $billing = $this->billing->find($user_id);
            $user = User::find($user_id)->first();
            if(isset($billing)&&isset($user)){
                $message = "update billing info success";

                $billing->token = $array['token'];
                $customer = \Stripe\Customer::create(array(
                    "email" => $user->email,
                    "source" => $billing->token,
                ));

                $billing->customer_id = $customer->id;
                $billing->name_card = $array['name_card'];
                $billing->expiration_date = $array['expiration_date'];
                $billing->card_last_digits = substr($array['card_last_digits'], -4);
                $billing->address = $array['address'];
                $billing->city = $array['city'];
                $billing->state = $array['state'];
                $billing->zipcode = array(intval($array['zipcode']));
                $result = $billing->save();
            }
        }catch(\Stripe\Error\Card $e) {
            // Since it's a decline, \Stripe\Error\Card will be caught
            $body = $e->getJsonBody();
            $err  = $body['error'];
            
            $code = $e->getHttpStatus();
            $message = $err['message'];
        } catch (\Stripe\Error\InvalidRequest $e) {
            // Invalid parameters were supplied to Stripe's API
        } catch (\Stripe\Error\Authentication $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
        } catch (\Stripe\Error\ApiConnection $e) {
            // Network communication with Stripe failed
        } catch (\Stripe\Error\Base $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
        }

        return $this->common->responseJson($result, $code, $message, []); 
    }

    public function chargeForPayment($user_id, $price, $description = "Example charge", $currency = "usd"){
        try{
            $billing = $this->billing->find($user_id)->first();
            if(isset($billing)){
                $charge = \Stripe\Charge::create(array(
                    "amount" => $price*100,
                    "currency" => $currency,
                    "description" => $description,
                    "customer" => $billing->customer_id
                ));
                return false;
                if($charge->status=="succeeded"){
                    return true;
                }
            }
        } catch(\Stripe\Error\Card $e) {
            // Since it's a decline, \Stripe\Error\Card will be caught
            $body = $e->getJsonBody();
            $err  = $body['error'];

            print('Status is:' . $e->getHttpStatus() . "\n");
            print('Type is:' . $err['type'] . "\n");
            print('Code is:' . $err['code'] . "\n");

            // param is '' in this case
            print('Param is:' . $err['param'] . "\n");
            print('Message is:' . $err['message'] . "\n");
        } catch (\Stripe\Error\InvalidRequest $e) {
            // Invalid parameters were supplied to Stripe's API
        } catch (\Stripe\Error\Authentication $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
        } catch (\Stripe\Error\ApiConnection $e) {
            // Network communication with Stripe failed
        } catch (\Stripe\Error\Base $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
        }
        return false;
    }

}
