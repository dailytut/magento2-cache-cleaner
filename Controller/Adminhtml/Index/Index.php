<?php
namespace W3cert\CacheCleaner\Controller\Adminhtml\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action;

class Index extends Action
{
    protected $cacheManager;
    protected $varnishPurger;

    public function __construct(
        Action\Context $context,
        \Magento\Framework\App\Cache\Manager $cacheManager,
        \Magento\CacheInvalidate\Model\PurgeCache $varnishPurger
    ) {
        $this->cacheManager = $cacheManager;
        $this->varnishPurger = $varnishPurger;
        parent::__construct($context);
    }

    public function execute()
    {
        try {
            $types = array_keys($this->cacheManager->getAvailableTypes());
            $this->cacheManager->clean($types);
            
            // Purge Varnish Cache
            $this->varnishPurger->purgeAll();

            $this->messageManager->addSuccessMessage(__('Cache has been cleaned.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('adminhtml/dashboard/index');
    }
}
