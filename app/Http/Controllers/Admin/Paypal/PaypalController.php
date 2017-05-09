<?php

namespace App\Http\Controllers\Admin\Paypal;

use App\Http\Controllers\Controller;
use App\Models\Fatcha\Payment\PaypalManager;
use App\Models\PaypalPlan;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Quiz\Quiz;
use PayPal\Api\Agreement;
use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Api\Payer;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;
use App\Models\Fatcha\Payment\ResultPrinter;
use PayPal\Api\PlanList;
use PayPal\Api\ShippingAddress;
use PayPal\Common\PayPalModel;

class PaypalController extends Controller {

    private $apiContext = null;
    private $planId = 'P-2E713203253186408I5M7RCQ';

    public function __construct() {
        //   $this->middleware('guest', ['except' => 'logout']);
        $this->apiContext = PaypalManager::getApiContext(ENV('PAYPAL_CLIENT_ID'), ENV('PAYPAL_SECRET'));
    }

    public function createPlan() {


        // Create a new instance of Plan object
        $plan = new Plan();
        // # Basic Information
        // Fill up the basic information that is required for the plan
        $plan->setName('Daily Edition')->setDescription('Template creation 20.')->setType('fixed');
        // # Payment definitions for this billing plan.
        $paymentDefinition = new PaymentDefinition();
        // The possible values for such setters are  mentioned in the setter method documentation.
        // Just open the class file. e.g. lib/PayPal/Api/PaymentDefinition.php and look for setFrequency method.
        // You should be able to see the acceptable values in the comments.
        $paymentDefinition
            ->setName('Regular Payments')
            ->setType('REGULAR')
            ->setFrequency('DAY')
            ->setFrequencyInterval("2")
            ->setCycles("700")
            ->setAmount(new Currency(array('value' => 1, 'currency' => 'EUR')));
        // Charge Models
//        $chargeModel = new ChargeModel();
//        $chargeModel->setType('SHIPPING')->setAmount(new Currency(array('value' => 10, 'currency' => 'USD')));
//        $paymentDefinition->setChargeModels(array($chargeModel));
        $merchantPreferences = new MerchantPreferences();
        $baseUrl = PaypalManager::getBaseUrl();
        // ReturnURL and CancelURL are not required and used when creating billing agreement with payment_method as "credit_card".
        // However, it is generally a good idea to set these values, in case you plan to create billing agreements which accepts "paypal" as payment_method.
        // This will keep your plan compatible with both the possible scenarios on how it is being used in agreement.
        $merchantPreferences
            ->setReturnUrl("$baseUrl/ExecuteAgreement.php?success=true")
            ->setCancelUrl("$baseUrl/ExecuteAgreement.php?success=false")
            ->setAutoBillAmount("yes")->setInitialFailAmountAction("CONTINUE")
            ->setMaxFailAttempts("0")
            ->setSetupFee(new Currency(array('value' => 1, 'currency' => 'EUR')));

        $plan->setPaymentDefinitions(array($paymentDefinition));
        $plan->setMerchantPreferences($merchantPreferences);
// For Sample Purposes Only.
        $request = clone $plan;
// ### Create Plan
        try {
            $output = $plan->create($this->apiContext);
        } catch (\Exception $ex) {
            // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
            ResultPrinter::printError("Created Plan", "Plan", null, $request, $ex);
            exit(1);
        }
// NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
        //ResultPrinter::printResult("Created Plan", "Plan", $output->getId(), $request, $output);
        return $output;
    }

    public function listPlans($status = 'ACTIVE') {
        try {
            $params = array('page_size' => '15', 'status'=>$status);
            $plansList = Plan::all($params, $this->apiContext) ;
        } catch (Exception $ex) {
            echo $ex;
            exit(1);
        }

        $arrayPlans = $plansList->getPlans() == null ? [] : $plansList->getPlans() ;

        PaypalPlan::checkPlans($arrayPlans);



        return view('admin.paypal.plans_list',[
            'plans'             => $arrayPlans,
            'statusArray'       => array_combine(PaypalPlan::STATUS_ARRAY, PaypalPlan::STATUS_ARRAY),
            'currentStatus'     => $status,
        ]);

    }

    public function deletePlan() {

        $createdPlan = Plan::get($this->planId, $this->apiContext);
        try {
            $result = $createdPlan->delete($this->apiContext);
        } catch (Exception $ex) {
            ResultPrinter::printError("Deleted a Plan", "Plan", $createdPlan->getId(), null, $ex);
            exit(1);
        }


        return 'ok';

    }

    public function activePlan() {
        try {
            $patch = new Patch();
            $value = new PayPalModel('{
	       "state":"ACTIVE"
	     }');
            $patch->setOp('replace')->setPath('/')->setValue($value);
            $patchRequest = new PatchRequest();
            $patchRequest->addPatch($patch);

            $createdPlan = Plan::get($this->planId, $this->apiContext);

            $createdPlan->update($patchRequest, $this->apiContext);
            $plan = Plan::get($this->planId, $this->apiContext);
        } catch (\Exception $ex) {
            // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
           // ResultPrinter::printError("Updated the Plan to Active State", "Plan", null, $patchRequest, $ex);
            exit(1);
        }
        // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
       // ResultPrinter::printResult("Updated the Plan to Active State", "Plan", $plan->getId(), $patchRequest, $plan);
        return $plan;
    }

    public function createAgreement() {


        $agreement = new Agreement();
        $agreement->setName('Base Agreement')->setDescription('Basic Agreement')->setStartDate('2016-12-28T15:19:21+00:00');
// Add Plan ID
// Please note that the plan Id should be only set in this case.
        $plan = new Plan();
        $plan->setId($this->planId);
        $agreement->setPlan($plan);

// Add Payer
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $agreement->setPayer($payer);
// Add Shipping Address
//        $shippingAddress = new ShippingAddress();
//        $shippingAddress->setLine1('111 First Street')
//            ->setCity('Saratoga')
//            ->setState('CA')
//            ->setPostalCode('95070')
//            ->setCountryCode('US');
//        $agreement->setShippingAddress($shippingAddress);
// For Sample Purposes Only.
        $request = clone $agreement;
// ### Create Agreement
        try {
            // Please note that as the agreement has not yet activated, we wont be receiving the ID just yet.
            $agreement = $agreement->create($this->apiContext);
            // ### Get redirect url
            // The API response provides the url that you must redirect
            // the buyer to. Retrieve the url from the $agreement->getApprovalLink()
            // method
            $approvalUrl = $agreement->getApprovalLink();
        } catch (Exception $ex) {
            // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
            ResultPrinter::printError("Created Billing Agreement.", "Agreement", null, $request, $ex);
            exit(1);
        }
// NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
        //ResultPrinter::printResult("Created Billing Agreement. Please visit the URL to Approve.", "Agreement", "<a href='$approvalUrl' >$approvalUrl</a>", $request, $agreement);
        return "<a href='$approvalUrl' >$approvalUrl</a>";
        return $agreement;

    }
}
