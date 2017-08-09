<?php
 class Price_Wpsync_IndexController extends Mage_Core_Controller_Front_Action {
     public function indexAction() {
             $this->loadLayout();
             $this->renderLayout();
     }
     public function paramsAction() {
             echo ' ';  
		$sku = '';          
             foreach($this->getRequest()->getParams() as $key=>$value) {
                       echo ' Param: '.$key.' ';
                       echo ' Value: '.$value.' ';
			$sku = $value;
                       echo '</br>';
             }
			echo $sku;
                echo ' ';
		if($sku != "") {
			$_product = Mage::getModel('catalog/product')->loadByAttribute('sku',$sku);
			
			//get Price matrix
			$priceMatrixCollection = Mage::getResourceModel('flagbit_countrybasedpricematrix/priceMatrix_collection')
					->addFilterByProduct($_product)
					->setOrder('website_id', 'ASC')
					->addOrder('country_id', 'ASC');
	
			$price_data = array();
	
			foreach($priceMatrixCollection as $priceMatrixItem) {
				$itemData = $priceMatrixItem->getData();
				$price_data[] = $itemData;
			}
			
			//get currency conversion rates if currency is passed
			$currencyRates = array();
	
			if($currency != "") {
				//$baseCurrencyCode = Mage::app()->getBaseCurrencyCode();
				$allowedCurrencies = Mage::getModel('directory/currency')->getConfigAllowCurrencies();
				$currencyRates = Mage::getModel('directory/currency')->getCurrencyRates('EUR', array_values($allowedCurrencies));
			}
	
			$response = array();
			$response["currency"] = $currencyRates;
			$response["product"] = $price_data;
	
			echo json_encode($response);
		}
		else {
			echo json_encode(array());
		}
     }
 }
