<?php
namespace Barefoot\ProductContributors\Controller\Adminhtml\Product;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Export extends \Magento\Backend\App\Action
{
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

    public $storeProduct;
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Cms\Model\Block $cmsBlockModel
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Barefoot\ProductContributors\Model\Manageproduct $manageproductFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->_manageproductFactory = $manageproductFactory;
    }
    
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
    public function execute()
    {
      $productContributors = $this->_manageproductFactory->getCollection();
      $fieldData = $productContributors->getLastItem()->getData();
      try {
            $fileName="ProductContributors".date("Y_M_d_H_i_s").".csv";

            if ($productContributors) {
                if ($fieldData) {
                      $fieldArray=array_keys($fieldData);
                }
            }
            //@codingStandardsIgnoreLine
            $f = fopen('php://memory', 'w');
            if (!empty($fieldArray)) {
                fputcsv($f, $fieldArray);
            }
            $contributorData = $productContributors->getData();
            foreach ($contributorData as $line) {
                fputcsv($f, $line);
            }
            // reset the file pointer to the start of the file
            fseek($f, 0);
            // tell the browser it's going to be a csv file
            //@codingStandardsIgnoreLine
            header('Content-Type: application/csv');
            // tell the browser we want to save it instead of displaying it
            //@codingStandardsIgnoreLine
            header('Content-Disposition: attachment; filename="'.$fileName.'";');
            // make php send the generated csv lines to the browser
            fpassthru($f);
            $this->messageManager->addSuccess(
                __('Product Contributors Exported Successfully!')
            );
            return;
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }
        $this->_redirect('barefoot/product/index/');
    }
}
