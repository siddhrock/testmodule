<?php
namespace Barefoot\ProductContributors\Controller\Adminhtml\Product;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class AjaxImport extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\App\Request\Http
     */
    public $request;

    /**
     * result page Factory
     *
     * @var Magento\Framework\View\Result\PageFactory
     */
    public $resultPageFactory;

    /**
     * @var \Magento\Cms\Model\Block
     */
    public $storeModel;
    public $productModel;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Cms\Model\Block $cmsBlockModel
     */
    //@codingStandardsIgnoreStart
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Magento\Framework\App\Request\Http $request,
        \Barefoot\ProductContributors\Model\Manageproduct $manageproductFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->request=$request;
        $this->_manageproductFactory = $manageproductFactory;
    }
    //@codingStandardsIgnoreEnd
    /**
     * {@inheritdoc}
     */
    public function _isAllowed()
    {
        return true;
    }
    
    /**
     * Execute method for Attachment index action
     *
     * @return $resultPage
     */
    //@codingStandardsIgnoreLine
    public function execute()
    {
        if($_FILES["import_store"]["name"]==""){
            $responce=array("message"=>"Please select file for upload","html"=>"");
            echo json_encode($responce);
            exit();
        }

        $fh = fopen($_FILES['import_store']['tmp_name'], 'r+');
        $ext=explode(".",$_FILES['import_store']["name"]);
        $manageproductModel=$this->_manageproductFactory;

        $ext=end($ext);
        $lines = array();
        $replace=$this->getRequest()->getParam('replace');
        $i=0;
        $skip=0;
        while( ($row = fgetcsv($fh)) !== FALSE ) {
            $replaceWithId=0;
            if($ext!="csv"){
                $responce=array("message"=>"invalid file","html"=>"");
                echo json_encode($responce);
                exit();
            }
            if($i==0){
                if (trim($row[0])!="cav" || trim($row[1])!="store_id" || trim($row[2])!="entity_id" || trim($row[3])!="contributor_id" || trim($row[4])!="contributor_type_handle") {
                    $responce=array("message"=>"invalid file format","html"=>"");
                    echo json_encode($responce);
                    exit();
                }
                $i++;
            }
            else{
                if($row[1]==""){
                    $row[1]=0;
                }
                if($replace=="on"){
                    $skip=1;
                }else
                {
                    $skip=0;
                }
                if ($skip == 0) {
                    /*echo "skip ".$skip;
                    $contricollection=$this->_manageproductFactory->getCollection()
                        ->addFieldToSelect("*")
                        ->addFieldToFilter("cav",$row[0]);
                        echo "<pre>";
                        print_r($contricollection->getData());
                        exit();*/

                    $data=array();                    
                    $data["store_id"]=$row[1];
                    $data["entity_id"]=$row[2];
                    $data["contributor_id"]=$row[3];
                    $data["contributor_type_handle"]=$row[4];
                    $editModel=$manageproductModel;
                    $editModel->setData($data);
                    try{
                        $editModel->save();
                        $i++;
                    }
                    catch(\Exception $ex){
                    }
                }
                if ($skip == 1) {
                    $data=array();                    
                    $replaceWithId = 0;
                    $contricollection=$this->_manageproductFactory->getCollection()
                        ->addFieldToSelect("*")
                        ->addFieldToFilter("cav",$row[0]);
                    if ($contricollection) {
                        foreach ($contricollection as $contri) {
                            $replaceWithId=$contri['cav'];
                        }
                    }
                    if ($replaceWithId != 0) {
                        $data["cav"]=$replaceWithId;
                    }                    
                    $data["store_id"]=$row[1];
                    $data["entity_id"]=$row[2];
                    $data["contributor_id"]=$row[3];
                    $data["contributor_type_handle"]=$row[4];
                    $editModel=$manageproductModel;

                    $editModel->setData($data);
                    try{
                        $editModel->save();
                        $i++;
                    }
                    catch(\Exception $ex){
                    }
                }
            }

        }
        $message=($i-1)." Product Contributors Imported";
        $responce=array("message"=>$message);
        echo json_encode($responce);
        exit;
    }
}
