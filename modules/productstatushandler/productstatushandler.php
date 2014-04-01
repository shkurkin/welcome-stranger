<?php

if (!defined('_PS_VERSION_'))
    exit;

class ProductStatusHandler extends Module {

    public $showLink;

    public function __construct() {
        $this->name = 'productstatushandler';
        $this->tab = 'back_office_features';
        $this->version = 0.1;
        $this->author = 'Welcome Stranger';
        $this->need_instance = 0;

        parent::__construct();

        $this->displayName = $this->l('Product Status Handler');
        $this->description = $this->l('A custom handler which controls hooks into the product status');

        $this->showLink = false;
    }

    public function install() {
        return (parent::install() AND $this->registerHook('actionOrderStatusPostUpdate') AND $this->registerHook('displayAdminOrder'));
    }

    /**
     * Returns module content for header
     *
     * @param array $params Parameters
     * @return string Content
     */
    public function hookActionOrderStatusPostUpdate($params) {
        global $cookie;
        $orderId = (int)$params['id_order'];
        $newStatus = $params['newOrderStatus']->name;
        $error_msg = false; 
        if ($newStatus == 'Shipped') {
            
            //TODO: If this fails, error out and set status back
            //TODO: Otherwise make sure the payment lines balance, otherwise fail
            
            if(class_exists('Firstdata')){
                $firstData = new Firstdata();
                $result = $firstData->sendCapture($orderId);
                if(!$result){
                    //Show an error
                    $this->context->smarty->assign('firstdata_error', "There was an error processing capture data");
                    
                    //Set status to "Payment Error"
                    $order = new Order();
                    $history = new OrderHistory();
                    $history->id_order = $orderId;
                    $history->changeIdOrderState(8, (int)$orderId); //order status=4
                    
                }
            }
            
            if(!$error_msg){
                $cookie->setAStatus = $orderId;
            }
        }
    }

    public function hookDisplayAdminOrder($params) {
        global $cookie;
        
        if(isset($cookie->setAStatus) && ($cookie->setAStatus)){
            $this->context->smarty->assign(array(
                'OrderId' => $cookie->setAStatus
            ));
            print $this->display(__FILE__, 'productStatusHandler.tpl');
            $cookie->setAStatus=false;
        }
    }

}
