<?php

namespace W3cert\CacheCleaner\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\App\Cache\Manager as CacheManager;
use Magento\CacheInvalidate\Model\PurgeCache;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action
{
    private $cacheManager;
    private $varnishPurger;
    private $cacheTypeList;

    public function __construct(
        Action\Context $context,
        CacheManager $cacheManager,
        PurgeCache $varnishPurger,
        TypeListInterface $cacheTypeList
    ) {
        $this->cacheManager = $cacheManager;
        $this->varnishPurger = $varnishPurger;
        $this->cacheTypeList = $cacheTypeList;
        parent::__construct($context);
    }

    public function execute()
    {
        try {
            // Clean all Magento cache types
            $types = array_keys($this->cacheTypeList->getTypes());
            $this->cacheManager->clean($types);
            
            // Purge Varnish Cache for all pages
            $this->varnishPurger->sendPurgeRequest('.*');
    
            $this->messageManager->addSuccessMessage(__('Cache has been cleaned.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
    
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('adminhtml/dashboard/index');
    }
    
}
